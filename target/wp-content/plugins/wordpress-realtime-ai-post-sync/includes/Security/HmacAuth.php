<?php
namespace WPRTS\Security;

use WP_Error;

if (!defined('ABSPATH')) exit;

class HmacAuth {

    public static function verify($request) {

        $key = $request->get_header('x-wprts-key');
        $signature = $request->get_header('x-wprts-signature');
        $domain = $request->get_header('x-wprts-domain');

        if (!$key || !$signature) {
            return new WP_Error('unauthorized','Missing headers',['status'=>401]);
        }

        if ($key !== get_option('wprts_target_key')) {
            return new WP_Error('forbidden','Invalid key',['status'=>403]);
        }

        $body = $request->get_body();
        $expected = hash_hmac('sha256',$body,$key);

        if (!hash_equals($expected,$signature)) {
            return new WP_Error('forbidden','Invalid signature',['status'=>403]);
        }

        if ($domain !== parse_url(home_url(),PHP_URL_HOST)) {
            return new WP_Error('forbidden','Domain mismatch',['status'=>403]);
        }

        return true;
    }
}
