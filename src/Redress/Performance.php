<?php

/**
 * Performance.
 *
 * @category   Performance
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress;

class Performance
{

    /**
     * @see http://php.net/manual/en/language.oop5.traits.php
     */
    use \Redress\HelperMethods;


    /**
     * Class initializer.
     *
     * @access public
     */
    public function __construct()
    {
        foreach ([
            [$this, 'dequeueScripts'],
            [$this, 'removeUnnecessaryScripts']
        ] as $action) {
            add_action('wp_enqueue_scripts', $action, 100);
        }

        add_filter('script_loader_tag', [$this, 'deferScripts']);
        add_filter('rest_enabled', [$this, 'returnFalse']);
        add_filter('rest_jsonp_enabled', [$this, 'returnFalse']);

        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        remove_action('wp_head', 'wp_generator');
    }


    /* -- */


    /**
     * Dequeue scripts
     */
    public function dequeueScripts()
    {
        wp_dequeue_script('picturefill');
    }


    /**
    * Defer scripts.
    *
    * @param string $tag Script tag.
    *
    * @return string Script tag.
    */
    public function deferScripts($tag)
    {
        if (is_admin()) {
            return $tag;
        }

        return str_replace(' src', ' defer="defer" src', $tag);
    }


    /**
    * Remove scripts.
    */
    public function removeUnnecessaryScripts()
    {
        wp_deregister_script('jquery');
        wp_deregister_script('wp-embed');
    }


    /**
     * @return boolean
     */
    public function returnFalse()
    {
        return false;
    }
}

/* <> */
