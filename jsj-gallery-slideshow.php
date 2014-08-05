<?php

/*
Plugin Name: JSJ Gallery Slideshow
Plugin URI: http://wordpress.org/plugins/jsj-gallery-slideshow/
Description: A plugin to immediately improve all your WordPress galleries, with a simple, easy-to-use slideshow. 
Version: 1.2.9
Author: Jorge Silva Jetter
Author URI: http://thejsj.com
License: GPL2
*/

// Require Default Themes
require( plugin_dir_path( __FILE__ ) . '/themes/default/theme-main.php');
require( plugin_dir_path( __FILE__ ) . '/themes/default-captions/theme-main.php');

// Require Classes
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-settings-class.php');
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-static-enqueue.php');
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-admin.php');
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-shortcode-handler.php');

$jsj_gallery_slideshow_object = new JSJGallerySlideshow();

class JSJGallerySlideshow {

	private $defined = true; 
	private $title = 'JSJ Gallery Slideshow';
	private $name_space = 'jsj-gallery-slideshow';
	private $titleLowerCase = '';
	private $instructions = '';
	
	/**
	 * Bind Plugin to WordPress hooks
	 * 
	 * @return void
	 */
	public function __construct(){
		/* * * Bind Plugin to WordPress Hooks * * */

		$this->all_themes     = array();
		$this->theme = false;

		$this->settings = new JSJGallerySlideshowSettings(
			$this->name_space
		);

		$this->static_enqueue = new JSJGallerySlideshowStaticEnqueue(
			$this->name_space, 
			$this->settings,
			$this->theme
		);

		$this->admin = new JSJGallerySlideshowAdmin(
			$this->name_space, 
			$this->settings, 
			$this->title, 
			$this->all_themes
		);

		$this->shortcode_handler = new JSJGallerySlideshowShortcodeHandler(
			$this->name_space, 
			$this->settings,
			$this->theme
		);

		// Init Set All Plugin Variables
		add_action('init', array($this, 'init') );

		remove_shortcode('gallery');
		add_shortcode('gallery', array($this->shortcode_handler, 'gallery_shortcode') );
	}


	/**
	 * Init Plugin and get all settings
	 * 
	 * @return void
	 */
	public function init(){
		// Load Translation
		load_plugin_textdomain('jsj-gallery-slideshow', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
		$this->title = __( 'JSJ Gallery Slideshow', 'jsj-gallery-slideshow' );

		// Load Settings
		$this->settings->initSettings();

		// Load All Themes
		$this->all_themes = apply_filters( 'jsj-gallery-slideshow_load_themes', $this->all_themes);

		// Determine which is our active theme, if no theme is selected, use the default one
		foreach($this->all_themes as $k => $theme){
			if($this->settings->themes['current_theme']['value'] === $theme['slug']) {
				$this->theme                    = $this->all_themes[$k];
				$this->all_themes[$k]['active'] = true;
			} else {
				$this->all_themes[$k]['active'] = false;
			}
		}

		// If the theme is not theme found, make the 'default' theme our theme
		if(!$this->theme) {
			foreach($this->all_themes as $k => $theme){
				if($theme['slug'] === 'jsj-gallery-slideshow-default') {
					$this->all_themes[$k]['active']                 = true;
					$this->theme                                    = $this->all_themes[$k];
				}
			}
		}

		// Update our $all_themes in Admin
		$this->settings->appendThemeSettings($this->theme);
		$this->admin->updateThemes($this->all_themes);
		$this->static_enqueue->updateTheme($this->theme);
		$this->shortcode_handler->updateTheme($this->theme);
	}

} ?>