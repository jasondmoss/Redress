<?php

/**
 * WordPress Redress.
 * Map public functions to/from application classes.
 *
 * @package    WordPress
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2016 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 */


/**
 * Dump variable to screen, prettily.
 *
 * @param mixed $variable Variable to be "dumped" to screen.
 * @param \MU   $k        Application instance.
 *
 * @return string
 * @access public
 */
$dump = function ($variable) use ($k) {
    return $k->development->dump($variable);
};

/* <> */
