<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="sticky-post"><?php _e( 'Featured', 'twentysixteen' ); ?></span>
		<?php endif; ?>
        
        <!--new position: meta entry -->
        
        <?php 
		//	$category = get_the_category();
		//	echo $category[0] -> cat_name;
		?>
        
        <!-- Category -->      
		<?php // twentysixteen_child_gdd_entry_meta(); ?>        
        
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->

	<?php twentysixteen_excerpt(); ?>

	<!-- Content -->
	<div class="entry-content">
    	<!-- Adding permalink to content -->
    	<a href="<?php echo get_permalink(); ?>">
		<?php
		
		
				
			/* translators: %s: Name of current post */

			$lang = ( function_exists( 'pll_current_language' ) ) ? pll_current_language() : 'en';
			
			if( $lang == 'en' ) {
				$content = strip_shortcodes( twentysixteen_child_wp_trim_words( get_the_content(), 700, ' ...' ) );
			}
			else{
				$content = strip_shortcodes( twentysixteen_child_wp_trim_words( get_the_content(), 500, ' ...' ) );
			}
			
			echo gdd_remove_links( $content );

			
//			echo gdd_remove_links( wp_strip_all_tags( get_the_content() ) );
			
//			echo strip_shortcodes( twentysixteen_child_wp_trim_words( get_the_content(), 500, ' ...' ) );
//			echo '<br /><span class="translation">' . twentysixteen_child_wp_trim_words( twentysixteen_child_gdd_translation(), 300, ' ...' ) . '</span>';		
			// echo get_excerpt(140, 'content'); //excerpt is grabbed from get_the_content
			// echo get_excerpt(140, 'translation');
			
			
		//	echo twentysixteen_child_gdd_translation();			
			
			
			/*
			the_content( sprintf(
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
				get_the_title()
			) );	

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		*/	
		?> 
        </a>
	</div><!-- .entry-content -->
    
    <!-- Thumbnail -->
    <?php twentysixteen_post_thumbnail(); ?>

	<footer class="entry-footer">
		<!--old position: meta entry -->
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
