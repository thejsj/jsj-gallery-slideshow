/*global window: false, document: false */
(function ($) {
    'use strict';

    var jsj_gallery_slideshow = window.createJSJGallerySlideshow(),
        utilities = jsj_gallery_slideshow.utilities,
        settings = jsj_gallery_slideshow.settings;

    /*jslint unparam: true*/
    $('body')
        .on('cycle-initialized', settings.autoSelector, function (event, optionHash) {
            jsj_gallery_slideshow.get$el()
                .each(function () {
                    // Init
                    var $this_gallery = $(this),
                        $this_numbering = $this_gallery.parent().find(settings.numbering), // settings.numbering is the css class used for our numbering. Find it in our gallerie's container
                        $this_pager = $this_gallery.parent().find(settings.pager); // settings.pager is the css class used for our page. Find it in our gallerie's container

                    utilities
                        .updatePaginationString($this_numbering, 0) // Pass on our first slide);
                        .setInitialHeight($this_gallery)
                        .addImagePagination($this_gallery, $this_pager);
                });
        })
        .on('cycle-before', settings.autoSelector, function (event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
            var $this_gallery = $(this),
                $this_numbering = $this_gallery.parent().find(settings.numbering), // settings.numbering is the css class used for our numbering. Find it in our gallerie's container
                next_slide_index = optionHash.nextSlide;

            utilities
                .updateGalleryHeight($this_gallery, incomingSlideEl)
                .updatePaginationString($this_numbering, next_slide_index);
        });

}(window.jQuery));