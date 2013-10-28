function UpdateNumbers(isNext, zeroBasedSlideIndex, slideElement){
	if(slideElement.src != undefined){
		console.log("SlideElementHeight: " + slideElement.height);
		galleryId = jQuery("img[src$='" + slideElement.src + "']").data("galleryid");
		updatePaginationString(galleryId, zeroBasedSlideIndex);
	}
	else {
		var string = "";
	}
	jQuery("#galleryNumbering-" + galleryId).html(string);
}

function updatePaginationString(galleryId, slideNumber){
	if(slideNumber != undefined && slideNumber > 0){
		var total = parseInt(jQuery("#galleryid-" + galleryId).data("total"));
		var string = "(" + (slideNumber + 1) + " of " + total + ")"; // (1 of 6)
	}
	else {
		var total = parseInt(jQuery("#galleryid-" + galleryId).data("total"));
		var string = "(" + 1 + " of " + total + ")"; // (1 of 6)
	}
	jQuery("#galleryNumbering-" + galleryId).html(string);
}

function updateGalleryHeight(currSlideElement, nextSlideElement, options, forwardFlag){
	if(nextSlideElement.height > 0){
		console.log("Height: " + nextSlideElement.height)
		jQuery("#galleryid-" + options.id).clearQueue().animate({
			height: nextSlideElement.height
		}, slideTransitionTime);
	}
}
function setInitialHeight(thisGallery){
	// Set Height
	// Plan A: Get it directly...
	var hght = thisGallery[0].children[0].height;
	if(hght > 0){
		thisGallery.clearQueue().animate({
			height: hght
		}, 200);
	}
	else {
	// Plan B: Try Another way...
	var myImage = new Image();
	myImage.name = thisGallery.context.images[0].src;
	myImage.src = thisGallery.context.images[0].src;
	myImage.onload = function(){
		imgHeight = this.height;
		if(imgHeight > 0){
			thisGallery.clearQueue().animate({
				height: imgHeight
			}, 200);
		}
		};
		myImage.src = thisGallery.context.images[0].src;
	}
}