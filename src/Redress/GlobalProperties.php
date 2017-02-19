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
 * ...
 *
 * @trait
 */
trait GlobalProperties
{

    /**
     * ...
     *
     * @var string
     * @access protected
     */
    protected $assetsDir;

    /**
     * ...
     *
     * @var string
     * @access protected
     */
    protected $assetsUrl;

    /**
     * ...
     *
     * @var string
     * @access protected
     */
    protected $baseDir;

    /**
     * ...
     *
     * @var string
     * @access protected
     */
    protected $baseUrl;

    /**
     * ...
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
     * @see https://developers.google.com/speed/libraries/#jquery
     */
    protected $jqv;

    /**
     * ...
     *
     * @var object
     * @access protected
     */
    protected $meta;

    /**
     * ...
     *
     * @var string
     * @access protected
     */
    private $redress;
}

/* <> */
