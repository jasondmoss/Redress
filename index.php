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
 * Domain Path: /languages
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
 * ...
 */
use Redress\Access;
use Redress\Bootstrap;
use Redress\Cleanup;
use Redress\Development;

/**
 * Register given function as __autoload() implementation.
 *
 * @param callable $function Autoload function.
 * @param boolean  $throw    Throw exception on register fail? Default true
 * @param boolean  $prepend  Prepend the autoloader on the autoload queue? Default false
 *
 * @see http://php.net/manual/en/function.spl-autoload-register.php
 */
spl_autoload_register('redressAutoloader');


/**
 * Custom autoloader.
 *
 * @param string $klass
 */
function redressAutoloader($klass)
{
    if (false !== strPos($klass, 'Redress')) {
        $klassDir = realPath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR .'src'. DIRECTORY_SEPARATOR;
        $klassFile = str_replace('\\', DIRECTORY_SEPARATOR, $klass) .'.php';

        require_once "{$klassDir}{$klassFile}";
    }
}


/**
 * Initialize.
 */
function redressInitializer()
{
    global $devel;

    $redress = plugin_basename(__FILE__);
    $redressBaseDir = plugin_dir_path(__FILE__);
    $redressBaseUrl = plugins_url();

    $redressAssetsDir = "{$redressBaseDir}assets";
    $redressAssetsUrl = "{$redressBaseUrl}/assets";
    $jQueryVersion = '3.1.1';

    foreach ([
        'name', 'description', 'url', 'admin_email', 'charset', 'language', 'stylesheet_directory', 'template_url'
    ] as $param) {
        $wpMetaData[$param] = get_bloginfo($param);
    }

    new Bootstrap($redressAssetsDir, $redressAssetsUrl, $jQueryVersion);
    new Development($devel);
    new Cleanup();
    new Access($redressAssetsUrl, (object) $wpMetaData);
}

add_action('plugins_loaded', 'redressInitializer');

/* <> */
