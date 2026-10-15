/**
 * Override browser-native HTML5 constraint validation bubbles
 * so messages follow the site locale (html[lang] / FrontI18n),
 * not the browser UI language.
 */
(function (global, document) {
    'use strict';

    if (!document || !document.addEventListener) {
        return;
    }

    function t(key) {
        if (typeof global.__ === 'function') {
            return global.__(key);
        }
        if (global.FrontI18n && typeof global.FrontI18n.t === 'function') {
            return global.FrontI18n.t(key);
        }
        return key;
    }

    function isFormControl(el) {
        return !!(el && el.nodeType === 1 && typeof el.setCustomValidity === 'function' && el.validity);
    }

    function messageFor(el) {
        var v = el.validity;
        if (!v || v.valid) {
            return '';
        }
        if (v.valueMissing) {
            if (String(el.tagName || '').toUpperCase() === 'SELECT') {
                return t('Please select an item in the list.');
            }
            return t('Please fill out this field.');
        }
        if (v.typeMismatch) {
            var type = String(el.type || '').toLowerCase();
            if (type === 'email') {
                return t('Please enter a valid email address.');
            }
            if (type === 'url') {
                return t('Please enter a valid URL.');
            }
            return t('Please enter a valid value.');
        }
        if (v.patternMismatch) {
            return t('Please match the requested format.');
        }
        if (v.badInput) {
            return t('Please enter a number.');
        }
        if (v.tooShort || v.tooLong || v.rangeUnderflow || v.rangeOverflow || v.stepMismatch) {
            return t('Please enter a valid value.');
        }
        return t('Please enter a valid value.');
    }

    function clearCustom(el) {
        if (isFormControl(el)) {
            el.setCustomValidity('');
        }
    }

    document.addEventListener('invalid', function (e) {
        var el = e.target;
        if (!isFormControl(el)) {
            return;
        }
        // Reset previous custom message so ValidityState reflects native constraints.
        el.setCustomValidity('');
        var msg = messageFor(el);
        if (msg) {
            el.setCustomValidity(msg);
        }
    }, true);

    document.addEventListener('input', function (e) {
        clearCustom(e.target);
    }, true);

    document.addEventListener('change', function (e) {
        clearCustom(e.target);
    }, true);
})(typeof window !== 'undefined' ? window : this, typeof document !== 'undefined' ? document : null);
