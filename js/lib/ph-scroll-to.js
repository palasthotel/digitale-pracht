/**
 * @from https://gist.github.com/dezinezync/5487119
 * @version 2.0
 */

;(function (document, ph) {

	ph.ScrollTo = function (Y, duration, easingFunction, callback) {
		var start = Date.now(),
			elem = document.documentElement.scrollTop ? document.documentElement : document.body,
			from = elem.scrollTop;

		if (from === Y) {
			callback();
			return;
			/* Prevent scrolling to the Y point if already there */
		}

		function min(a, b) {
			return a < b ? a : b;
		}

		function scroll(timestamp) {
			var currentTime = Date.now(),
				time = min(1, ((currentTime - start) / duration)),
				easedT = easingFunction(time);

			elem.scrollTop = (easedT * (Y - from)) + from;

			if (time < 1) requestAnimationFrame(scroll);
			else if (callback) callback();
		}

		requestAnimationFrame(scroll);
	};

	/* Bits and bytes of the scrollTo function inspired by the works of Benjamin DeCock */

	/*
	 * Easing Functions - inspired from http://gizma.com/easing/
	 * only considering the t value for the range [0, 1] => [0, 1]
	 */
	ph.Easing = {
		// no easing, no acceleration
		linear: function (t) {
			return t;
		},
		// accelerating from zero velocity
		easeInQuad: function (t) {
			return t * t;
		},
		// decelerating to zero velocity
		easeOutQuad: function (t) {
			return t * (2 - t);
		},
		// acceleration until halfway, then deceleration
		easeInOutQuad: function (t) {
			return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
		},
		// accelerating from zero velocity
		easeInCubic: function (t) {
			return t * t * t;
		},
		// decelerating to zero velocity
		easeOutCubic: function (t) {
			return (--t) * t * t + 1;
		},
		// acceleration until halfway, then deceleration
		easeInOutCubic: function (t) {
			return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
		},
		// accelerating from zero velocity
		easeInQuart: function (t) {
			return t * t * t * t;
		},
		// decelerating to zero velocity
		easeOutQuart: function (t) {
			return 1 - (--t) * t * t * t;
		},
		// acceleration until halfway, then deceleration
		easeInOutQuart: function (t) {
			return t < 0.5 ? 8 * t * t * t * t : 1 - 8 * (--t) * t * t * t;
		},
		// accelerating from zero velocity
		easeInQuint: function (t) {
			return t * t * t * t * t;
		},
		// decelerating to zero velocity
		easeOutQuint: function (t) {
			return 1 + (--t) * t * t * t * t;
		},
		// acceleration until halfway, then deceleration
		easeInOutQuint: function (t) {
			return t < 0.5 ? 16 * t * t * t * t * t : 1 + 16 * (--t) * t * t * t * t;
		}
	};

})(document, window.ph = window.ph || {});
