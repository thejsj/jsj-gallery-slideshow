<?php 

	class JSJGallerySlideshowStaticEnqueue {

		public function __construct ($name_space, &$settings, &$theme, $scripts) {
			$this->name_space = $name_space;
			$this->settings   = $settings;
			$this->theme      = $theme;
			$this->scripts    = $scripts;
			$this->all_enqueued_themes = array();
		}

		/**
		 * Update our theme variable
		 *
		 * I'm only adding this because passing by reference wasn't working for me
		 */
		public function updateTheme($theme) {
			$this->theme = $theme;
		}

		/**
		 * Update the all_enqueued_themes variable from our shortcode_handler
		 *
		 * I'm only adding this because passing by reference wasn't working for me
		 *
		 * @return void
		 */
		public function updateAllEnqueuedThemes($all_enqueued_themes) {
			$this->all_enqueued_themes = $all_enqueued_themes;
		}

		/**
		 * Add Script to the Footer and Header
		 *
		 * @return void
		 */
		public function enqueueClientScripts(){
			global $post;

			if( $this->settings->other['checkForShortCode']['value'] == 'false' || $this->settings->other['checkForShortCode']['value'] == 'true' && has_shortcode( $post->post_content, 'gallery' ) ) {
				// Determines if Javascript code will be inserted into the page
				$this->scripts_enqueued = true; 

				//	Parse Settings so that they come out in their most simple form
				$jsj_gallery_slideshow_options_for_javascript = array(); 
				foreach($this->settings->cycle as $key => $setting){
					// Check if a cycle default is defined
					if($this->settings->appendValue($setting)){
						$jsj_gallery_slideshow_options_for_javascript[$key] = $this->settings->getValue($setting);
					}
				}

				// Settings to be localized
				$settings = array(
					'settings'         => $jsj_gallery_slideshow_options_for_javascript,
					'scripts_enqueued' => $this->scripts_enqueued
				);

				//  Enqueue Modernizr, if not there
				if(!wp_script_is('modernizr')){
					wp_enqueue_script(
						'modernizr',
						'//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.min.js',
						array( ), // Deps
						"2.8.2" // Version
					);
				}	

				// Enqueue jQuery if not there
				if(!wp_script_is('jquery')){
					wp_enqueue_script( 'jquery' );
				}

				wp_enqueue_script(
					$this->scripts['main'],
					plugins_url( 'static/js/jsj-gallery-slideshow.min.js' , dirname(dirname(__FILE__)) ),
					array( 'jquery' ), // Deps
					"", // Version
					true // Footer
				);

				// Localize Settings
				wp_localize_script( 
					$this->scripts['main'],
					'jsj_gallery_slideshow_options', 
					$settings
				);

				// Enqueue All theme Static file

				if($this->theme['css_url']){
					wp_enqueue_style(
						$this->theme['slug'], 
						$this->theme['css_url']
					);
				}

				if($this->theme['js_url']){
					wp_enqueue_script(
						$this->theme['slug'], 
						$this->theme['js_url'],
						array( 'jquery', $this->scripts['main'] ), // Deps
						"", // Version
						true // Footer
					);
				}
			}
			else {
				$this->scripts_enqueued = false; 
			}
		}

		/**
		 * Enqueue CSS stylesheet to admin
		 *
		 * @return void
		 */
		public function enqueueAdminScripts(){
			// Add CSS
			wp_enqueue_style(
				"jsj-gallery-slideshow-admin-style", 
				plugins_url( 'static/css/jsj-gallery-slideshow-admin-style.css' , dirname(dirname(__FILE__)) )
			);
		}

		/**
		 * Enqueue all scripts that are being used by our themes declared in our shortcode
		 *
		 * @return void
		 */
		public function enqueueAllExtraThemes() {
			foreach($this->all_enqueued_themes as $theme) {
				if($theme['css_url']){
					wp_enqueue_style(
						$theme['slug'], 
						$theme['css_url']
					);
				}

				if($theme['js_url']){
					wp_enqueue_script(
						$theme['slug'], 
						$theme['js_url'],
						array( 'jquery', $this->scripts['main'] ), // Deps
						"", // Version
						true // Footer
					);
				}
			}

			// Enqueue Theme Options
			$enqueued_themes_cycle_options = array();

			foreach($this->all_enqueued_themes as $theme) {
				$enqueued_themes_cycle_options[$theme['slug']] = $theme['cycle_options'];
			}

			wp_localize_script( 
				$this->scripts['main'],
				'jsj_gallery_slideshow_theme_options', 
				$enqueued_themes_cycle_options
			);
		}

	}