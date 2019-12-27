<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	

	<?php twentysixteen_excerpt(); ?>

	<?php twentysixteen_post_thumbnail(); ?>
    
    
    <!-- Multiple Feature Image -->
    <?php
    if( class_exists('Dynamic_Featured_Image') ) {
         global $dynamic_featured_image;
         $featured_images = $dynamic_featured_image -> get_featured_images( get_the_ID() );
		
        //You can now loop through the image to display them as required
        foreach( $featured_images as $image ) {
			
			echo '<div class="post-thumbnail">' . sf_create_responsive_image( $image['full'] ) . '</div>';
        }
     }
     ?>

	<!-- Category -->
	                <?php 
					/*
                    $terms = get_terms("category"); // get all categories, but you can use any taxonomy
                    $count = count($terms); //How many are they?
                    if ( $count > 0 ){  //If there are more than 0 terms
                        foreach ( $terms as $term ) {  //for each term:
                           echo "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
                            //create a list item with the current term slug for sorting, and name for label
                        }
                    } 
					*/
                ?>

    <!-- Taxonomies (Categories) -->
	<?php twentysixteen_entry_taxonomies(); ?>    

<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* Content of the post */
			wp_make_content_images_responsive( the_content() );
			/* Translation of the post */
//			echo '<span class="translation">' . twentysixteen_child_gdd_translation() . '</span>';	
		
			// CMB2 Images
			gdd_get_gallery_images( 'filelist', 'gdd-image', 'large');

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php // twentysixteen_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
