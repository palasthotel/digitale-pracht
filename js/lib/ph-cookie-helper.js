/**
 * Helper functions for adding, removing and checking cookies.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @version 2.0
 */

;(function (document, ph) {

	/**
	 * Read the value of a cookie.
	 * @url http://www.w3schools.com/js/js_cookies.asp
	 */
	ph.getCookie = function (cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i].replace(/^\s+|\s+$/g, '');  // Trim left and right
			if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
		}
		return "";
	};


	/**
	 * Create a cookie.
	 * @url http://www.w3schools.com/js/js_cookies.asp
	 */
	ph.setCookie = function (cname, cvalue, exminutes) {
		var d = new Date();
		d.setTime(d.getTime() + (exminutes * 60 * 1000));
		var expires = "expires=" + d.toGMTString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	};


	/**
	 * Clears an existing cookie by expiring its date.
	 */
	ph.clearCookie = function (cname) {
		document.cookie = cname + '=;Path=/;Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	};

})(document, window.ph = window.ph || {});
