<?php 

// Top Anchor Function
function twentysixteen_child_gdd_scripts() {
	wp_enqueue_script( 'top anchor js', get_stylesheet_directory_uri() . '/js/top-anchor.js' );
}

add_action( 'wp_enqueue_scripts', 'twentysixteen_child_gdd_scripts' );


//* Add support for custom flexible header (SVG images)
add_theme_support( 'custom-header', array(
	'flex-width'    => true,
	'width'           => 260,
	'flex-height'    => true,
	'height'          => 100,
	'header-selector' => '.site-title a',
	'header-text'     => false
) );


// Multiple Featured Image
add_filter( 'kdmfi_featured_images', function( $featured_images ) {
    $args = array(
        'id' => 'featured-image-2',
        'desc' => 'Your description here.',
        'label_name' => 'Featured Image 2',
        'label_set' => 'Set featured image 2',
        'label_remove' => 'Remove featured image 2',
        'label_use' => 'Set featured image 2',
        'post_type' => array( 'page' ),
    );

    $featured_images[] = $args;

    return $featured_images;
});




// Modifyed Entry Meta function (removing the date on posts)

if ( ! function_exists( 'twentysixteen_child_gdd_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own twentysixteen_child_gdd_entry_meta() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_child_gdd_entry_meta() {
	
/*	deleting the avatar (author)
	if ( 'post' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'twentysixteen' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}
*/
		
	/** Removing the date here
	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		
		//twentysixteen_entry_date();		
		
	}
	*/

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentysixteen' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() ) {
		twentysixteen_child_gdd_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentysixteen' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;


if ( ! function_exists( 'twentysixteen_child_gdd_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own twentysixteen_child_gdd_entry_taxonomies() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_child_gdd_entry_taxonomies() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentysixteen' ) );
	if ( $categories_list && twentysixteen_categorized_blog() ) {
		printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Categories', 'Used before category names.', 'twentysixteen' ),
			$categories_list
		);		
	}
}
endif;


// Masonry 
//wp_enqueue_script( 'masonry' );

function add_isotope() {
    wp_register_script( 'images_loaded', get_stylesheet_directory_uri().'/js/imagesloaded.pkgd.min.js', array('jquery'), true );
	wp_enqueue_script('images_loaded');	
	
    wp_register_script( 'isotope', get_stylesheet_directory_uri().'/js/isotope.pkgd.min.js', array('jquery'), true );
    wp_register_script( 'isotope-init', get_stylesheet_directory_uri().'/js/isotope.js', array('jquery', 'isotope'), true );
    wp_register_style( 'isotope-css', get_stylesheet_directory_uri() . '/css/isotope.css' );

    wp_enqueue_script('isotope-init');
    wp_enqueue_style('isotope-css');
}

add_action( 'wp_enqueue_scripts', 'add_isotope' );


// read more link
/**
 * Display post content with "more" link when applicable
 *
 * @since Tiny Framework 2.0.1
 
function tinyframework_post_content() {
	// translators: %s: Name of current post 
	the_excerpt( sprintf(
		__( 'hugo...<span class="screen-reader-text"> "%s"</span>', 'tinyframework' ),
		get_the_title()
	) );
}


add_action( 'wp_enqueue_scripts', 'tinyframework_post_content' );
*/

// Limiting the exceprt length
/*
function custom_excerpt_length( $length ) {
        return 20;
    }
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
*/	
	



// Managing CSS for specific pages
function register_foundation_style() {
  if ( is_single() or is_page() ) {
	wp_dequeue_style( 'screen' );
    wp_deregister_style( 'screen' );
	
    wp_enqueue_style( 'css_single', get_stylesheet_directory_uri() . '/css/style-single.css' );
  }
}
add_action( 'wp_enqueue_scripts', 'register_foundation_style' );




// Sidr Slide In/Out Menu for mobile devices
function sidr_footer() {

// output the static html for the side menus

echo ' <div id="sidr-left"> ';
wp_nav_menu( array( 'theme_location' => 'primary' ) );
echo ' </div> ';


/* output the two links */

echo ' <a href="#sidr-left" class="sidr-left-link">LEFT</a>
<a href="#sidr-right" class="sidr-right-link">RIGHT</a>';


/* hook up the Sidr functionality */

echo '
<script language="javascript">

jQuery(document).ready(function($){
// hook up the left side menu

$(".sidr-left-link").sidr({
name: "sidr-left",
side: "left"
});

// hook up the right side menu
$(".sidr-right-link").sidr({
name: "sidr-right",
side: "right"
});

});

</script>';

}

// add_action( 'wp_footer' , 'sidr_footer' );


function twentysixteen_child_gdd_translation() {
	if(pll_get_post( get_the_ID(), 'ja' ) != null){	
			$translation_ID = pll_get_post( get_the_ID(), 'ja' );	 	
			$translation_post = get_post($translation_ID);
			$translation = $translation_post->post_content;
			$translation = apply_filters('the_content', $translation);
			$translation = str_replace(']]>', ']]&gt;', $translation);
			return $translation;
	}
}

add_action( 'wp_enqueue_scripts', 'twentysixteen_child_gdd_translation' );


//Limiting excerpt by character instead of words count

/*
function get_excerpt($limit, $source = null){

//    if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
	if($source == "content"){
		$excerpt = get_the_content();	
	}
	else if ($source == "translation"){
		$excerpt = twentysixteen_child_gdd_translation();
	}
	else{
		get_the_excerpt();
	}
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'... <a href="'.get_permalink($post->ID).'">more</a>';
    return $excerpt;
}
*/

function twentysixteen_child_wp_trim_words( $text, $num_words = 55, $more = null ) {
    if ( null === $more ) {
        $more = __( '&hellip;' );
    }
 
    $original_text = $text;
    $text = wp_strip_all_tags( $text );
 
    /*
     * translators: If your word count is based on single characters (e.g. East Asian characters),
     * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
     * Do not translate into your own language.
     */
    if ( strpos( _x( 'characters_excluding_spaces', 'Word count type. Do not translate!' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
        $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
        preg_match_all( '/./u', $text, $words_array );
        $words_array = array_slice( $words_array[0], 0, $num_words + 1 );
        $sep = '';
    } else {
        $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
        $sep = ' ';
    }
 
    if ( count( $words_array ) > $num_words ) {
        array_pop( $words_array );
        $text = implode( $sep, $words_array );
        $text = $text . $more;
    } else {
        $text = implode( $sep, $words_array );
    }
 
    /**
     * Filters the text content after words have been trimmed.
     *
     * @since 3.3.0
     *
     * @param string $text          The trimmed text.
     * @param int    $num_words     The number of words to trim the text to. Default 5.
     * @param string $more          An optional string to append to the end of the trimmed text, e.g. &hellip;.
     * @param string $original_text The text before it was trimmed.
     */
    return apply_filters( 'twentysixteen_child_wp_trim_words', $text, $num_words, $more, $original_text );
}

