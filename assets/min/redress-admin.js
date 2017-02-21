/* redress v0.5.0 [ 2017-02-20 ]
 *
 * ...
 *
 * Package    WordPress
 * Subpackage Redress
 * Version    0.5.0
 * Author     Jason D. Moss <jason@jdmlabs.com>
 * Copyright  2017 Jason D. Moss. All rights freely given.
 * License    https://github.com/jasondmoss/redress/blob/master/LICENSE.md [WTFPL License]
 * Link       https://github.com/jasondmoss/redress
 */

function mergeArrays(){return[].concat.apply([],arguments)}var okay=function(){return"querySelector"in document&&"addEventListener"in window&&Array.prototype.forEach};if(okay)var App=App||{};if(okay){App.Admin={ExtUrl:Array.from(document.querySelectorAll("a[rel~=external]")),ExtUrlEditScreen:Array.from(document.querySelectorAll("#the-list .row-actions .view > a"))||[],ExtUrlPlugins:Array.from(document.querySelectorAll(".wp-list-table.plugins .plugin-description a, .plugin-version-author-uri a"))||[]};var ExternalURLs=mergeArrays(App.Admin.ExtUrl,App.Admin.ExtUrlEditScreen,App.Admin.ExtUrlPlugins);[].forEach.call(ExternalURLs,function(item,index){item.setAttribute("target","_blank")})}
//# sourceMappingURL=redress-access.js.map