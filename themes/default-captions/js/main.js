(function($) {
    "use strict";
    var jsj_gallery_slideshow = window.createJSJGallerySlideshow(), utilities = jsj_gallery_slideshow.utilities, settings = jsj_gallery_slideshow.settings;
    $(document).on("cycle-initialized", settings.autoSelector, function(event, optionHash) {
        var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering), $this_caption = $this_gallery.parent().find(settings.caption);
        utilities.updateNumberingString($this_gallery, $this_numbering, optionHash).updateCaption($this_gallery, $this_caption, optionHash, {
            use_current_slide: true
        }).setInitialHeight($this_gallery);
    }).on("cycle-before", settings.autoSelector, function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
        var $this_gallery = $(this), $this_numbering = $this_gallery.parent().find(settings.numbering), $this_caption = $this_gallery.parent().find(settings.caption);
        utilities.updateGalleryHeight($this_gallery, incomingSlideEl).updateCaption($this_gallery, $this_caption, optionHash).updateNumberingString($this_gallery, $this_numbering, optionHash);
    });
})(window.jQuery);