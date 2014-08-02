<?php

	/**
	 * Things you should change in this file
	 *
	 * 1. Name of class (JSJGallerySlideshowDefaultTheme). This must be changed twice
	 * 2. Name of class instance variable (jsj_gallery_slideshow_default_Theme)
	 * 3. Name of your theme ('Default')
	 */
	
	// Require the default theme class, in order to extend it
	require( plugin_dir_path( dirname(dirname(__FILE__)) ) . '/lib/jsj-gallery-slideshow-theme.php');

	// Extend the default Theme Class
	class JSJGallerySlideshowDefaultTheme extends JSJGallerySlideshowTheme {

		public $name = 'Default'; // Change the name of your theme that will appear in the admin

		public function __construct(){
			 // Get this file's directory
			$this->directory = plugin_dir_path( __FILE__ );
			parent::__construct();
		}
	}

	// Init Our Slideshow
	$jsj_gallery_slideshow_default_Theme = new JSJGallerySlideshowDefaultTheme();

