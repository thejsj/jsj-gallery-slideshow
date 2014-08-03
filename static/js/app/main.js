/*global window: false, document: false */

(function ($) {
    'use strict';

    window.createJSJGallerySlideshow = (function () {

        var slideTransitionTime,
            cycle_options,
            cycleGallery = [], // All Galleries
            utilities = new window.JSJ_Gallery_SlideShow_Utilities(); // Create an instance of our utilities class

        // Parse Options from WordPress
        cycle_options = (function () {

            var options = {},
                settings = window.jsjGallerySlideshowOptions.settings,
                i,
                value;

            for (i in settings) {
                if (settings.hasOwnProperty(i)) {
                    value = settings[i];
                    if (!isNaN(Number(value))) {
                        value = Number(value);
                    }
                    if (value === 'false' || value === 'true') {
                        value = (value === 'false') ? false : true;
                    }
                    options[i] = value;
                }
            }
            return options;
        }());

        slideTransitionTime = cycle_options.speed;

        return function () {
            $('.gallery').each(function (index) {
                var $this = $(this),
                    galleryId = $this.attr("id").replace("galleryid-", "");

                // Update Pagination
                utilities.update_pagination_string(galleryId);

                // Remove Any Previous Pagination (if resize)
                $this.parent().children('.gallery-pager')
                    .html('');

                cycleGallery[index] = $this.cycle('destroy').cycle($.extend(cycle_options, {
                    id:               galleryId,
                    next:             '#galleryNext-' + galleryId,
                    prev:             '#galleryPrev-' + galleryId,
                    pager:            $("#gallery-pager-" + galleryId),
                    onPrevNextEvent:  utilities.update_numbers, // callback fn for prev/next events: function(isNext, zeroBasedSlideIndex, slideElement),
                    before: function () {
                        var sh = $(this).height();
                        if (sh > 1) {
                            $(this).parent().clearQueue().animate({ height: sh }, slideTransitionTime);
                        }
                    },
                    pagerAnchorBuilder: function (i, slide) { // callback fn that creates a thumbnail to use as pager anchor 
                        return '<li class="slideshow-thumb index-' + i + '" style="background-image: url(' + slide.src + ');"></li>'; //<a href="#"><img src="" /></a>
                    }
                })); // Append Settings to Cycle Object
                utilities.set_intial_height(cycleGallery[index]);
            });
        };
    }());

    if (window.jsjGallerySlideshowOptions.scripts_enqueued) {
        $(window).resize(function () {
            window.createJSJGallerySlideshow();
        });
        $(document).ready(function () {
            window.createJSJGallerySlideshow();
        });
    }

}(window.jQuery));


