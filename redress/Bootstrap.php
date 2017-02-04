<?php

/**
 * Bootstrap Must-Use Plug-In.
 *
 * @category   Bootstrap
 * @package    WordPress
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/mu-plugins/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 */


add_action('plugins_loaded', 'redressLoadTextDomain');
add_action('wp_enqueue_scripts', 'redressPublicAssets');
add_action('admin_enqueue_scripts', 'redressAdminAssets');
add_action('login_enqueue_scripts', 'redressAccessAssets', 10);


/* -------------------------------------------------------------------------- */


/**
 * Determine Internet Explorer version (Not exactly 100% full-proof; but close
 * enough for our general purposes).
 *
 * @return integer|boolean Version number, or false if not Internet Explorer.
 * @access public
 */
function getIeBrowserVersion()
{
    preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if (count($matches) < 2) {
        preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
    } elseif /* IE. */ (count($matches) > 1) {
        return $matches[1];
    }

    return false;
}


  /* -- */


/**
 * Load/Register the Redress text domain (Translations).
 *
 * @return void
 * @access public
 */
function redressLoadTextDomain()
{
    load_plugin_textdomain('redress', false, REDRESS_ASSETS_DIR .'/language/');
}


/**
 * Add a "Settings" link on the plugins.php page.
 *
 * @param array $links
 *
 * @return array
 * @access public
 */
function redressSettingsLink($links)
{
    $settingsLink = '<a href="'. admin_url('admin.php?page=redress') .'">Settings</a>';
    array_unshift($links, $settingsLink);

    return $links;
}


/**
 * Register administration access assets (styles|scripts).
 *
 * @param array $hook
 *
 * @access public
 */
function redressAccessAssets()
{
    wp_register_style('redress-access-style', REDRESS_ASSETS_URL .'/min/access.css', [], false, 'all');
    wp_register_script('redress-access-script', REDRESS_ASSETS_URL .'/min/access.js', [
        'jquery'
    ], false, true);

    wp_enqueue_style('redress-access-style');
    wp_enqueue_script('redress-access-script');
}


/**
 * Custom Script and Style.
 *
 * @return void
 * @access public
 */
function redressAdminAssets()
{
    wp_register_style('redress-admin-style', REDRESS_ASSETS_URL ."/min/admin.css", [], false, 'all');

    // wp_register_script('redress-core-script', REDRESS_ASSETS_URL ."/min/redress.js", [
    //     'jquery-ui-sortable'
    // ], false, true);

    // wp_register_script('redress-admin-script', REDRESS_ASSETS_URL ."/min/redress-admin.js", [
    //     'redress-core-script'
    // ], false, true);

    wp_enqueue_style('redress-admin-style');
    // wp_enqueue_script('redress-core-script');
    // wp_enqueue_script('redress-admin-script');
}


/**
 * Enqueues the assets.
 *
 * @return void
 * @access public
 */
function redressPublicAssets()
{
    /* jQuery version we want. */
    $jqv = '3.1.1';

    /* Unregister WP styles. */
    wp_deregister_script('jquery');

    /**
     * "Dumbed Down" jQuery Version for older IE.
     */
    if (function_exists('getIeBrowserVersion')) {
        /**
         * Determine Internet Explorer version (Not exactly 100% full-proof; but
         * close enough for our general purposes).
         *
         * @return integer|boolean Version number, or false if not Internet Explorer.
         * @access public
         */
        $ieVersion = getIeBrowserVersion();
        if ($ieVersion && $ieVersion < 9) {
            $jqv = '1.12.4'; // IE 9 and below (Just in case they still exist).
        }
    }

    wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/{$jqv}/jquery.min.js", [], false, true);

    // wp_register_style(
    //     'base',
    //     REDRESS_ASSETS_URL ."/min/base.css",
    //     [],
    //     false,
    //     false
    // );

    // wp_register_script(
    //     'boot',
    //     REDRESS_ASSETS_URL .'/min/boot.js',
    //     [],
    //     false,
    //     false
    // );

    // // Core libraries and functions
    // wp_register_script(
    //     'redress',
    //     REDRESS_ASSETS_URL ."/min/redress.js",
    //     array('boot'),
    //     false,
    //     true
    // );

    // wp_enqueue_style('base');

    wp_enqueue_script('jquery');
    // wp_enqueue_script('boot');
    // wp_enqueue_script('redress');
}

/* <> */
