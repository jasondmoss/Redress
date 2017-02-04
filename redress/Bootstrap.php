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
// add_action('wp_enqueue_scripts', 'loadSiteAssets');
add_action('admin_enqueue_scripts', 'loadAdminAssets');
add_action('login_enqueue_scripts', 'registerAccessAssets', 10);


/* -------------------------------------------------------------------------- */


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
function registerAccessAssets()
{
    wp_register_style('redress-access-style', REDRESS_ASSETS_URL .'/min/access.min.css', [], false, 'all');
    wp_register_script(
        'redress-access-script',
        REDRESS_ASSETS_URL .'/min/access.min.js',
        [ 'jquery' ], // Required dependency for WP scripts.
        false,
        true
    );

    wp_enqueue_style('redress-access-style');
    wp_enqueue_script('redress-access-script');
}


/**
 * Custom Script and Style.
 *
 * @return void
 * @access public
 */
function loadAdminAssets($hook)
{
    wp_register_style(
        'redress-admin-style',
        REDRESS_ASSETS_URL ."/min/admin.min.css",
        array(),
        false,
        'all'
    );

    // wp_register_script(
    //     'redress-core-script',
    //     REDRESS_ASSETS_URL ."/min/redress.min.js",
    //     array('jquery-ui-sortable'),
    //     false,
    //     true
    // );

    // wp_register_script(
    //     'redress-admin-script',
    //     REDRESS_ASSETS_URL ."/min/redress-admin.min.js",
    //     array('redress-core-script'),
    //     false,
    //     true
    // );

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
function loadSiteAssets($hook)
{
    // Unregister WP styles.
    wp_deregister_script('jquery');

    // Unregister WP styles.
    wp_deregister_style('admin-bar');
    wp_deregister_style('boxes');

    wp_register_style(
        'base',
        REDRESS_ASSETS_URL ."/min/base.min.css",
        array(),
        false,
        false
    );

    wp_register_script(
        'boot',
        REDRESS_ASSETS_URL .'/min/boot.min.js',
        array(),
        false,
        false
    );

    // Core libraries and functions
    wp_register_script(
        'redress',
        REDRESS_ASSETS_URL ."/min/redress.min.js",
        array('boot'),
        false,
        true
    );

    wp_enqueue_style('base');

    wp_enqueue_script('boot');
    wp_enqueue_script('redress');
}

/* <> */
