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

require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-settings-class.php');
require( plugin_dir_path( __FILE__ ) . '/lib/jsj-gallery-slideshow-static-enqueue.php');

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

		// Init Set All Plugin Variables
		add_action('init', array($this, 'init') );

		// Hook for adding admin menus
		add_action('admin_menu',  array($this, 'add_options_menu'));

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

		if($_GET && isset($_GET['tab'])){
			$options_tab = $_GET['tab'];
		}
		else{
			$options_tab = 'themes';
		}

		// Reset Settings
		if($_POST && isset($_POST[ $this->name_space . '-switch_default']) && $_POST[ $this->name_space . '-switch_default']) { 
			$this->settings->resetSettings();
			echo('<div class="updated settings-error"><p>' . __( 'Your settings have been reverted back to their default.', 'jsj-gallery-slideshow' ) . '</p></div>');
		}
		?>

		<div id="<?php echo $this->name_space; ?>-container" class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-container">

			<!-- Title & Description -->
			<h2 class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-header"><?php echo $this->title ?></h2>

			<div id="nav" class="tab-nav">
				<h2 class="themes-php">
					<a class="nav-tab" href="?page=<?php echo $this->name_space; ?>&amp;tab=themes"><?php _e('Themes', 'jsj-gallery-slideshow' ); ?></a>
					<a class="nav-tab" href="?page=<?php echo $this->name_space; ?>&amp;tab=simple"><?php _e('Simple', 'jsj-gallery-slideshow' ); ?></a>
					<a class="nav-tab" href="?page=<?php echo $this->name_space; ?>&amp;tab=advanced"><?php _e('Advanced', 'jsj-gallery-slideshow' ); ?></a>
				</h2>
			</div>

			<form method="post" action="options.php" class="<?php echo $this->name_space; ?>">
				<?php settings_fields( 'jsj_gallery_slideshow-settings-group' ); ?>
				<?php $this->current_theme = 2; ?>
				<div class="<?php echo $this->name_space; ?>-tab-content <?php echo (($options_tab == 'themes') ? 'active' : 'disabled' );?>">
					<!-- Gallery Options -->
					<h3><?php _e( 'Theme Options', 'jsj-gallery-slideshow' ); ?></h3>
					<?php foreach(array(1,2,3) as $theme): ?>
						<label 
							class="<?php echo $this->name_space;?>_style_image_container <?php echo $this->name_space;?>_theme_label" 
							for="<?php echo $theme; ?>"
						>
							<input 
								id="<?php echo $theme; ?>" 
								type="radio" 
								name="<?php echo $this->name_space; ?>" 
								value="<?php echo $theme; ?>" 
								<?php if ( $theme == $this->current_theme) echo 'checked="checked"'; ?>
							/>
							<img 
								src="<?php echo plugins_url( 'images/' . $theme . '.png' , __FILE__ ); ?>" 
								alt="<?php echo $theme; ?>" 
							/>
							<p><?php echo $theme; ?></p>
						</label>
					<?php endforeach; ?>
				</div>

				<div class="<?php echo $this->name_space; ?>-tab-content <?php echo (($options_tab == 'simple') ? 'active' : 'disabled' );?>">
					<!-- Gallery Options -->
					<h3><?php _e( 'Gallery Options', 'jsj-gallery-slideshow' ); ?></h3>
					<?php $this->displayOptionsForm($this->settings->cycle, 'simple'); ?>
				</div>

				<div class="<?php echo $this->name_space; ?>-tab-content <?php echo (($options_tab == 'advanced') ? 'active' : 'disabled' );?>">		

					<!-- Gallery Options -->
					<h3><?php _e( 'Advanced Gallery Options', 'jsj-gallery-slideshow' ); ?></h3>
					<?php $this->displayOptionsForm($this->settings->cycle, 'advanced'); ?>			

					<!-- Loading Options -->
					<h3><?php _e( 'Loading Options', 'jsj-gallery-slideshow' ); ?></h3>
					<?php $this->displayOptionsForm($this->settings->other, 'advanced'); ?>		

				</div>
				<div style="clear:both"></div>

				<!-- Save -->
				<!-- <p><?php _e( 'If pleased with your settings, go ahead and save them!', 'jsj-gallery-slideshow' ); ?></p> -->
				<?php submit_button(); ?>

			</form>

			<!-- Revert Options to their defults -->
			<p><?php _e( 'Reset all plugin settings to their defaults. This will delete all your current settings.', 'jsj-gallery-slideshow' ); ?></p>
			<form name="<?php echo $this->name_space; ?>-default" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                <input type="hidden" name="<?php echo $this->name_space; ?>-switch_default" value="1">  
                <input type="submit" name="Submit" value="<?php _e( 'Reset Plugin Settings', 'jsj-gallery-slideshow' ); ?>" class="button"/>
            </form>
     
            <h4><?php _e('Resources', 'jsj-gallery-slideshow' ); ?></h4>
            <ul>
            	<li><?php echo sprintf( __('%sRequest A Feature%s', 'jsj-gallery-slideshow' ), '<a href="http://thejsj.com/jsj-gallery-slideshow-feature-request/" target="_blank">' , '</a>'); ?></li>
            	<?php /* <li><?php echo sprintf( __('%sHow To Use This Plugin%s', 'jsj-gallery-slideshow' ), '<a href="#" target="_blank">' , '</a>'); ?></li>
            	<?php // TODO : Add Survey link ?> */ ?>
            	<?php /* <li><?php echo sprintf( __('%sProvide Feedback%s', 'jsj-gallery-slideshow' ), '<a href="#" target="_blank">','</a>'); ?></li> */ ?>
            	<li><?php echo sprintf( __('%sReview This Plugin%s', 'jsj-gallery-slideshow' ), '<a href="http://wordpress.org/support/view/plugin-reviews/jsj-gallery-slideshow" target="_blank">','</a>'); ?></li>
            	<li><?php echo sprintf( __('%sVisit Plugin Website%s', 'jsj-gallery-slideshow' ), '<a href="http://wordpress.org/plugins/jsj-gallery-slideshow/" target="_blank">', '</a>'); ?></li>
            	<li><?php echo sprintf( __('%sSee All JSJ Plugins%s', 'jsj-gallery-slideshow' ), '<a href="http://profiles.wordpress.org/jorgesilva-1/" target="_blank">','</a>'); ?></li>
			</ul>
            <h4><?php _e('Credit', 'jsj-gallery-slideshow' ); ?></h4>
            <ul>
            	<li><?php echo sprintf( __('Plugin by  %s', 'jsj-gallery-slideshow' ), '<a href="http://thejsj.com" target="_blank">Jorge Silva-Jetter</a>'); ?></li>
            	<li><?php echo sprintf( __('Built with %sJquery Cycle%s', 'jsj-gallery-slideshow' ), '<a href="http://jquery.malsup.com/cycle/" target="_blank">' , '</a>'); ?></li>
            	<li><?php echo sprintf( __('Inspired by %sCargo%s', 'jsj-gallery-slideshow' ), '<a href="http://cargocollective.com/slideshow" target="_blank">', '</a>'); ?></li>
			</ul>
			
	</div>
	<?php }

	/**
	 * Turns an array of options into HTML
	 *
	 * @return void
	 */
	private function displayOptionsForm($options_group, $tab = 'simple'){ ?>
		<table class="<?php echo $this->name_space; ?>">
		<?php $i = 0; // used for odd/even value?>
		<?php foreach($options_group as $key => $option): ?>
			<?php if($option->tab == $tab): ?>
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
				<?php $i++; ?>
			<?php endif; ?>
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