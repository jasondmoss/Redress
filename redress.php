<?php

/**
 * Redress.
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
 * Description: Bootstrapping processes to clean-up, streamline and otherwise fix and enhance WordPress.
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
 * Check/Confirm minimum PHP version.
 */
if (version_compare(PHP_VERSION, '5.6.30', '<')) {
    die('Redress requires at least PHP 5.6.30. Your installed version is '. PHP_VERSION);
}

/**
 * Confirm Composer has been installed locally.
 *
 * @see https://getcomposer.org/
 */
if (!file_exists(__DIR__ .'/vendor/autoload.php')) {
    die(
        'Redress requires Composer to be installed locally.'.
        '<br>Please visit <a href="https://getcomposer.org/" title="Composer: Dependency Manager for PHP" '.
        'target="_blank">getcomposer.org</a> for installation instructions.'
    );
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
use Redress\Administration;
use Redress\Bootstrap;
use Redress\Cleanup;
use Redress\Development;
use Redress\Media;
use Redress\Performance;
use Redress\Settings\Register as Settings;

/**
 * Initialize.
 */
function redressInitializer()
{
    global $devel;

    $redress = (object) [];

    foreach ([
        'name', 'description', 'url', 'admin_email', 'charset', 'language'
    ] as $param) {
        $redress->$param = get_bloginfo($param);
    }

    $redress->basename = plugin_basename(__FILE__);
    $redress->baseDir = plugin_dir_path(__FILE__);
    $redress->baseUrl = plugin_dir_url(__FILE__);

    $redress->version = '0.5.0';
    /**
     * @see http://www.jsdelivr.com/projects/jquery
     */
    $redress->jQueryVersion = '3.1.1';
    /**
     * @see http://www.jsdelivr.com/projects/umbrella
     */
    $redress->umbrellaVersion = '2.6.7';

    $redress->assets = "{$redress->baseUrl}assets/min";
    $redress->images = "{$redress->baseUrl}assets/image";
    $redress->langDir = "{$redress->baseDir}assets/language";

    new Bootstrap($redress);
    new Development($devel);
    new Cleanup;
    new Media;
    new Performance;
    new Administration($redress);
    new Settings($redress);
    new Access($redress);
}

add_action('plugins_loaded', 'redressInitializer');

/* <> */
