<?php
namespace WPRTS\Translation;

if (!defined('ABSPATH')) exit;

class Chunker {

    public static function split($content, $max = 2000) {

        $paragraphs = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        $chunks = [];
        $buffer = '';

        foreach ($paragraphs as $part) {
            $buffer .= $part;

            if (strlen($buffer) >= $max) {
                $chunks[] = $buffer;
                $buffer = '';
            }
        }

        if (!empty($buffer)) {
            $chunks[] = $buffer;
        }

        return $chunks;
    }
}
