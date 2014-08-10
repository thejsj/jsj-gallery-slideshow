/*global window: false, document: false */
(function ($) {
    'use strict';

    var jsj_gallery_slideshow = window.createJSJGallerySlideshow(),
        utilities = jsj_gallery_slideshow.utilities,
        settings = jsj_gallery_slideshow.settings;

    /*jslint unparam: true*/
    $(document)
        .on('cycle-initialized', settings.autoSelector, function (event, optionHash) {
            // Init
            var $this_gallery = $(this),
                $this_numbering = $this_gallery.parent().find(settings.numbering), // settings.numbering is the css class used for our numbering. Find it in our gallerie's container
                $this_caption = $this_gallery.parent().find(settings.caption); // settings.numbering is the css class used for our numbering. Find it in our gallerie's container

            utilities
                .updateNumberingString($this_gallery, $this_numbering, optionHash) // Pass on our first slide);
                .updateCaption($this_gallery, $this_caption, optionHash, {'use_current_slide': true})
                .setInitialHeight($this_gallery);
        })
        .on('cycle-before', settings.autoSelector, function (event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
            var $this_gallery = $(this),
                $this_numbering = $this_gallery.parent().find(settings.numbering), // settings.numbering is the css class used for our numbering. Find it in our gallerie's container
                $this_caption = $this_gallery.parent().find(settings.caption);

            utilities
                .updateGalleryHeight($this_gallery, incomingSlideEl)
                .updateCaption($this_gallery, $this_caption, optionHash)
                .updateNumberingString($this_gallery, $this_numbering, optionHash);
        });
    /*jslint unparam: false*/

}(window.jQuery));