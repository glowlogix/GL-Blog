<?php
/**
 * The Blog template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Glowlogix Blog
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
  <!-- pagination here -->
  <!-- the loop -->


<?php
  if ( get_theme_mod( 'sample_default_radio' ) && get_theme_mod( 'sample_default_radio' ) == 'grid') {
      get_template_part( '/template-parts/grid-part', 'none' );    
  }
  else{
    get_template_part( '/template-parts/list-part', 'none' );
  }

?>
<div class="col-md-4">
        <?php get_sidebar();?>
</div>
<?php get_footer();?>