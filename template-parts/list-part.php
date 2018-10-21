<div class="listingWrap">
<div class="container">
 <?php if (! is_front_page() ) {?>
    <div class="pageTitle">
       <h3><?php single_post_title();?></h3>
     </div>
  <?php }?>
<div class="row">
<div class="col-md-8"> 
  <div class="blogWraper">
  <ul class="blogList">
    <?php
    $args =  array(  'post_type' => 'post',
            'posts_per_page' => 8,
        );
    $lastposts = get_posts( $args );
    foreach ( $lastposts as $post ) :setup_postdata( $post ); ?>
      <li>
        <div class="row">
          <div class="col-md-5 col-sm-5">
            <div class="postimg"><?php the_post_thumbnail();?>
              <div class="link">
               <i class="fa fa-bolt" aria-hidden="true"></i>
              </div>
            </div>
          </div>
          <div class="col-md-7 col-sm-7">
            <div class="post-header">
             <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
             <ul class="postmetadata">
                <li>By: <a href="<?php the_permalink(); ?>"><?php the_author(); ?> </a></li>
                | <li><i class="icon-bubble"></i><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
              </ul>
              <?php the_excerpt(); ?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; 
    wp_reset_postdata(); ?>
  </ul>
  <div class="pagiWrap">
    <div class="row">
      <div class="col-md-4 col-sm-6">
      <!--  <div class="showreslt">Showing 1-10</div> -->
      </div>
      <div class="col-md-8 col-sm-6 text-right">
        <?php glblog_pagination();?>
      </div>
    </div>
  </div>
  </div>
</div>