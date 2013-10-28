<?php 
 // Start Setting Options

    $options = Array();
    $i = 0; 
    
    $options[$i] = (object) array(
      'name' => 'activePagerClass', 
      'title' => 'Active Pager Class',
      'descp' => 'Class name used for the active pager element. No Spaces!',
      'type' => 'text',
      'class' => '',
      'parameters' => '',
      'default' => 'activeSlide_gallery_cycle'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'autostop', 
      'title' => 'Auto Stop',
      'descp' => 'True to end slideshow after X transitions (where X == slide count) ',
      'type' => 'number',
      'class' => 'important',
      'parameters' => '',
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'autostopCount', 
      'title' => 'Auto Stop Count',
      'descp' => 'number of transitions (optionally used with autostop to define X) ',
      'type' => 'number',
      'class' => '',
      'parameters' => '',
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'backwards', 
      'title' => 'Start Backwards',
      'descp' => 'true to start slideshow at last slide and move backwards through the stack',
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'false'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'cleartypeNoBg', 
      'title' => 'Clear Type No Background',
      'descp' => 'Set to true to disable extra cleartype fixing (leave false to force background color setting on slides) ',
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'false'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'containerResize', 
      'title' => 'Container Resize',
      'descp' => 'Resize container to fit largest slide. 0:False / 1: True',
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '1'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'delay', 
      'title' => 'Delay',
      'descp' => 'Additional delay (in ms) for first transition (hint: can be negative).',
      'type' => 'number',
      'class' => '',
      'parameters' => "",
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'fastOnEvent', 
      'title' => 'FastOn Event',
      'descp' => 'Force fast transitions when triggered manually (via pager or prev/next); value == time in ms.',
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'fit', 
      'title' => 'Fit Slides',
      'descp' => 'Force slides to fit container.',
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'fx', 
      'title' => 'Transition Effect',
      'descp' => 'Name of transition effect.',
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("blindX","blindY","blindZ","cover","curtainX","curtainY","fade","fadeZoom","growX","growY","scrollUp","scrollDown","scrollLeft","scrollRight","scrollHorz","scrollVert","shuffle","slideX","slideY","toss","turnUp","turnDown","turnLeft","turnRight","uncover","wipe","zoom"),
      'default' => 'fade'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'height', 
      'title' => 'Slide Height',
      'descp' => 'Container height (if the \'fit\' option is true, the slides will be set to this height as well).',
      'type' => 'text',
      'class' => '',
      'parameters' => "",
      'default' => 'auto'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'manualTrump', 
      'title' => 'Manual Trump',
      'descp' => 'Causes manual transition to stop an active transition instead of being ignored.',
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'true'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'metaAttr', 
      'title' => 'Data Attribute',
      'descp' => 'data- attribute that holds the option data for the slideshow.',
      'type' => 'text',
      'class' => '',
      'parameters' => "",
      'default' => 'cycle'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'nowrap', 
      'title' => 'No Wrapping',
      'descp' => 'True(1) to prevent slideshow from wrapping.',
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'pause', 
      'title' => 'Pause Slidehow',
      'descp' => 'True(1) to enable "pause on hover".',
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'pauseOnPagerHover', 
      'title' => 'Pause On Pager Hover',
      'descp' => 'True(1) to pause when hovering over pager link.',
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'random', 
      'title' => 'Random Slides',
      'descp' => 'True(1) for random, false for sequence (not applicable to shuffle fx).',
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'requeueOnImageNotLoaded', 
      'title' => 'Requeue OnImageNotLoaded',
      'descp' => 'Requeue the slideshow if any image slides are not yet loaded .',
      'type' => 'select',
      'class' => '',
      'parameters' => array("true", "false"),
      'default' => 'true'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'requeueTimeout', 
      'title' => 'Requeue Timeout',
      'descp' => 'Ms delay for requeue.',
      'type' => 'number',
      'class' => '',
      'parameters' => "",
      'default' => '250'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'rev', 
      'title' => 'Reverse Animation',
      'descp' => 'Causes animations to transition in reverse (for effects that support it such as scrollHorz/scrollVert/shuffle).',
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'slideResize', 
      'title' => 'Slide Resize',
      'descp' => 'Force slide width/height to fixed size before every transition).',
      'type' => 'select',
      'class' => 'important',
      'parameters' => array("0", "1"),
      'default' => '1'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'speed', 
      'title' => 'Speed',
      'descp' => 'speed of the transition (any valid fx speed value) .',
      'type' => 'number',
      'class' => 'important',
      'parameters' => "",
      'default' => '1000'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'startingSlide', 
      'title' => 'Starting Slide #',
      'descp' => 'Zero-based index of the first slide to be displayed.',
      'type' => 'number',
      'class' => '',
      'parameters' => "",
      'default' => '0'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'sync', 
      'title' => 'Synchronize Slides',
      'descp' => 'True if in/out transitions should occur simultaneously.',
      'type' => 'select',
      'class' => '',
      'parameters' => array("0", "1"),
      'default' => '1'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'timeout', 
      'title' => 'Transition Time',
      'descp' => 'Milliseconds between slide transitions <strong>(0 to disable auto advance)</strong>.',
      'type' => 'number',
      'class' => 'important',
      'parameters' => "",
      'default' => '4000'
      );
    $i++;

    $options[$i] = (object) array(
      'name' => 'width', 
      'title' => 'Width',
      'descp' => 'Container width (if the \'fit\' option is true, the slides will be set to this width as well) .',
      'type' => 'text',
      'class' => '',
      'parameters' => "",
      'default' => 'null'
      );
    $i++;
    

?>