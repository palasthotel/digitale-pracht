/**
 * This will be the first script executed on every page load.
 * Perfect place for storing variables and executing JS stuff, which
 * is independent of document.ready.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 */
;"use strict";

// Palasthotel namespace
window.ph = window.ph || {};

ph.isIos     = (navigator.userAgent.match(/(iPhone|iPad|iPod|iOS)/i) !== null);
ph.isAndroid = (navigator.userAgent.match(/Android/i) !== null);
ph.isWp      = (navigator.userAgent.match(/IEMobile/i) !== null);

ph.breakpointTablet  = 958;
ph.breakpointDesktop = 1200;


// add mobile os classes
if (ph.isIos) {
    document.querySelector('html').className += ' is-ios';
}
if (ph.isAndroid) {
    document.querySelector('html').className += ' is-android';
}
if (ph.isWp) {
    document.querySelector('html').className += ' is-wp';
}

ph.isMobile = function () {
    return document.documentElement.clientWidth < ph.breakpointTablet;
};
