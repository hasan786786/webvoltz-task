<?php
namespace WPRTS\Admin;

if (!defined('ABSPATH')) exit;

class Settings {

    public function __construct() {
        add_action('admin_menu', [$this,'menu']);
        add_action('admin_init', [$this,'register']);
        add_action('admin_enqueue_scripts', [$this,'enqueue_assets']);
        add_action('wp_ajax_wprts_delete_target', [$this,'delete_target']);
    }

    public function menu() {
        add_options_page(
            'Realtime AI Sync',
            'Realtime AI Sync',
            'manage_options',
            'wprts',
            [$this,'page']
        );
        
    }

    public function register() {

        register_setting('wprts','wprts_mode');
        register_setting('wprts','wprts_targets');
        register_setting('wprts','wprts_target_key');
        register_setting('wprts','wprts_language');
        register_setting('wprts','wprts_openai_key');
    }

    public function enqueue_assets($hook) {

        if ($hook !== 'settings_page_wprts') {
            return;
        }

        wp_enqueue_script(
            'wprts-admin',
            plugin_dir_url(__FILE__) . 'assets/js/settings.js',
            [],
            '1.0',
            true
        );

        wp_localize_script('wprts-admin','wprts_ajax',[
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wprts_nonce')
        ]);
    }

    private function generate_key() {
        return wp_generate_password(32,false,false);
    }

    public function delete_target() {

        check_ajax_referer('wprts_nonce','nonce');
    
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission denied');
        }
    
        $key = sanitize_text_field($_POST['key'] ?? '');
    
        if(empty($key)){
            wp_send_json_error('Invalid key');
        }
    
        $targets = get_option('wprts_targets',[]);
        $targets = is_array($targets) ? $targets : [];
    
        $found = false;
    
        foreach($targets as $index => $row){
            if(isset($row['key']) && $row['key'] === $key){
                unset($targets[$index]);
                $found = true;
                break;
            }
        }
    
        if(!$found){
            wp_send_json_error('Target not found');
        }
    
        update_option('wprts_targets', array_values($targets));
    
        wp_send_json_success();
    }
    
    public function page() {

        if (!current_user_can('manage_options')) {
            return;
        }
    
        $mode = get_option('wprts_mode','host');
    
        $targets = get_option('wprts_targets',[]);
        $targets = is_array($targets) ? $targets : [];

        require plugin_dir_path(__FILE__) . 'views/settings-page.php';
    }
}