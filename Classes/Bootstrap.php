<?php

/**
 * ...
 *
 * @category   Bootstrap
 * @package    WordPress
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2016 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [MIT License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 */


namespace MU\Classes;

/**
 * Class Bootstrap
 *
 * @package mu-plugins\Classes
 */
class Bootstrap
{

    /**
     * Bootstrap constructor.
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'redressLoadTextDomain']);
        // add_action('admin_enqueue_scripts', [$this, 'loadAdminAssets']);
        // add_action('wp_enqueue_scripts', [$this, 'loadSiteAssets']);
    }


    /* -- */


    /**
     * Load/Register the Redress text domain (Translations).
     *
     * @return void
     * @access public
     * @final
     */
    final public function redressLoadTextDomain()
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
     * @final
     */
    final public function redressSettingsLink($links)
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
     * @final
     */
    final public function loadAdminAssets()
    {
        wp_register_style(
            'redress-admin',
            REDRESS_ASSETS_URL ."/css/{$this->dev}redress-admin.css",
            array(),
            $this->rand,
            'all'
        );

        wp_register_script(
            'redress-core',
            REDRESS_ASSETS_URL ."/js/{$this->dev}redress.js",
            array('jquery-ui-sortable'),
            $this->rand,
            true
        );

        wp_register_script(
            'redress-admin',
            REDRESS_ASSETS_URL ."/js/{$this->dev}redress-admin.js",
            array('redress-core'),
            $this->rand,
            true
        );

        wp_enqueue_style('redress-admin');

        wp_enqueue_script('redress-core');
        wp_enqueue_script('redress-admin');
    }


    /**
     * Enqueues the assets.
     *
     * @return void
     * @access public
     * @final
     */
    final public function loadSiteAssets()
    {
        // Unregister WP styles
        wp_deregister_script('jquery');

        // Unregister WP styles
        wp_deregister_style('admin-bar');
        wp_deregister_style('boxes');

        wp_register_style(
            'base',
            REDRESS_ASSETS_URL ."/css/{$this->dev}base.css",
            array(),
            $this->rand,
            false
        );

        wp_register_script(
            'boot',
            REDRESS_ASSETS_URL .'/js/library/boot.js',
            array(),
            $this->rand,
            false
        );

        // Core libraries and functions
        wp_register_script(
            'redress',
            REDRESS_ASSETS_URL ."/js/{$this->dev}redress.js",
            array('boot'),
            $this->rand,
            true
        );

        wp_enqueue_style('base');

        wp_enqueue_script('boot');
        wp_enqueue_script('redress');
    }
}

/* <> */
