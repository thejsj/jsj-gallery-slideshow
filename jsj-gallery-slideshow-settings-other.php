<?php 
 // Start Setting Options

    $jsj_gallery_slideshow_options_other = Array();
    
    $jsj_gallery_slideshow_options_other_i = 0; 
    
    $jsj_gallery_slideshow_options_other[$jsj_gallery_slideshow_options_other_i] = (object) array(
      'name' => 'checkForShortCode', 
      'title' => __( 'Check For Shortcode', 'jsj-gallery-slideshow' ),
      'descp' => __( 'Only load plugin if [gallery] shortcode is being used in content. Recommened for most cases. Deactivate if using Ajax.', 'jsj-gallery-slideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'true'
      );
    $jsj_gallery_slideshow_options_other_i++;

?>