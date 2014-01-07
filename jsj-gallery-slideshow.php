<?php

/*
Plugin Name: JSJ Gallery Slideshow
Plugin URI: http://wordpress.org/plugins/jsj-gallery-slideshow/
Description: A Plugin to change your slidehow. 
Version: 1.1.4
Author: Jorge Silva Jetter
Author URI: http://thejsj.com
License: GPL2
*/

$jsj_gallery_slideshow_object = new JSJGallerySlideshow();

class JSJGallerySlideshow {

	private $defined = true; 
	private $title = 'JSJ Gallery Slideshow';
	private $name_space = 'jsj-gallery-slideshow';
	private $titleLowerCase = '';
	private $instructions = '';
	
	/**
	 * Init Plugin and get all settings
	 * 
	 * @return void
	 */
	public function init(){
		global $jsj_gallery_slideshow_options_cycle; 
		global $jsj_gallery_slideshow_options_other; 

		/* * * Bind Plugin to Wordpress Hooks * * */

		// Init Set All Plugin Variables
		add_action('init', array($this, 'init') );

		// Call register settings function
		add_action( 'admin_init', array($this, 'admin_init') );

		// Hook on init
		// add_action('plugins_loaded', array($jsj_gallery_slideshow_object, 'add_translations'));

		// Add JS scripts
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_client_scripts') );

		// Admin: Enqueue CSS
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );

		// Hook for adding admin menus
		add_action('admin_menu',  array($this, 'add_options_menu'));

		remove_shortcode('gallery');
		add_shortcode('gallery', array($this, 'gallery_shortcode') );

		/* * * Get All Settings * * */

		load_plugin_textdomain('jsj-gallery-slideshow', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');

		require( plugin_dir_path( __FILE__ ) . '/jsj-gallery-slideshow-settings-cycle.php');
		require( plugin_dir_path( __FILE__ ) . '/jsj-gallery-slideshow-settings-other.php');

		$this->settings = (object) array(); 
		$this->settings->cycle = $jsj_gallery_slideshow_options_cycle;
		$this->settings->other = $jsj_gallery_slideshow_options_other;		

		// Create Namespace
		foreach($this->settings->cycle as $key => $setting){
			$this->settings->cycle[$key]->name_space = $this->name_space . "-" . $setting->name;
		}
		foreach($this->settings->other as $key => $setting){
			$this->settings->other[$key]->name_space = $this->name_space . "-" . $setting->name;		
		}

		// Get Settings
		foreach($this->settings->cycle as $key => $setting){
			$this->settings->cycle[$key]->value = get_option( $setting->name_space, $setting->default );
		}
		foreach($this->settings->other as $key => $setting){
			$this->settings->other[$key]->value = get_option( $setting->name_space, $setting->default );
		}

		/* * * Get Translation Strings * * */

		$this->title = __( 'JSJ Gallery Slideshow', 'jsj-gallery-slideshow' );
		$this->instructions  = '';

		$this->instructions .= __('These are some of the settings you can change for your gallery.', 'jsj-gallery-slideshow' );
		$this->instructions .= sprintf( __(' This plugin is based in %sJquery Cycle%s', 'jsj-gallery-slideshow' ), '<a href="http://jquery.malsup.com/cycle/">' , '</a>');
		$this->instructions .= sprintf( __(' and the options are taken from Jquery Cycle\'s %soptions page%s.', 'jsj-gallery-slideshow' ), '<a href="http://jquery.malsup.com/cycle/options.html">', '</a>');
		$this->instructions .= sprintf( __(' The visual feel of the gallery is based on %sCargo\'s slideshow settingss%s.', 'jsj-gallery-slideshow' ), '<a href="http://cargocollective.com/slideshow">', '</a>');
		$this->instructions .= sprintf( __(' You can see an example of this plugin in action in my website: %s.', 'jsj-gallery-slideshow' ), '<a href="http://thejsj.com">thejsj.com</a>'); 
		$this->instructions .= '<br/><br/>';
		$this->instructions .= sprintf( __('%sSettings with a Green Background%s denote settings that are probably more important.', 'jsj-gallery-slideshow' ), '<span style="background-color: #ccffcc;">', '</span>');
	}

	/**
	 * Register all plugin settings
	 *
	 * @return void
	 */
	public function admin_init(){
		// Register our settings
		foreach($this->settings->cycle as $key => $setting){
			register_setting( 'jsj_gallery-settings-group', $setting->name_space );
		}
		foreach($this->settings->other as $key => $setting){
			register_setting( 'jsj_gallery-settings-group', $setting->name_space );
		}
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

			if(!wp_script_is('jquery')){
				wp_enqueue_script( 'jquery' );
			}
			wp_enqueue_script(
				'jsjGallerySlideshowScripts-jQueryCycle',
				plugins_url( 'js/jsj-gallery-slideshow-ck.js' , __FILE__ ),
				array( 'jquery' ), // Deps
				"", // Version
				true // Footer
			);
			wp_localize_script( 
				'jsjGallerySlideshowScripts-jQueryCycle', 
				'jsjGallerySlideshowOptions', 
				array(
					'settings' => $this->settings,
					'scripts_enqueued' => $this->scripts_enqueued
				) 
			);

			// Add CSS
			wp_enqueue_style(
				"jsj-gallery-slideshow-style", 
				plugins_url( 'css/jsj-gallery-slideshow-style.css' , __FILE__ )
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
			plugins_url( 'css/jsj-gallery-slideshow-admin-style.css' , __FILE__ )
		);
	}

	/**
	 * This will create a menu item under the option menu
	 * @see http://codex.wordpress.org/Function_Reference/add_options_page
	 *
	 * @return void
	 */
	public function add_options_menu(){
		add_options_page(__( 'JSJ Gallery Slideshow Options', 'jsj-gallery-slideshow' ), 'JSJ Gallery Slideshow', 'manage_options', 'jsj-gallery-slideshow', array($this, 'options_page'));
	}

	/**
	 * This is where you add all the html and php for your option page
	 * @see http://codex.wordpress.org/Function_Reference/add_options_page
	 *
	 * @return void
	 */
	public function options_page(){


		if($_POST && isset($_POST[ $this->name_space . '-switch_default']) && $_POST[ $this->name_space . '-switch_default']) { 
			foreach($this->settings->cycle as $setting){
				update_option($setting->name_space , $setting->default);
			}
			foreach($this->settings->other as $setting){
				update_option($setting->name_space , $setting->default);
			}
			echo('<div class="updated settings-error"><p>' . __( 'Your settings have been reverted back to their default.', 'jsj-gallery-slideshow' ) . '</p></div>');
		}
		?>
		<div id="<?php echo $this->name_space; ?>-container" class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-container">

			<!-- Title & Description -->
			<h2 class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-header"><?php echo $this->title ?></h2>
			<p class="<?php echo $this->name_space; ?>"><?php echo $this->instructions ?></p>

			<form method="post" action="options.php" class="<?php echo $this->name_space; ?>">
				<?php settings_fields( 'jsj_gallery-settings-group' ); ?>

				<!-- Gallery Options -->
				<h3><?php _e( 'Gallery Options', 'jsj-gallery-slideshow' ); ?></h3>
				<?php $this->displayOptionsForm($this->settings->cycle); ?>

				<!-- Loading Options -->
				<h3><?php _e( 'Loading Options', 'jsj-gallery-slideshow' ); ?></h3>
				<?php $this->displayOptionsForm($this->settings->other); ?>				
				<div style="clear:both"></div>

				<!-- Save -->
				<p><?php _e( 'If pleased with your settings, go ahead and save them!', 'jsj-gallery-slideshow' ); ?></p>
				<?php submit_button(); ?>

			</form>

			<!-- Revert Options to their defults -->
			<p><?php _e( 'Clear all your settings and switch to the original plugin settings.', 'jsj-gallery-slideshow' ); ?></p>
			<form name="<?php echo $this->name_space; ?>-default" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                <input type="hidden" name="<?php echo $this->name_space; ?>-switch_default" value="1">  
                <input type="submit" name="Submit" value="<?php _e( 'Revert back to default options', 'jsj-gallery-slideshow' ); ?>" class="button"/>
            </form>
     
	</div>
	<? }

	/**
	 * Turns an array of options into HTML
	 *
	 * @return void
	 */
	private function displayOptionsForm($options_group){ ?>
		<table class="<?php echo $this->name_space; ?>">
		<?php $i = 0; ?>
		<?php foreach($options_group as $key => $option): ?>
			<tr class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-main <?php echo ( isset($option->class) ? $option->class : '' ); ?> <?php echo $i; ?> <?php echo ( $i % 2  == 0 ? 'odd' : 'even' ); ?>">
				<td class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-name"><strong><?php echo $option->title ?></strong></td>
				<td class="<?php echo $this->name_space; ?>-field">
					<label for="<?php echo $option->name_space; ?>">
						<?php if($option->type == 'boolean'): // Boolean ?>
							<input type='checkbox' id="<?php echo $option->name_space; ?>" name="<?php echo $option->name_space; ?>" value='1' <?php if ( 1 == $option->value ) echo 'checked="checked"'; ?> />
						<?php elseif( $option->type != "select" ): ?>
							<input id="<?php echo $option->name_space; ?>" class="<?php echo $this->name_space; ?>" type="<?php echo $option->type ?>" name="<?php echo $option->name_space ?>" value="<?php echo $option->value ?>" />
						<?php else: ?>
							<select id="<?php echo $option->name_space; ?>" name="<?php echo $option->name_space ?>">
								<option class="<?php echo $this->name_space; ?>" value="<?php echo $option->value; ?>"><?php echo $option->value; ?></option>';
								<?php for($iii = 0; $iii < count($option->parameters); $iii++): ?>
									<?php if($option->parameters[$iii] != $option->value): ?>
										<option class="<?php echo $this->name_space; ?>" value="<?php echo $option->parameters[$iii]; ?>"><?php echo $option->parameters[$iii]; ?></option>
									<?php endif; ?>
								<?php endfor; ?>
							</select>
						<?php endif; ?>
						<span class='description <?php echo $this->name_space; ?>-description'><?php echo $option->descp ?></span>
					</label>
				</td>
			</tr>
			<!-- <tr>
				<td colspan="2">
					
				</td>
			</tr> -->
			<?php $i++; ?>
		<?php endforeach; ?>
		</table><?php
	}

	/**
	 * Get a specific admin color user user preferences and the WP array of colors
	 *
	 * @return string
	 */
	private function get_admin_color($key = 3){
		if(!isset($this->colors)){
			global $_wp_admin_css_colors;
			$current_color = get_user_option( 'admin_color' );
			if($current_color && $_wp_admin_css_colors[$current_color]){
				$this->colors = $_wp_admin_css_colors[$current_color];
			}
		}
		if(isset($this->colors) && isset($this->colors->colors[$key])){
			return $this->colors->colors[$key];
		}
		return '#000'; 
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
			'size'       => 'full',
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
		$output .= "<div id='gallery-container-{$instance} gallery_container_<?php echo  $this->name_space; ?>-{$instance}' class='gallery-container gallery_container_<?php echo  $this->name_space; ?>'>";
	  		// Start Navigation
			$output .= "<div class='gallery-navigation'>";
				$output .= "<a id='galleryPrev-{$instance}' class='gallery-prev gallery-button' href='#'>" . __( 'Previous', 'jsj-gallery-slideshow' ) . "</a>";
				$output .= " / <a id='galleryNext-{$instance}' class='gallery-next gallery-button' href='#'>" . __( 'Next Image', 'jsj-gallery-slideshow' ) . "</a>";
				$output .= " <span id='galleryNumbering-{$instance}' class='gallery-numbering'></span>";
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