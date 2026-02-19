<?php
namespace WPRTS\Translation;

if (!defined('ABSPATH')) exit;

class Translator {

    public static function translate_text($text, $language) {
        return self::call_api($text, $language);
    }

    public static function translate_content($content, $language) {

        if (empty($language)) {
            return $content;
        }

        $chunks = Chunker::split($content);
        $translated = [];

        foreach ($chunks as $chunk) {
            $translated[] = self::call_api($chunk, $language);
        }

        return implode('', $translated);
    }

    private static function call_api($text, $language) {

        $api_key = get_option('wprts_openai_key');

        if (empty($api_key)) {
            return $text;
        }

        $response = wp_remote_post(
            'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . trim($api_key),
                    'Content-Type'  => 'application/json',
                ],
                'body' => wp_json_encode([
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "You are a professional translator. Translate to $language. Keep HTML tags unchanged."
                        ],
                        [
                            'role' => 'user',
                            'content' => $text
                        ]
                    ],
                    'temperature' => 0.2
                ]),
                'timeout' => 60,
            ]
        );

        if (is_wp_error($response)) {
            error_log('WPRTS Translation Error: ' . $response->get_error_message());
            return $text;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (!empty($body['choices'][0]['message']['content'])) {
            return trim($body['choices'][0]['message']['content']);
        }

        return $text;
    }
}
