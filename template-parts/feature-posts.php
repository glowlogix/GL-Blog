<?php 
$glblog_feature_post_ids = array();
$glblog_feature_post_ids[] = get_theme_mod( 'glblog-feature-post-one');

$glblog_feature_posts_ids = array();
$glblog_feature_posts_ids[] = get_theme_mod( 'glblog-feature-post-two');
$glblog_feature_posts_ids[] = get_theme_mod( 'glblog-feature-post-three');
?>
  <!-- Featured post -->
<div class="sliderWrap">
  <div class="container">
    <div class="row">
      <?php 
      $args = array(
          'post_type' => 'post',
          'posts_per_page' => 1,
          'post__in' => $glblog_feature_post_ids,
          'orderby' => 'post__in',
        );
        $the_query = new WP_Query($args);
      if ( $the_query->have_posts() ) :  
      ?>
      <?php while ( $the_query->have_posts() ) : $the_query->the_post();?>
      <div class="col-lg-8">
        <div class="mainblogpost">
          <div class="postimg"> <?php the_post_thumbnail(); ?> </div>
          <div class="postinfo">
            <div class="heading_one"><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></div>
            <ul class="postmeta_data">
              <li>By: <a href="<?php the_permalink(); ?>"><?php the_author(); ?> </a></li>
              |
              <li><i class="icon-bubble"></i><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
            </ul>
            <?php the_excerpt();?> 
          </div>
        </div>
      </div>
      <?php endwhile; endif;?>
      <div class="col-lg-4">
        <div class="row">
          <?php
            $args1 = array(
                'post_type' => 'post',
                'posts_per_page' => 2,
                'post__in' => $glblog_feature_posts_ids,
                'orderby' => 'post__in',
            );
              // the query
              $the_query1 = new WP_Query($args1); 
              if ( $the_query1->have_posts() ) :
                while ( $the_query1->have_posts() ) : $the_query1->the_post();
          ?>
          <div class="col-lg-12 col-md-6">
            <div class="subposts">
              <div class="postimg"> <?php the_post_thumbnail( array(360, 200)); ?> </div>
              <div class="postinfo">
                <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>
                <ul class="postmeta_data">
                  <li>By: <a href="<?php the_permalink(); ?>"><?php the_author(); ?> </a></li>
                  |
                  <li><i class="icon-bubble"></i><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
                </ul>
              </div>
            </div>
          </div>
          <?php endwhile; endif;?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Featured post -->

<!-- Popular post -->
<div class="newsWrap">
  <div class="container">
    <div class="row">
      <?php
        $args3 = array(
            'post_type' => 'post',
            'orderby'   => 'rand',
            'posts_per_page' => 4,
        );
        $the_query3 = new WP_Query($args3); 
         if ( $the_query3->have_posts() ) :
         while ( $the_query3->have_posts() ) : $the_query3->the_post();
      ?>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="blogNew">
          <div class="blogImg"><?php the_post_thumbnail(array(263, 200)); ?></div>
            <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>
            <ul class="postmetadata">
              <li>By: <a href="<?php the_permalink(); ?>"><?php the_author(); ?></a></li>
              |
              <li><i class="icon-bubble"></i><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
            </ul>
        </div>
      </div>
      <?php endwhile; endif;?>
    </div>
  </div>
</div>
<!-- End Popular post -->
<div class="bannerWrap">
<div class="container">
  <div class="banner-img"><img src="<?php echo get_theme_mod('tcx_background_image'); ?> "></div>
  </div>
</div>