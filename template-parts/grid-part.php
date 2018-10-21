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
    <ul class="blogGrid row">  
      <?php
        $args = array( 'posts_per_page' =>8,
                'post_type' => 'post',
                'paged' => ( get_query_var('page') ? get_query_var('page') : 1)
        );
        $lastposts = get_posts( $args );
        foreach ( $lastposts as $post ) :setup_postdata( $post ); ?>
        <!-- Blog Box -->
        <li class="col-md-6 col-sm-6">
          <div class="int"> 
            <div class="postimg"><?php the_post_thumbnail(array(318, 200));?></div>              
            <div class="post-header">
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <ul class="postmetadata">
                <li>By: <a href="<?php the_permalink(); ?>"><?php the_author(); ?> </a></li>| 
                <li><i class="icon-bubble"></i>
                  <a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
                </li>
              </ul>
            </div>
            <?php the_excerpt();
             ?> 
             <a href="<?php the_permalink(); ?>" class="readmore">Read More</a>
          </div>
        </li>
        <?php endforeach; 
      wp_reset_postdata(); ?>
    </ul>
  </div>
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