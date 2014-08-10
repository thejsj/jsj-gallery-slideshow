/*jslint nomen: true  */
/*global window: false, document: false */

(function ($) {
    'use strict';

    window.createJSJGallerySlideshow = (function () {

        console.log('RUN createJSJGallerySlideshow');

        var settings = window.jsjGallerySlideshowOptions.settings,
            slideshow_initialized = false,
            self = {},
            __self = {};

        /**
         * Our private init function, that runs when when this object is being initialized
         *
         * Has nothing to do with self.init, which initializes our slidedhow and is meant to be exposed
         */
        __self.init = function () {
            // Set document_ready as false
            __self.document_ready = false;

            // Re-write defaults
            $.fn.cycle.defaults = self.settings = $.extend($.fn.cycle.defaults, settings);

            // Initialize Utilities
            self.utilities = new window.JSJ_Gallery_SlideShow_Utilities(self.settings);

            // Re-init all slideshows on init
            $(window)
                .resize(self.init)
                .on('orientationchange', self.init);

            $(document)
                .ready(__self.setDocumentReady);

            // Log that this is being initizlied
            __self.log('Initializing createJSJGallerySlideshow');
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
            __self.$el = self.$el = $(self.settings.autoSelector);
        };

        /**
         * Initializes the galleries 
         */
        self.init = function () {
            if (!slideshow_initialized) {
                slideshow_initialized = true;
            } else {
                __self.log('Re-Initializing Slideshow. jQuery elements were not required. Slideshows destroyed and re-initiated');
                if (window.jsjGallerySlideshowOptions.scripts_enqueued) {
                    self.get$el().cycle('reinit'); // Append Settings to Cycle Object
                } else {
                    __self.log('scripts_enqueued is set in settings. Not initializing slideshows.');
                }
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
            return $(self.settings.autoSelector);
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


