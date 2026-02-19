<?php
/**
 * Plugin Name: WP Realtime AI Sync
 * Description: Sync posts from Host to Target AI translation.
 * Version: 1.0.0
 * Author: Hasanabbas
 */

if (!defined('ABSPATH')) { exit; }

define('WPRTS_VERSION', '1.0.0');
define('WPRTS_PATH', plugin_dir_path(__FILE__));
define('WPRTS_URL', plugin_dir_url(__FILE__));

require_once WPRTS_PATH . 'includes/Core/Plugin.php';

\WPRTS\Core\Plugin::init();

register_activation_hook(__FILE__, ['\WPRTS\Core\Plugin', 'activate']);

add_filter('post_thumbnail_html', function($html, $post_id) {
    if (empty($html)) {
        $url = get_post_meta($post_id, '_featured_image_url', true);
        if ($url) {
            $html = '<img src="' . esc_url($url) . '" alt="' . get_the_title($post_id) . '" />';
        }
    }
    return $html;
}, 10, 2);