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
require_once( plugin_dir_path( __FILE__ ) . '/themes/default/theme-main.php');
require_once( plugin_dir_path( __FILE__ ) . '/themes/default-captions/theme-main.php');

// Require Classes
require_once( plugin_dir_path( __FILE__ ) . 'includes/handlers/class-settings-handler.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/handlers/class-static-enqueue-handler.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/handlers/class-admin-handler.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/handlers/class-shortcode-handler.php');

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

		$this->all_themes          = array();
		$this->all_enqueued_themes = array();
		$this->theme               = false;
		$this->scripts             = array(
			'main'  => $this->name_space + '-main',
		);

		$this->settings = new JSJGallerySlideshowSettings(
			$this->name_space
		);

		$this->static_enqueue = new JSJGallerySlideshowStaticEnqueue(
			$this->name_space, 
			$this->settings,
			$this->theme,
			$this->scripts
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
			$this->theme,
			$this->all_themes,
			$this->scripts
		);

		// Init Set All Plugin Variables
		add_action('init', array($this, 'init') );

		// Call register settings function
		add_action( 'admin_init', array($this->settings, 'admintInit') );

		// Hook for adding admin menus
		add_action('admin_menu',  array($this->admin, 'addOptionsMenu'));

		// Add JS scripts
		add_action( 'wp_enqueue_scripts', array($this->static_enqueue, 'enqueueClientScripts') );

		// Admin: Enqueue CSS
		add_action( 'admin_enqueue_scripts', array($this->static_enqueue, 'enqueueAdminScripts') );

		// Add an array of all used images
		add_action( 'wp_footer', array($this, 'getAllEnqueuedThemes'), 5 );
		add_action( 'wp_footer', array($this->static_enqueue, 'enqueueAllExtraThemes'), 5);
		add_action( 'wp_footer', array($this->shortcode_handler, 'enqueueImagesArray'));

		// Add our shortcode
		remove_shortcode('gallery');
		add_shortcode('gallery', array($this->shortcode_handler, 'galleryShortcode') );
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

		// If the theme is not theme found, make the 'classic' theme our theme
		if(!$this->theme) {
			foreach($this->all_themes as $k => $theme){
				if($theme['slug'] === 'jsj-gallery-slideshow-classic') {
					$this->all_themes[$k]['active']                 = true;
					$this->theme                                    = $this->all_themes[$k];
				}
			}
		}

		// Update our $all_themes in Admin
		$this->settings->appendThemeSettings($this->theme);

		$this->admin->updateAllThemes($this->all_themes);
		$this->shortcode_handler->updateAllThemes($this->all_themes);

		$this->static_enqueue->updateTheme($this->theme);
		$this->shortcode_handler->updateTheme($this->theme);
	}

	/** 
	 * Query our shortcode_handler for all used themes. Pass them on to the our static_enqueue handler
	 * 
	 * @return void
	 */
	public function getAllEnqueuedThemes () {
		$this->static_enqueue->updateAllEnqueuedThemes($this->shortcode_handler->all_enqueued_themes);
	}

} ?>