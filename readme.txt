=== Slidy ===
Contributors: gungorbudak
Tags: jQuery, slider, slick, slide, responsive, image, image album, image slider, image slideshow, images, jQuery gallery, jQuery slider, jQuery slideshow, links, template, shortcode, widget, sidebar, page, Post, posts, best gallery, best gallery plugin, easy media gallery, fancy gallery, photo album gallery, Gallery Plugin, photo, photo album, photo albums, photo gallery, Photo Slider, photos, picture, pictures, plugin, plugin for gallery, plugin gallery, wp gallery, wp gallery plugin, wp slider
Donate link: http://www.gungorbudak.com
Requires at least: 3.3
Tested up to: 4.0
Stable tag: 0.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Slidy is a responsive jQuery slider that uses slick carousel. Insert it directly into a template or with its shortcode into pages, posts & widgets.

== Description ==

[Slidy](http://www.gungorbudak.com/slidy "Slidy / Responsive jQuery Wordpress Slider") is a reponsive jQuery slider that uses [slick carousel by Ken Wheeler](http://kenwheeler.github.io/slick/ "slick - the last carousel you'll ever need") and it's fully integrated into Wordpress, so it's possible to add and administer slides via the Dashboard. You just need to set the image that you want to see in Slidy as the featured image in each post. Slides can be categorized and in this way you can have different sliders on your website. With the functionalities slick carousel brings, it is possible to create sliders in different ways, such as having multiple items unlike many sliders. Also, with the wide range of settings, you can customize your slider in various ways such as inifinite looping, mouse dragging, swiping, arrow key navigation etc. You can also add links to the individual slides via Add/Edit Slide interface. The slides are posts at the same time so you can use them as contents but you may have to edit your theme to view slide images. Note that this version doesn't cover all functionalities slick carousel provided but the present functionalities are very sufficent for you to create awesome sliders. Check out [Slidy's screenshots here](https://wordpress.org/plugins/slidy/screenshots/ "Slidy's Screenshots").

**How to use Slidy**

Find the example below for inserting it directly into the template

`
$args = array(
	'category' => 'home-page',
	'autoplay' => 'true',
	'autoplaySpeed' => '500',
	'dots' => 'true',
	'slidesToShow' => '3',
	'slidesToScroll' => '1'
);

if( function_exists( 'slidy_create' ) ){ slidy_create( $args ); }
`

Find the example below for inserting it using shortcode

`[slidy category="" title="false" autoplay="true" autoplaySpeed="500" dots="true" slideToShow="3" slideToScroll="1"]`

**Options you can set for the template insert / shortcode**

* category (none) - category of the slides (must be slug)
* number (5) - number of sliders to be shown
* title (true) - title of the slides
* autoplay (true) - autoplay of the slides
* autoplaySpeed (3000) - speed of the autoplay
* arrows (true) - navigation arrows
* cssEase ("ease") - CSS3 Animation Easing
* dots (true) - navigation dots
* draggable (true) - desktop mouse dragging
* fade (false) - fade transition (only possible when slidesToShow is 1)
* infinite (true) - infinite looping of the slides
* pauseOnHover (true) - pause when hover the slides
* pauseOnDotsHover (false) - pause when hover the navigation dots
* slidesToShow (1) - number of slides to show in one time
* slidesToScroll (1) - number of slides to scroll in one time
* speed (300) - speed of the scrolling
* swipe (true) - swiping
* touchMove (true) - touch move
* touchThreshold (5) - threshold of the touch move
* useCSS (true) - CSS transitions

The plugin is written in English and has been translated into Turkish by [myself](http:/www.gungorbudak.com/ "Güngör Budak"). You're welcomed if you want to translate it into your language. Use translations.pot, rename it as slidy-LANGCODE.po (e.g. slidy-tr_TR) and open it in Poedit. Translate and save. There should be a MO file created by Poedit. Send PO and MO files to me, then I will add them in the next release.

== Installation ==

1. Decompress the package you downloaded and upload `/slidy/` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. And slide!

== Frequently Asked Questions ==

= Is this plugin bug free? =
It is the first release so, any bug report would be appreciated.

= May I request a new feature? =
Absolutely.

== Screenshots ==

1. Home page look of Slidy with 3 slides in one time
2. Post/page look of Slidy with 1 slide in one time without arrows and dots
3. Post/page look of Slidy with 2 slides in one time
4. Add/Edit Slide interface slide link meta box
5. Add/Edit Slide interface slide image and category meta box

== Changelog ==

= 0.0.3 =
Promlem with cssEase option solved

= 0.0.2 =
CSS3 Animation Easing option added

= 0.0.1 =
First release

== Upgrade Notice ==

= 0.0.1 =
First release
