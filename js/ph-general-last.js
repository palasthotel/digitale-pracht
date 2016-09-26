/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 */

;(function (window, document, ph) {

	/* ###### READING INDICATOR ###### */

	var indicator,
		articleTextDom = document.querySelector('.ph-article-text');
	if (articleTextDom) {
		indicator = new ph.Indicator(
			document.getElementById('indicator'),
			articleTextDom, 0);
	}
	else {
		indicator = new ph.Indicator(
			document.getElementById('indicator'),
			document.getElementById('content'), 0);
	}


	/* ###### FLOATING BAR VISIBILITY ###### */

	var scrollClass = new ph.ScrollClass({
		threshold: 200,
		timeout: 10
	});


	/* ###### BACK TO TOP SMOOTH SCROLL ###### */

	document.querySelector('.ph-floatingbar-link-top').addEventListener('click', function (e) {
		e.preventDefault();
		ph.ScrollTo(0, 600, ph.Easing.easeInOutQuint);
	});


	/* ###### TOGGLE CLASSES ON CLICKS ###### */

	// Toggle search overlay when clicking on search icon
	var toggleSearch = new ph.ToggleClass({
		triggerDomObj: document.querySelector('.ph-actionbar-search-link'),
		targetDomObj: document.body,
		classToBeSet: 'is-search-expanded',
		callbackAdd: function () {
			// Set focus to input field
			// 300ms is the css visibility transition time. focus does only work
			// if the element is visibility: visible
			setTimeout(function () {
				document.querySelector('.ph-overlay-search .ph-search-input').focus();
			}, 300);
		},
		preCallbackAdd: function () {
			// Hide other overlays before showing this overlay
			if (toggleShare) {
				toggleShare.removeClass();
			}
		}
	});

	// Toggle share overlay when clicking on share icon
	var shareBtn = document.querySelector('.ph-floatingbar-link-share');
	if (shareBtn) {
		var toggleShare = new ph.ToggleClass({
			triggerDomObj: shareBtn,
			targetDomObj: document.body,
			classToBeSet: 'is-share-expanded',
			preCallbackAdd: function () {
				// Hide other overlays before showing this overlay
				toggleSearch.removeClass();
			}
		});
	}

	function hideOverlay() {
		toggleSearch.removeClass();
		if (toggleShare) {
			toggleShare.removeClass();
		}
	}

	// @todo cleaner solution?
	// Hide menu, search and share when clicking on background
	var overlays = document.querySelectorAll('.ph-overlay');
	for (var i = 0; i < overlays.length; i++) {
		overlays[i].addEventListener('click', hideOverlay);
	}
	document.querySelector('.ph-main').addEventListener('click', hideOverlay);

	// Prevent elements inside overlay to hide background
	// @todo check
	var overlayContents = document.querySelectorAll('.ph-overlay-share-btn');
	for (var i = 0; i < overlayContents.length; i++) {
		overlayContents[i].addEventListener('click', function (ev) {
			ev.stopPropagation();
		});
	}
	document.querySelector('.ph-overlay-search .ph-search-input').addEventListener('click', function (ev) {
		ev.stopPropagation();
	});


	// Collapse some comment respond form elements if available
	var commentRespondDom = document.querySelector('.comment-respond');
	var commentTextareaDom = document.getElementById('comment');
	if (window.location.hash !== '#respond' &&
		commentRespondDom &&
		commentTextareaDom) {
		ph.addClass(commentRespondDom, 'is-collapsed');
		commentTextareaDom.addEventListener('focus', function () {
			ph.removeClass(commentRespondDom, 'is-collapsed');
		});
	}


	/* ###### TOGGLE CLASSES ON KEY PRESS ###### */

	document.body.addEventListener('keydown', function (ev) {
		if (ev.keyCode == 27) {
			hideOverlay();
		}
	});


	/* ###### PAGE LOAD EVENT ###### */

	window.addEventListener('load', function () {
		ph.addClass(document.body, 'is-loaded');
	});

})(window, document, window.ph = window.ph || {});
