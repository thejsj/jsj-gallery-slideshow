/*global window: false, document: false */
(function ($) {
    'use strict';

    $(document).ready(function () {
        var jsj_gallery_slideshow = window.createJSJGallerySlideshow(),
            utilities = jsj_gallery_slideshow.utilities;

        jsj_gallery_slideshow.$galleries
            .on('cycle-initialized', function () {
                utilities.setInitialHeight($(this));
            })
            .on('cycle-before', function () {
                var sh = $(this).height();
                if (sh > 1) {
                    $(this).parent().clearQueue().animate({ height: sh }, 200);
                }
            })
            .on('cycle-prev', function () {
                // utilities.update_numbers();
                console.log('PREV');
            })
            .on('cycle-next', function () {
                console.log($(this).attr('class'));
                console.log('NEXT');
            })
            .on('cycle-after', function () {
                console.log('after');
            });

            // utilities.update_pagination_string($this.parent().find('.gallery-numbering'), 1);

            //                 // Set Initial Height
            // 
    });

}(window.jQuery));