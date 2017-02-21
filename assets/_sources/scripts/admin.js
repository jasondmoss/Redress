/**
 * Redress Administration.
 *
 * @category   JavaScript
 * @subpackage Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2017 Jason D. Moss. All rights freely given.
 * @license    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/redress/
 */

if /* Browser passes check? */(okay) {

    /**
     * Admininstration variables.
     *
     * @var {Object}
     */
    App.Admin = {
        ExtUrl: Array.from(document.querySelectorAll("a[rel~=external]")),
        ExtUrlEditScreen: Array.from(document.querySelectorAll("#the-list .row-actions .view > a")),
        ExtUrlHelpSidebar: Array.from(document.querySelectorAll(".contextual-help-sidebar a")),
        ExtUrlPlugins: Array.from(
            document.querySelectorAll(".wp-list-table.plugins .plugin-description a, .plugin-version-author-uri a")
        )
    };


    /**
     * External Links.    ---------------------------------------------------- *
     *
     * Open external links in new tab/window.
     */
    var ExternalURLs = mergeArrays(
        App.Admin.ExtUrl,
        App.Admin.ExtUrlEditScreen,
        App.Admin.ExtUrlHelpSidebar,
        App.Admin.ExtUrlPlugins
    );
    [].forEach.call(ExternalURLs, function (item, index) {
        item.setAttribute("target", "_blank");
    });
}

/* <> */
