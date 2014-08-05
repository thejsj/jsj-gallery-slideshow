/*jslint nomen: true  */
/*global window: false, document: false, Image */

var JSJ_Gallery_SlideShow_Utilities;

(function ($) {
    'use strict';

    JSJ_Gallery_SlideShow_Utilities = function () {

        var self = {}, __self = {};

        self.update_numbers = function (isNext, zeroBasedSlideIndex, slideElement) {
            var galleryId, string;
            if (slideElement.src !== undefined) {
                galleryId = $("img[src$='" + slideElement.src + "']").data("galleryid");
                self.update_pagination_string(galleryId, zeroBasedSlideIndex);
            } else {
                string = "";
            }
            $("#galleryNumbering-" + galleryId).html(string);
        };

        self.update_pagination_string = function ($el, slideNumber) {
            var total, string;
            __self.of_string = $el.data("numbering-translation-of");
            total = Number($el.data("total"));
            if (slideNumber !== undefined && slideNumber > 0) {
                string = "(" + (slideNumber + 1) + " " + __self.of_string + " " + total + ")"; // (1 of 6)
            } else {
                string = "(" + 1 + " " + __self.of_string + " " + total + ")"; // (1 of 6)
            }
            $("#galleryNumbering-" + galleryId).html(string);
        };

        self.update_gallery_height = function (currSlideElement, nextSlideElement, options, forwardFlag) {
            if (nextSlideElement.height > 0) {
                $("#galleryid-" + options.id).clearQueue().animate({
                    height: nextSlideElement.height
                }, slideTransitionTime);
            }
        };

        self.set_intial_height = function (thisGallery) {
            // Set Height
            // Plan A: Get it directly...
            var hght = thisGallery[0].children[0].height, myImage;
            if (hght > 1) {
                thisGallery.clearQueue().animate({
                    height: hght
                }, 200);
            } else {
                // Plan B: Try Another way...
                myImage = new Image();
                myImage.name = thisGallery.context.images[0].src;
                myImage.src = thisGallery.context.images[0].src;
                myImage.onload = function () {
                    var imgHeight = this.height;
                    if (imgHeight > 0) {
                        thisGallery.clearQueue().animate({
                            height: imgHeight
                        }, 200);
                    }
                };
            }
        };
        return self;
    };

}(window.jQuery));
