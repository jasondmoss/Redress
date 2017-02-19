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
        add_action('admin_menu', [$this, 'redressSettingsMenu']);
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
    public function redressSettingsMenu()
    {
        add_options_page(
            __('Redress Settings', 'redress'),
            __('Redress', 'redress'),
            'manage_options',
            'redress-settings',
            [$this, 'redressSettingsPage']
        );

        add_action('admin_init', [$this, 'registerRedressSettings']);
    }


    /**
     * Create the admin settings page.
     *
     * @return void
     * @access public
     */
    public function redressSettingsPage()
    {
        ?>

<div class="wrap">
  <h2><?php _e("Redress <small>(v{$this->version})</small> Settings", 'redress'); ?></h2><hr>
</div>

        <?php
    }


    /* -- */


    /**
     * Register all of our settings 'sections'.
     *
     * @return void
     * @access public
     */
    public function registerRedressSettings()
    {
        $this->generalSection();
        $this->modulesSection();
    }


    /**
     * Register and define general settings.
     *
     * @return void
     * @access private
     */
    private function generalSection()
    {
        /**/
    }


    /**
     * Register and define general settings.
     *
     * @return void
     * @access private
     */
    private function modulesSection()
    {
        /**/
    }
}

/* <> */
