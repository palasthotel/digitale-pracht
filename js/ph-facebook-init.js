/**
 * Init Facebook script if necessary.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 */
;"use strict";

// Palasthotel namespace
window.ph = window.ph || {};

ph.facebookIsInitialized = false;
ph.facebookInit = function () {
    if (!ph.facebookIsInitialized) {
        ph.facebookIsInitialized = true;
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.3";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    }
};
