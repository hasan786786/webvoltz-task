<?php
namespace WPRTS\Sync;

use WPRTS\Core\Logger;

if (!defined('ABSPATH')) exit;

class HostDispatcher {

    public function __construct() {
        add_action('save_post_post',[$this,'dispatch'],20,3);
    }

    public function dispatch($post_id,$post,$update){

        if(get_option('wprts_mode')!=='host') return;
        if($post->post_status!=='publish') return;
        if(wp_is_post_revision($post_id)) return;
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        $targets = get_option('wprts_targets',[]);
        $targets = is_array($targets) ? $targets : [];

        if(empty($targets)) return;

        $payload = [
            'host_post_id'   => $post_id,
            'title'          => $post->post_title,
            'content'        => $post->post_content,
            'excerpt'        => $post->post_excerpt,
            'categories'     => wp_get_post_terms($post_id,'category',['fields'=>'names']),
            'tags'           => wp_get_post_terms($post_id,'post_tag',['fields'=>'names']),
            'featured_image' => get_the_post_thumbnail_url($post_id,'full')
        ];

        $json = wp_json_encode($payload);

        foreach($targets as $target){

            if(empty($target['url']) || empty($target['key'])){
                continue;
            }

            $url = esc_url_raw($target['url']);
            $key = sanitize_text_field($target['key']);

            $signature = hash_hmac('sha256',$json,$key);

            $start = microtime(true);

            $response = wp_remote_post(
                rtrim($url,'/').'/wp-json/wprts/v1/sync',
                [
                    'headers'=>[
                        'Content-Type'=>'application/json',
                        'X-WPRTS-Key'=>$key,
                        'X-WPRTS-Signature'=>$signature,
                        'X-WPRTS-Domain'=>parse_url(home_url(),PHP_URL_HOST)
                    ],
                    'body'=>$json,
                    'timeout'=>90
                ]
            );

            $duration = microtime(true) - $start;

            Logger::log([
                'role'=>'host',
                'action'=>$update?'update':'create',
                'host_post_id'=>$post_id,
                'target_post_id'=>0,
                'target_url'=>$url,
                'status'=>is_wp_error($response)?'error':'success',
                'message'=>is_wp_error($response)
                            ? $response->get_error_message()
                            : wp_remote_retrieve_response_code($response),
                'duration'=>$duration,
                'created_at'=>current_time('mysql')
            ]);
        }
    }
}
