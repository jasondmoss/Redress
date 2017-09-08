<?php

/**
 * Redress Management.
 *
 * @category   Settings
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [GPL-2.0 License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress\Settings;

class Manager
{

    /**
     * @see http://php.net/manual/en/language.oop5.traits.php
     */
    use \Redress\HelperMethods;


    /**
     * @var string
     * @access protected
     */
    protected $version;


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
    public function redressManagerPage()
    {
        ?>

<div class="wrap">
  <h2><?php _e("Redress Manager <small>(v{$this->version})</small>", 'redress'); ?></h2><hr>
  <p class="howto">This is the Redress Manager ...</p>

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
    public function redressManagerSections()
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
