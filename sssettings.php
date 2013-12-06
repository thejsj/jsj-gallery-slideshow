<?php 
 // Start Setting Options

    $jsj_gallery_slideshow_options = Array();
    $i = 0; 
    
    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'activePagerClass', 
      'title' => __( 'Active Pager Class', 'jsjGallerySlideshow' ),
      'descp' => __( 'Class name used for the active pager element. No Spaces!', 'jsjGallerySlideshow' ),
      'type' => 'text',
      'class' => '',
      'parameters' => '',
      'default' => 'activeSlide_gallery_cycle'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'autostop', 
      'title' => __( 'Auto Stop', 'jsjGallerySlideshow' ),
      'descp' => __( 'True to end slideshow after X transitions (where X == slide count) ', 'jsjGallerySlideshow' ),
      'type' => 'number',
      'class' => 'important',
      'parameters' => '',
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'autostopCount', 
      'title' => __( 'Auto Stop Count', 'jsjGallerySlideshow' ),
      'descp' => __( 'number of transitions (optionally used with autostop to define X) ', 'jsjGallerySlideshow' ),
      'type' => 'number',
      'class' => '',
      'parameters' => '',
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'backwards', 
      'title' => __( 'Start Backwards', 'jsjGallerySlideshow' ),
      'descp' => __( 'true to start slideshow at last slide and move backwards through the stack', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'false'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'cleartypeNoBg', 
      'title' => __( 'Clear Type No Background', 'jsjGallerySlideshow' ),
      'descp' => __( 'Set to true to disable extra cleartype fixing (leave false to force background color setting on slides) ', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'false'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'containerResize', 
      'title' => __( 'Container Resize', 'jsjGallerySlideshow' ),
      'descp' => __( 'Resize container to fit largest slide. 0:False / 1: True', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '1'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'delay', 
      'title' => __( 'Delay', 'jsjGallerySlideshow' ),
      'descp' => __( 'Additional delay (in ms) for first transition (hint: can be negative).', 'jsjGallerySlideshow' ),
      'type' => 'number',
      'class' => '',
      'parameters' => "",
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'fastOnEvent', 
      'title' => __( 'FastOn Event', 'jsjGallerySlideshow' ),
      'descp' => __( 'Force fast transitions when triggered manually (via pager or prev/next); value == time in ms.', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'fit', 
      'title' => __( 'Fit Slides', 'jsjGallerySlideshow' ),
      'descp' => __( 'Force slides to fit container.', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'fx', 
      'title' => __( 'Transition Effect', 'jsjGallerySlideshow' ),
      'descp' => __( 'Name of transition effect.', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("blindX","blindY","blindZ","cover","curtainX","curtainY","fade","fadeZoom","growX","growY","scrollUp","scrollDown","scrollLeft","scrollRight","scrollHorz","scrollVert","shuffle","slideX","slideY","toss","turnUp","turnDown","turnLeft","turnRight","uncover","wipe","zoom"),
      'default' => 'fade'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'height', 
      'title' => __( 'Slide Height', 'jsjGallerySlideshow' ),
      'descp' => __( 'Container height (if the "fit" option is true, the slides will be set to this height as well).', 'jsjGallerySlideshow' ),
      'type' => 'text',
      'class' => '',
      'parameters' => "",
      'default' => 'auto'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'manualTrump', 
      'title' => __( 'Manual Trump', 'jsjGallerySlideshow' ),
      'descp' => __( 'Causes manual transition to stop an active transition instead of being ignored.', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'true'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'metaAttr', 
      'title' => __( 'Data Attribute', 'jsjGallerySlideshow' ),
      'descp' => __( 'data- attribute that holds the option data for the slideshow.', 'jsjGallerySlideshow' ),
      'type' => 'text',
      'class' => '',
      'parameters' => "",
      'default' => 'cycle'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'nowrap', 
      'title' => __( 'No Wrapping', 'jsjGallerySlideshow' ),
      'descp' => __( 'True(1) to prevent slideshow from wrapping.', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'pause', 
      'title' => __( 'Pause Slidehow', 'jsjGallerySlideshow' ),
      'descp' => __( 'True(1) to enable "pause on hover".', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'pauseOnPagerHover', 
      'title' => __( 'Pause On Pager Hover', 'jsjGallerySlideshow' ),
      'descp' => __( 'True(1) to pause when hovering over pager link.', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'random', 
      'title' => __( 'Random Slides', 'jsjGallerySlideshow' ),
      'descp' => __( 'True(1) for random, false for sequence (not applicable to shuffle fx).', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'requeueOnImageNotLoaded', 
      'title' => __( 'Requeue OnImageNotLoaded', 'jsjGallerySlideshow' ),
      'descp' => __( 'Requeue the slideshow if any image slides are not yet loaded .', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'true'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'requeueTimeout', 
      'title' => __( 'Requeue Timeout', 'jsjGallerySlideshow' ),
      'descp' => __( 'Ms delay for requeue.', 'jsjGallerySlideshow' ),
      'type' => 'number',
      'class' => '',
      'parameters' => "",
      'default' => '250'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'rev', 
      'title' => __( 'Reverse Animation', 'jsjGallerySlideshow' ),
      'descp' => __( 'Causes animations to transition in reverse (for effects that support it such as scrollHorz/scrollVert/shuffle).', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'slideResize', 
      'title' => __( 'Slide Resize', 'jsjGallerySlideshow' ),
      'descp' => __( 'Force slide width/height to fixed size before every transition).', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '1'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'speed', 
      'title' => __( 'Speed', 'jsjGallerySlideshow' ),
      'descp' => __( 'speed of the transition (any valid fx speed value) .', 'jsjGallerySlideshow' ),
      'type' => 'number',
      'class' => 'important',
      'parameters' => "",
      'default' => '1000'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'startingSlide', 
      'title' => __( 'Starting Slide #', 'jsjGallerySlideshow' ),
      'descp' => __( 'Zero-based index of the first slide to be displayed.', 'jsjGallerySlideshow' ),
      'type' => 'number',
      'class' => '',
      'parameters' => "",
      'default' => '0'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'sync', 
      'title' => __( 'Synchronize Slides', 'jsjGallerySlideshow' ),
      'descp' => __( 'True if in/out transitions should occur simultaneously.', 'jsjGallerySlideshow' ),
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '1'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'timeout', 
      'title' => __( 'Transition Time', 'jsjGallerySlideshow' ),
      'descp' => __( 'Milliseconds between slide transitions <strong>(0 to disable auto advance)</strong>.', 'jsjGallerySlideshow' ),
      'type' => 'number',
      'class' => 'important',
      'parameters' => "",
      'default' => '4000'
      );
    $i++;

    $jsj_gallery_slideshow_options[$i] = (object) array(
      'name' => 'width', 
      'title' => __( 'Width', 'jsjGallerySlideshow' ),
      'descp' => __( 'Container width (if the "fit" option is true, the slides will be set to this width as well) .', 'jsjGallerySlideshow' ),
      'type' => 'text',
      'class' => '',
      'parameters' => "",
      'default' => 'null'
      );
    $i++;

?>