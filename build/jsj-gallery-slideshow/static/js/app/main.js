/*jslint nomen: true  */
/*global window: false, document: false */

(function ($) {
    'use strict';

    window.createJSJGallerySlideshow = (function (theme_selector, theme_settings) {

        var settings = window.jsj_gallery_slideshow_options.settings,
            slideshow_initialized = false,
            self = {},
            __self = {};

        if (theme_selector !== undefined && theme_settings !== undefined) {
            // Make sure we only select 
            __self.selector = settings.autoSelector + '.' + theme_selector;
            __self.theme_instance = true;
            // Overwrite local settings with theme settings
            settings = $.extend(settings, theme_settings);
        } else {
            __self.selector = settings.autoSelector;
            __self.theme_instance = false;
        }

        /**
         * Our private init function, that runs when when this object is being initialized
         *
         * Has nothing to do with self.init, which initializes our slidedhow and is meant to be exposed
         */
        __self.init = function () {
            // Set document_ready as false
            __self.document_ready = false;

            // Set our settings
            self.settings = $.extend($.fn.cycle.defaults, settings);

            if (!__self.theme_instance) {
                // Re-write defaults
                $.fn.cycle.defaults = self.settings;
                // Turn off default captions (You can overwrite this in your theme if you want)
                $.fn.cycle.defaults.captionModule = false;
            }

            // Initialize Utilities
            self.utilities = new window.JSJGallerySlideShowUtilities(self.settings);

            // Re-init all slideshows on init
            $(window)
                .resize(__self.resizeHandler)
                .on('orientationchange', __self.resizeHandler);

            $(document)
                .ready(__self.documentReadyHandler);

            // Log that this is being initizlied
            __self.log('Initializing createJSJGallerySlideshow');
        };

        __self.resizeHandler = function () {
            clearTimeout(__self.resizeTimeout);
            __self.resizeTimeout = setTimeout(self.init, 50);
        };

        __self.log = function (message) {
            if (self.settings.log) {
                console.log('[JSJ Gallery Slideshow] ' + message);
            }
        };

        /**
         * Handles our document.ready event
         * Sets our cached jQuery Element
         */
        __self.documentReadyHandler = function () {
            __self.document_ready = true;
            // Query all galleries
            __self.$el = self.$el = $(__self.selector);
            self.init();
        };

        /**
         * Initializes the galleries 
         */
        self.init = function () {
            __self.log('Re-Initializing Slideshow. jQuery elements were not required. Slideshows destroyed and re-initiated');
            if (window.jsj_gallery_slideshow_options.scripts_enqueued) {
                if (!slideshow_initialized) {
                    slideshow_initialized = true;
                    self.get$el().cycle();
                } else {
                    self.get$el().cycle('reinit'); // Append Settings to Cycle Object
                }
            } else {
                __self.log('scripts_enqueued is set in settings. Not initializing slideshows.');
            }
            return self;
        };

        /**
         * Returns the jQuery element(s) for the queried galleries
         * 
         * If document.ready has been fired, this element is cached
         * If not, it will return the result of the latest query
         */
        self.getJQueryElement = function () {
            if (__self.document_ready) {
                return __self.$el;
            }
            return $(__self.selector);
        };

        /**
         * A shortcut for self.getJQueryElement
         */
        self.get$el = self.getJQueryElement;

        // Return the object so that it can be used by 
        __self.init();
        return function (initalize) {
            if (initalize === undefined) {
                initalize = true;
            }
            if (initalize && __self.document_ready) {
                self.init();
            }
            return self;
        };
    }());

}(window.jQuery));


