/*jslint nomen: true  */
/*global window: false, document: false */

(function ($) {
    'use strict';

    window.createJSJGallerySlideshow = (function () {

        var settings = window.jsjGallerySlideshowOptions.settings,
            slideshow_initialized = false,
            self = {},
            __self = {};

        // Re-write defaults
        $.fn.cycle.defaults = self.settings = $.extend($.fn.cycle.defaults, settings);
        console.log(settings.pagerTemplate);

        // Query all galleries
        self.$el = $(self.settings.autoSelector);

        // Initialize Utilities
        self.utilities = new window.JSJ_Gallery_SlideShow_Utilities(self.settings);

        self.init = function () {
            if (!slideshow_initialized) {
                slideshow_initialized = true;
            } else {
                if (self.settings.log) {
                    __self.log('Re-Initializing Slideshow. jQuery elements were not required. Slideshows destroyed and re-initiated');
                }
            }
            if (window.jsjGallerySlideshowOptions.scripts_enqueued) {
                self.$el.cycle('destroy').cycle(settings); // Append Settings to Cycle Object
            }
            return self;
        };

        __self.log = function (message) {
            console.log('[JSJ Gallery Slideshow] ' + message);
        };

        // Re-init all slideshows on init
        $(window)
            .resize(self.init)
            .on('orientationchange', self.init);

        // Return the object so that it can be used by 
        self.init();
        return function () {
            self.init();
            return self;
        };
    }());

}(window.jQuery));


