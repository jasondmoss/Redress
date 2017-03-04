<?php

/**
 * Bootstrap.
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
     * @param object $redress
     *
     * @access public
     */
    public function __construct($redress)
    {
        $this->redress = $redress;

        add_action('plugins_loaded', [$this, 'redressLanguageFiles']);

        add_action('wp_enqueue_scripts', [$this, 'redressPublicAssets']);
        add_action('admin_enqueue_scripts', [$this, 'redressAdminAssets']);
    }


    /* -- */


    /**
     * Load/Register the Redress text domain (Translations).
     *
     * @return void
     * @access public
     */
    public function redressLanguageFiles()
    {
        load_plugin_textdomain('redress', false, $this->redress->langDir);
    }


    /**
     * Custom Script and Style.
     *
     * @return void
     * @access public
     */
    public function redressAdminAssets()
    {
        wp_register_style('redress-admin-style', "{$this->redress->assets}/redress-admin.css", [], false, 'all');
        wp_register_style('redress-modules-style', "{$this->redress->assets}/redress-modules.css", [], false, 'all');

        // wp_register_script('redress-core-script', "{$this->redress->assets}/redress.js", [
        //     'jquery-ui-sortable'
        // ], false, true);

        wp_register_script('redress-admin-script', "{$this->redress->assets}/redress-admin.js", [
        //     'redress-core-script'
        ], false, true);

        wp_enqueue_style('redress-admin-style');
        wp_enqueue_style('redress-modules-style');

        // wp_enqueue_script('redress-core-script');
        wp_enqueue_script('redress-admin-script');
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
         * De-register jQuery.
         */
        wp_deregister_script('jquery');

        /**
         * If the current browser is Microsoft's Internet Explorer, attempt to
         * determine the base version.
         */
        // if ($ieVersion = $this->getIeBrowserVersion()) {
        //     // WTF?  Still using an IE below v.9?  Geesh.
        //     if ($ieVersion < 9) {
        //         $this->redress->jQueryVersion = '1.12.4';
        //     }
        // }
        //
        // wp_register_script(
        //     'jquery',
        //     "//cdn.jsdelivr.net/jquery/{$this->redress->jQueryVersion}/jquery.min.js",
        //     [],
        //     false,
        //     true
        // );


        wp_register_script(
            'umbrella',
            "//cdn.jsdelivr.net/umbrella/{$this->redress->umbrellaVersion}/umbrella.min.js",
            [],
            false,
            true
        );


        // // Core libraries and functions
        // wp_register_script(
        //     'redress',
        //     "{$this->redress->assets}/redress.js",
        //     array('boot'),
        //     false,
        //     true
        // );

        // wp_enqueue_style('base');

        // wp_enqueue_script('jquery');
        wp_enqueue_script('umbrella');
        // wp_enqueue_script('boot');
        // wp_enqueue_script('redress');
    }
}

/* <> */
