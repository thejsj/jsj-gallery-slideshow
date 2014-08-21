<?php
	
	/**
	 * If you're creating your own theme, extend this class
	 */
	class JSJGallerySlideshowTheme {

		/**
		 * Default location and file names of files
		 *
		 * Don't change this unless you have a good reason to do so
		 */
		public $css_file        = 'css/main.css';
		public $js_file         = 'js/main.js';
		public $template_file   = 'template.php';
		public $screenshot_file = 'screenshot.png';

		/**
		 * Template Options
		 *
		 * These will be passed on to our template and to our Cycle2 slideshow
		 */

		public $cycle_options = array(
			'autoSelector' => array(
				'name'          => 'autoSelector', 
				'value'         => '.jsj-gs-gallery',
				'css_class'     => 'jsj-gs-gallery',
				'cycle_default' => '.cycle-slideshow[data-cycle-auto-init!=false]',
				'data_type'     => 'jquery-selector',
			),
			'caption' => array(
				'name'          => 'caption', 
				'value'         => '> .jsj-gs-caption',
				'css_class'     => 'jsj-gs-caption',
				'cycle_default' => '> .cycle-caption',
				'data_type'     => 'jquery-selector',
			),
			'captionTemplate' => array(
				'name'          => 'caption-template', 
				'value'         => '{{attachment.metadata.caption}}',
				'cycle_default' => '{{slideNum}} !! / {{slideCount}}',
				'data_type'     => 'string',
			),
			'disabledClass' => array(
				'name'          => 'disabled-class', 
				'value'         => 'disabled',
				'cycle_default' => 'disabled',
				'data_type'     => 'string',
			),
			'next' => array(
				'name'          => 'next', 
				'value'         => '> .gallery-navigation .jsj-gs-next',
				'css_class'     => 'jsj-gs-next',
				'cycle_default' => '> .cycle-next',
				'data_type'     => 'jquery-selector',
			),
			'numbering' => array(
				'name'          => 'numbering', 
				'value'         => '> .gallery-navigation .jsj-gs-numbering',
				'css_class'     => 'jsj-gs-numbering',
				'cycle_default' => '', // Not part of Cycle 2
				'data_type'     => 'jquery-selector',
			),
			'numberingTemplate' => array(
				'name'          => 'numberingTemplate', 
				'value'         => '({{slideNum}} {{ofString}} {{slideCount}})',
				'cycle_default' => '', // Not part of Cycle 2
				'data_type'     => 'string',
			),
			'pager' => array(
				'name'          => 'pager', 
				'value'         => '> .jsj-gs-pager',
				'css_class'     => 'jsj-gs-pager',
				'cycle_default' => '> .cycle-pager',
				'data_type'     => 'jquery-selector',
			),
			'pagerTemplate' => array(
				'name'          => 'pager-template', 
				'value'         => "<li class='slideshow-thumbnail'></li>",
				'cycle_default' => '<span>&bull;</span>',
				'data_type'     => 'string',
			),
			'pagerActiveClass' => array(
				'name'          => 'pager-active-class', 
				'value'         => 'active',
				'cycle_default' => 'cycle-pager-active',
				'data_type'     => 'string',
			),
			'prev' => array(
				'name'          => 'prev', 
				'value'         => '> .gallery-navigation .jsj-gs-prev',
				'css_class'     => 'jsj-gs-prev',
				'cycle_default' => '> .cycle-prev',
				'data_type'     => 'jquery-selector',
			),
			'slideActiveClass' => array(
				'name'          => 'slide-active-class', 
				'value'         => 'active',
				'cycle_default' => 'cycle-slide-active',
				'data_type'     => 'string',
			),
			'slideClass' => array(
				'name'          => 'slide-class', 
				'value'         => 'jsj-gs-slide',
				'cycle_default' => 'cycle-slide',
				'data_type'     => 'string',
			),
		);

		public function __construct() {
			$this->css_url                  = sprintf("%s%s", $this->url, $this->css_file);
			$this->js_url                   = sprintf("%s%s", $this->url, $this->js_file);
			$this->template_file_location   = sprintf("%s%s", $this->directory, $this->template_file);
			$this->screenshot_url           = sprintf("%s%s", $this->url, $this->screenshot_file);

			// Register our theme with its respective name
			add_filter('jsj-gallery-slideshow_load_themes', array($this, 'loadTheme'));
		}

		public function loadTheme($themes) {

			$this->theme_options = array(
				'name'                    => $this->name,
				'slug'                    => $this->slug,
				'css_url'                 => $this->css_url,
				'js_url'                  => $this->js_url,
				'template_file_location'  => $this->template_file_location,
				'screenshot_url'          => $this->screenshot_url,
				'cycle_options'           => $this->cycle_options
			);

			// Append our class to 
			array_push($themes, $this->theme_options);
			return $themes;
		}

	}