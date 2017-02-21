/**
 * Redress App Core.
 *
 * @category   JavaScript
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */


/**
 * Browser capability test.
 *
 * @returns {Boolean} True if browser supports
 */
var okay = function () {
    return (
        "querySelector" in document &&
        "addEventListener" in window &&
        Array.prototype.forEach
    );
};


/**
 * Concatenate individual arrays into single array for easier manipulation.
 *
 * @param {Array} Individual arrays; as many as required.
 *
 * @returns {Array} Concatenated array.
 */
function mergeArrays()
{
    return [].concat.apply([], arguments);
}


/* -- */


if /* Browser passes check? */(okay) {

    /**
     * ...
     *
     * @var {Object}
     */
    var App = App || {};
}

/* <> */
