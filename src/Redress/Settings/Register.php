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

use Redress\Settings\Page as SettingsPage;

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

        add_filter('plugin_action_links', [$this, 'redressSettingsLink'], 10, 2);
        add_action('admin_menu', [$this, 'registerSettingsPage']);
    }


    /* -- */


    /**
     * ...
     *
     * @access public
     */
    public function redressSettingsLink($links, $file)
    {
        if ($file == $this->redress) {
            // Settings Link.
            $redressLink['settings'] = '<a href="options-general.php?page=redress-settings">'.
                __('Settings', 'redress') .'</a>';

            // Modules Link.
            $redressLink['modules'] = '<a href="options-general.php?page=redress-settings#modules">'.
                __('Modules', 'redress') .'</a>';

            // Let's set the order to: Settings, Modules, [WP Defined]
            array_unshift($links, $redressLink['modules']);
            array_unshift($links, $redressLink['settings']);
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
    public function registerSettingsPage()
    {
        $settingsPage = new SettingsPage($this->version);
        add_options_page(
            __('Redress Settings', 'redress'),
            __('Redress', 'redress'),
            'manage_options',
            'redress-settings',
            [$settingsPage, 'redressSettingsPage']
        );

        add_action('admin_init', [$settingsPage, 'settingsPageSections']);
    }
}

/* <> */
