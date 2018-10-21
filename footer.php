<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Glowlogix Blog
 */

?>

      </div>
    </div>
  </div>
</div>
<div class="footer">
	<?php echo get_theme_mod( 'footer_text_block' ); ?>
<?php echo get_theme_mod( 'panel_id' ); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
