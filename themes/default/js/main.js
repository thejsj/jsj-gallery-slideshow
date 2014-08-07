(function($) {
    "use strict";
    $(document).ready(function() {
        var jsj_gallery_slideshow = window.createJSJGallerySlideshow(), utilities = jsj_gallery_slideshow.utilities;
        jsj_gallery_slideshow.$el.each(function() {
            utilities.updatePaginationString($(this).parent().find(".gallery-numbering"), 0);
            utilities.setInitialHeight($(this));
        }).on("cycle-before", function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
            utilities.updateGalleryHeight(incomingSlideEl, this);
            utilities.updatePaginationString($(this).parent().find(".gallery-numbering"), optionHash.nextSlide);
        });
    });
})(window.jQuery);