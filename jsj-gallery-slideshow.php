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

		$this->settings       = new JSJGallerySlideshowSettings($this->name_space);
		$this->static_enqueue = new JSJGallerySlideshowStaticEnqueue($this->name_space, $this->settings);
		$this->admin          = new JSJGallerySlideshowAdmin($this->name_space, $this->settings, $this->title);

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
		$this->themes = apply_filters( 'jsj-gallery-slideshow_load_themes', array() );
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

		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$columns = intval($columns);
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = $gallery_div = '';
		if ( apply_filters( 'use_default_gallery_style', true ) )
			$gallery_style = "<style type='text/css'>#{$selector} .gallery img { border: 0px; margin: 0px; }</style>";
		// see gallery_shortcode() in wp-includes/media.php
		$size_class = sanitize_html_class( $size );
		$totalCount = count($attachments);
		$gallery_div = "<div id='galleryid-{$instance}' data-total='{$totalCount}'class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	  	
	  	// Start Gallery HTML Code
		$output  = "";
	  	// Start Container 
		$output .= "<div id='gallery-container-{$instance} gallery_container_{$this->name_space}-{$instance}' class='gallery-container gallery_container_{$this->name_space}'>";
	  		// Start Navigation
			$output .= "<div class='gallery-navigation'>";
				$output .= "<a id='galleryPrev-{$instance}' class='gallery-prev gallery-button' href='#'>" . __( 'Previous', 'jsj-gallery-slideshow' ) . "</a>";
				$output .= " / <a id='galleryNext-{$instance}' class='gallery-next gallery-button' href='#'>" . __( 'Next Image', 'jsj-gallery-slideshow' ) . "</a>";
				$output .= " <span id='galleryNumbering-{$instance}' class='gallery-numbering' data-numbering-translation-of='" . _x( 'of', '1 of 10','jsj-gallery-slideshow' ) . "'></span>";
			$output .= "</div>"; // Finish Navigation
	  		// Start Gallery
			$output .= apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
				$i = 0;
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
					$output .= wp_get_attachment_image( $id, $size, false, $attributes);
				}
			$output .= "</div>\n"; // Finish gallery div (has images)
			// Start Gallery Pager
			$output .= "<div id='gallery-pager-{$instance}' class='gallery-pager'></div>";
			// End Container
			$output .= "<div style='clear:both;'></div>";
		$output .= "</div>"; // Finish Gallery Container
		return $output;
	}

} ?>