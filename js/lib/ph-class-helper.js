/**
 * Helper functions for adding, removing and checking CSS classes on DOM elements
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @version 2.0
 */

;(function (ph) {

	/**
	 * Adds a class to a given dom element.
	 */
	ph.addClass = function (object, className) {
		if (object.className) {
			// Only adds class, if it does not already exists
			var elClass = ' ' + object.className + ' ';
			if (elClass.indexOf(' ' + className + ' ') == -1) {
				object.className += ' ' + className;
			}
		}
		else {
			object.className = className;
		}
	};


	/**
	 * Removes a class from a given dom element.
	 */
	ph.removeClass = function (object, className) {
		var elClass = ' ' + object.className + ' ';
		while (elClass.indexOf(' ' + className + ' ') != -1) {
			elClass = elClass.replace(' ' + className + ' ', ' ');
		}
		object.className = elClass.replace(/^\s+|\s+$/g, '');  // Trim left and right
	};


	/**
	 * Checks, if a class is attached to a given DOM element.
	 */
	ph.hasClass = function (object, className) {
		return !!object.className && object.className.indexOf(className) > -1;
	};

})(window.ph = window.ph || {});
