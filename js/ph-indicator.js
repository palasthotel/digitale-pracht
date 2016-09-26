/**
 * A reading indicator showing how many percent you have already read.
 * It handles scroll, resize and load event and sets the height of indicatorDomEl
 * accordingly to the height of contentDomEl.
 *
 * @requires ph-debounce.js
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 */

;(function (window, document, ph) {

	ph.Indicator = function (indicatorDomEl, contentDomEl, timeoutScroll, timeoutResize) {
		var _this = this;
		this.timeoutScroll = typeof timeoutScroll === 'undefined' ? 20 : timeoutScroll;
		this.timeoutResize = typeof timeoutResize === 'undefined' ? 150 : timeoutResize;
		this.indicatorDomEl = indicatorDomEl;
		this.contentDomEl = contentDomEl;

		this.initDimensions = function () {
			var domEl = _this.contentDomEl;
			_this.contentTop = domEl.offsetTop;
			while (domEl.offsetParent) {
				domEl = domEl.offsetParent;
				_this.contentTop += domEl.offsetTop;
			}

			_this.contentHeight = _this.contentDomEl.offsetHeight;
			_this.setIndicatorHeight();
		};

		this.init = function () {
			// For requestAnimationFrame handling
			_this.latestKnownScrollY = 0;
			_this.ticking = false;

			_this.initDimensions();
			window.addEventListener('scroll', _this.rafScroll);
			window.addEventListener('resize', _this.debounceInitDimensions);
		};

		this.setIndicatorHeight = function () {
			// Reset the tick so we can
			// Capture the next onScroll
			_this.ticking = false;

			_this.indicatorDomEl.style.height = _this.readingCompleted() * 100 + '%';
		};

		// Returns a ratio value between 0 and 1
		this.readingCompleted = function () {
			var viewPortScrollYBottom = _this.latestKnownScrollY + document.documentElement.clientHeight;
			var viewPortScrollYBottomWithoutContentTop = viewPortScrollYBottom - _this.contentTop;
			var ratio = viewPortScrollYBottomWithoutContentTop / _this.contentHeight;
			if (ratio > 1) {
				ratio = 1;
			}
			else if (ratio < 0) {
				ratio = 0;
			}
			return ratio;
		};

		this.rafScroll = function () {
			_this.latestKnownScrollY = window.scrollY;
			_this.requestTick();
		};

		this.requestTick = function () {
			if (!_this.ticking) {
				requestAnimationFrame(_this.setIndicatorHeight);
			}
			_this.ticking = true;
		};

		this.debounceInitDimensions = ph.debounce(function (e) {
			_this.initDimensions();
		}, this.timeoutResize);

		// Don’t do anything, when requestAnimationFrame is not supported.
		if (typeof window.requestAnimationFrame === 'function') {
			window.addEventListener('load', this.init);
		}
	};

})(window, document, window.ph = window.ph || {});
