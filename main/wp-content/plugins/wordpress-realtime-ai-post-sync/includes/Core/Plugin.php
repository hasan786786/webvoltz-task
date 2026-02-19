<?php
namespace WPRTS\Core;

if (!defined('ABSPATH')) exit;

class Plugin {

    public static function init() {

        require_once WPRTS_PATH . 'includes/Core/Logger.php';
        require_once WPRTS_PATH . 'includes/Admin/Settings.php';
        require_once WPRTS_PATH . 'includes/Admin/Logs.php';
        require_once WPRTS_PATH . 'includes/Security/HmacAuth.php';
        require_once WPRTS_PATH . 'includes/Sync/HostDispatcher.php';
        require_once WPRTS_PATH . 'includes/Sync/TargetReceiver.php';
        require_once WPRTS_PATH . 'includes/Sync/Mapper.php';
        require_once WPRTS_PATH . 'includes/Sync/TaxonomySync.php';
        require_once WPRTS_PATH . 'includes/Sync/MediaSync.php';
        require_once WPRTS_PATH . 'includes/Translation/Chunker.php';
        require_once WPRTS_PATH . 'includes/Translation/Translator.php';

        new \WPRTS\Admin\Settings();
        
        if (is_admin()) {
            new \WPRTS\Admin\Logs();
        }
        
        new \WPRTS\Sync\HostDispatcher();
        new \WPRTS\Sync\TargetReceiver();
    }

    public static function activate() {
        \WPRTS\Core\Logger::install();
    }
}
