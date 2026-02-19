<?php
namespace WPRTS\Core;

if (!defined('ABSPATH')) exit;

class Logger {

    public static function install() {

        global $wpdb;

        $table = $wpdb->prefix . 'wprts_logs';
        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            role VARCHAR(10),
            action VARCHAR(20),
            host_post_id BIGINT,
            target_post_id BIGINT,
            target_url TEXT,
            status VARCHAR(20),
            message TEXT,
            duration FLOAT,
            created_at DATETIME
        ) $charset;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public static function log($data){

        global $wpdb;
    
        $table = $wpdb->prefix . 'wprts_logs';
    
        $wpdb->insert(
            $table,
            [
                'role'           => $data['role'] ?? '',
                'action'         => $data['action'] ?? '',
                'host_post_id'   => $data['host_post_id'] ?? 0,
                'target_post_id' => $data['target_post_id'] ?? 0,
                'target_url'     => $data['target_url'] ?? '',
                'status'         => $data['status'] ?? '',
                'message'        => $data['message'] ?? '',
                'duration'       => $data['duration'] ?? 0,
                'created_at'     => current_time('mysql')
            ],
            [
                '%s','%s','%d','%d','%s','%s','%s','%f','%s'
            ]
        );
    }    
}
