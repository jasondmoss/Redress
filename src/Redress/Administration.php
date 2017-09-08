<?php

/**
 * WordPress Administration.
 *
 * @category   Administration
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [GPL-2.0 License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress;

class Administration
{

    /**
     * @see http://php.net/manual/en/language.oop5.traits.php
     */
    use \Redress\HelperMethods;


    /**
     * @var object
     * @access protected
     */
    protected $redress;


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

        add_action('init', [$this, 'changePostObjectLabels']);
        add_filter('admin_footer_text', [$this, 'footerText']);
    }


    /* -- */


    /**
     * ...
     *
     * @access public
     */
    public function changePostObjectLabels()
    {
        global $wp_post_types;

        $labels = &$wp_post_types['post']->labels;

        $labels->name = _x('Articles', 'post type general name');
        $labels->singular_name = _x('Article', 'post type singular name');
        $labels->all_items = __('All Articles', 'redress');
        $labels->add_new = __('Add new Article', 'redress');
        $labels->add_new_item = __('Add new Article', 'redress');
        $labels->edit_item = __('Edit Article', 'redress');
        $labels->new_item = __('New Article', 'redress');
        $labels->view_item = __('View Article', 'redress');
        $labels->search_items = __('Search Articles', 'redress');
        $labels->not_found = __('No Articles found', 'redress');
        $labels->not_found_in_trash = __('No Articles found in Trash', 'redress');
        $labels->menu_name = __('Articles', 'redress');
        $labels->name_admin_bar = __('Article', 'redress');
    }


    /**
     * Custom footer credits.
     *
     * @access public
     */
    public function footerText()
    {
        $urlJdmlabs = '<a rel="external" href="https://www.jdmlabs.com/" title="JdmLabs: The On-line Laboratory'.
            ' of Jason D. Moss">Jason D. Moss</a>';
        $urlWordpress = '<a rel="external" href="https://codex.wordpress.org/Main_Page" title="The online manual for'.
            ' WordPress">WordPress Codex</a>';

        _e("Managed by {$urlJdmlabs} &#160;&#160;WordPress Help: {$urlWordpress}", 'redress');
    }
}

/* <> */
