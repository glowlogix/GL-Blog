<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Glowlogix Blog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="top-bar">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
    		<nav  class="top-nav">
    			<?php
    			wp_nav_menu( array(
    				'theme_location' => 'Top-menu',
    				'menu_id'        => 'primary-menu',
    			) );
    			?>
    		</nav><!-- #site-navigation -->
      </div>
      <div class="col-md-4">
        <div class="logo"> 			
        <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?> 
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/importer/media/logo.png">
        <?php endif; ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="top-social">
          <?php glblog_social_icons_output(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="navigationwrape" data-spy="affix" data-offset-top="197">
  <div class="container">
    <div class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="navbar-collapse collapse">
       			<?php
			wp_nav_menu( array(
				'theme_location' => 'Main-menu',
				'menu_id'        => 'main-menu',
				'items_wrap' => '<ul  class="nav navbar-nav">%3$s</ul>',
			) );
			?>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

