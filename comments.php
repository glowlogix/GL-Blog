<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Glowlogix Blog
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="comments margin-top30">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h4 class="comments-title">
			<?php
			$glblog_comment_count = get_comments_number();
			if ( '1' === $glblog_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'glblog' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $glblog_comment_count, 'comments title', 'glblog' ) ),
					number_format_i18n( $glblog_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h4><!-- .comments-title -->
		<?php endif; // Check for have_comments().?>

		<?php the_comments_navigation(); ?>

		<ul class="media-list">
			<?php
				wp_list_comments( 'type=comment&callback=glblog_comment' );
			?>
		</ul><!-- .comment-list -->

		<div class="commnetsfrm">
		<?php
		the_comments_navigation();
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'glblog' ); ?></p>
			<?php
		endif;
	
	$fields =  array(
        'author' => '<ul class="row"><li class="col-sm-6"><label>' . '<input class="form-control" id="author" name="author" type="text" placeholder="' . esc_attr__( "Name", "text-domain" ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size=""' . $aria_req . ' /></label></li>',
        'email'  => '<li class="col-sm-6"><label>' .  '<input class="form-control" name="email" type="text" placeholder="' . esc_attr__( "Email", "text-domain" ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size=""' . $aria_req . ' /></label></li>',

    );
    comment_form(array('fields'=>$fields));
	?>
</div>
</div><!-- #comments -->



