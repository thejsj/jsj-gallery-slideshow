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

/*

TODO : Add Correct urls to resources and credit
TODO : Add new screenshots for plugin admin
TODO : Add changes to readme.txt
TODO : Update readme.txt

LATER: 

TODO : Update Banners in Wordpress.org
TODO : Add new screenshots for plugin front-end

*/

// Require Default Themes
require( plugin_dir_path( __FILE__ ) . '/themes/default/theme-main.php');
require( plugin_dir_path( __FILE__ ) . '/themes/default-captions/theme-main.php');

// Require Classes
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-settings-class.php');
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-static-enqueue.php');
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-admin.php');

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
		$this->settings       = new JSJGallerySlideshowSettings(
			$this->name_space
		);

		$this->static_enqueue = new JSJGallerySlideshowStaticEnqueue(
			$this->name_space, 
			$this->settings
		);

		$this->admin          = new JSJGallerySlideshowAdmin(
			$this->name_space, 
			$this->settings, 
			$this->title, 
			$this->all_themes
		);

		// Init Set All Plugin Variables
		add_action('init', array($this, 'init') );

		remove_shortcode('gallery');
		add_shortcode('gallery', array($this, 'gallery_shortcode') );
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
		$this->theme = false;
		foreach($this->all_themes as $k => $theme){
			if($this->settings->themes['current_theme']->value === $theme['slug']) {
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
		$this->admin->updateThemes($this->all_themes);
	}
	
	/**
	 * Change Slidehow Function
	 * 
	 * Overwrite of WP Core
	 * 
	 * @return string
	 */
	public function gallery_shortcode($attr){
		global $post, $wp_locale;

		static $instance = 0;
		$instance++;
		if ( ! empty( $attr['ids'] ) ) {
		  // 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

	  	// Allow plugins/themes to override the default gallery template.
		$output = apply_filters('post_gallery', '', $attr);
		if ( $output != '' )
			return $output;

	  	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		};

		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => $this->settings->other['defaultImageSize']->value,
			'include'    => '',
			'exclude'    => ''
			), $attr));

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		if ( empty($attachments) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}

		/**
		 *
		 * Don't include this, because this is horrible code
		 *
		 * $gallery_style = $gallery_div = '';
		 * if ( apply_filters( 'use_default_gallery_style', true ) )
		 *	$gallery_style = "<style type='text/css'>#{$selector} .gallery img { border: 0px; margin: 0px; }</style>";
		 * see gallery_shortcode() in wp-includes/media.php
		 * $size_class = sanitize_html_class( $size );
		 */
		
		/**
		 * WARNING: We're ignoring and NOT including the 'gallery_style' filter
	     */

		// Define all our variables to be used in our templates
		$template_variables = array();
		$template_variables['itemtag']            = tag_escape($itemtag);
		$template_variables['captiontag']         = tag_escape($captiontag);
		$template_variables['name_space']         = $this->name_space;
		$template_variables['columns']            = intval($columns);
		$template_variables['itemwidth']          = $columns > 0 ? floor(100/$columns) : 100;
		$template_variables['float']              = is_rtl() ? 'right' : 'left';
		$template_variables['id']                 = $instance;
		$template_variables['selector']           = "gallery-{$instance}";
		$template_variables['previous']           = __( 'Previous', 'jsj-gallery-slideshow' );
		$template_variables['next']               = __( 'Next Image', 'jsj-gallery-slideshow' );
		$template_variables['totalCount']         = count($attachments);
		$template_variables['count']              = $template_variables['totalCount'];
		$template_variables['images']             = $this->getImages($attachments, $size, $instance);
		$template_variables['number_translation'] =  __( 'of', '1 of 10','jsj-gallery-slideshow' );

		// Render Template
		$output   = $this->renderTemplate($this->theme['template_file_location'], $template_variables);
		
		return $output;
	}

	/**
	 * Get an array of attachemnts as a HTML
	 *
	 * @param $attachments <array> - Array of WP attachments IDs
	 * @return <string> - HTML with images
	 */
	public function getImages($attachments, $size, $instance) {
		// Set our {{ images }} tag
		$i = 0;
		$images_html = "";
		foreach ( $attachments as $id => $attachment ) {
			$i++;
			  // This comes from line 770 of wp-includes/media.php
			$image_src = wp_get_attachment_image_src( $id, $size );
			$attributes = array(
				'data-galleryid'   => $instance,
				'data-link'   => $image_src[0],
				'data-width'  => $image_src[1],
				'data-height' => $image_src[2],
				);
			$images_html .= wp_get_attachment_image( $id, $size, false, $attributes);
		}
		return $images_html;
	}

	/**
	 * Render Template
	 *
	 * This function is pretty horrible and embarrasing, but it's the best solution I found that doesn't involve writing my own template system
	 * I hate you PHP and the things you make me do!
	 *
	 * @param filename <string>
	 * @param variables <array> - variables available to the template
	 * @return HTML <string> - Parsed HTML
	 */
    public function renderTemplate($template_file_location, $vars) {
		//start output buffering (so we can return the content)
        ob_start();
        //bring all variables into "local" variables using "variable variable names"
        foreach($vars as $k => $v) {
            $$k = $v;
        }

        //include view
        include($template_file_location);

        $str = ob_get_contents();//get teh entire view.
        ob_end_clean();//stop output buffering
        return $str;
    }

} ?>