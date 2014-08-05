/*global window: false, document: false */

(function ($) {
    'use strict';

    window.createJSJGallerySlideshow = (function () {

        var settings = window.jsjGallerySlideshowOptions.settings,
            cycleGallery = [], // All Galleries
            utilities = new window.JSJ_Gallery_SlideShow_Utilities(); // Create an instance of our utilities class

        console.log(utilities);

        $.fn.cycle.defaults = $.extend($.fn.cycle.defaults, settings);

        console.log($.fn.cycle.defaults);

        // $.extend(cycle_options, {
        //             id:               galleryId,
        //             next:             '#galleryNext-' + galleryId,
        //             prev:             '#galleryPrev-' + galleryId,
        //             pager:            $("#gallery-pager-" + galleryId),
        //             onPrevNextEvent:  utilities.update_numbers, // callback fn for prev/next events: function(isNext, zeroBasedSlideIndex, slideElement),
        //             before: function () {
        //                 var sh = $(this).height();
        //                 if (sh > 1) {
        //                     $(this).parent().clearQueue().animate({ height: sh }, slideTransitionTime);
        //                 }
        //             },
        //             pagerAnchorBuilder: function (i, slide) { // callback fn that creates a thumbnail to use as pager anchor 
        //                 return '<li class="slideshow-thumb index-' + i + '" style="background-image: url(' + slide.src + ');"></li>'; //<a href="#"><img src="" /></a>
        //             }
        //         })

        return function () {
            $($.fn.cycle.defaults.autoSelector).each(function (index) {
                var $this = $(this),
                    gallery_id = $this.attr("id").replace("galleryid-", "");

                // Update Pagination
                utilities.update_pagination_string(gallery_id);

                // Remove Any Previous Pagination (if resize)
                $this.parent().children('.gallery-pager')
                    .html('');

                cycleGallery[index] = $this.cycle('destroy').cycle(settings); // Append Settings to Cycle Object
                console.log('End Init');
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


