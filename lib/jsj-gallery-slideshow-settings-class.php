<?php

	class JSJGallerySlideshowSettings {

		public function __construct($name_space) {
			$this->name_space = $name_space;

			// Call register settings function
			add_action( 'admin_init', array($this, 'admin_init') );
		}

		/**
		 * Init all settings, so that they can be used by the plugin
		 */
		public function initSettings() {
			
			require( plugin_dir_path( __FILE__ ) . 'settings/jsj-gallery-slideshow-settings-themes.php');
			require( plugin_dir_path( __FILE__ ) . 'settings/jsj-gallery-slideshow-settings-cycle.php');
			require( plugin_dir_path( __FILE__ ) . 'settings/jsj-gallery-slideshow-settings-other.php');

			$this->themes = $jsj_gallery_slideshow_options_themes;
			$this->cycle  = $jsj_gallery_slideshow_options_cycle;
			$this->other  = $jsj_gallery_slideshow_options_other;		
			
			// Get Settings
			foreach($this as $group_key => $setttings_group){
				if (is_array($setttings_group)){
					foreach($setttings_group as $setting){
						$k = $setting->name;

						$this->{$group_key}[$k]->name_space = $this->name_space . "-" . $setting->name;
						$this->{$group_key}[$k]->value      = get_option( $this->{$group_key}[$k]->name_space, $setting->default );

						// Perform Data checks
						// If Boolean, conver to boolean
						if($this->{$group_key}[$k]->value == false && $setting->type == 'boolean'){
							$this->{$group_key}[$k]->value = 0; // Convert boolean to int
						}	

						// If numberic value, convert to int
						if(is_numeric($this->{$group_key}[$k]->value) && ($setting->type == 'boolean' || $setting->type == 'number')){
							$this->{$group_key}[$k]->value = intval($this->{$group_key}[$k]->value); // Convert boolean to int
						}	
					}	
				}	
			}
		}	

		/**
		 * Register all plugin settings
		 *
		 * @return void
		 */
		public function admin_init() {
			foreach($this as $group_key => $setttings_group){
				if (is_array($setttings_group)){
					foreach($setttings_group as $setting){
						register_setting( 'jsj_gallery_slideshow-settings-group', $setting->name_space );
					}
				}
			}
		}

		/**
		 * Reset all settings
		 */
		public function resetSettings() {
			foreach($this->cycle as $setting){
				update_option( $setting->name_space , $setting->default);
			}
			foreach($this->other as $setting){
				update_option( $setting->name_space , $setting->default);
			}
		}

	}