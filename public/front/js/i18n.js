/**
 * Front JS i18n runtime.
 *
 * Usage:
 *   __('Please fill in required fields.')
 *   __('You can upload up to :count files.', { count: 5 })
 *   FrontI18n.t('Success')
 *   FrontI18n.getLocale()
 *
 * Load order:
 *   1) /front/js/i18n.js
 *   2) /front/lang/{locale}.js  (calls FrontI18n.setLocale)
 *   3) other front scripts
 */
(function (global) {
    'use strict';

    var locale = 'en';
    var messages = {};

    function format(text, replace) {
        text = String(text == null ? '' : text);
        if (!replace || typeof replace !== 'object') {
            return text;
        }
        Object.keys(replace).forEach(function (k) {
            var val = String(replace[k]);
            text = text.split(':' + k).join(val);
            text = text.split('{' + k + '}').join(val);
        });
        return text;
    }

    function __(key, replace) {
        if (key == null || key === '') {
            return '';
        }
        var text = Object.prototype.hasOwnProperty.call(messages, key) ? messages[key] : key;
        return format(text, replace);
    }

    var FrontI18n = {
        version: '1.0.0',

        getLocale: function () {
            return locale;
        },

        /**
         * @param {string} loc
         * @param {Object<string,string>} dict
         */
        setLocale: function (loc, dict) {
            locale = String(loc || 'en');
            if (dict && typeof dict === 'object') {
                messages = dict;
            }
            global.__LOCALE__ = locale;
            global.__I18N__ = messages;
            return FrontI18n;
        },

        /**
         * Merge / replace messages without changing locale.
         * @param {Object<string,string>} dict
         * @param {boolean} [merge=true]
         */
        setMessages: function (dict, merge) {
            if (!dict || typeof dict !== 'object') {
                return FrontI18n;
            }
            if (merge === false) {
                messages = dict;
            } else {
                Object.keys(dict).forEach(function (k) {
                    messages[k] = dict[k];
                });
            }
            global.__I18N__ = messages;
            return FrontI18n;
        },

        has: function (key) {
            return Object.prototype.hasOwnProperty.call(messages, key);
        },

        getMessages: function () {
            return messages;
        },

        __: __,
        t: __,
        trans: __
    };

    global.FrontI18n = FrontI18n;
    global.__ = __;
    global.trans = __;
    global.__I18N__ = messages;
    global.__LOCALE__ = locale;
})(typeof window !== 'undefined' ? window : this);
