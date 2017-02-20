<?php

/**
 * Register.
 *
 * @category   Settings
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress\Settings;

use Redress\Settings\Manager as ManagerPage;
use Redress\Settings\Options as OptionsPage;

class Register
{

    /**
     *
     */
    use \Redress\GlobalProperties;


    /**
     * Class initializer.
     *
     * @access public
     */
    public function __construct($pluginBasename, $redressVersion)
    {
        $this->redress = $pluginBasename;
        $this->version = $redressVersion;

        add_filter('plugin_action_links', [$this, 'redressPluginLinks'], 10, 2);
        add_action('admin_menu', [$this, 'redressPluginOptions']);
    }


    /* -- */


    /**
     * ...
     *
     * @access public
     */
    public function redressPluginLinks($links, $file)
    {
        if ($file == $this->redress) {
            // Plugin Options Link.
            $redressLink['options'] = '<a href="options-general.php?page=redress-options">'.
                __('Plugin Options', 'redress') .'</a>';

            // Redress Manager Link.
            $redressLink['manage'] = '<a href="options-general.php?page=redress-manager">'.
                __('Manage', 'redress') .'</a>';

            // Let's set the order to: Manage, Options, [WP Defined]
            array_unshift($links, $redressLink['options']);
            array_unshift($links, $redressLink['manage']);
            array_merge($redressLink, $links);
        }

        return $links;
    }


    /**
     * Register our admin settings page.
     *
     * @return void
     * @access public
     */
    public function redressPluginOptions()
    {
        $managerPage = new Manager($this->version);
        $optionsPage = new Options($this->version);

        add_options_page(
            __('Redress Options', 'redress'),
            __('Redress Options', 'redress'),
            'manage_options',
            'redress-options',
            [$optionsPage, 'redressOptionsPage']
        );

        /**
         * Register a custom menu page.
         */
        add_menu_page(
            __('Redress Manager', 'redress'),
            __('Redress Manager', 'redress'),
            'manage_options',
            'redress-manager',
            [$managerPage, 'redressManagerPage'],
            'dashicons-schedule',
            '59.1'
        );

        add_submenu_page(
            'redress-manager',
            __('Redress Options', 'redress'),
            __('Redress Options', 'redress'),
            'manage_options',
            'options-general.php?page=redress-options'
        );

        foreach ([
            [$managerPage, 'redressManagerSections'],
            [$optionsPage, 'redressOptions']
        ] as $action) {
            add_action('admin_init', $action);
        }
    }
}

/* <> */
