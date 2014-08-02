<?php 

	class JSJGallerySlideshowStaticEnqueue {

		public function __construct ($name_space, &$settings) {
			$this->name_space = $name_space;
			$this->settings   = $settings;

			// Add JS scripts
			add_action( 'wp_enqueue_scripts', array($this, 'enqueue_client_scripts') );

			// Admin: Enqueue CSS
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );
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

				// Add CSS
				wp_enqueue_style(
					"jsj-gallery-slideshow-style", 
					plugins_url( 'static/css/jsj-gallery-slideshow-style.css' , dirname(__FILE__) )
				);

				if(!wp_script_is('jquery')){
					wp_enqueue_script( 'jquery' );
				}
				wp_enqueue_script(
					'jsjGallerySlideshowScripts-jQueryCycle',
					plugins_url( 'static/js/jsj-gallery-slideshow.js' , dirname(__FILE__) ),
					array( 'jquery' ), // Deps
					"", // Version
					true // Footer
				);

				//	Parse Settings so that they come out in their most simple form
				$jsj_gallery__slideshow_options_for_javascript = array(); 
				foreach($this->settings->cycle as $key => $setting){
					if($setting->value != $setting->default || $key == "speed"){
						$jsj_gallery__slideshow_options_for_javascript[$key] = $setting->value;
					}
				}

				// Localize Settings
				wp_localize_script( 
					'jsjGallerySlideshowScripts-jQueryCycle', 
					'jsjGallerySlideshowOptions', 
					array(
						'settings' => $jsj_gallery__slideshow_options_for_javascript,
						'scripts_enqueued' => $this->scripts_enqueued
					) 
				);
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