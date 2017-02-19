<?php

/**
 * Settings Page.
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

class Page
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
    public function __construct($pluginVersion)
    {
        $this->version = $pluginVersion;
    }


    /* -- */


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
  <p class="howto">General plug-in description will go here, followed by actual options...</p>

  <?php /*
  <form action="options.php" method="post">
    <?php settings_fields('redress_option_group'); ?>
    <?php submit_button(); ?>

    <div class="redress-options-section">
      <?php do_settings_sections('redress-general-settings'); ?>
    </div>

    <div class="redress-options-section">
      <?php do_settings_sections('redress-recaptcha-settings'); ?>
    </div>

    <div class="redress-options-section">
      <?php do_settings_sections('redress-miscellaneous-settings'); ?>
    </div>

    <?php submit_button(); ?>
  </form>
  */ ?>
</div>

        <?php
    }


    /**
     * Register all of our settings 'sections'.
     *
     * @return void
     * @access public
     */
    public function settingsPageSections()
    {
        $this->generalSection();
        $this->modulesSection();
    }


    /* -- */


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
