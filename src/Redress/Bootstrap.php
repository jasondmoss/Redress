<?php

/**
 * Bootstrap Must-Use Plug-In.
 *
 * @category   Bootstrap
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress;

class Bootstrap
{

    /**
     *
     */
    use \Redress\GlobalProperties;
    use \Redress\HelperMethods;


    /**
     * Class initializer.
     *
     * @param string $redressAssetsDir
     * @param string $redressAssetsUrl
     * @param string $jQueryVersion
     *
     * @access public
     */
    public function __construct($redressAssetsDir, $redressAssetsUrl, $jQueryVersion)
    {
        $this->assetsDir = $redressAssetsDir;
        $this->assetsUrl = $redressAssetsUrl;
        $this->jqv = $jQueryVersion;

        add_action('init', [$this, 'redressLoadTextDomain']);
        add_action('wp_enqueue_scripts', [$this, 'redressPublicAssets']);
        add_action('admin_enqueue_scripts', [$this, 'redressAdminAssets']);
    }


    /* ---------------------------------------------------------------------- */


    /**
     * Load/Register the Redress text domain (Translations).
     *
     * @return void
     * @access public
     */
    public function redressLoadTextDomain()
    {
        load_plugin_textdomain('redress', false, "{$this->assetsDir}language/");
    }


    /**
     * Add a "Settings" link on the plugins.php page.
     *
     * @param array $links
     *
     * @return array
     * @access public
     */
    public function redressSettingsLink($links)
    {
        $settingsLink = '<a href="'. admin_url('admin.php?page=redress') .'">Settings</a>';
        array_unshift($links, $settingsLink);

        return $links;
    }


    /**
     * Custom Script and Style.
     *
     * @return void
     * @access public
     */
    public function redressAdminAssets()
    {
        wp_register_style('redress-admin-style', "{$this->assetsUrl}/min/admin.css", [], false, 'all');

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
    public function redressPublicAssets()
    {
        /**
         * De-register WordPress' version of jQuery.
         */
        wp_deregister_script('jquery');

        /**
         * If the current browser is Microsoft's Internet Explorer, attempt to
         * determine the base version.
         */
        if ($ieVersion = $this->getIeBrowserVersion()) {
            // WTF?  Still using an IE below v.9?  Geesh.
            if ($ieVersion < 9) {
                $this->jqv = '1.12.4';
            }
        }

        wp_register_script(
            'jquery',
            "//ajax.googleapis.com/ajax/libs/jquery/{$this->jqv}/jquery.min.js",
            [],
            false,
            true
        );

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
}

/* <> */
