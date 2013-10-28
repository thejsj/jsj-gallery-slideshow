<?php

/*
Plugin Name: JSJ Gallery Slideshow
Plugin URI: http://thejsj.com
Description: A Plugin to change your slidehow. 
Version: 1.0
Author: Jorge Silva Jetter
Author URI: http://thejsj.com
License: GPL2
*/

$object = new JSJGallery();

// Hook for adding admin menus
add_action('admin_menu',  array($object, 'jsj_gallery_addMenu'));

//call register settings function
add_action( 'admin_init', array($object, 'jsj_gallery_register_mysettings') );

remove_shortcode('gallery');
add_shortcode('gallery', array($object, 'jsj_gallery_gallery_shortcode') );

// Add JS scripts
add_action( 'wp_enqueue_scripts', array($object, 'jsj_gallery_queryScripts') );

// Add JS code to the Footer   
add_action('wp_footer', array($object, 'jsj_slide_add_init_function'), 30); //Enqueued scripts are executed at priority level 20.

require( plugin_dir_path( __FILE__ ) . '/sssettings.php');
global $options; 

class JSJGallery{

	private $defined = true; 
	private $title = 'JSJ Gallery Slideshow';
	private $titleLowerCase = '';
	private $instructions = 'These are some of the settings you can change for your gallery. This plugin is based in <a href="http://jquery.malsup.com/cycle/">Jquery Cycle</a> and the options are taken from Jquery Cycle\'s <a href="http://jquery.malsup.com/cycle/options.html">options page</a>. The visual feel of the gallery is based on <a href="http://cargocollective.com/slideshow">Cargo\'s slideshow settings</a>. You can see an example of this plugin in action in my website: <a href="http://thejsj.com">thejsj.com</a>.<br/><br/><span style="background-color: #ccffcc;">Settings with a Green Background</span> denote settings that are probably more imoprtant.';
	private $settings = Array();

	/**
	* This will create a menu item under the option menu
	* @see http://codex.wordpress.org/Function_Reference/add_options_page
	*/
	public function jsj_gallery_addMenu(){
		add_options_page('JSJ Gallery Slideshow Options', 'JSJ Gallery Slideshow', 'manage_options', 'jsj_gallery', array($this, 'jsj_gallery_optionPage'));
	}

  // Register Settings
  function jsj_gallery_register_mysettings() {
  	global $options; 
	//register our settings
  	for($ii = 0; $ii < count($options); $ii++){
  		register_setting( 'jsj_gallery-settings-group', $options[$ii]->name );
  	}
  }

	/**
	 * This is where you add all the html and php for your option page
	 * @see http://codex.wordpress.org/Function_Reference/add_options_page
	 */
	public function jsj_gallery_optionPage(){
		global $options; 
		if(isset($_POST['switch_default']) && $_POST['switch_default']) { 
			for($ii = 0; $ii < count($options); $ii++){
				update_option($options[$ii]->name , $options[$ii]->default);
			}
			echo('<div class="updated settings-error"><p>Your settings have been deverted back to their default.</p></div>');
		}
		?>  
		<div id="<?php $this->titleLowerCase ?>" class="wrap jsj_gallery">
			<style>
			div.wrap.jsj_gallery {
				max-width: 1100px;
			}

			p.jsj_gallery {
				max-width: 600px;
			}

			ul.jsj_gallery {
				display: block; 
			}

			ul.jsj_gallery li.jsj_gallery {
				display: inline-block;
				width: 200px;
				height: 200px;
				border: solid 1px #ccc;
				padding: 10px;
				margin: 0px;
				float: left;
			}

			ul.jsj_gallery li.jsj_gallery.important {
				background-color: #ccffcc;
			}
			</style> 
			<h2 class="jsj_gallery"><?php echo $this->title ?></h2>

			<p class="jsj_gallery"><?php echo $this->instructions ?></p>
			<form method="post" action="options.php" class="jsj_gallery">
				<?php settings_fields( 'jsj_gallery-settings-group' ); ?>
				<?php //do_settings( 'jsj_gallery-settings-group' ); ?>
				<ul class="jsj_gallery">
					<?php for($ii = 0; $ii < count($options); $ii++){ ?>
					<li class="jsj_gallery <?php echo $options[$ii]->class ?>">
						<h4 class="jsj_gallery"><?php echo $options[$ii]->title ?></h4>
						<p class="jsj_gallery"><?php echo $options[$ii]->descp ?></p>
						<?php 

						// Check to see if we have a previous entry
						if(get_option($options[$ii]->name) === FALSE){ 
							$input_value = $options[$ii]->default;
						} else { 
							$input_value = get_option($options[$ii]->name); 
						}

						if( $options[$ii]->type != "select" ) { ?>
							<input class="jsj_gallery" type="<?php echo $options[$ii]->type ?>" name="<?php echo $options[$ii]->name ?>" value="<?php echo $input_value ?>" />
							<?php }
							else { ?>
							<select name="<?php echo $options[$ii]->name ?>"> <?php
							echo '<option class="jsj_gallery" value="' . $input_value . '">' . $input_value .'</option>';
							for($iii = 0; $iii < count($options[$ii]->parameters); $iii++){
								if($options[$ii]->parameters[$iii] != $input_value){
									echo '<option class="jsj_gallery" value="' . $options[$ii]->parameters[$iii] . '">' . $options[$ii]->parameters[$iii] .'</option>';
								}
							}
							?>
							</select>
							<?php 
						} ?>
					</li>
					<?php } ?>
				</ul>
				<div style="clear:both"></div>
				<p>If pleased with your settings, go ahead and save them!</p>
				<?php submit_button(); ?>
			</form>
			<h3>Swith To Default Settings</h3>
			<p>Clear all your settings and swith to the original plugin settings.</p>
			<form name="jsj_gallery_default" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                <input type="hidden" name="switch_default" value="1">  
                <input type="submit" name="Submit" value="Revert Default Settings" />
            </form>
	</div>
	<?php } 
	

	// Add Script to the Footer and Header
	public function jsj_gallery_queryScripts(){
		// Check if Jquery is here!!!
		if(!wp_script_is('jquery')){
			wp_enqueue_script( 'jquery');
		}
		wp_enqueue_script(
			'jqueryBrowser',
			plugins_url( 'js/jquery.browser.min.js' , __FILE__ ),
			array( 'jquery' ), // Deps
			"", // Version
			true //
		);
		wp_enqueue_script(
			'jqueryEasing',
			plugins_url( 'js/jquery.easing.min.js' , __FILE__ ),
			array( 'jquery', 'jqueryBrowser' ), // Deps
			"", // Version
			true //
		);
		wp_enqueue_script(
			'jqueryCycle',
			plugins_url( 'js/jquery.cycle.js' , __FILE__ ),
			array( 'jquery', 'jqueryEasing', 'jqueryBrowser'), // Deps
			"", // Version
			true //
		);
		wp_enqueue_script(
			'JSJMiniFunctions',
			plugins_url( 'js/jsjSlideShowMiniFuncitons.js' , __FILE__ ),
			array( 'jquery', 'jqueryCycle', 'jqueryBrowser'), // Deps
			"", // Version
			true //
		);
		wp_enqueue_style(
			"jsj_gallery_css", 
			plugins_url( 'css/jsj_gallery_css.css' , __FILE__ )
			);
	}
	
	// Change Slidehow Function
	public function jsj_gallery_gallery_shortcode($attr){

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
		}

		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
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
		$gallery_div = "<div id='galleryid-{$instance}' data-total='{$totalCount}'class='gallery jsj-gallery-slideshow galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	  	// Start Gallery HTML Code
		$output  = "";
	  	// Start Container 
		$output .= "<div id='gallery-container-{$instance} gallery_container_jsjss-{$instance}' class='gallery-container gallery_container_jsjss'>";
	  	// Start Navigation
		$output .= "<div class='gallery-navigation'>";
		$output .= "<a id='galleryPrev-{$instance}' class='gallery-prev gallery-button' href='#'>Previous</a>";
		$output .= " / <a id='galleryNext-{$instance}' class='gallery-next gallery-button' href='#'>Next image</a>";
		$output .= " <span id='galleryNumbering-{$instance}' class='gallery-numbering'></span>";
		$output .= "</div>";
	  	// Start Gallery
		$output .= apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$i++;
			  // This comes from line 770 of wp-includes/media.php
			$attributes = array(
				'data-galleryid'   => $instance,
				'data-link'   => wp_get_attachment_image_src( $id, "full" ),
				);
			$output .= wp_get_attachment_image( $id, 'pageWidth', false, $attributes);
		}
		$output .= "</div>\n";
	  	// Start Gallery Pager
		$output .= "<div id='gallery-pager-{$instance}' class='gallery-pager'></div>";
	  	// Clear
		$output .= "<div style='clear:both;'></div>";
		// End Container
		$output .= "</div>\n";
		return $output;
	}
	
	// Add Code to initiate Galleryjsj-slide-showf
	public function jsj_slide_add_init_function(){
		global $options; 
		?> 
		<script type="text/javascript">
		console.log("Start Ready");
		var isNext; 
		var zeroBasedSlideIndex; 
		var slideElement;
		var galleryid;
		var slideTransitionTime = 200;
		var cycleGallery = [];
		jQuery(document).ready(function(){
			console.log("REady!");
			jQuery('.jsj-gallery-slideshow').each(function(index){
				console.log(index);
				console.log(this);
				var galleryId = jQuery(this).attr("id");
				galleryId = galleryId.replace("galleryid-",""); 
				updatePaginationString(galleryId);
				cycleGallery[index] = jQuery("#galleryid-" + galleryId).cycle({ 
					id:               galleryId,
					next:             '#galleryNext-' + galleryId, 
					prev:             '#galleryPrev-' + galleryId,
					pager:            jQuery("#gallery-pager-" + galleryId), 
					onPrevNextEvent:  UpdateNumbers, // callback fn for prev/next events: function(isNext, zeroBasedSlideIndex, slideElement),
					<?php for($i4 = 0; $i4 < count($options); $i4++){
						$option_value = get_option($options[$i4]->name , $options[$i4]->default);
						if($option_value != $options[$i4]->default){
							if(is_numeric($option_value)){
								echo ($options[$i4]->name . ": " . $option_value . ", //" . $options[$i4]->descp . "\n");
							}
							else {
								echo ($options[$i4]->name . ": '" . $option_value . "', //" . $options[$i4]->descp . "\n");
							}
						}
					}
					?>
					before: function(){ 
						var sh = jQuery(this).height();
						<?php 
						if(get_option($options[21]->name) === FALSE || !is_numeric(get_option($options[21]->name))){ 
							$input_value = $options[21]->default;//This number is the default for 
						} else {
							$input_value = get_option($options[21]->name);
						}
						?>
						if(sh > 0) jQuery(this).parent().clearQueue().animate({ height: sh }, <?php echo $input_value; ?> );
					},
					pagerAnchorBuilder: function(idx, slide) { // callback fn that creates a thumbnail to use as pager anchor 
						return '<li class="slideshow_thumb" style="background-image: url(' + slide.src + ');"></li>'; //<a href="#"><img src="" /></a>
					}
				});
				setInitialHeight(cycleGallery[index]);
			});
		});
		</script>
	<?php }
} ?>