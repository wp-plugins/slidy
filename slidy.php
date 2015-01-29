<?php
/*
 * Plugin Name: Slidy
 * Plugin URI: http://www.gungorbudak.com/slidy
 * Description: Slidy is a responsive jQuery slider that uses slick carousel and that is fully integrated into Wordpress
 * Version: 0.0.3
 * Author: Gungor Budak
 * Author URI: http://www.gungorbudak.com
 * License: GPL2
 */

 /*
 * Copyright 2014  Gungor Budak  (email : gngrbdk@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

 /*
 * This plugin uses slick carousel by Ken Wheeman
 * please visit http://kenwheeler.github.io/slick/
 * for more information about it
 */

add_action( 'init', 'slidy_localization_init' );
add_action( 'wp_enqueue_scripts', 'slidy_enqueue' );
add_action( 'init', 'slidy_post_type_init' );
add_action( 'init', 'slidy_taxonomy_init');
add_action('admin_menu', 'slidy_add_slide_url');
add_action('save_post', 'slidy_save_slide_link');
add_shortcode( 'slidy', 'slidy_shortcode' );

$default_args = array(
	'category' => '',
	'number' => '5',
	'title' => 'true',
	'autoplay' => 'true',
	'autoplaySpeed' => '3000',
	'arrows' => 'true',
	'cssEase' => 'ease',
	'dots' => 'true',
	'draggable' => 'true',
	'fade' => 'false',
	'infinite' => 'true',
	'pauseOnHover' => 'true',
	'pauseOnDotsHover' => 'false',
	'slidesToShow' => '1',
	'slidesToScroll' => '1',
	'speed' => '300',
	'swipe' => 'true',
	'touchMove' => 'true',
	'touchThreshold' => '5',
	'useCSS' => 'true'
	);

/*
* Localization
*/

function slidy_localization_init() {
	load_plugin_textdomain('slidy', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}

/*
* Enqueue scripts
*/
 
function slidy_enqueue() {
	wp_enqueue_style( 'slick-style', plugins_url( 'slick/slick.css' , __FILE__ ) );
	wp_enqueue_style( 'slidy-style', plugins_url( 'css/main.css' , __FILE__ ), array( 'slick-style' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'script', plugins_url( 'js/main.js' , __FILE__ ), false, '1.0', true );	
	wp_enqueue_script( 'slick-script', plugins_url( 'slick/slick.min.js' , __FILE__ ), array( 'jquery' ), false, true );
}

/*
* Slidy create custom posty type: slidy
*/

function slidy_post_type_init() {
	$labels = array(
		'name'               => _x( 'Slides', 'post type general name', 'slidy' ),
		'singular_name'      => _x( 'Slide', 'post type singular name', 'slidy' ),
		'menu_name'          => _x( 'Slides', 'admin menu', 'slidy' ),
		'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'slidy' ),
		'add_new'            => _x( 'Add New', 'book', 'slidy' ),
		'add_new_item'       => __( 'Add New Slide', 'slidy' ),
		'new_item'           => __( 'New Slide', 'slidy' ),
		'edit_item'          => __( 'Edit Slide', 'slidy' ),
		'view_item'          => __( 'View Slide', 'slidy' ),
		'all_items'          => __( 'All Slides', 'slidy' ),
		'search_items'       => __( 'Search Slides', 'slidy' ),
		'parent_item_colon'  => __( 'Parent Slides:', 'slidy' ),
		'not_found'          => __( 'No slides found.', 'slidy' ),
		'not_found_in_trash' => __( 'No slides found in Trash.', 'slidy' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'slide', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => plugins_url( 'img/icon.png' , __FILE__ ),
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'slide', $args );
}

/*
* Slidy create custom taxonomy
*/

function slidy_taxonomy_init() {
	register_taxonomy(
		'slide-category',
		'slide',
		array(
			'hierarchical'        => true,
			'label'               => __('Categories'),
			'query_var'           => true,
			'show_admin_column'   => true,
			'rewrite'             => array(
				'slug'            => 'slide-category',
				'with_front'      => true
				)
			)
	);
}
 
/*
* Meta box for slide's URLs
*/
     
$slide_url = array( 
	'id' => 'slide_link',
	'title' => __('Slide Link'),
	'page' => array('slide'),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(
		array(
		'name'          => __('Slide URL'),
		'desc'          => __('Enter the slide URL or a custom URL to link it to a content'),
		'id'                => 'slidy_slide_url',
		'class'             => 'slidy_slide_url',
		'type'          => 'text',
		'rich_editor'   => 0,            
		'max'           => 0             
		),
	)
);

/*
* Function to add meta box for slide's URLs
*/

function slidy_add_slide_url() {
	global $slide_url;        

	foreach($slide_url['page'] as $page) {
		add_meta_box($slide_url['id'], $slide_url['title'], 'slidy_show_slide_url', $page, 'normal', 'default', $slide_url);
	}
}

/*
* Function to show meta box for slide's URLs
*/

function slidy_show_slide_url()  {
	global $post;
	global $slide_url;
	global $slidy_prefix;
	global $wp_version;

	// Use nonce for verification
	echo '<input type="hidden" name="slidy_slide_link_nonce" value="', wp_create_nonce(basename(__FILE__)), '">';
	echo '<table class="form-table">';

		foreach ($slide_url['fields'] as $field) {
		// Get current post meta data

		$meta = get_post_meta($post->ID, $field['id'], true);

		echo '<tr>',
			'<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
			'<td class="wptuts_field_type_' . str_replace(' ', '_', $field['type']) . '">';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
			break;
			}
		echo '<td>',
			'</tr>';
		}
	echo '</table>';
}   

/*
* Function to save data from meta box for slide's URLs
*/

function slidy_save_slide_link($post_id) {
	global $post;
	global $slide_url;

	// Verify nonce
	if (!wp_verify_nonce($_POST['slidy_slide_link_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// Check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// Check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	foreach ($slide_url['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];

		if ($new && $new != $old) {
			if($field['type'] == 'date') {
				$new = wptuts_format_date($new);
				update_post_meta($post_id, $field['id'], $new);
			} else {
				if(is_string($new)) {
					$new = $new;
				} 
			update_post_meta($post_id, $field['id'], $new);
			}
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

/*
* Create Slidy
*/

function slidy_create( $atts ) {
	global $default_args;
	$args = shortcode_atts($default_args, $atts, 'slidy');

	// Query arguments
	$query_args = array(
		'slide-category' => (isset($args['category']) === true) ? $args['category'] : '',
		'post_type' => 'slide',
		'posts_per_page' => (isset($args['number']) === true) ? $args['number'] : '',
	); 

	// Unset category & number arg, we don't need it anymore
	if (isset($args['category']) === true) unset($args['category']);
	if (isset($args['number']) === true) unset($args['number']);

	// Title asked?
	if (isset($args['title']) === true) {
		$title_asked = $args['title'];
		unset($args['title']);
		}

	// The query
	$slides = get_posts( $query_args );

	// Check if the query returns any posts
	if (empty($slides) === false) {
		// Start the Slider
		$the_slidy = '<script type="text/javascript" charset="utf-8">
			jQuery(document).ready(function(){
				jQuery(".slidy").slick({';
					foreach ($args as $arg => $value):
						$the_slidy .= ($arg == "cssEase") ? $arg .': "' . $value . '",' : $arg .': ' . $value . ',';
					endforeach;
		$the_slidy .= '});
			});
		</script>';
		?>
		<?php $the_slidy .= '<div class="slidy">'; ?>
			<?php
				foreach ($slides as $slide): ?>
					<?php $the_slidy .= '<div>'; ?>
						<?php $the_slidy .= '<div class="slide-container">'; ?>
							<?php // Check if there's a slide URL given and if so let's a link to it
								if ( get_post_meta( $slide->ID, 'slidy_slide_url', true) != '' ) { ?>
									<?php $the_slidy .= '<a href="' . esc_url( get_post_meta( $slide->ID, 'slidy_slide_url', true) ) . '">'; ?>
							<?php }

							// The slide's image
							$the_slidy .= get_the_post_thumbnail($slide->ID);
							
							// The slide's title
							$the_slidy .= ($title_asked == 'true') ? '<div class="slide-title">' . $slide->post_title . '</div>' : '';
							
							// Close off the slide's link if there is one
							if ( get_post_meta( $slide->ID, 'slidy_slide_url', true) != '' ) { ?>
								<?php $the_slidy .= '</a>'; ?>
							<?php } ?>
						<?php $the_slidy .= '</div>'; ?>
					<?php $the_slidy .= '</div>'; ?>
				<?php endforeach; ?>
		<?php $the_slidy .= '</div>'; ?><!-- .slidy -->

<?php }

	echo $the_slidy;
}

/*
* Slidy shortcode
*/

function slidy_shortcode( $atts ) {
	// Fix keys in array because shortcode atts are always lowercased
	if (isset($atts['autoplayspeed']) === true) $atts['autoplaySpeed'] = $atts['autoplayspeed'];
	if (isset($atts['slidestoscroll']) === true) $atts['slidesToScroll'] = $atts['slidestoscroll'];
	if (isset($atts['slidestoshow']) === true) $atts['slidesToShow'] = $atts['slidestoshow'];
	if (isset($atts['cssease']) === true) $atts['cssEase'] = $atts['cssease'];
	if (isset($atts['pauseonhover']) === true) $atts['pauseOnHover'] = $atts['pauseonhover'];
	if (isset($atts['pauseondotshover']) === true) $atts['pauseOnDotsHover'] = $atts['pauseondotshover'];
	if (isset($atts['touchmove']) === true) $atts['touchMove'] = $atts['touchmove'];
	if (isset($atts['touchthreshold']) === true) $atts['touchThreshold'] = $atts['touchthreshold'];
	if (isset($atts['usecss']) === true) $atts['useCSS'] = $atts['usecss'];
	slidy_create( $atts );
}