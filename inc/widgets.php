<?php
/*
For Widget Area
*/
/**
 * Extend Recent Posts Widget 
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function glblog_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'glblog' ),
    'id'            => 'sidebar-1',
    'description'   => esc_html__( 'Add widgets here.', 'glblog' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h5 class="widget-title">',
    'after_title'   => '</h5>',
  ) );

  register_sidebar( array(
    'name' => 'Footer Sidebar 1',
    'id' => 'footer-sidebar-1',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );
  register_sidebar( array(
    'name' => 'Footer Sidebar 2',
    'id' => 'footer-sidebar-2',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );
}
add_action( 'widgets_init', 'glblog_widgets_init' );


Class glblog_Recent_Posts_Widget extends WP_Widget_Recent_Posts {

        function widget($args, $instance) {

                if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }

            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'glblog' );

            /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
            if ( ! $number )
                $number = 5;
            $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

            /**
             * Filter the arguments for the Recent Posts widget.
             *
             * @since 3.4.0
             *
             * @see WP_Query::get_posts()
             *
             * @param array $args An array of arguments used to retrieve the recent posts.
             */
            $r = new WP_Query( apply_filters( 'widget_posts_args', array(
                'posts_per_page'      => $number,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true
            ) ) );

            if ($r->have_posts()) :
            ?>
            <?php echo $args['before_widget']; ?>
            <?php if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            } ?>
            <ul class="papu-post">
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                    <div class="media-left"><a><?php the_post_thumbnail( array(120, 90) ); ?></a></div>
              <div class="media-body"><a class="media-heading" href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                <?php if ( $show_date ) : ?>  
                    <span class="post-date">
                    	<?php
                         echo word_count(get_the_excerpt(), '6');?>
                    	</span>
                <?php endif; ?>
                
                </li>
            <?php endwhile; ?>
            </ul>
            <?php echo $args['after_widget']; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

            endif;
        }
}
function glblog_recent_widget_registration() {
  unregister_widget('WP_Widget_Recent_Posts');
  register_widget('glblog_Recent_Posts_Widget');
}
add_action('widgets_init', 'glblog_recent_widget_registration');

/*
Function for Categories
*/
function glblog_empty_cats($cat_args) {
    $cat_args['hide_empty'] = 0;
    return $cat_args;
}
add_filter( 'widget_categories_args', 'glblog_empty_cats' );

/*
Function for search widget
*/
function glblog_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div class="search">
    <input type="text" class="form-control" placeholder="Search" value="' . get_search_query() . '" name="s" id="s" />
   <button type="submit" class="btn"><i class="fa fa-search" value=""></i></button>
    </div>
    </form>';
    return $form;
}