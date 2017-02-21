<?php

/**
 * WordPress Administration.
 *
 * @category   Administration
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress;

class Administration
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
    public function __construct($redressImageUrl)
    {
        $this->imageUrl = $redressImageUrl;

        add_filter('admin_footer_text', [$this, 'footerText']);
    }


    /* -- */


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
