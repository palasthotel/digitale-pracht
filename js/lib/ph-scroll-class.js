/**
 * Just sets a class (e.g. to the body tag), when the viewport or an element is
 * scrolled horizontally or vertically the amount of pixels given in the
 * parameters. Secondly it sets a class for the inverse state, when the page is
 * scrolled to top.
 *
 * @param parameter, optional object, which can hold values for:
 *   - sourceDomObj:       you can also check scrolling inside a dom element
 *   - classScrolledEnd:   when the source/page is scrolled down/right and
 *                         [threshold] is reached, this class will be set
 *   - classScrolledStart: class set to the target dom object, when
 *                         classScrolledEnd is not set
 *   - threshold:          when the source/page is scrolled down/right
 *                         [threshold] pixels, the classes switch
 *   - timeout:            the scroll state is checked every [timeout]
 *                         milliseconds
 *   - direction:          'x' or 'y' axis
 *
 * @requires ph.debounce, ph.addClass, ph.removeClass
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @version 2.0
 */

;(function (window, document, ph) {

	ph.ScrollClass = function (parameter) {
		this.currentStep = -2; // 0 = first steps array element, -1 = top

		if (!parameter) {
			parameter = {};
		}

		this.parameter = {
			sourceDomObj: typeof parameter.sourceDomObj !== 'undefined' ? parameter.sourceDomObj : undefined,
			targetDomObj: typeof parameter.targetDomObj !== 'undefined' ? parameter.targetDomObj : document.body,
			direction: typeof parameter.direction !== 'undefined' ? parameter.direction : 'y',
			classScrolledStart: typeof parameter.classScrolledStart !== 'undefined' ? parameter.classScrolledStart : 'is-scrolled-start',
			callback: typeof parameter.callback !== 'undefined' ? parameter.callback : undefined,
			preCallback: typeof parameter.preCallback !== 'undefined' ? parameter.preCallback : undefined,
			steps: parameter.steps ? parameter.steps : [{
				threshold: typeof parameter.threshold !== 'undefined' ? parameter.threshold : 200,
				classToBeSet: typeof parameter.classScrolledEnd !== 'undefined' ? parameter.classScrolledEnd : 'is-scrolled-end',
				callback: typeof parameter.callbackEnd !== 'undefined' ? parameter.callbackEnd : undefined,
				preCallback: typeof parameter.preCallbackEnd !== 'undefined' ? parameter.preCallbackEnd : undefined,
			}],
			timeout: typeof parameter.timeout !== 'undefined' ? parameter.timeout : 100,
		};

		// Constructor
		this.init();
	};


	ph.ScrollClass.prototype.init = function () {
		this.validateStepParameter();
		this.sortSteps();

		this.debounceScroll = ph.debounce(function (e) {
			this.checkThreshold();
		}, this.parameter.timeout);

		this.debounceScrollBind = this.debounceScroll.bind(this);

		if (this.parameter.sourceDomObj) {
			this.parameter.sourceDomObj.addEventListener('scroll', this.debounceScrollBind);
		}
		else {
			window.addEventListener('scroll', this.debounceScrollBind);
		}

		this.checkThreshold();
	};


	/**
	 * Remove listener and classes
	 */
	ph.ScrollClass.prototype.unset = function () {
		if (this.parameter.sourceDomObj) {
			this.parameter.sourceDomObj.removeEventListener('scroll', this.debounceScrollBind);
		}
		else {
			window.removeEventListener('scroll', this.debounceScrollBind);
		}

		this.removeClasses();
	};


	ph.ScrollClass.prototype.validateStepParameter = function () {
		if (typeof this.parameter.steps === 'undefined' ||
			this.parameter.steps.length == 0) {
			throw "ParameterException: steps parameter must be an array and not empty.";
		}
		for (var i = 0; i < this.parameter.steps.length; i++) {
			if (typeof this.parameter.steps[i].threshold === 'undefined' ||
				isNaN(this.parameter.steps[i].threshold)) {
				throw "ParameterException: threshold property must be a number, but is " + this.parameter.steps[i].threshold;
			}
			if (typeof this.parameter.steps[i].classToBeSet === 'undefined' ||
				typeof this.parameter.steps[i].classToBeSet !== 'string') {
				throw "ParameterException: classToBeSet property must be a string, but is " + this.parameter.steps[i].classToBeSet;
			}
		}
	};


	ph.ScrollClass.prototype.compareStep = function (a, b) {
		if (a.threshold < b.threshold) {
			return -1;
		}
		if (a.threshold > b.threshold) {
			return 1;
		}
		return 0;
	};


	ph.ScrollClass.prototype.sortSteps = function () {
		this.parameter.steps.sort(this.compareStep);
	};


	ph.ScrollClass.prototype.removeClasses = function () {
		ph.removeClass(this.parameter.targetDomObj, this.parameter.classScrolledStart);
		for (var i = 0; i < this.parameter.steps.length; i++) {
			ph.removeClass(this.parameter.targetDomObj, this.parameter.steps[i].classToBeSet);
		}
	};


	ph.ScrollClass.prototype.checkThreshold = function () {
		var pos;

		if (this.parameter.sourceDomObj) {
			pos = this.parameter.direction == 'x' ? this.parameter.sourceDomObj.scrollLeft : this.parameter.sourceDomObj.scrollTop;
		}
		else {
			pos = this.parameter.direction == 'x' ? window.pageXOffset : window.pageYOffset;
		}
		var newClass = this.parameter.classScrolledStart;
		var currentStep = -1;

		for (var i = 0; i < this.parameter.steps.length; i++) {
			if (pos >= this.parameter.steps[i].threshold) {
				newClass = this.parameter.steps[i].classToBeSet;
				currentStep = i;
			}
			else {
				break;
			}
		}

		// Only apply new classes, if there are changes.
		if (currentStep !== this.currentStep) {
			// Calling preCallback
			if (currentStep === -1 &&
				typeof this.parameter.preCallback !== 'undefined') {
				this.parameter.preCallback();
			}
			if (currentStep >= 0 &&
				typeof this.parameter.steps[currentStep].preCallback !== 'undefined') {
				this.parameter.steps[currentStep].preCallback();
			}

			this.removeClasses();
			ph.addClass(this.parameter.targetDomObj, newClass);

			// Calling callback
			if (currentStep === -1 &&
				typeof this.parameter.callback !== 'undefined') {
				this.parameter.callback();
			}
			if (currentStep >= 0 &&
				typeof this.parameter.steps[currentStep].callback !== 'undefined') {
				this.parameter.steps[currentStep].callback();
			}

			this.currentStep = currentStep;
		}
	};

})(window, document, window.ph = window.ph || {});
