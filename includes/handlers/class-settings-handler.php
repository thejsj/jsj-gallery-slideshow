<?php

	class JSJGallerySlideshowSettings {

		public function __construct($name_space) {
			$this->name_space = $name_space;
		}

		/**
		 * Init all settings, so that they can be used by the plugin
		 */
		public function initSettings() {
			
			require_once( plugin_dir_path( dirname(__FILE__) ) . 'settings/settings-themes.php');
			require_once( plugin_dir_path( dirname(__FILE__) ) . 'settings/settings-cycle.php');
			require_once( plugin_dir_path( dirname(__FILE__) ) . 'settings/settings-other.php');

			$this->themes = $jsj_gallery_slideshow_options_themes;
			$this->cycle  = $jsj_gallery_slideshow_options_cycle;
			$this->other  = $jsj_gallery_slideshow_options_other;		
			
			// Get Settings
			foreach($this as $group_key => $setttings_group){
				if (is_array($setttings_group)){
					foreach($setttings_group as $setting){
						$k = $setting['name'];

						$this->{$group_key}[$k]['name_space'] = $this->addNameSpace($setting['name']);
						$this->{$group_key}[$k]['value']      = get_option( $this->{$group_key}[$k]['name_space'], $setting['default'] );

						// Perform Data checks
						// If Boolean, conver to boolean
						if($this->{$group_key}[$k]['value'] == false && $setting['type'] == 'boolean'){
							$this->{$group_key}[$k]['value'] = 0; // Convert boolean to int
						}	

						// If numberic value, convert to int
						if(is_numeric($this->{$group_key}[$k]['value']) && ($setting['type'] == 'boolean' || $setting['type'] == 'number')){
							$this->{$group_key}[$k]['value'] = intval($this->{$group_key}[$k]['value']); // Convert boolean to int
						}

						if ($this->{$group_key}[$k]['value'] === ""){
							$this->{$group_key}[$k]['value'] = $this->{$group_key}[$k]['default'];
						}
					}	
				}	
			}
		}

		/**
		 * Add name space
		 */
		public function addNameSpace($name){
			return $this->name_space . "-" . $name;
		}

		/**
		 * Register all plugin settings
		 *
		 * @return void
		 */
		public function admintInit() {
			foreach($this as $group_key => $setttings_group){
				if (is_array($setttings_group)){
					foreach($setttings_group as $setting){
						register_setting( 'jsj_gallery_slideshow-settings-group', $setting['name_space'] );
					}
				}
			}
		}

		/**
		 * Reset all settings
		 */
		public function resetSettings() {
			foreach($this->cycle as $setting){
				update_option( $setting['name_space'] , $setting['default']);
			}
			foreach($this->other as $setting){
				update_option( $setting['name_space'] , $setting['default']);
			}
		}

		public function appendThemeSettings($theme) {
			$this->cycle = array_merge($this->cycle, $theme['cycle_options']);
			foreach($this->cycle as $key => $setting){
				$this->cycle[$key]['name_space'] = $this->addNameSpace($setting['name']);
			}
		}

		/**
		 * Check if value needs to be appended
		 *
		 * @param <array> - $setting
		 * @return <boolean>
		 */
		public function appendValue($setting){
			// Don't append if empty
			if($setting['value'] === ''){
				return false;
			}
			// Check against default
			if(isset($setting['cycle_default'])) {
				if ($this->getValue($setting) === $setting['cycle_default']){
					return false;
				}
			} else {
				if($this->getValue($setting) === $setting['default']){
					return false;
				}
			}
			return true;
		}

		/**
		 * Return the correct value, by checking our data-type
		 *
		 * @param <array> - $setting
		 * @return <mixed>
		 */
		public function getValue($setting) {
			if (isset($setting['data_type'])){
				if ($setting['data_type'] === 'boolean'){
					return (bool) $setting['value'];
				} else if($setting['data_type'] === 'integer') {
					return (int) $setting['value'];
				} else if($setting['data_type'] === 'string') {
					return (string) $setting['value'];
				} else if($setting['data_type'] === 'jquery-selector') {
					return (string) $setting['value'];
				}
				return $setting['value'];
			}
			return $setting['value'];
		}

	}