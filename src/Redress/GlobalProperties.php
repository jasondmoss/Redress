<?php

/**
 * Global Properties.
 *
 * @category   Properties
 * @package    WordPress
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

namespace Redress;

/**
 * Global Properties.
 *
 * @trait
 */
trait GlobalProperties
{

    /**
     * Absolute path to plug-in assets.
     *
     * @var string
     * @access protected
     */
    protected $assetsDir;

    /**
     * Absolute URL to plug-in assets.
     *
     * @var string
     * @access protected
     */
    protected $assetsUrl;

    /**
     * Absolute path to plug-in.
     *
     * @var string
     * @access protected
     */
    protected $baseDir;

    /**
     * Absolute URL to plug-in.
     *
     * @var string
     * @access protected
     */
    protected $baseUrl;

    /**
     * Are we in "Development" mode?
     *
     * @var boolean
     * @access protected
     */
    protected $devel;

    /**
     * Preferred jquery version.
     *
     * @var string
     * @access protected
     *
     * @see https://developers.google.com/speed/libraries/#jquery
     */
    protected $jqv;

    /**
     * Absolute path to plug-in language files.
     *
     * @var string
     * @access protected
     */
    protected $langDir;

    /**
     * Objectified bloginfo() data.
     *
     * @var object
     * @access protected
     */
    protected $meta;

    /**
     * Plug-in basename.
     *
     * @var string
     * @access protected
     */
    protected $redress;

    /**
     * Plug-in version.
     *
     * @var string
     * @access protected
     */
    protected $version;
}

/* <> */
