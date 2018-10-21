<?php
/**
 * glblog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package glblog
 */

if ( ! function_exists( 'glblog_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function glblog_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on glblog, use a find and replace
		 * to change 'glblog' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'glblog', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'Top-menu' => esc_html__( 'Primary', 'glblog' ),
		) );
	    // This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'Main-menu' => esc_html__( 'Main', 'glblog' ),
		) );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'glblog_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;

add_action( 'after_setup_theme', 'glblog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function glblog_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'glblog_content_width', 640 );
}
add_action( 'after_setup_theme', 'glblog_content_width', 0 );



/**
 * Enqueue scripts and styles.
 */
function glblog_scripts() {
$js_dir = get_template_directory_uri() . "/js/";

$js_files = array("bootstrap.min", "nav",);

foreach($js_files as $file){
    $label = str_replace(".", "", $file);

    wp_register_script($label, $js_dir . $file . '.js', array('jquery'), '1.0.0');
    wp_enqueue_script($label);
}
/*
For Style sheet
*/
$css_dir = get_template_directory_uri() . "/css/";
$css_files = array("bootstrap.min.css", "font-awesome.min.css");

	foreach($css_files as $file){       
	    $label = str_replace(".", "", $file);

	    wp_register_style($label, $css_dir . $file, array(), '1.0', 'all');
	    wp_enqueue_style($label);
	}
	wp_enqueue_style( 'glblog-style', get_stylesheet_uri() );
/*
Font calling
*/	
$font_dir = get_template_directory_uri() . "/assets/fonts/";
$font_files = array("FontAwesome.otf", "fontawesome-webfont.eot","fontawesome-webfont.woff", "fontawesome-webfont.woff2","glyphicons-halflings-regular.eot","glyphicons-halflings-regular","glyphicons-halflings-regular","glyphicons-halflings-regular.woff","glyphicons-halflings-regular.woff2");
	foreach($font_files as $file){       
	    $label = str_replace(".", "", $file);

	    wp_register_style($label, $font_dir . $file, array(), '4.9.8', 'all');
	   wp_enqueue_style($label);
	}

}
add_action( 'wp_enqueue_scripts', 'glblog_scripts' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Widgets.
 */
require get_template_directory() . '/inc/template-tags.php';

// sample content importer
if(is_admin()){
	include_once('importer/importer.inc.php');
}
/*
Google Fonts
*/
function glblog_add_google_fonts() {
 
wp_enqueue_style( 'glblog-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300', false ); 
}
 wp_enqueue_style( 'glblog-google-fonts-2', 'https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i', false ); 

wp_enqueue_style( 'glblog-google-fonts-3', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900', false ); 

add_action( 'wp_enqueue_scripts', 'glblog_add_google_fonts' );


/*
For Excerpt
*/
function glblog_excerpt_more( $more ) {
	 if ( get_theme_mod( 'sample_default_radio' ) && get_theme_mod( 'sample_default_radio' ) == 'grid') {
   		return '....';
	} 
	else {
	    return '<a href="'. get_permalink($post->ID) . '">' . ' Continue Reading' . '</a>';
	} 
}
add_filter( 'excerpt_more', 'glblog_excerpt_more' );

function glblog_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'glblog_excerpt_length');


/*
For word count
*/
function word_count($string, $limit) {
 
$words = explode(' ', $string);
 
return implode(' ', array_slice($words, 0, $limit));
 
}
/*
FUNCTION FOR change blog layouts
*/

 
function glblog_page_template( $template ) {
 
	if ( get_theme_mod( 'sample_default_radio' ) && get_theme_mod( 'sample_default_radio' ) == 'grid' && is_home()) {
    	$new_template = locate_template( array( 'grid-template.php' ) );

	    if ( '' != $new_template ) {
	       $template = $new_template ;
	    }
	}
	return $template;
}


add_filter( 'template_include', 'glblog_page_template', 99 );
/*
For tags
*/
add_filter('get_terms_args','glblogtags');

function glblogtags($args) {
$args['hide_empty']=false;
return $args;
}


add_filter( 'get_search_form', 'glblog_search_form', 100 );
/*Function for Jquery Code*/
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});

//remove the URL field using this filter
function glblog_comment_fields($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','glblog_comment_fields');

function glblog_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;
return $fields;
}
 
add_filter( 'comment_form_fields', 'glblog_move_comment_field_to_bottom' );

//change text to leave a reply your comments form
function glblog_comment_reform ($arg) {
$arg['title_reply'] = __('Leave Your Comments', 'glblog');
return $arg;
}
add_filter('comment_form_defaults','glblog_comment_reform');

function glblog_commentform_title( $args ) {
        
	$args['title_reply_before'] = '<h4>';
  $args['title_reply_after']  = '</h4>';

	return  $args;
	
}
add_filter( 'comment_form_defaults', 'glblog_commentform_title' );

// customize message field of comment form
function glblog_comment_field($comment_field){
    $comment_field =
        '<li class="col-sm-12">
            <textarea required placeholder="MESSAGE" class="form-control" name="comment" aria-required="true"></textarea>
        </li>';
    return $comment_field;
}
add_filter('comment_form_field_comment', 'glblog_comment_field');

// create post comment button 
function glblog_comment_button() {
    echo '<input name="submit" type="submit" class="btn margin-top-20" value="Send">';
}
add_action( 'comment_form', 'glblog_comment_button' );

function glblog_comment_reply_text( $link ) {
$link = str_replace( 'Reply', '<i class="fa fa-reply" aria-hidden="true"></i>', $link );

return $link;
}
add_filter( 'comment_reply_link', 'glblog_comment_reply_text' );

function glblog_comment_reply_class( $class ) {
$class = str_replace("class='comment-reply-link", "class='btn btn-yellow raply", $class);
return $class;
}
add_filter( 'comment_reply_link', 'glblog_comment_reply_class' );

//Function for customize default design of comment template
function glblog_comment($comment, $args, $depth) {
   
   if ( 'div' != $args['style'] ) : ?>
          <?php endif; ?>
          <li class="media">
          <div class="media-left">
          	<a href="#"> 
           <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'], '', '',  array('class' => 'media-object img-responsive') ); ?>
           </a>
           </div>
          
          <?php if ( $comment->comment_approved == '0' ) : ?>
               <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'glblog' ); ?></em>
          <?php endif; ?>
          <div class="media-body">
          	 <h6 class="media-heading"><?php comment_author(); ?><span> <?php comment_date('M d, Y'); ?> - <?php comment_time('g:i A'); ?></span></h6>
            <?php comment_text(); ?>
            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
          </div>
      </li>
          <?php if ( 'div' != $args['style'] ) : ?>
    <?php endif; ?>
    <?php
}

function glblog_pagination() {

   if( is_singular() )
       return;

   global $wp_query;

   /** Stop execution if there's only 1 page */
   if( $wp_query->max_num_pages <= 1 )
       return;

   $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
   $max   = intval( $wp_query->max_num_pages );

   /** Add current page to the array */
   if ( $paged >= 1 )
       $links[] = $paged;

   /** Add the pages around the current page to the array */
   if ( $paged >= 3 ) {
       $links[] = $paged - 1;
       $links[] = $paged - 2;
   }

   if ( ( $paged + 2 ) <= $max ) {
       $links[] = $paged + 2;
       $links[] = $paged + 1;
   }

   echo '<div class="pagination-wrap"><ul class="pagination">' . "\n";

   /** Previous Post Link */
   if ( get_previous_posts_link() )
       printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

   /** Link to first page, plus ellipses if necessary */
   if ( ! in_array( 1, $links ) ) {
       $class = 1 == $paged ? ' class="active"' : '';

       printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

       if ( ! in_array( 2, $links ) )
           echo '<li>…</li>';
   }

   /** Link to current page, plus 2 pages in either direction if necessary */
   sort( $links );
   foreach ( (array) $links as $link ) {
       $class = $paged == $link ? ' class="active"' : '';
       printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
   }

   /** Link to last page, plus ellipses if necessary */
   if ( ! in_array( $max, $links ) ) {
       if ( ! in_array( $max - 1, $links ) )
           echo '<li>…</li>' . "\n";

       $class = $paged == $max ? ' class="active"' : '';
       printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
   }

   /** Next Post Link */
   if ( get_next_posts_link() )
       printf( '<li>%s</li>' . "\n", get_next_posts_link() );

   echo '</ul></div>' . "\n";

}
