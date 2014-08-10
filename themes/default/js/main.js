(function($) {
    "use strict";
    var jsj_gallery_slideshow = window.createJSJGallerySlideshow(), utilities = jsj_gallery_slideshow.utilities, settings = jsj_gallery_slideshow.settings;
    $(document).on("cycle-initialized", settings.autoSelector, function(event, optionHash) {
        var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering), $this_pager = $this_gallery.parent().find(settings.pager);
        utilities.updateNumberingString($this_gallery, $this_numbering, optionHash).setInitialHeight($this_gallery).addImagePagination($this_gallery, $this_pager);
    }).on("cycle-before", settings.autoSelector, function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
        var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering);
        utilities.updateGalleryHeight($this_gallery, incomingSlideEl).updateNumberingString($this_gallery, $this_numbering, optionHash);
    });
})(window.jQuery);