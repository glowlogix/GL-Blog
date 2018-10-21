<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Glowlogix Blog
 */

get_header();
?>
<div class="listingWrap">
  <div class="container">
<div class="pageTitle">
  	<h3><?php echo get_the_title(); ?></h3>
  </div>
    <div class="row">
      <div class="col-md-8"> 
	      	<div class="blogWraper">
	      		<div class="blogList blogdetailbox">
					<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', get_post_type() );
							//the_post_navigation();
							// If comments are open or we have at least one comment, load up the comment template.
							
						endwhile; // End of the loop.
					?>
	            </div><!-- #blogList blogdetailbox -->
	            <?php if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;?>
		    </div><!-- #blogWraper -->
      	</div><!-- #col-md-8 -->
      	

<div class="col-md-4">
        <?php get_sidebar();?>
</div>
<?php get_footer();?>
