(function($) {
    "use strict";
    $(document).ready(function() {
        var jsj_gallery_slideshow = window.createJSJGallerySlideshow(), utilities = jsj_gallery_slideshow.utilities, settings = jsj_gallery_slideshow.settings;
        jsj_gallery_slideshow.$el.each(function() {
            var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering), $this_pager = $this_gallery.parent().find(settings.pager);
            utilities.updatePaginationString($this_numbering, 0).setInitialHeight($this_gallery).addImagePagination($this_gallery, $this_pager);
        }).on("cycle-before", function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
            var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering), next_slide_index = optionHash.nextSlide;
            utilities.updateGalleryHeight($this_gallery, incomingSlideEl).updatePaginationString($this_numbering, next_slide_index);
        });
    });
})(window.jQuery);