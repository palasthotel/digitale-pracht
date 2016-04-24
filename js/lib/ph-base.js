/**
 * Contains several helper classes for other Palasthotel libraries, e.g.
 * ph-scroll-class, ph-toggle-class etc.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 */
;"use strict";
window.ph = window.ph || {};


/**
 * helper function to read cookies
 * @url http://www.w3schools.com/js/js_cookies.asp
 */
ph.getCookie = function (cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
    }
    return "";
};


/**
 * helper function to write cookies
 * @url http://www.w3schools.com/js/js_cookies.asp
 */
ph.setCookie = function (cname, cvalue, exminutes) {
    var d = new Date();
    d.setTime(d.getTime() + (exminutes * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
};


// helper function to add a class to a given dom element
ph.addClass = function (object, className) {
    if (object.className) {
        // only add class, if not already existent
        var elClass = ' ' + object.className + ' ';
        if (elClass.indexOf(' ' + className + ' ') == -1) {
            object.className += ' ' + className;
        }
    }
    else {
        object.className = className;
    }
};


// helper function to remove a class to a given dom element
ph.removeClass = function (object, className) {
    var elClass = ' ' + object.className + ' ';
    while (elClass.indexOf(' ' + className + ' ') != -1) {
        elClass = elClass.replace(' ' + className + ' ', ' ');
    }
    object.className = elClass.trim();
};


ph.hasClass = function (object, className) {
    if (object.className && object.className.indexOf(className) > -1) {
        return true;
    }
    return false;
};


// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
ph.debounce = function (func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};
