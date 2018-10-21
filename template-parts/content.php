<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Glowlogix Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<?php glblog_post_thumbnail(); ?>
		<header class="post-header margin-top30">
		<?php
		if ( is_singular() ) :
			the_title( '<h4 class="post-header margin-top30">', '</h4>' );
		else :
			the_title( '<h2 class="post-header margin-top30"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<ul class="postmetadata">
				<li><?php
				glblog_posted_by();
								
				?>
			    </li>
			    <li>
			    <?php glblog_posted_on(); ?>
			    	
			    </li>
			</ul><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->


		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'glblog' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'glblog' ),
			'after'  => '</div>',
		) );
		?>


	<footer class="entry-footer">
		<?php //glblog_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
