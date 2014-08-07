/*jslint nomen: true  */
/*global window: false, document: false, Image */

(function ($) {
    'use strict';

    window.JSJ_Gallery_SlideShow_Utilities = function () {

        var self = {}, __self = {};

        self.update_numbers = function (isNext, zeroBasedSlideIndex, slideElement) {
            // var galleryId, string;
            // if (slideElement.src !== undefined) {
            //     galleryId = $("img[src$='" + slideElement.src + "']").data("galleryid");
            //     self.update_pagination_string(galleryId, zeroBasedSlideIndex);
            // } else {
            //     string = "";
            // }
            // $("#galleryNumbering-" + galleryId).html(string);
        };

        self.update_pagination_string = function ($numbering_el, slide_number) {
            var string;

            __self.of_string = __self.of_string || $numbering_el.data("numbering-translation-of");
            __self.total     = __self.total     || Number($numbering_el.data('total'));

            console.log(__self.total);

            if (slide_number !== undefined && slide_number > 0) {
                string = "(" + (slide_number + 1) + " " + __self.of_string + " " + __self.total + ")"; // (1 of 6)
            } else {
                string = "(" + 1 + " " + __self.of_string + " " + __self.total + ")"; // (1 of 6)
            }
            console.log(string);
            $numbering_el.html(string);
        };

        self.eventTriggerHandler = function () {
            console.log('eventTriggerHandler');
        };

        self.update_gallery_height = function (currSlideElement, nextSlideElement, options, forwardFlag) {
            // if (nextSlideElement.height > 0) {
            //     $("#galleryid-" + options.id).clearQueue().animate({
            //         height: nextSlideElement.height
            //     }, slideTransitionTime);
            // }
        };

        self.setInitialHeight = function ($el) {
            // Set Height
            // Plan A: Get it directly...
            var el = $el.get(0),
                height = el.children[0].height,
                loader_image;

            console.log('height');
            console.log(height);

            if (height > 1) {
                $el.clearQueue().animate({
                    height: height
                }, 200);
            } else {
                // Plan B: Try Another way...
                loader_image = new Image();
                loader_image.name = el.context.images[0].src;
                loader_image.src = el.context.images[0].src;
                loader_image.onload = function () {
                    var imgHeight = this.height;
                    if (imgHeight > 0) {
                        loader_image.clearQueue().animate({
                            height: imgHeight
                        }, 200);
                    }
                };
            }
        };
        return self;
    };

}(window.jQuery));
