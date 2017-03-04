<?php

/**
 * General WordPress Clean-Up.
 *
 * @category   CleanUp
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress;

class Cleanup
{

    /**
     * Class initializer.
     *
     * @access public
     */
    public function __construct()
    {
        /* Remove unnecessary <link>'s. */
        add_action('wp_head', 'ob_start', 1, 0);
        add_action('wp_head', function () {
            ob_start();
            $pattern = '/.*'. preg_quote(esc_url(get_feed_link('comments_'. get_default_feed())), '/') .'.*[\r\n]+/';
            echo preg_replace($pattern, '', ob_get_clean());
        }, 3, 0);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);
        remove_action('wp_head', 'wp_resource_hints', 2);

        /* Remove inline CSS used by Recent Comments widget. */
        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', [
                $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
                'recent_comments_style'
            ]);
        }

        /*  */
        remove_filter('the_excerpt', 'wpautop');


        //////


        /* Remove the WordPress version from RSS feeds. */
        add_filter('the_generator', '__return_false');

        /*  */
        add_filter('style_loader_tag', [$this, 'cleanStyleTag']);
        add_filter('script_loader_tag', [$this, 'cleanScriptTag']);

        /*  */
        add_filter('get_bloginfo_rss', [$this, 'removeDefaultDescription']);

        /* Remove WP version info appended to styles and scripts. */
        // foreach ([
        //     'script_loader_src',
        //     'style_loader_src'
        // ] as $filter) {
        //     add_filter($filter, [$this, 'removeWordPressVersionStrings']);
        // }

        /* HTML5-ize single elements. */
        foreach ([
            'the_excerpt',
            'the_content',
            'post_thumbnail_html',
            'get_avatar',
            'comment_text',
            'comment_id_fields'
        ] as $filter) {
            add_filter($filter, [$this, 'stripSingleElement'], 10);
        }
    }


    /* -- */


    /**
     * Clean up output of stylesheet <link> tags.
     *
     * @param string $input
     *
     * @return string
     * @access public
     */
    public function cleanStyleTag($input)
    {
        preg_match_all(
            "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!",
            $input,
            $matches
        );

        if (isset($matches[2][0]) && isset($matches[3][0])) {
            /**
             * Only display media if it is actually meaningful.
             */
            $media = ('' !== $matches[3][0]/* && 'all' !== $matches[3][0]*/) ? " media=\"{$matches[3][0]}\"" : '';

            return "<link rel=\"stylesheet\" href=\"{$matches[2][0]}\"{$media}>\n";
        }

        return $this->stripSingleElement($input);
    }


    /**
     * Clean up output of script tags.
     *
     * @param string $input
     *
     * @return string
     * @access public
     */
    public function cleanScriptTag($input)
    {
        $input = str_replace(" type='text/javascript'", '', $input);
        $input = str_replace(' type="text/javascript"', '', $input);
        $input = str_replace("'", '"', $input);

        return $input;
    }


    /**
     * Hide WP version strings from scripts and styles.
     *
     * @param string $src
     *
     * @return string
     * @access public
     */
    public function removeWordPressVersionStrings($src)
    {
        parse_str(parse_url($src, PHP_URL_QUERY), $query);
        if (!empty($query['ver'])) {
            $src = remove_query_arg('ver', $src);
        }

        return $src;
    }


    /**
     * Don't return the default description in the RSS feed if it hasn't been
     * changed from the default value.
     *
     * @param string $tagline
     *
     * @return string
     * @access public
     */
    public function removeDefaultDescription($tagline)
    {
        $defaultTagline = 'Just another WordPress site';

        return ($tagline === $defaultTagline) ? '' : $tagline;
    }


    /**
     *
     */
    public function stripSingleElement($element)
    {
        return preg_replace('/\s+\/>/', '>', $element);
    }
}

/* <> */
