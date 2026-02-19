<?php
namespace WPRTS\Sync;

if (!defined('ABSPATH')) exit;

class Mapper {

    const META_KEY = '_wprts_host_post_id';

    public static function find($host_post_id) {

        $query = new \WP_Query([
            'post_type'  => 'post',
            'meta_key'   => self::META_KEY,
            'meta_value' => $host_post_id,
            'fields'     => 'ids',
            'post_status'=> 'any'
        ]);

        return $query->posts[0] ?? 0;
    }

    public static function save($post_id, $host_post_id) {
        update_post_meta($post_id, self::META_KEY, intval($host_post_id));
    }
}
