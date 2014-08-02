<?php 

	class JSJGallerySlideshowStaticEnqueue {

		public function __construct ($name_space, &$settings, &$theme) {
			$this->name_space = $name_space;
			$this->settings   = $settings;
			$this->theme      = $theme;

			// Add JS scripts
			add_action( 'wp_enqueue_scripts', array($this, 'enqueue_client_scripts') );

			// Admin: Enqueue CSS
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );
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
		 * Add Script to the Footer and Header
		 *
		 * @return void
		 */
		public function enqueue_client_scripts(){
			global $post;

			if( $this->settings->other['checkForShortCode']->value == 'false' || $this->settings->other['checkForShortCode']->value == 'true' && has_shortcode( $post->post_content, 'gallery' ) ) {
				// Determines if Javascript code will be inserted into the page
				$this->scripts_enqueued = true; 

				//	Parse Settings so that they come out in their most simple form
				$jsj_gallery__slideshow_options_for_javascript = array(); 
				foreach($this->settings->cycle as $key => $setting){
					if($setting->value != $setting->default || $key == "speed"){
						$jsj_gallery__slideshow_options_for_javascript[$key] = $setting->value;
					}
				}

				// Settings to be localized
				$settings = array(
					'settings' => $jsj_gallery__slideshow_options_for_javascript,
					'scripts_enqueued' => $this->scripts_enqueued
				);

				if(!wp_script_is('jquery')){
					wp_enqueue_script( 'jquery' );
				}
				wp_enqueue_script(
					'jsjGallerySlideshowScripts-jQueryCycle',
					plugins_url( 'static/js/jsj-gallery-slideshow.min.js' , dirname(__FILE__) ),
					array( 'jquery' ), // Deps
					"", // Version
					true // Footer
				);

				// Localize Settings
				wp_localize_script( 
					'jsjGallerySlideshowScripts-jQueryCycle', 
					'jsjGallerySlideshowOptions', 
					$settings
				);

				// Enqueue All theme Static file

				if($this->theme['css_url']){
					wp_enqueue_style(
						"jsj-gallery-slideshow-theme-style", 
						$this->theme['css_url']
					);
				}

				if($this->theme['js_url']){
					wp_enqueue_script(
						'jsjGallerySlideshowScripts-theme-script',
						$this->theme['js_url'],
						array( 'jquery', 'jsjGallerySlideshowScripts-jQueryCycle' ), // Deps
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
		public function enqueue_admin_scripts(){
			// Add CSS
			wp_enqueue_style(
				"jsj-gallery-slideshow-admin-style", 
				plugins_url( 'static/css/jsj-gallery-slideshow-admin-style.css' , dirname(__FILE__) )
			);
		}

	}