<?php

/**
 * WordPress custom bootstrapper.
 *
 * @category   Bootstrap
 * @package    WordPress
 * @subpackage MustUsePlugin
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2016 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [MIT License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 *
 * - - - - -
 *
 * Plugin Name: Bootstrapper
 * Plugin URI:  https://github.com/jasondmoss/mu-plugins/
 * Description: Bootstrapping processes to clean up and streamline WordPress.
 * Version:     1.0.0 <strong>[2016-04-04]</strong>
 * Author:      Jason D. Moss <jason@jdmlabs.com>
 * Author URI:  https://www.jdmlabs.com/
 * License:     MIT License
 * License URI: https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md
 * Domain Path: /languages
 * Text Domain: bs
 */


namespace MU;

foreach (glob(__DIR__ .'/Classes/*.php') as $classFile) {
    include $classFile;

    $className = basename($classFile, '.php');
    $instance = "MU\\Classes\\{$className}";
    new $instance;
}

/* <> */
