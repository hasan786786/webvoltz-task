<?php
namespace WPRTS\Sync;

if (!defined('ABSPATH')) exit;

class MediaSync {

    public static function sideload($image_url, $post_id) {

        if (!$image_url) return;

        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attachment_id = media_sideload_image($image_url, $post_id, null, 'id');

        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
}
