/*jslint nomen: true  */
/*global window: false, document: false, Image */

(function ($) {
    'use strict';

    window.JSJ_Gallery_SlideShow_Utilities = function (settings) {

        var self = {}, __self = {};

        __self.settings = settings;
        __self.tmpl = $.fn.cycle.API.tmpl;

        self.addImagePagination = function ($el, $pager) {

            var all_images = $.map($el.find('img'), function (el) {
                if (el.className.indexOf('sentinel') === -1) {
                    return el.src;
                }
            });

            $pager.find('.slideshow-thumbnail').each(function (i) {
                $(this)
                    .css('background-image', 'url(' +  all_images[i] + ')');
            });

            return self;
        };

        self.updatePaginationString = function ($numbering_el, new_slide_number) {
            var string;

            __self.of_string = __self.of_string || $numbering_el.data("numbering-translation-of");
            __self.total     = __self.total     || Number($numbering_el.data('total'));

            if (new_slide_number !== undefined && new_slide_number > 0) {
                string = "(" + (new_slide_number + 1) + " " + __self.of_string + " " + __self.total + ")"; // (1 of 6)
            } else {
                string = "(" + 1 + " " + __self.of_string + " " + __self.total + ")"; // (1 of 6)
            }
            $numbering_el.html(string);

            return self;
        };

        self.updateGalleryHeight = function ($el, image_el) {
            if (image_el.height > 0) {
                $el.clearQueue().animate({
                    height: image_el.height
                }, __self.settings.speed);
            }
            return self;
        };

        self.setInitialHeight = function ($el) {
            // Set Height
            // Plan A: Get it directly...
            var el = $el.get(0),
                images = $el.find('img'),
                height = el.children[0].height,
                loader_image;

            if (height > 1) {
                $el.clearQueue().animate({
                    height: height
                }, 200);
            } else {
                // Plan B: Try Another way...
                loader_image = new Image();
                loader_image.name = images.get(0).src;
                loader_image.src = images.get(0).src;
                loader_image.onload = function () {
                    var image_height = this.height;
                    if (image_height > 0) {
                        $el.clearQueue().animate({
                            height: image_height
                        }, 200);
                    }
                };
            }
            return self;
        };
        return self;
    };

}(window.jQuery));
