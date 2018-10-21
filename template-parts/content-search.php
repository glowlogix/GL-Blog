<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Glowlogix Blog
 */

?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
	  <div class="col-md-5 col-sm-5">
	    <div class="postimg"><?php glblog_post_thumbnail();?>
	      <div class="link">
	       <i class="fa fa-bolt" aria-hidden="true"></i>
	      </div>
	    </div>
	  </div>
	  <div class="col-md-7 col-sm-7">
	    <div class="post-header">
	     <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	     <?php if ( 'post' === get_post_type() ) : ?>
	     <ul class="postmetadata">
	        <li>By: <a href="<?php the_permalink(); ?>"><?php the_author(); ?> </a></li>
	        | <li><i class="icon-bubble"></i><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
	      </ul>
	      <?php endif; ?>
	      <?php the_excerpt(); ?>
	    </div>
	  </div>
	</div>
</li>
