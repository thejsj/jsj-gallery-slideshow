<?php

	/**
	 * Things you should change in this file
	 *
	 * 1. Name of class (JSJGallerySlideshowDefaultTheme). This must be changed twice
	 * 2. Name of class instance variable (jsj_gallery_slideshow_default_Theme)
	 * 3. Name of your theme ('Default')
	 */
	
	// Require the default theme class, in order to extend it
	if (!class_exists('JSJGallerySlideshowTheme')) {
		require( plugin_dir_path( dirname(dirname(__FILE__)) ) . '/lib/jsj-gallery-slideshow-theme.php');
	}

	// Extend the default Theme Class
	class JSJGallerySlideshowDefaultCaptionTheme extends JSJGallerySlideshowTheme {

		public $name = 'Default With Caption'; // Change the name of your theme that will appear in the admin
		public $slug = 'jsj-gallery-slideshow-default-caption';

		public function __construct(){
			 // Get this file's directory
			$this->directory = plugin_dir_path( __FILE__ );
			$this->url       = trailingslashit(plugins_url('', __FILE__ )); // Used for static files
			parent::__construct();
		}
	}

	// Init Our Slideshow
	$jsj_gallery_slideshow_default_caption_theme = new JSJGallerySlideshowDefaultCaptionTheme();

