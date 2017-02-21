<?php

/**
 * Media.
 *
 * @category   Media
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress;

class Media
{

    /**
     *
     */
    use \Redress\GlobalProperties;
    use \Redress\HelperMethods;


    /**
     * Class initializer.
     *
     * @access public
     */
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'defaultMediaSettings']);
        add_filter('image_size_names_choose', [$this, 'customImageSizes']);
        add_action('upload_mimes', [$this, 'uploadableMimeTypes']);
        add_action('jpeg_quality', [$this, 'customJpegQuality']);

        /**
         * Don't assume I want media embedding by default...
         */
        add_action('init', function () {
            remove_action('rest_api_init', 'wp_oembed_register_route');
            remove_action('wp_head', 'wp_oembed_add_discovery_links');
            remove_action('wp_head', 'wp_oembed_add_host_js');
            remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        }, PHP_INT_MAX - 1);

        /*  */
        add_filter('embed_oembed_html', [$this, 'customOembedFilter'], 10, 4);

        /* Remove inline CSS and JS for WP emoji support. */
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

        /* Disable smilies. */
        add_filter('option_use_smilies', '__return_false');

        /* Remove inline CSS used by posts with galleries. */
        add_filter('use_default_gallery_style', '__return_false');
    }


    /* -- */


    /**
     * Default settings when adding or editing post images.
     */
    public function defaultMediaSettings()
    {
        update_option('image_default_align', 'center');
        update_option('image_default_link_type', 'none');
        update_option('image_default_size', 'large');
    }


    /**
     * Add custom image sizes option to WP admin.
     *
     * @param array $sizes Default sizes
     *
     * @return array Updated sizes
     */
    public function customImageSizes($sizes)
    {
        return array_merge($sizes, [
            'small' => __('Small'),
        ]);
    }


    /**
     * Allowing additional image types.
     *
     * @param array $mimes mime types
     *
     * @return array extended mime types
     */
    public function uploadableMimeTypes($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';

        return $mimes;
    }


    /**
     * Sets custom JPG quality when resizing images.
     *
     * @return number JPG Quality
     */
    public function customJpegQuality()
    {
        return 80;
    }


    /**
     * Custom container for content videos.
     */
    public function customOembedFilter($html, $url, $attr, $post_ID)
    {
        $return = "<div class=\"c-video\">{$html}</div>";

        return $return;
    }


    /**
     * Allows to use standard WP method for getting attachments.
     *
     * @param [string] $src Attachment src
     * @param [number] $id  Attachment ID
     *
     * @return [string] Attachment URL
     */
    public function get_attachment($src, $id)
    {
        return wp_get_attachment_image_src($id, $size)[0];
    }
}

/* <> */
