<?php

/**
 * WordPress Redress.
 *
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 *
 * - - - - -
 *
 * Plugin Name: Redress
 * Plugin URI:  https://github.com/jasondmoss/redress/
 * Description: Bootstrapping processes to clean-up, streamline and otherwise fix + enhance WordPress.
 * Version:     0.5.0
 * Author:      Jason D. Moss <jason@jdmlabs.com>
 * Author URI:  https://www.jdmlabs.com/
 * License:     WTFPL License
 * License URI: https://raw.githubusercontent.com/jasondmoss/redress/master/LICENSE.md
 * Domain Path: /assets/language
 * Text Domain: redress
 */

defined('ABSPATH') || die('No Direct Access');

/**
 * Check/Confirm PHP version.
 */
if (version_compare(PHP_VERSION, '5.6.30', '<')) {
    die('Redress requires at least PHP 5.6.30. Your installed version is '. PHP_VERSION);
}

/**
 * ClassLoader implements a PSR-4 class loader.
 *
 * @uses /vendor/composer/ClassLoader.php
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
 */
include_once __DIR__ .'/vendor/autoload.php';

use Redress\Access;
use Redress\Bootstrap;
use Redress\Cleanup;
use Redress\Development;
use Redress\Settings\Register as Settings;

/**
 * Initialize.
 */
function redressInitializer()
{
    global $devel;

    $pluginBasename = plugin_basename(__FILE__);
    $pluginBaseDir = plugin_dir_path(__FILE__);
    $pluginBaseUrl = plugin_dir_url(__FILE__);
    $pluginVersion = '0.5.0';

    $redressAssetsDir = "{$pluginBaseDir}assets";
    $redressAssetsUrl = "{$pluginBaseUrl}assets/min";
    $redressImageUrl = "{$pluginBaseUrl}assets/image";
    $redressLanguageDir = "{$pluginBaseUrl}assets/language";

    /**
     * @see https://developers.google.com/speed/libraries/#jquery
     */
    $jQueryVersion = '3.1.1';

    foreach ([
        'name', 'description', 'url', 'admin_email', 'charset', 'language', 'stylesheet_directory', 'template_url'
    ] as $param) {
        $wordpressMetadata[$param] = get_bloginfo($param);
    }

    new Bootstrap($redressLanguageDir, $redressAssetsUrl, $jQueryVersion);
    new Development($devel);
    new Cleanup();
    new Access($redressAssetsUrl, (object) $wordpressMetadata);
    new Settings($pluginBasename, $pluginVersion);
}

add_action('plugins_loaded', 'redressInitializer');

/* <> */
