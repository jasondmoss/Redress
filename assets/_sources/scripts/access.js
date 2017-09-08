/**
 * WordPress Access (Login Screen).
 *
 * @category   JavaScript
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [GPL-2.0 License]
 * @link       https://github.com/jasondmoss/redress/
 */

if /* Browser passes check? */(okay) {

    var body = document.getElementsByTagName("body")[0];
    var logo = document.querySelector("#login").getElementsByTagName("h1")[0];
    var title = document.querySelector("#login").getElementsByTagName("h2")[0];

    body.insertBefore(title, body.firstChild);
}

/* <> */
