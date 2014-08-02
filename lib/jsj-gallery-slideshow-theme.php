<?php
	
	/**
	 * If you're creating your own theme, extend this class
	 */
	class JSJGallerySlideshowTheme {

		public function __construct() {
			$this->css_file_location      = sprintf("%s/css/main.css", $this->directory);
			$this->js_file_location       = sprintf("%s/js/main.js", $this->directory);
			$this->template_file_location = sprintf("%s/template.php", $this->directory);

			// Register our theme with its respective name
			add_filter('jsj-gallery-slideshow_load_themes', array($this, 'loadTheme'));
		}

		public function loadTheme($themes) {

			$this->theme_options = array(
				'name'                   => $this->name,
				'css_file_location'      => $this->css_file_location,
				'js_file_location'       => $this->js_file_location,
				'template_file_location' => $this->template_file_location
			);

			// Append our class to 
			array_push($themes, $this->theme_options);
			return $themes;
		}

	}