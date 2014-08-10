<?php

	/**
	 * Things you should change in this file
	 *
	 * 1. Name of class (JSJGallerySlideshowDefaultTheme). This must be changed twice
	 * 2. Name of class instance variable (jsj_gallery_slideshow_classic_Theme)
	 * 3. Name of your theme ('Classic')
	 */
	
	// Require the default theme class, in order to extend it
	if (!class_exists('JSJGallerySlideshowTheme')) {
		require_once( plugin_dir_path( dirname(dirname(__FILE__)) ) . '/includes/classes/class-theme.php');
	}

	// Extend the default Theme Class
	class JSJGallerySlideshowDefaultCaptionTheme extends JSJGallerySlideshowTheme {

		public $name = 'Classic With Caption'; // Change the name of your theme that will appear in the admin
		public $slug = 'jsj-gallery-slideshow-classic-caption';

		public function __construct(){
			 // Get this file's directory
			$this->directory = plugin_dir_path( __FILE__ );
			$this->url       = trailingslashit(plugins_url('', __FILE__ )); // Used for static files
			parent::__construct();
		}
	}

	// Init Our Slideshow
	$jsj_gallery_slideshow_default_caption_theme = new JSJGallerySlideshowDefaultCaptionTheme();

