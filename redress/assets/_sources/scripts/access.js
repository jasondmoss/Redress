/**
 * Application Core.
 *
 * @category   JavaScript
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 */

var $ = jQuery;
var logo = $("div#login").find(">h1:nth-child(1)");
var title = $("div#login").find(">h2:nth-child(2)");

$.fn.swapWith = function (to) {
    "use strict";

    return this.each(function () {
        var copyTo = $(to).clone(true);
        var copyFrom = $(this).clone(true);

        $(to).replaceWith(copyFrom);
        $(this).replaceWith(copyTo);
    });
};

title.prependTo($("body"));

/* <> */
