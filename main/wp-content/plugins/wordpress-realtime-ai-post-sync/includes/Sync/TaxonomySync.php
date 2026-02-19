<?php
namespace WPRTS\Sync;

if (!defined('ABSPATH')) exit;

class TaxonomySync {

    public static function sync($post_id, $terms, $taxonomy) {

        $term_ids = [];

        foreach ($terms as $name) {

            $term = term_exists($name, $taxonomy);

            if (!$term) {
                $term = wp_insert_term($name, $taxonomy);
            }

            if (!is_wp_error($term)) {
                $term_ids[] = is_array($term) ? $term['term_id'] : $term;
            }
        }

        wp_set_object_terms($post_id, $term_ids, $taxonomy);
    }
}
