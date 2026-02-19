<?php
namespace WPRTS\Admin;

if (!defined('ABSPATH')) exit;

class Logs {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_wprts_get_logs', [$this, 'ajax_get_logs']);
    }

    public function menu() {
        add_menu_page(
            'Realtime Sync Logs',
            'Sync Logs',
            'manage_options',
            'wprts-sync-logs',
            [$this, 'page'],
            'dashicons-analytics',
            25
        );
    }

    public function enqueue_assets($hook) {
        
        if ($hook !== 'toplevel_page_wprts-sync-logs') return;

        wp_enqueue_script(
            'wprts-logs-js',
            plugin_dir_url(__FILE__) . 'assets/js/sync-logs.js',
            ['jquery'],
            '1.0',
            true
        );

        wp_localize_script('wprts-logs-js', 'wprts_logs_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wprts_logs_nonce')
        ]);
    }

    public function page() {
        require plugin_dir_path(__FILE__) . 'views/logs-page.php';
    }

    public function ajax_get_logs() {
        check_ajax_referer('wprts_logs_nonce', 'nonce');

        global $wpdb;
        $table = $wpdb->prefix . 'wprts_logs';

        $role   = isset($_POST['role']) ? sanitize_text_field($_POST['role']) : '';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';

        $where = [];
        $params = [];

        if ($role) {
            $where[] = 'role = %s';
            $params[] = $role;
        }
        if ($status) {
            $where[] = 'status = %s';
            $params[] = $status;
        }

        $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $query = "SELECT * FROM $table $where_sql ORDER BY created_at DESC LIMIT 200";
        $logs = $wpdb->get_results($wpdb->prepare($query, ...$params));

        if ($logs) {
            foreach($logs as $log) {
                echo '<tr>
                    <td>'.esc_html($log->id).'</td>
                    <td>'.esc_html($log->role).'</td>
                    <td>'.esc_html($log->action).'</td>
                    <td>'.esc_html($log->host_post_id).'</td>
                    <td>'.esc_html($log->target_post_id).'</td>
                    <td>'.esc_url($log->target_url).'</td>
                    <td>'.esc_html($log->status).'</td>
                    <td>'.esc_html($log->message).'</td>
                    <td>'.esc_html($log->duration).'</td>
                    <td>'.esc_html($log->created_at).'</td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="10">No logs found.</td></tr>';
        }

        wp_die();
    }
}