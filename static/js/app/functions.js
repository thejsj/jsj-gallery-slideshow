/*jslint nomen: true  */
/*global window: false, document: false, Image */

(function ($) {
    'use strict';

    window.JSJ_Gallery_SlideShow_Utilities = function (settings) {

        var self = {}, __self = {};

        __self.settings = settings;

        self.updateNumbers = function (zeroBasedSlideIndex, slideElement) {
            var galleryId, string;
            if (slideElement.src !== undefined) {
                galleryId = $("img[src$='" + slideElement.src + "']").data("galleryid");
                self.update_pagination_string(galleryId, zeroBasedSlideIndex);
            } else {
                string = "";
            }
            $("#galleryNumbering-" + galleryId).html(string);
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
        };

        self.updateGalleryHeight = function (imageEl, galleryEl) {
            if (imageEl.height > 0) {
                $(galleryEl).clearQueue().animate({
                    height: imageEl.height
                }, __self.settings.speed);
            }
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
        };
        return self;
    };

}(window.jQuery));
