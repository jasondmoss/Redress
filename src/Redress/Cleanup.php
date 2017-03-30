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

        /* ... */
        remove_filter('the_excerpt', 'wpautop');


        //////


        /* Remove the WordPress version from RSS feeds. */
        add_filter('the_generator', '__return_false');


        /**
         * Clean up output of stylesheet <link> tags.
         *
         * @param string $input
         *
         * @return string
         */
        add_filter('style_loader_tag', function ($input) {
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

            /**
             * HTML5-ize single elements.
             *
             * @param string $input
             *
             * @return string
             */
            return function ($input) {
                return preg_replace('/\s+\/>/', '>', $input);
            };
        });


        /**
         * Clean up output of script tags.
         *
         * @param string $input
         *
         * @return string
         */
        add_filter('script_loader_tag', function ($input) {
            $input = str_replace(" type='text/javascript'", '', $input);
            $input = str_replace(' type="text/javascript"', '', $input);
            $input = str_replace("'", '"', $input);

            return $input;
        });


        /**
         * Don't return the default description in the RSS feed if it hasn't been
         * changed from the default value.
         *
         * @param string $tagline
         *
         * @return string
         */
        add_filter('get_bloginfo_rss', function ($tagline) {
            $defaultTagline = 'Just another WordPress site';

            return ($tagline === $defaultTagline) ? '' : $tagline;
        });


        /**
         * Hide WP version strings from scripts and styles.
         *
         * @param string $src
         *
         * @return string
         */
        foreach ([ 'script_loader_src', 'style_loader_src' ] as $filter) {
            add_filter($filter, function ($src) {
                parse_str(parse_url($src, PHP_URL_QUERY), $query);
                if (!empty($query['ver'])) {
                    $src = remove_query_arg('ver', $src);
                }

                return $src;
            });
        }


        /**
         * HTML5-ize single elements.
         *
         * @param string $element
         *
         * @return string
         */
        foreach ([
            'the_excerpt',
            'the_content',
            'post_thumbnail_html',
            'get_avatar',
            'comment_text',
            'comment_id_fields'
        ] as $filter) {
            add_filter($filter, function ($element) {
                return preg_replace('/\s+\/>/', '>', $element);
            }, 10);
        }


        /**
         * Remove update notifications for non-admin users.
         *
         */
        add_action('admin_notices', function () {
            if (!current_user_can('activate_plugins')) {
                remove_action('admin_notices', 'update_nag', 3);
            }
        }, 1);


        /**
         * Remove Admin Menu Link to Theme Customizer
         *
         */
        add_action('admin_menu', function () {
            global $submenu;

            if (isset($submenu['themes.php'])) {
                foreach ($submenu['themes.php'] as $index => $menu_item) {
                    if (in_array('Customize', $menu_item)) {
                        unset($submenu['themes.php'][$index]);
                    }
                }
            }
        });


        /**
         * Remove unneeded menu items from the adminbar.
         *
         * @param \WP_Admin_Bar $wpAdminBar
         */
        add_action('admin_bar_menu', function ($wpAdminBar) {
            $wpAdminBar->remove_menu('customize');
            $wpAdminBar->remove_menu('themes');
        }, 999);
    }
}

/* <> */
