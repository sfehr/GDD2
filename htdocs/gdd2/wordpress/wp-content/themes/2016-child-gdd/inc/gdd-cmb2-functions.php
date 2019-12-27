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


/** GDD CMB2 Functions Inventory
 *  
 * FILE LIST
 *
 */




/* FILE LIST
*
* [file_list] content images
*
*/
add_action( 'cmb2_admin_init', 'gdd_register_filelist_metabox' );

function gdd_register_filelist_metabox() {
	$prefix = 'gdd_image_gallery_';

	// Register the metabox
	$cmb_image_gallery = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Image Gallery', 'cmb2' ),
		'object_types'  => array( 'post', 'page' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );	
	
	// Register the field
	$cmb_image_gallery->add_field( array(
		'name' => 'Images',
		'desc' => '',
		'id'   => 'filelist',
		'type' => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		// 'query_args' => array( 'type' => 'image' ), // Only images attachment
		// Optional, override default text strings
		'text' => array(
//			'add_upload_files_text' => 'Replacement', // default: "Add or Upload Files"
//			'remove_image_text' => 'Replacement', // default: "Remove Image"
//			'file_text' => 'Replacement', // default: "File:"
//			'file_download_text' => 'Replacement', // default: "Download"
//			'remove_text' => 'Replacement', // default: "Remove"
		),
	) );	
	
}


