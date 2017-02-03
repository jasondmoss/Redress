<?php

/**
 * ...
 *
 * @category   CleanUp
 * @package    WordPress
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2016 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 */


/**
 * Cleanup constructor.
 *
 * @return void
 * @access public
 */
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

/**
 * Don't assume I want media embedding by default...
 */
add_action('init', function () {
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
}, PHP_INT_MAX - 1);

/* Remove inline CSS and JS for WP emoji support. */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

/* Remove inline CSS used by posts with galleries. */
add_filter('use_default_gallery_style', '__return_false');

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

/* Remove the WordPress version from RSS feeds. */
add_filter('the_generator', '__return_false');

/*  */
add_filter('style_loader_tag', 'cleanStyleTag');
add_filter('script_loader_tag', 'cleanScriptTag');

/*  */
add_filter('embed_oembed_html', 'embedWrap');

/*  */
add_filter('get_bloginfo_rss', 'removeDefaultDescription');

/* Remove WP version info appended to styles and scripts. */
foreach ([
    'script_loader_src',
    'style_loader_src'
] as $filter) {
    add_filter($filter, 'removeWordPressVersionStrings');
}

/* HTML5-ize all content output. */
foreach ([
    'the_excerpt',
    'the_content',
    'post_thumbnail_html',
    'get_avatar',
    'comment_text',
    'comment_id_fields'
] as $filter) {
    add_filter($filter, 'removeSelfClosingTags', 10);
}


/* -------------------------------------------------------------------------- */


/**
 * Clean up output of stylesheet <link> tags.
 *
 * @param string $input
 *
 * @return string
 * @access public
 */
function cleanStyleTag($input)
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

    return preg_replace('/\s+\/>/', '>', $input);
}


/**
 * Clean up output of script tags.
 *
 * @param string $input
 *
 * @return string
 * @access public
 */
function cleanScriptTag($input)
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
function removeWordPressVersionStrings($src)
{
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver'])) {
        $src = remove_query_arg('ver', $src);
    }

    return $src;
}


/**
 * Remove unnecessary self-closing tags.
 *
 * @param string $input
 *
 * @return mixed
 * @access public
 */
function removeSelfClosingTags($input)
{
    return preg_replace('/\s+\/>/', '>', $input);
}


/**
 * Wrap embedded media as suggested by Readability.
 *
 * @param string $cache
 *
 * @return string
 * @access public
 */
function embedWrap($cache)
{
    return "<div class=\"entry-content-asset\">{$cache}</div>";
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
function removeDefaultDescription($tagline)
{
    $defaultTagline = 'Just another WordPress site';

    return ($tagline === $defaultTagline) ? '' : $tagline;
}

/* <> */
