<?php
	
	/**
	 * If you're creating your own theme, extend this class
	 */
	class JSJGallerySlideshowTheme {

		/**
		 * Default location and file names of files
		 *
		 * Don't change this unless you have a good reason to do so
		 */
		public $css_file        = 'css/main.css';
		public $js_file         = 'js/main.js';
		public $template_file   = 'template.php';
		public $screenshot_file = 'screenshot.png';

		/**
		 * Template Options
		 *
		 * These will be passed on to our template and to our Cycle2 slideshow
		 */
		public $js_selectors = array(
			'autoSelector'       => 'jsj-gs-gallery',
			'caption'            => 'jsj-gs-caption',
			'caption-template'   => '{{slideNum}} / {{slideCount}}',
			'disabled-class'     => 'jsj-gs-disabled',
			'next'               => 'jsj-gs-next',
			'pager'              => 'jsj-gs-pager',
			'pager-active-class' => 'jsj-gs-active',
			'prev'               => 'jsj-gs-prev',
			'slide-active-class' => 'jsj-gs-active',
			'slide-class'        => 'jsj-gs-slide',
		);

		public function __construct() {
			$this->css_url                  = sprintf("%s%s", $this->url, $this->css_file);
			$this->js_url                   = sprintf("%s%s", $this->url, $this->js_file);
			$this->template_file_location   = sprintf("%s%s", $this->directory, $this->template_file);
			$this->screenshot_url           = sprintf("%s%s", $this->url, $this->screenshot_file);

			// Register our theme with its respective name
			add_filter('jsj-gallery-slideshow_load_themes', array($this, 'loadTheme'));
		}

		public function loadTheme($themes) {

			$this->theme_options = array(
				'name'                    => $this->name,
				'slug'                    => $this->slug,
				'css_url'                 => $this->css_url,
				'js_url'                  => $this->js_url,
				'template_file_location'  => $this->template_file_location,
				'screenshot_url'          => $this->screenshot_url
			);

			// Append our class to 
			array_push($themes, $this->theme_options);
			return $themes;
		}

	}