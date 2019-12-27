<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */


/** TCT CMB2 Functions Inventory
 *  
 * SHOW or NO SHOW IN START PAGE BOX
 *
 * TRANSLATION META BOX
 *
 * CUSTOM POST TYPE: BRAND STORY
 * * * MEDIA META BOX
 *
 * CUSTOM POST TYPE: COLLABORATION
 * * * PROFILE BOX
 *  
 * CUSTOM POST TYPE: PORTFOLIO
 * * * PORTFOLIO DATA BOX
 *  
 * CUSTOM POST TYPE: SAMPLE TILES
 * * * SAMPLE TILE IMAGES
 * * * SAMPLE TILE DIMENSIONS
 * * * SAMPLE TILE INFO 
 * * * NO STOCK CHECKBOX
 * 
 * cmb2_get_term_options
 *  
 */



/* SHOW or NO SHOW IN START PAGE BOX
*
* [radio] weather to show in front page or not
*/
add_action( 'cmb2_admin_init', 'tct_register_show_in_startpage_option_metabox' );

function tct_register_show_in_startpage_option_metabox() {
	$prefix = 'tct_show_in_startpage_options_';
	
	$cmb_show_options = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Start Page Display Option', 'cmb2' ),
		'object_types'  => array( 'brand_story', 'production_method', 'collaborations', 'sample_tile'), // Post type
	) );
	
	// CHECK BOX FIELD
	$cmb_show_options->add_field( array(
		'name'    => esc_html__( 'Display Option', 'cmb2' ),
		'desc'	  => esc_html__( 'Show this entry in start page', 'cmb2' ),
		'id'      => $prefix . 'checkbox',
		'type'    => 'checkbox',
	) );
	
}


/* TRANSLATION META BOX 
*
* Standard Fields:
* [title] content translation
* [wysiwyg] content translation
*/
/*
add_action( 'cmb2_admin_init', 'tct_register_translation_metabox' );

function tct_register_translation_metabox() {
	$prefix = 'tct_translation_';

	$cmb_translation = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Japanese Translation', 'cmb2' ),
		'object_types'  => array( 'brand_story', 'production_method', 'collaborations' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.

	) );

	// TITLE FIELD
	$cmb_translation->add_field( array(
		'name' => 'Title JP',
		'desc' => 'Title in Japanese',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'title_JP'
	) );
	
	
	// TEXT EDITOR FIELD
	$cmb_translation->add_field( array(
		'name'    => esc_html__( 'Content JP', 'cmb2' ),
		'desc'    => esc_html__( 'body text content in Japanese', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg_JP',
		'type'    => 'wysiwyg',
		'options' => array(
			'media_buttons' => false, // show insert/upload button(s)			
			'teeny' => true // output the minimal editor config used in Press This
		),
	) );	
}
*/



/*
*
* CUSTOM POST TYPE: BRAND STORY //////////////////////////////////////////////
* (Also used for Production Methods, Collaborations)
*/

/* MEDIA META BOX
*
* Repeatable Field Groups:
* [radio] switch between image or movie
* [file_list] content images
* [oembed] content movies
*/
add_action( 'cmb2_admin_init', 'tct_register_repeatable_brand_story_group_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function tct_register_repeatable_brand_story_group_metabox() {
	$prefix = 'tct_brand_story_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_brand_story_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'Media (Image or Movie)', 'cmb2' ),
		'object_types' => array( 'brand_story', 'production_method', 'collaborations' ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_brand_story_group->add_field( array(
		'id'          => $prefix . 'group',
		'type'        => 'group',
		'description' => esc_html__( 'Choose either an image or a movie', 'cmb2' ),
		'options'     => array(
			'group_title'    => esc_html__( 'Media Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'     => esc_html__( 'Add Another Media Entry', 'cmb2' ),
			'remove_button'  => esc_html__( 'Remove Media Entry', 'cmb2' ),
			'sortable'       => true,
			// 'closed'      => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	
	// RADIO BUTTON FIELD
	$cmb_brand_story_group->add_group_field( $group_field_id, array(
		'name'    => __( 'Media Type', 'cmb2' ),
		'id'      => 'select',
		'type'    => 'select',
		'options' => array(
			'img' => __( 'Image', 'cmb2' ),
			'mov' => __( 'Movie', 'cmb2' ),
		),
		'default' => 'img',
	) );	
	
	// IMAGE FIELD
	$cmb_brand_story_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Image(s)', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		// 'query_args' => array( 'type' => 'image' ), // Only images attachment
		'attributes' => array(
		//	'required'               => true, // Will be required only if visible.
		),		
	) );	
	
	// MOVIE FIELD
	$cmb_brand_story_group->add_group_field( $group_field_id, array(
		'name' => 'Movie',
		'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
		'id'   => 'movie',
		'type' => 'oembed',
	) );	
}


/*
*
* CUSTOM POST TYPE: COLLABORATION //////////////////////////////////////////////
* 
* [file] profile image
* [wysiwyg] profile text
*
*/
add_action( 'cmb2_admin_init', 'tct_register_profile_metabox' );

function tct_register_profile_metabox() {
	$prefix = 'tct_profile_';

	$cmb_profile = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Profile', 'cmb2' ),
		'object_types'  => array( 'collaborations' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );
	
	// FILE FIELD
	$cmb_profile->add_field( array(
		'name'    => esc_html__( 'Profile Photo', 'cmb2' ),
		'desc'    => esc_html__( 'Select a profile photo', 'cmb2' ),
		'id'      => $prefix . 'file',
		'type'    => 'file',
		// Optional:
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
		),
		// query_args are passed to wp.media's library query.
		//'query_args' => array(
			//'type' => 'application/pdf', // Make library only display PDFs.
			// Or only allow gif, jpg, or png images
			// 'type' => array(
			// 	'image/gif',
			// 	'image/jpeg',
			// 	'image/png',
			// ),
		// ),
		// 'preview_size' => 'large', // Image size to use when previewing in the admin.
	) );	
	
	// TEXT EDITOR FIELD
	$cmb_profile->add_field( array(
		'name'    => esc_html__( 'Profile Text', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array(
			'media_buttons' => false, // show insert/upload button(s)			
			'teeny' => true // output the minimal editor config used in Press This
		),
	) );	
}

	

/*
*
* CUSTOM POST TYPE: PORTFOLIO //////////////////////////////////////////////
* [file_list] images
* [text_date_timestamp] year
* [text] city
* [text] prefecture
* [text] country
* [text] architectv
* [text] production method
* [text_small] volume
*
*/

add_action( 'cmb2_admin_init', 'tct_register_portfolio_data_metabox' );

function tct_register_portfolio_data_metabox() {
	$prefix = 'tct_portfolio_data_';

	$cmb_portfolio = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Portfolio Data', 'cmb2' ),
		'object_types'  => array( 'portfolio' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.

	) );
	
	// IMAGES (FILE LIST)
	$cmb_portfolio->add_field( array(
		'name' => 'Portfolio Images',
		'desc' => '',
		'id'   => $prefix . 'file_list',
		'type' => 'file_list',
		'preview_size' => array( 200, 200 ), // Default: array( 50, 50 )
		// 'query_args' => array( 'type' => 'image' ), // Only images attachment
		// Optional, override default text strings
		'text' => array(
			'add_upload_files_text' => 'Add Image', // default: "Add or Upload Files"
			'remove_image_text' => 'Replacement', // default: "Remove Image"
			'file_text' => 'Replacement', // default: "File:"
			'file_download_text' => 'Replacement', // default: "Download"
			'remove_text' => 'Replacement', // default: "Remove"
		),
	) );
	
	// YEAR FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Year',
		'desc' => 'choose random date, only the year will be displayed',
		'id'   => $prefix . 'year',
		'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => 'wiki_test_timezone',
		// 'date_format' => 'l jS \of F Y',
		'date_format' => 'Y',
	) );	
	
	// LOCATION: CITY FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Location: City',
		'desc' => 'if blank a "–" will appear',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'location_city'
	) );
	
	// LOCATION: PREFECTURE FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Location: Prefecture',
		'desc' => 'if blank a "–" will appear',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'location_prefecture'
	) );
	
	// LOCATION: COUNTRY FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Location: Country',
//		'desc' => 'e.g. Japan -> JP',
		'desc' => 'if blank a "–" will appear',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'location_country'
	) );	
	
	// ARCHITECT FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Architect',
		'desc' => 'who is the architect?',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'architect'
	) );
	
	// METHOD USED FIELD
	
	// PLL CHECKS FOR TRANSLATION
	if ( function_exists( 'pll_current_language' ) ){
		$lang = ( pll_current_language() === pll_default_language() ) ? '' : '_' . pll_current_language();
	}
	
	$category = get_term_by( 'slug', 'tile_production_method' . $lang, 'tile_category' );
	
	$cmb_portfolio->add_field( array(
		'name' => 'Method used',
		'desc' => 'which production method?',
//		'default' => 'standard value (optional)',
		'type' => 'select',
		'id'   => $prefix . 'method',
		'options_cb'     => 'cmb2_get_term_options',
		// Same arguments you would pass to `get_terms`.
		'get_terms_args' => array(
			'taxonomy'   => 'tile_category',
			'hide_empty' => false,
			'child_of'   => $category->term_id
		),		
	) );
	
	// VOLUME FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Volume',
		'desc' => '(positive number only)',
//		'default' => 'standard value (optional)',
		'type' => 'text_small',
		'id'   => $prefix . 'volume',
		'before_field' => 'tile surface in m2: ', // Replaces default '$'
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
		'escape_cb'       => 'absint',
	) );
}
	 

/*
*
* CUSTOM POST TYPE: SAMPLE TILES //////////////////////////////////////////////
* [file] image 1
* [file] image 2
*
*/

add_action( 'cmb2_admin_init', 'tct_register_sample_tiles_metabox' );

function tct_register_sample_tiles_metabox() {
	$prefix = 'tct_sample_tiles_';

	$cmb_sample_tile = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Tile Data', 'cmb2' ),
		'object_types'  => array( 'sample_tile' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );
	
	// IMAGE 1 (frontal) FIELD
	$cmb_sample_tile->add_field( array(
		'name'    => 'Tile Image 1',
		'desc'    => 'Upload an image or enter an URL.',
		'id'      => $prefix . 'image_1',
		'type'    => 'file',
		// Optional:
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
		),
		// query_args are passed to wp.media's library query.
		//'query_args' => array(
			//'type' => 'application/pdf', // Make library only display PDFs.
			// Or only allow gif, jpg, or png images
			// 'type' => array(
			// 	'image/gif',
			// 	'image/jpeg',
			// 	'image/png',
			// ),
		// ),
		'preview_size' => 'large', // Image size to use when previewing in the admin.
	) );
	
	// IMAGE 2 (perspective) FIELD
	$cmb_sample_tile->add_field( array(
		'name'    => 'Tile Image 2',
		'desc'    => 'Upload an image or enter an URL.',
		'id'      => $prefix . 'image_2',
		'type'    => 'file',
		// Optional:
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
		),
		// query_args are passed to wp.media's library query.
		//'query_args' => array(
			//'type' => 'application/pdf', // Make library only display PDFs.
			// Or only allow gif, jpg, or png images
			// 'type' => array(
			// 	'image/gif',
			// 	'image/jpeg',
			// 	'image/png',
			// ),
		// ),
		'preview_size' => 'large', // Image size to use when previewing in the admin.
	) );	
	
}


/*
*
* CUSTOM POST TYPE: SAMPLE TILES  //////////////////////////////////////////////
* SAMPLE TILE DIMENSIONS
* [text_small] width
* [text_small] height
* [text_small] depth
*
*/
add_action( 'cmb2_admin_init', 'tct_register_tct_sample_tiles_dimensions_metabox' );

function tct_register_tct_sample_tiles_dimensions_metabox() {
	
	$prefix = 'tct_sample_tiles_dimensions_';
	
	$cmb_sample_tile_dimensions = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Sample Tile Dimensions', 'cmb2' ),
		'object_types'  => array( 'sample_tile' ), // Post type
	) );

	// WIDTH FIELD
	$cmb_sample_tile_dimensions->add_field( array(
		'name' => 'Width',
		'desc' => esc_html__( 'positive number only', 'cmb2' ),
		'type' => 'text_small',
		'id'   => $prefix . 'width',
		'before_field' => esc_html__( 'Width in mm:', 'cmb2' ),
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
		'escape_cb'       => 'absint',
	) );
	
	// HEIGHT FIELD
	$cmb_sample_tile_dimensions->add_field( array(
		'name' => 'Height',
		'desc' => esc_html__( 'positive number only', 'cmb2' ),
		'type' => 'text_small',
		'id'   => $prefix . 'height',
		'before_field' => esc_html__( 'Height in mm:', 'cmb2' ),
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
		'escape_cb'       => 'absint',
	) );
	
	// HEIGHT FIELD
	$cmb_sample_tile_dimensions->add_field( array(
		'name' => 'Depth',
		'desc' => esc_html__( 'positive number only', 'cmb2' ),
		'type' => 'text_small',
		'id'   => $prefix . 'depth',
		'before_field' => esc_html__( 'Depth in mm:', 'cmb2' ),
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
		'escape_cb'       => 'absint',
	) );	
}	

/*
*
* CUSTOM POST TYPE: SAMPLE TILES  //////////////////////////////////////////////
* SAMPLE TILE INFO
* [text] info EN
* [text] info JA
*
*/
add_action( 'cmb2_admin_init', 'tct_register_tct_sample_tiles_info_metabox' );

function tct_register_tct_sample_tiles_info_metabox() {
	
	$prefix = 'tct_sample_tiles_info_';
	
	$cmb_sample_tile_info = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Sample Tile Info', 'cmb2' ),
		'object_types'  => array( 'sample_tile' ), // Post type
	) );	
	
	// NOTE FIELD EN
	$cmb_sample_tile_info->add_field( array(
		'name' => 'Note EN',
		'desc' => esc_html__( 'Notification on this sample tile EN. Max 85 characters.', 'cmb2' ),		
		'type' => 'text',
		'id'   => $prefix . 'note_en',
	) );
	
	// NOTE FIELD JP
	$cmb_sample_tile_info->add_field( array(
		'name' => 'Note JP',
		'desc' => esc_html__( 'Notification on this sample tile JP. Max 85 characters.', 'cmb2' ),		
		'type' => 'text',
		'id'   => $prefix . 'note_ja',
	) );	
	
}


/*
*
* CUSTOM POST TYPE: SAMPLE TILES //////////////////////////////////////////////
* [radio_inline] no stock
*
*/
add_action( 'cmb2_admin_init', 'tct_register_no_stock_metabox' );

function tct_register_no_stock_metabox() {
	
	$prefix = 'tct_no_stock_option_';
	
	$cmb_no_stock_option = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'No Stock Option', 'cmb2' ),
		'object_types'  => array( 'sample_tile' ), // Post type
	) );
	
	// RADIO FIELD
	$cmb_no_stock_option->add_field( array(
		'name'    => 'Is stock available?',
		'id'      => $prefix . 'nostock',
		'type'    => 'radio_inline',
		'options' => array(
			'false' => __( 'Available', 'cmb2' ),
			'true'   => __( 'Not Available', 'cmb2' ),
		),
		'default' => 'false',
	) );
}



/**
 * Gets a number of terms and displays them as options
 * @param  CMB2_Field $field 
 * @return array An array of options that matches the CMB2 options array
 */
function cmb2_get_term_options( $field ) {
	$args = $field->args( 'get_terms_args' );
	$args = is_array( $args ) ? $args : array();

	$args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

	$taxonomy = $args['taxonomy'];

	$terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
		? get_terms( $args )
		: get_terms( $taxonomy, $args );

	// Initate an empty array
	$term_options = array();
	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$term_options[ $term->term_id ] = $term->name;
		}
	}

	return $term_options;
}

