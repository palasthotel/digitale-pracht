/**
 * Attaches a click listener on a given dom element, which toggles a given css class
 * on another given dom element.
 *
 * @params triggerDomObj, targetDomObj and classToBeSet must be set
 * @requires addClass and removeClass prototypes
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 */
;"use strict";
window.ph = window.ph || {};

ph.ToggleClass = function (parameter) {
    if (!parameter || !parameter.triggerDomObj || !parameter.classToBeSet) {
        throw "ParameterException: Please provide at least triggerDomObj and classToBeSet.";
    }

    this.parameter = {
        triggerDomObj: typeof parameter.triggerDomObj !== 'undefined' ? parameter.triggerDomObj : undefined,
        targetDomObj: typeof parameter.targetDomObj !== 'undefined' ? parameter.targetDomObj : document.body,
        classToBeSet: typeof parameter.classToBeSet !== 'undefined' ? parameter.classToBeSet : undefined,
        callbackAdd: typeof parameter.callbackAdd !== 'undefined' ? parameter.callbackAdd : undefined,
        callbackRemove: typeof parameter.callbackRemove !== 'undefined' ? parameter.callbackRemove : undefined,
        preCallbackAdd: typeof parameter.preCallbackAdd !== 'undefined' ? parameter.preCallbackAdd : undefined,
        preCallbackRemove: typeof parameter.preCallbackRemove !== 'undefined' ? parameter.preCallbackRemove : undefined
    };

    // constructor
    this.init();
};


ph.ToggleClass.prototype.init = function (ev) {
    // array?
    if (this.parameter.triggerDomObj.length) {
        for (var i = 0; i < this.parameter.triggerDomObj.length; i++) {
            this.parameter.triggerDomObj[i].addEventListener('click', this.toggleClass.bind(this));
        }
    }
    else {
        this.parameter.triggerDomObj.addEventListener('click', this.toggleClass.bind(this));
    }
};


ph.ToggleClass.prototype.toggleClass = function (ev) {
    if (ev) {
        ev.preventDefault();
    }
    if (ph.hasClass(this.parameter.targetDomObj, this.parameter.classToBeSet)) {
        if (typeof this.parameter.preCallbackRemove != "undefined") {
            this.parameter.preCallbackRemove();
        }

        this.removeClass();

    }
    else {
        if (typeof this.parameter.preCallbackAdd != "undefined") {
            this.parameter.preCallbackAdd();
        }

        ph.addClass(this.parameter.targetDomObj, this.parameter.classToBeSet);

        if (typeof this.parameter.callbackAdd != "undefined") {
            this.parameter.callbackAdd();
        }
    }
};


ph.ToggleClass.prototype.removeClass = function (ev) {
    if (ph.hasClass(this.parameter.targetDomObj, this.parameter.classToBeSet)) {
        ph.removeClass(this.parameter.targetDomObj, this.parameter.classToBeSet);
    }
    if (typeof this.parameter.callbackRemove != "undefined") {
        this.parameter.callbackRemove();
    }
};
