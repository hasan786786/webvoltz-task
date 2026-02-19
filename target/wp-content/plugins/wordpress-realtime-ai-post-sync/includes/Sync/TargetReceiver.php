<?php
namespace WPRTS\Sync;

use WP_REST_Request;
use WP_REST_Response;
use WPRTS\Translation\Translator;
use WPRTS\Core\Logger;

if (!defined('ABSPATH')) exit;

class TargetReceiver {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {

        register_rest_route('wprts/v1', '/sync', [
            'methods'  => 'POST',
            'callback' => [$this, 'handle'],
            'permission_callback' => '__return_true'
        ]);
    }

    public function handle(WP_REST_Request $request) {

        if (get_option('wprts_mode') !== 'target') {
            return new WP_REST_Response(['error'=>'Not target mode'],403);
        }

        $key       = get_option('wprts_target_key');
        $incoming  = $request->get_header('X-WPRTS-Key');
        $signature = $request->get_header('X-WPRTS-Signature');

        if (!$incoming || $incoming !== $key) {
            return new WP_REST_Response(['error'=>'Invalid key'],401);
        }

        $raw = $request->get_body();
        $expected = hash_hmac('sha256',$raw,$key);

        if (!hash_equals($expected,$signature)) {
            return new WP_REST_Response(['error'=>'Invalid signature'],401);
        }

        $data = json_decode($raw,true);

        if (empty($data['host_post_id'])) {
            return new WP_REST_Response(['error'=>'Invalid payload'],400);
        }

        $language = get_option('wprts_language','Hindi');

        $translated_title = Translator::translate_text(
            $data['title'] ?? '',
            $language
        );

        $translated_content = Translator::translate_content(
            $data['content'] ?? '',
            $language
        );

        $translated_excerpt = Translator::translate_text(
            $data['excerpt'] ?? '',
            $language
        );

        $existing = Mapper::find($data['host_post_id']);

        if ($existing) {

            $post_id = wp_update_post([
                'ID'            => $existing,
                'post_title'    => $translated_title,
                'post_content'  => $translated_content,
                'post_excerpt'  => $translated_excerpt
            ]);

            $action = 'update';

        } else {

            $post_id = wp_insert_post([
                'post_type'     => 'post',
                'post_status'   => 'publish',
                'post_title'    => $translated_title,
                'post_content'  => $translated_content,
                'post_excerpt'  => $translated_excerpt
            ]);

            if (!is_wp_error($post_id)) {
                Mapper::save($post_id,$data['host_post_id']);
            }

            $action = 'create';
        }

        if (is_wp_error($post_id)) {
            return new WP_REST_Response(['error'=>'Insert failed'],500);
        }

        // if (!empty($data['categories']) && is_array($data['categories'])) {
        //     TaxonomySync::sync($post_id,$data['categories'],'category');
        // }

        if (!empty($data['categories']) && is_array($data['categories'])) {
            $term_ids = [];
            foreach($data['categories'] as $cat_name){
                $term = term_exists($cat_name, 'category');
                if (!$term) {
                    $term = wp_insert_term($cat_name, 'category');
                }
                if (!is_wp_error($term)) {
                    $term_ids[] = is_array($term) ? $term['term_id'] : $term;
                }
            }
            wp_set_post_terms($post_id, $term_ids, 'category');
        }

        // if (!empty($data['tags']) && is_array($data['tags'])) {
        //     TaxonomySync::sync($post_id,$data['tags'],'post_tag');
        // }
        
        if (!empty($data['tags']) && is_array($data['tags'])) {
            $term_ids = [];
            foreach($data['tags'] as $tag_name){
                $term = term_exists($tag_name, 'post_tag');
                if (!$term) {
                    $term = wp_insert_term($tag_name, 'post_tag');
                }
                if (!is_wp_error($term)) {
                    $term_ids[] = is_array($term) ? $term['term_id'] : $term;
                }
            }
            wp_set_post_terms($post_id, $term_ids, 'post_tag');
        }

        // if (!empty($data['featured_image'])) {
        //     MediaSync::sideload($data['featured_image'],$post_id);
        // }

        // if (!empty($data['featured_image'])) {

        //     require_once(ABSPATH . 'wp-admin/includes/image.php');
        //     require_once(ABSPATH . 'wp-admin/includes/file.php');
        //     require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        //     $image_url = esc_url_raw($data['featured_image']);
        
        //     $tmp = download_url($image_url);
        
        //     error_log("Download URL: " . $image_url);
        //     error_log("Temporary file: " . print_r($tmp, true));
        
        //     if (is_wp_error($tmp)) {
        //         error_log("Download failed: " . $tmp->get_error_message());
        //     } else {
        //         $file_array = [
        //             'name'     => sanitize_file_name(basename(parse_url($image_url, PHP_URL_PATH))),
        //             'tmp_name' => $tmp
        //         ];
        
        //         $id = media_handle_sideload($file_array, $post_id);
        
        //         if (is_wp_error($id)) {
        //             error_log("Sideload failed: " . $id->get_error_message());
        //             @unlink($tmp); 
        //         } else {
        //             set_post_thumbnail($post_id, $id);
        //             error_log("Featured image set successfully. Attachment ID: " . $id);
        //         }
        //     }
        // }

        if (!empty($data['featured_image'])) {
            update_post_meta($post_id, '_featured_image_url', esc_url_raw($data['featured_image']));
            error_log("Stored featured image URL: " . $data['featured_image']);
        }        

        Logger::log([
            'role'           => 'target',
            'action'         => $action,
            'host_post_id'   => $data['host_post_id'],
            'target_post_id' => $post_id,
            'target_url'     => home_url(),
            'status'         => 'success',
            'message'        => 'All fields synced',
            'duration'       => 0,
            'created_at'     => current_time('mysql')
        ]);

        return new WP_REST_Response(['success'=>true],200);
    }
}
