/*global window: false, document: false */

(function ($) {
    'use strict';

    window.createJSJGallerySlideshow = (function () {

        var settings = window.jsjGallerySlideshowOptions.settings,
            self = {};

        console.log('createJSJGallerySlideshow');

        // Re-write defaults
        $.fn.cycle.defaults = $.extend($.fn.cycle.defaults, settings);

        // Query all galleries
        self.$galleries = $($.fn.cycle.defaults.autoSelector);

        // Initialize Utilities
        self.utilities = new window.JSJ_Gallery_SlideShow_Utilities();

        self.init = function () {
            console.log('initSlideshows');
            if (window.jsjGallerySlideshowOptions.scripts_enqueued) {
                self.$galleries.cycle('destroy').cycle(settings); // Append Settings to Cycle Object
            }
            return self;
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


