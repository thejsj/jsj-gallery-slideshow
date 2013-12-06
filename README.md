# JSJGallerySlideshow

JSJ Gallery Slideshow is a  Wordpress plugin that substitutes the default gallery an turns into a much nicer slideshow. 

## Description

JSJ Gallery Slideshow is a Wordpress plugin that substitutes the default gallery an turns into a much nicer slideshow. It does this completely automatically (really, it’s that easy!). You only have to install the plugin and all your slideshows will be automatically converted to something like [this](http://thejsj.com/#/uncategorized/jsj-%C2%B7-gallery-slideshow-example/).

You can change almost all the options allowed by [Jquery Cycle](http://jquery.malsup.com/cycle/options.html) (it’s based on this Jquery plugin) such as: transition time, transition effect, timeout between transition (or no timeout), slide class, …etc.

This plugin is inspired by [Cargo Collective’s slideshow feature](http://cargocollective.com/slideshow) and uses [Jquery Cycle](http://jquery.malsup.com/cycle/) and [Jquery Easing](http://gsgd.co.uk/sandbox/jquery/easing/) as the basis for the plugin.

Available translations:

- Spanish (es_ES)

## Installation

1. Upload the entire jsjGallerySlideshow folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the ‘Plugins’ menu in WordPress. At that moment, all your slideshows will be automatically converted into JSJ Gallery Slideshows.
3. Optional: If you want to change any of the options for the plugin, go to Settings -> JSJ Gallery Slideshow.

## Frequently asked questions

If you have any questions, please try to add a ticket in the WordPress support forum for this plugin (http://wordpress.org/support/plugin/jsj-gallery-slideshow). Also, if you wish, email me at jorge dot silva at thejsj dot com.

## Screenshots

1. Example #1. See it online: <http://thejsj.com/#/uncategorized/jsj-gallery-slideshow-example/>

2. Example #2. See it online: <http://thejsj.com/#/pieces/anything-worth-saying-exhibition/>

3. Example #3. See it online: <http://thejsj.com/#/pieces/n-possible-routes/>

4. Example #4. See it online: <http://thejsj.com/#/pieces/anything-worth-saying-interactive/>

5. Options Page

## Changelog

### 1.0 
First Version. 

### 1.1 
Added translation capabilities.
Added Spanish(es_ES) translation to plugin.
Created javascript function to ensure easier use with AJAX.
Changed default image size to 'Full'.
Fixed some HTML bugs.

## Upgrade notice 

### 1.0
First Version. 

### 1.1 
Check your html doesn't break. 
If using ajax, try using the createJSJGallerySlideshow() function to re-init your plugin. 

## Online Examples

You can see some online examples here:

1. <http://thejsj.com/#/uncategorized/jsj-gallery-slideshow-example/>

1. <http://thejsj.com/#/pieces/anything-worth-saying-exhibition/>

1. <http://jajaja.thejsj.com/?page_id=118#>

1. <http://thejsj.com/#/uncategorized/jsj-gallery-slideshow-example/>

1. <http://thejsj.com/#/pieces/anything-worth-saying-exhibition/>

1. <http://thejsj.com/#/pieces/n-possible-routes/>

1. <http://thejsj.com/#/pieces/anything-worth-saying-interactive/>

## Available Options (From JqueryCycle)

* Active Pager Class – Class name used for the active pager element. No Spaces.
* Auto Stop – True to end slideshow after X transitions (where X == slide count.
* Auto Stop Count – number of transitions (optionally used with autostop to define X.
* Start Backwards – true to start slideshow at last slide and move backwards through the stac.
* Clear Type No Background – Set to true to disable extra cleartype fixing (leave false to force background color setting on slides.
* Container Resize – Resize container to fit largest slide. 0:False / 1: Tru.
* Delay – Additional delay (in ms) for first transition (hint: can be negative).
* FastOn Event – Force fast transitions when triggered manually (via pager or prev/next); value == time in ms.
* Fit Slides – Force slides to fit container.
* Transition Effect – Name of transition effect.
* Slide Height – Container height (if the ‘fit’ option is true, the slides will be set to this height as well).
* Manual Trump – Causes manual transition to stop an active transition instead of being ignored.
* Data Attribute – data-attribute that holds the option data for the slideshow.
* No Wrapping – True(1) to prevent slideshow from wrapping.
* Pause Slidehow – True(1) to enable “pause on hover”.
* Pause On Pager Hover – True(1) to pause when hovering over pager link.
* Random Slides – True(1) for random, false for sequence (not applicable to shuffle fx).
* Requeue OnImageNotLoaded – Requeue the slideshow if any image slides are not yet loaded .
* Requeue Timeout – Ms delay for requeue.
* Reverse Animation – Causes animations to transition in reverse (for effects that support it such as scrollHorz/scrollVert/shuffle).
* Slide Resize – Force slide width/height to fixed size before every transition).
* Speed – speed of the transition (any valid fx speed value).
* Starting Slide # – Zero-based index of the first slide to be displayed.
* Synchronize Slides – True if in/out transitions should occur simultaneously.
* Transition Time – Milliseconds between slide transitions (0 to disable auto advance).
* Width – Container width (if the ‘fit’ option is true, the slides will be set to this width as well).

## Info

Contributors: jorge.silva

Donate link: 

Tags: slideshow, gallery, simple, jquery, easing, animation, cargo, cycle, jsj

Requires at least: 3.3

Tested up to: 3.5.1

Stable tag: 1.1

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html