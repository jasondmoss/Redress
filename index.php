<?php

/**
 * WordPress Redress.
 *
 * @package    WordPress
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 *
 * - - - - -
 *
 * Plugin Name: Redress
 * Plugin URI:  https://github.com/jasondmoss/mu-plugins/
 * Description: Bootstrapping processes to clean-up, streamline and enhance WordPress.
 * Version:     0.0.3
 * Author:      Jason D. Moss <jason@jdmlabs.com>
 * Author URI:  https://www.jdmlabs.com/
 * License:     WTFPL License
 * License URI: https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md
 * Domain Path: /languages
 * Text Domain: redress
 */

/**
 * Check/Confirm PHP version.
 */
if (version_compare(PHP_VERSION, '5.6', '<')) {
    die('Redress requires at least PHP 5.6. Your installed version is '. PHP_VERSION);
}

/**
 * ...
 */
define('REDRESS', plugin_basename(__FILE__));
define('REDRESS_DIR', plugin_dir_path(__FILE__) .'redress/');
define('REDRESS_URL', plugin_dir_url(__FILE__) .'redress/');
define('REDRESS_ASSETS_DIR', REDRESS_DIR .'assets');
define('REDRESS_ASSETS_URL', REDRESS_URL .'assets');

/**
 * Load and initialize all available classes.
 *
 * Need to make the instance(s) object {$k} a GLOBAL for it's general use
 * throughout WordPress. Ugh.
 */
foreach ([ 'Development', 'Bootstrap', 'Cleanup', 'Access', ] as $file) {
    include REDRESS_DIR ."{$file}.php";
}

/* <> */
