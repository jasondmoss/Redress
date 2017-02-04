/* mu-plugins v0.3.2 [ 2017-02-04 ]
 *
 * ...
 *
 * Package    WordPress
 * Subpackage MustUsePlugin|Redress
 * Version    0.3.2
 * Author     Jason D. Moss <jason@jdmlabs.com>
 * Copyright  2017 Jason D. Moss. All rights freely given.
 * License    https://github.com/jasondmoss/mu-plugins/blob/master/LICENSE.md [WTFPL License]
 * Link       https://github.com/jasondmoss/mu-plugins
 */

var $=jQuery,logo=$("div#login").find(">h1:nth-child(1)"),title=$("div#login").find(">h2:nth-child(2)");$.fn.swapWith=function(to){"use strict";return this.each(function(){var copyTo=$(to).clone(!0),copyFrom=$(this).clone(!0);$(to).replaceWith(copyFrom),$(this).replaceWith(copyTo)})},title.prependTo($("body"));
//# sourceMappingURL=access.js.map