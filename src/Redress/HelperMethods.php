<?php

/**
 * Miscellaneous Helper Methods.
 *
 * @category   Helpers
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
trait HelperMethods
{

    /**
     * Determine Internet Explorer version (Not exactly 100% full-proof; but
     * close enough for our general purposes).
     *
     * @return integer|boolean Version number, or false if not Internet Explorer.
     * @access public
     */
    public function getIeBrowserVersion()
    {
        preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
        if (count($matches) < 2) {
            preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
        } elseif /* IE. */ (count($matches) > 1) {
            return $matches[1];
        }

        return false;
    }
}

/* <> */
