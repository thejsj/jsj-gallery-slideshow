<?php 

$all_transition_effects = array("fade","fadeout","scrollHorz","none");

// Start Setting Options
$jsj_gallery_slideshow_options_cycle = array(


	'allow-wrap' => array(
		'name' => 'allow-wrap', 
		'title' => __( 'Allow Wrap', 'jsj-gallery-slideshow' ),
		'descp' => __( 'This option determines whether or not a slideshow can advance from the last slide to the first (or vice versa)', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'tab' => 'advanced',
		'convert_to_boolean' => true,
		'default' => true,
		'data_type' => 'boolean',
	),
	'auto-height' => array(
		'name' => 'auto-height', 
		'title' => __( 'Auto Height', 'jsj-gallery-slideshow' ),
		'descp' => __( 'This option determines whether or not Cycle2 will provide height management for the slideshow which can be very useful in fluid or responsive designs', 'jsj-gallery-slideshow' ),
		'type' => 'text',
		'tab' => 'advanced',
		'default' => 0,
		'data_type' => 'integer',
	),
	/**
	 * NOT INCLUDED: autoSelector ++DETERMINED IN PHP CLASS
	 *
	 * A jQuery selector which identifies elements that should be initialized automatically by Cycle2. 
	 * The default value is .cycle-slideshow. 
	 * Add the cycle-slideshow class to your slideshow container and Cycle2 will automatically find and initialize it when the DOM ready event fires.
	 *
	 */
	/**
	 * NOT INCLUDED: caption ++DETERMINED IN PHP CLASS
	 *
	 * A selector which identifies the element that should be used for the slideshow caption. 
	 * By default, Cycle2 looks for an element with the class .cycle-caption that exists within the slideshow container.
	 *
	 */
	/**
	 * NOT INCLUDED: caption-template ++DETERMINED IN PHP CLASS
	 *
	 * A template string which defines how the slideshow caption should be formatted. 
	 * The template can reference real-time state information from the slideshow, such as the current slide index, etc.
	 *
	 */
	/**
	 * NOT INCLUDED: continueAuto
	 *
	 * Option which can be set dynamically to instruct C2 to stop transitioning on a timeout. 
	 * This is useful when you want to start with an automatic slideshow but later switch to a manual slideshow. This option can also be a function which returns a boolean value.
	 *
	 */
	'delay' => array(
		'name' => 'delay', 
		'title' => __( 'Delay', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The number of milliseconds to add onto, or substract from, the time before the first slide transition occurs', 'jsj-gallery-slideshow' ),
		'type' => 'number',
		'tab' => 'advanced',
		'default' => 0,
		'data_type' => 'integer',
	),
	/**
	 * NOT INCLUDED: disabled-class ++DETERMINED IN PHP CLASS
	 *
	 * The classname to assign to prev/next links when they cannot be activated (due to data-cycle-allow-wrap="false".
	 *
	 */
	'easing' => array(
		'name' => 'easing', 
		'title' => __( 'Easing', 'jsj-gallery-slideshow' ),
		'descp' => __( 'Name of the easing function to use for animations', 'jsj-gallery-slideshow' ),
		'type' => 'select',
		'tab' => 'simple',
		'parameters' => array('jswing', 'def', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack', 'easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce'),
		'default' => 'easeInQuad',
		'data_type' => 'string',
	),
	'fx' => array(
		'name' => 'fx', 
		'title' => __( 'Transition Effect', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The name of the slideshow transition to use', 'jsj-gallery-slideshow' ),
		'type' => 'select',
		'tab' => 'simple',
		'parameters' => $all_transition_effects,
		'default' => 'scrollHorz',
		'cycle_default' => 'fade',
		'data_type' => 'string',
	),
	'hide-non-active' => array(
		'name' => 'hide-non-active', 
		'title' => __( 'Hide Non-Active', 'jsj-gallery-slideshow' ),
		'descp' => __( 'Determines whether or not Cycle2 hides the inactive slides', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'tab' => 'advanced',
		'convert_to_boolean' => true,
		'default' => true,
		'data_type' => 'boolean',
	),
	/**
	 * NOT INCLUDED: loader
	 *
	 * The loader option sets the image loader behavior for the slideshow.
	 * false disabled loader functionality
	 * true load slides as images arrive
	 * "wait" wait for all images to arrive before staring slideshow
	 *
	 */
	'log' => array(
		'name' => 'log', 
		'title' => __( 'Log', 'jsj-gallery-slideshow' ),
		'descp' => __( 'Enable console logging', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'tab' => 'advanced',
		'convert_to_boolean' => true,
		'default' => false,
		'cycle_default' => true,
		'data_type' => 'boolean',
	),
	'loop' => array(
		'name' => 'loop', 
		'title' => __( 'Loop', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The number of times an auto-advancing slideshow should loop before terminating', 'jsj-gallery-slideshow' ),
		'type' => 'text',
		'tab' => 'advanced',
		'default' => 0,
		'data_type' => 'integer',
	),
	'manual-fx' => array(
		'name' => 'manual-fx', 
		'title' => __( 'Manual Transition Effect', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The transition effect to use for manually triggered transitions (not timer-based transitions)', 'jsj-gallery-slideshow' ),
		'type' => 'select',
		'tab' => 'advanced',
		'parameters' => array_merge(array(''), $all_transition_effects),
		'default' => '',
		'data_type' => 'string',
	),
	'manual-speed' => array(
		'name' => 'manual-speed', 
		'title' => __( 'Manual Speed', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The speed (in milliseconds) for transitions that are manually initiated, such as those caused by clicking a "next" button or a pager link', 'jsj-gallery-slideshow' ),
		'type' => 'text',
		'tab' => 'advanced',
		'default' => '',
		'data_type' => 'integer',
	),
	'manualTrump' => array(
		'name' => 'manualTrump', 
		'title' => __( 'Manual Trump', 'jsj-gallery-slideshow' ),
		'descp' => __( 'Determines whether or not transitions are interrupted to begin new ones if the new ones are the result of a user action (not timer)', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'convert_to_boolean' => true,
		'tab' => 'advanced',
		'default' => true,
		'data_type' => 'boolean',
	),
	/**
	 * NOT INCLUDED: next ++DETERMINED IN PHP CLASS
	 *
	 * A selector string which identifies the element (or elements) to use as a trigger to advance the slideshow forward. 
	 * By default, Cycle2 looks for an element with the class .cycle-next that exists within the slideshow container.
	 *
	 */
	/**
	 * NOT INCLUDED: next-event
	 *
	 * The event to bind to elements identified with the next option. By default, Cycle2 binds click events.
	 *
	 */
	/**
	 * NOT INCLUDED: overlay
	 *
	 * A selector string which identifies the element to use as the overlay element. 
	 * A slideshow overlay typically provides information about the current slide. 
	 * By default, Cycle2 looks for an element with the class .cycle-overlay that exists within the slideshow container.
	 *
	 */
	/**
	 * NOT INCLUDED: overlay-template
	 *
	 * A template string which defines how the overlay should be formatted. 
	 * The template can reference real-time state information from the slideshow, such as the current slide index, etc.
	 * Cycle2 uses simple Mustache-style templates by default.
	 *
	 */
	/**
	 * NOT INCLUDED: pager ++DETERMINED IN PHP CLASS
	 *
	 * A selector string which identifies the element to use as the container for pager links. 
	 * By default, Cycle2 looks for an element with the class .cycle-pager that exists within the slideshow container.
	 *
	 */
	/**
	 * NOT INCLUDED: pager-active-class ++DETERMINED IN PHP CLASS
	 *
	 * The classname to assign to pager links when a particular link references the currently visible slide.
	 *
	 */
	/**
	 * NOT INCLUDED: pager-event
	 *
	 * The type of event that is bound on the pager links. By default, Cycle2 binds click events.
	 *
	 */
	/**
	 * NOT INCLUDED: pager-event-bubble
	 *
	 * Set to true to allow pager events to bubble up the DOM. This is useful if you have an anchor inside your pager element and want the anchor to be followed when it is clicked.
	 *
	 */
	'pause-on-hover' => array(
		'name' => 'pause-on-hover', 
		'title' => __( 'Pause on Hover', 'jsj-gallery-slideshow' ),
		'descp' => __( 'Determines whether or not transitions are interrupted to begin new ones if the new ones are the result of a user action (not timer)', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'convert_to_boolean' => true,
		'tab' => 'simple',
		'default' => false,
		'data_type' => 'boolean',
	),
	'paused' => array(
		'name' => 'paused', 
		'title' => __( 'Paused on Start', 'jsj-gallery-slideshow' ),
		'descp' => __( 'If true the slideshow will begin in a paused state.', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'convert_to_boolean' => true,
		'tab' => 'simple',
		'default' => false,
		'data_type' => 'boolean',
	),
	/**
	 * NOT INCLUDED: prev ++DETERMINED IN PHP CLASS
	 *
	 * A selector string which identifies the element (or elements) to use as a trigger to advance the slideshow backward. 
	 * By default, Cycle2 looks for an element with the class .cycle-prev that exists within the slideshow container.
	 *
	 */
	/**
	 * NOT INCLUDED: prev-event
	 *
	 * The type of event that is bound on the prev and next links. 
	 * By default, Cycle2 binds click events.
	 *
	 */
	/**
	 * NOT INCLUDED: progressive
	 *
	 * Identifies an element in the DOM which holds a JSON array representing the slides to be progressively loaded into the slideshow. Example.
	 *
	 */
	'random' => array(
		'name' => 'random', 
		'title' => __( 'Random', 'jsj-gallery-slideshow' ),
		'descp' => __( 'If true the order of the slides will be randomized', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'convert_to_boolean' => true,
		'tab' => 'simple',
		'default' => false,
		'data_type' => 'boolean',
	),
	'reverse' => array(
		'name' => 'reverse', 
		'title' => __( 'Reverse', 'jsj-gallery-slideshow' ),
		'descp' => __( 'If true the slideshow will proceed in reverse order and transitions that support this option will run a reverse animation', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'convert_to_boolean' => true,
		'tab' => 'simple',
		'default' => false,
		'data_type' => 'boolean',
	),
	/**
	 * NOT INCLUDED: slide-active-class ++DETERMINED IN PHP CLASS
	 *
	 * The classname to assign to the active slide.
	 *
	 */
	/**
	 * NOT INCLUDED: slide-css
	 *
	 * An object which defines css properties that should be applied to each slide as it is initialized (once).
	 *
	 */
	/**
	 * NOT INCLUDED: slide-class ++DETERMINED IN PHP CLASS
	 *
	 * Name of the class to add to each slide.
	 *
	 */
	/**
	 * NOT INCLUDED: slides
	 *
	 * A selector string which identifies the elements within the slideshow container that should become slides.
	 * By default, Cycle2 finds all image elements that are immediate children of the slideshow container.
	 *
	 */
	'speed' => array(
		'name' => 'speed', 
		'title' => __( 'Speed', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The speed of the transition effect in milliseconds', 'jsj-gallery-slideshow' ),
		'type' => 'text',
		'tab' => 'simple',
		'default' => 350,
		'cycle_default' => 500,
		'data_type' => 'integer',
	),
	/**
	 * NOT INCLUDED: starting-slide
	 *
	 * The zero-based index of the slide that should be initially displayed
	 *
	 */
	'swipe' => array(
		'name' => 'swipe', 
		'title' => __( 'Swipe', 'jsj-gallery-slideshow' ),
		'descp' => __( 'Enable gesture support for advancing the slideshow forward or back', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'convert_to_boolean' => true,
		'tab' => 'simple',
		'default' => true,
		'data_type' => 'boolean',
	),
	'swipe-fx' => array(
		'name' => 'swipe-fx', 
		'title' => __( 'Swipe Transition Effect', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The transition effect to use for swipe-triggered transitions', 'jsj-gallery-slideshow' ),
		'type' => 'select',
		'tab' => 'advanced',
		'parameters' => array_merge(array(''), $all_transition_effects),
		'default' => '',
		'data_type' => 'string',
	),
	'sync' => array(
		'name' => 'sync', 
		'title' => __( 'Sync', 'jsj-gallery-slideshow' ),
		'descp' => __( 'If true then animation of the incoming and outgoing slides will be synchronized', 'jsj-gallery-slideshow' ),
		'type' => 'boolean',
		'convert_to_boolean' => true,
		'tab' => 'advanced',
		'default' => true,
		'data_type' => 'boolean',
	),
	'timeout' => array(
		'name' => 'timeout', 
		'title' => __( 'Timeout', 'jsj-gallery-slideshow' ),
		'descp' => __( 'The time between slide transitions in milliseconds', 'jsj-gallery-slideshow' ),
		'type' => 'text',
		'tab' => 'simple',
		'default' => 0,
		'cycle_default' => 4000,
		'data_type' => 'integer',
	),
	/**
	 * NOT INCLUDED: tmpl-regex
	 *
	 * The default regular expression used for template tokenization.
	 *
	 */
	/**
	 * NOT INCLUDED: update-view
	 *
	 * Determines when the updateView method is invoked (and event is triggered).
	 * If the value is -1 then updateView is only invoked immediately after the slide transition.
	 * If the value is 0 then updateView is invoked during the slide transition.
	 * If the value is 1 then updateView is invoked immediately upon the beginning of a slide transition and again immediately after the transition.
	 *
	 */
);

?>