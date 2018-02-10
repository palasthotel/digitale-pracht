/**
 * A reading indicator showing how many percent you have already read.
 * It handles scroll, resize and load event and sets the height of indicatorDomEl
 * accordingly to the height of contentDomEl.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 */

;(function (window, document, ph) {

	ph.Indicator = function (indicatorDomEl, contentDomEl, timeoutScroll, timeoutResize) {
		var _this = this;
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
			requestAnimationFrame(_this.setIndicatorHeight);
		};

		this.init = function () {
			_this.initDimensions();
			window.addEventListener('scroll', function() {
				requestAnimationFrame(_this.setIndicatorHeight);
			});
			window.addEventListener('resize', _this.initDimensions);
		};

		this.setIndicatorHeight = function () {
			_this.indicatorDomEl.style.transform = `scaleY(${_this.readingCompleted()})`;
		};

		// Returns a ratio value between 0 and 1
		this.readingCompleted = function () {
			var viewPortScrollYBottom = window.scrollY + document.documentElement.clientHeight;
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

		// Don’t do anything, when requestAnimationFrame is not supported.
		if (typeof window.requestAnimationFrame === 'function') {
			window.addEventListener('load', this.init);
		}
	};


	// Init reading indicator
	document.addEventListener('DOMContentLoaded', function(e) {
		var indicatorEl, contentEl;

		indicatorEl = document.getElementById('indicator');
		contentEl = document.querySelector('.ph-article-text') !== null ?
			document.querySelector('.ph-article-text') : document.getElementById('content');
		if (indicatorEl !== null && contentEl !== null) {
			indicator = new ph.Indicator(indicatorEl, contentEl);
		}
	});

})(window, document, window.ph = window.ph || {});
