/*jslint nomen: true  */
/*global window: false, document: false, Image */

(function ($) {
    'use strict';

    window.JSJGallerySlideShowUtilities = function (settings) {

        var self = {}, __self = {};

        __self.settings = settings;
        __self.tmpl = $.fn.cycle.API.tmpl;

        self.addImagePagination = function ($el, $pager_el) {

            var all_images = $.map($el.find('img'), function (el) {
                if (el.className.indexOf('sentinel') === -1) {
                    return el.src;
                }
            });

            $pager_el.find('.slideshow-thumbnail').each(function (i) {
                $(this)
                    .css('background-image', 'url(' +  all_images[i] + ')');
            });

            return self;
        };

        self.updateNumberingString = function ($el, $numbering_el, optionHash) {
            var html,
                $container = $el.parent();

            __self.of_string = __self.of_string || $container.data("numbering-translation-of");
            optionHash.slideNum = optionHash.slideNum || 1;

            html = __self.tmpl(__self.settings.numberingTemplate, $.extend({
                'ofString' : __self.of_string,
            }, optionHash));
            $numbering_el.html(html);

            return self;
        };

        /*jslint unparam: true*/
        self.updateCaption = function ($el, $caption_el, optionHash, options) {

            var current_slice_index = options && (options.use_current_slide) ? (optionHash.currSlide || 0) : optionHash.nextSlide || 0,
                current_slide       = optionHash.slides[current_slice_index],
                attachment_id       = +(current_slide.id.replace('attachment-image-', '')),
                html;

            html = __self.tmpl(__self.settings.captionTemplate, $.extend({
                'ofString'   : __self.of_string,
                'attachment' : window.jsj_gallery_slideshow_images[attachment_id]
            }, optionHash));

            $caption_el.html(html);

            return self;
        };
        /*jslint unparam: false*/

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
            setTimeout(function () {
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
            }, 1);
            return self;
        };
        return self;
    };

}(window.jQuery));
