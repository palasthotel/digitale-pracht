/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @version 2.0
 */

;(function (window, ph) {

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
			window.clearTimeout(timeout);
			timeout = window.setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};

})(window, window.ph = window.ph || {});
