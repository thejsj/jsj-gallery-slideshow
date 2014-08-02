<?php
	
	/**
	 * If you're creating your own theme, extend this class
	 */
	class JSJGallerySlideshowTheme {

		public function __construct() {
			$this->css_url                  = sprintf("%scss/main.css", $this->url);
			$this->js_url                   = sprintf("%sjs/main.js", $this->url);
			$this->template_file_location   = sprintf("%stemplate.php", $this->directory);
			$this->screenshot_url           = sprintf("%sscreenshot.png", $this->url);

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