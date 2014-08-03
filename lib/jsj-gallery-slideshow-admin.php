<?php 
	
	class JSJGallerySlideshowAdmin {

		public function __construct($name_space, &$settings, &$title, &$all_themes) {
			$this->name_space = $name_space;
			$this->settings   = $settings;
			$this->title      = $title;
			$this->all_themes = $all_themes;

			// Hook for adding admin menus
			add_action('admin_menu',  array($this, 'add_options_menu'));
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
		 * Update our themes variable
		 *
		 * I'm only adding this because passing by reference wasn't working for me
		 */
		public function updateThemes($themes) {
			$this->all_themes = $themes;
		}

		/**
		 * This is where you add all the html and php for your option page
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

				<!-- Display All Tabs -->
				<div id="nav" class="tab-nav">
					<h2 class="themes-php">
						<a class="nav-tab" href="?page=<?php echo $this->name_space; ?>&amp;tab=themes"><?php _e('Themes', 'jsj-gallery-slideshow' ); ?></a>
						<a class="nav-tab" href="?page=<?php echo $this->name_space; ?>&amp;tab=simple"><?php _e('Simple', 'jsj-gallery-slideshow' ); ?></a>
						<a class="nav-tab" href="?page=<?php echo $this->name_space; ?>&amp;tab=advanced"><?php _e('Advanced', 'jsj-gallery-slideshow' ); ?></a>
					</h2>
				</div>

				<!-- Display Form -->
				<form method="post" action="options.php" class="<?php echo $this->name_space; ?>">
					<?php settings_fields( 'jsj_gallery_slideshow-settings-group' ); ?>
					<div class="<?php echo $this->name_space; ?>-tab-content <?php echo (($options_tab == 'themes') ? 'active' : 'disabled' );?>">
						<!-- Gallery Options -->
						<h3><?php _e( 'Theme Options', 'jsj-gallery-slideshow' ); ?></h3>
						<?php foreach($this->all_themes as $theme): ?>
							<label 
								class="<?php echo $this->name_space;?>_themes <?php echo $this->name_space;?>_theme_label" 
								for="<?php echo $theme['slug']; ?>"
							>
								<input 
									id="<?php echo $theme['slug']; ?>" 
									type="radio" 
									name="<?php echo $this->settings->themes['current_theme']->name_space; ?>" 
									value="<?php echo $theme['slug']; ?>" 
									<?php if ( $theme['active']) echo 'checked="checked"'; ?>
								/>
								<img 
									src="<?php echo $theme['screenshot_url']; ?>" 
									alt="<?php echo $theme['name']; ?>" 
								/>
								<p><?php echo $theme['name']; ?></p>
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
	}