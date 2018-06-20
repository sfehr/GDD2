<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>


			<!-- Category Overview -->

                <?php 
                    $terms = get_terms("category"); // get all categories, but you can use any taxonomy
                    $count = count($terms); //How many are they?
					/*
                    if ( $count > 0 ){  //If there are more than 0 terms
                        foreach ( $terms as $term ) {  //for each term:
                           echo "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
                            //create a list item with the current term slug for sorting, and name for label
                        }
                    } 
					*/
                ?>
                </ul>
			
            
            <!-- Isotope: Loop-->
            <?php 
                 $terms_ID_array = array();
                 foreach ($terms as $term)
                 {
                     $terms_ID_array[] = $term->term_id; // Add each term's ID to an array
                 }
                 $terms_ID_string = implode(',', $terms_ID_array); // Create a string with all the IDs, separated by commas
                 $the_query = new WP_Query( 'posts_per_page=50&cat='.$terms_ID_string ); // Display 50 posts that belong to the categories in the string 
            ?>
            
            <?php if ( $the_query->have_posts() ) : ?>
	            <!-- Isotope-list Grid Wrapper -->
                <div id="isotope-list">
                
                <!-- for fluid layout -->
                 <div class="grid-sizer"></div> 
                 <div class="gutter-sizer"></div>
                
                <!-- Starting the Loop -->
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
                $termsArray = get_the_terms( $post->ID, "category" );  //Get the terms for this particular item
                $termsString = ""; //initialize the string that will contain the terms
                    foreach ( $termsArray as $term ) { // for each term 
                        $termsString .= $term->slug.' '; //create a string that has all the slugs 
                    }
                ?> 
                <div class="<?php echo $termsString; ?> item"> <?php // 'item' is used as an identifier (see Setp 5, line 6) ?>
                    
                    <!-- Category -->
					<?php echo "<a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a>"; ?>
                    
                   <?php get_template_part( 'template-parts/content', get_post_format() ); ?>
                                     
                    
                </div> <!-- end item -->
                <?php endwhile;  ?>
                </div><!-- end isotope-list -->
            <?php endif; ?>
			
			<?php
			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentysixteen' ),
				'next_text'          => __( 'Next page', 'twentysixteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
        
            <div class="filters">                
                <?php 
                    $terms = get_terms("category"); // get all categories, but you can use any taxonomy
                    $count = count($terms); //How many are they?
                    if ( $count > 0 ){  //If there are more than 0 terms
                        foreach ( $terms as $term ) {  //for each term:
                           echo "<div><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></div>";
                            //create a list item with the current term slug for sorting, and name for label
                        }
                    } 
                ?>
                <br>               
                <div class="cat-everything"><a class="selected" href="#" data-filter="*">All Categories</a></div>
                </div>        

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>


