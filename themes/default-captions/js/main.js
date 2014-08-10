(function($) {
    "use strict";
    var jsj_gallery_slideshow = window.createJSJGallerySlideshow(), utilities = jsj_gallery_slideshow.utilities, settings = jsj_gallery_slideshow.settings;
    $(document).on("cycle-initialized", settings.autoSelector, function(event, optionHash) {
        var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering);
        utilities.updateNumberingString($this_gallery, $this_numbering, 0).setInitialHeight($this_gallery);
    }).on("cycle-before", settings.autoSelector, function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
        var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering), next_slide_index = optionHash.nextSlide;
        utilities.updateGalleryHeight($this_gallery, incomingSlideEl).updateNumberingString($this_gallery, $this_numbering, next_slide_index);
    });
})(window.jQuery);