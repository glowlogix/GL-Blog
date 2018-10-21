<?php
/**
 * Glowlogix Theme Customizer
 *
 * @package Glowlogix Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
require_once get_template_directory() . '/inc/custom-controls.php';

function glblog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'glblog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'glblog_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'glblog_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function glblog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function glblog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function glblog_customize_preview_js() {
	wp_enqueue_script( 'glblog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'glblog_customize_preview_js' );
/*
Socail icon area
*/
function glblog_social_array() {

	$social_sites = array(
		'facebook'      => 'glblog_facebook_profile',
		'twitter'       => 'glblog_twitter_profile',
		'linkedin'      => 'glblog_linkedin_profile',
		'youtube'       => 'glblog_youtube_profile',
		'google-plus'   => 'glblog_googleplus_profile',
		'pinterest'     => 'glblog_pinterest_profile',
	);

	return apply_filters( 'glblog_social_array_filter', $social_sites );
}
/*
Socail 2
*/
function glblog_socail_icon_section( $wp_customize ) {

	$social_sites = glblog_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'glblog_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'glblog' ),
		'priority'    => 25,
		'description' => __( 'Add the URL for each of your social profiles.', 'glblog' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {

		$label = ucfirst( $social_site );

		if ( $social_site == 'google-plus' ) {
			$label = 'Google Plus';
		} elseif ( $social_site == 'rss' ) {
			$label = 'RSS';
		} elseif ( $social_site == 'soundcloud' ) {
			$label = 'SoundCloud';
		} elseif ( $social_site == 'slideshare' ) {
			$label = 'SlideShare';
		} elseif ( $social_site == 'codepen' ) {
			$label = 'CodePen';
		} elseif ( $social_site == 'stumbleupon' ) {
			$label = 'StumbleUpon';
		} elseif ( $social_site == 'deviantart' ) {
			$label = 'DeviantArt';
		} elseif ( $social_site == 'hacker-news' ) {
			$label = 'Hacker News';
		} elseif ( $social_site == 'whatsapp' ) {
			$label = 'WhatsApp';
		} elseif ( $social_site == 'qq' ) {
			$label = 'QQ';
		} elseif ( $social_site == 'vk' ) {
			$label = 'VK';
		} elseif ( $social_site == 'wechat' ) {
				$label = 'WeChat';
		} elseif ( $social_site == 'tencent-weibo' ) {
			$label = 'Tencent Weibo';
		} elseif ( $social_site == 'paypal' ) {
			$label = 'PayPal';
		} elseif ( $social_site == 'email-form' ) {
			$label = 'Contact Form';
		}
		// setting
		$wp_customize->add_setting( $social_site, array(
			'sanitize_callback' => 'esc_url_raw'
		) );
		// control
		$wp_customize->add_control( $social_site, array(
			'type'     => 'url',
			'label'    => $label,
			'section'  => 'glblog_social_media_icons',
			'priority' => $priority
		) );
		// increment the priority for next site
		$priority = $priority + 5;
	}
}
add_action( 'customize_register', 'glblog_socail_icon_section' );
/*Socail 3*/
function glblog_load_scripts_styles() {
    wp_enqueue_style( 'font-awesome2', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome2.min.css' );
}
add_action( 'wp_enqueue_scripts', 'glblog_load_scripts_styles' );
/*Socail 4*/
function glblog_social_icons_output() {

	$social_sites = glblog_social_array();

	foreach ( $social_sites as $social_site => $profile ) {

		if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
			$active_sites[ $social_site ] = $social_site;
		}
	}

	if ( ! empty( $active_sites ) ) {

		echo '<ul class="social-media-icons">';
		foreach ( $active_sites as $key => $active_site ) { 
        	$class = 'fa fa-' . $active_site."-square"; ?>
		 	<li>
				<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank" href="<?php echo esc_url( get_theme_mod( $key ) ); ?>">
					<i class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $active_site ); ?>"></i>
				</a>
			</li>
		<?php } 
		echo "</ul>";
	}
} 
/*
For Customizer
*/

/*
 * Register Our Customizer Stuff Here
 */
function glblog_register_theme_customizer( $wp_customize ) {
	// Create custom panel.
	$wp_customize->add_panel( 'text_blocks', array(
		'priority'       => 500,
		'theme_supports' => '',
		'title'          => __( 'Footer Text', 'glblog' ),
		'description'    => __( 'Set editable text for certain content.', 'glblog' ),
	) );
	// Add Footer Text
	// Add section.
	$wp_customize->add_section( 'custom_footer_text' , array(
		'title'    => __('Copyright','glblog'),
		'panel'    => 'text_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'footer_text_block', array(
		 'default'           => __( 'default text', 'glblog' ),
		 //'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_text',
		    array(
		        'label'    => __( 'Footer Text', 'glblog' ),
		        'section'  => 'custom_footer_text',
		        'settings' => 'footer_text_block',
		        'type'     => 'text'
		    )
	    )
	);
 	// Sanitize text
	function glblog_text( $text ) {
	    return glblog_text_field( $text );
	}
}
add_action( 'customize_register', 'glblog_register_theme_customizer' );
/*
For Banner image on fron page
*/
/**
 * Add our Sample Section
 */
function glblog_banner_customize_register($wp_customize){
    

$wp_customize->add_section(
    'tcx_advanced_options',
    array(
        'title'     => 'Banner',
        'priority'  => 201
    )
);
$wp_customize->add_setting(
    'tcx_background_image',
    array(
        'default'      => '',
        'transport'    => 'postMessage',
        'sanitize_callback' => 'esc_attr'
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'tcx_background_image',
        array(
            'label'    => 'Background Image',
            'settings' => 'tcx_background_image',
            'section'  => 'tcx_advanced_options'
        )
    )
);
}
add_action('customize_register', 'glblog_banner_customize_register');
/**
 * Add our Customizer content
 */
function glblog_blog_templelate_change( $wp_customize ) {
    $wp_customize->add_section(
    	'default_controls_section',
	    array(
	        'title'     => 'Blog Template change',
	        'priority'  => 100
	    )
    );


	$wp_customize->add_setting( 'sample_default_radio',
	   array(
	      'default' => '',
	      'transport' => 'refresh',
	      //'sanitize_callback' => 'skyrocket_radio_sanitization'
	      'sanitize_callback' => 'esc_attr',
	   )
	);
 
	$wp_customize->add_control( 'sample_default_radio',
	   array(
	      'label' => __( 'Change blog layout', 'glblog' ),
	      'description' => esc_html__( 'Choose your layout', 'glblog'),
	      'section' => 'default_controls_section',
	      'priority' => 10, // Optional. Order priority to load the control. Default: 10
	      'type' => 'radio',
	      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
	      'default' => 'list',
	      'choices' => array( // Optional.
	         'grid' => __( 'Grid', 'glblog'),
	         'list' => __( 'List', 'glblog')
	      )
	   )
	);
}
add_action( 'customize_register', 'glblog_blog_templelate_change' );


/**
 * Add Featured Post Section
 */
function glblog_featured_customize_register($wp_customize){
	$wp_customize->add_panel( 'glblog-feature-panel', array(
    'priority'       => 105,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Featured Section Options', 'glblog' ),
    'description'    => __( 'Customize your awesome site feature section ', 'glblog' )
) );

/*adding sections for feature side for front page */
$wp_customize->add_section( 'glblog-feature-side', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Featured Post', 'glblog' ),
    'panel'          => 'glblog-feature-panel'
) );

/*slider side post one*/
$wp_customize->add_setting( 'glblog-feature-post-one', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['glblog-feature-post-one'],
    // 'sanitize_callback' => 'glblog_sanitize_page'
) );
$wp_customize->add_control(
    new glblog_Customize_Post_Dropdown_Control(
        $wp_customize,
        'glblog-feature-post-one',
        array(
            'label'		=> __( 'Select Post One', 'glblog' ),
            'section'   => 'glblog-feature-side',
            'settings'  => 'glblog-feature-post-one',
            'type'	  	=> 'post_dropdown',
            'priority'  => 55
        )
    )
);

/*slider side post two*/
$wp_customize->add_setting( 'glblog-feature-post-two', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['glblog-feature-post-two'],
    // 'sanitize_callback' => 'glblog_sanitize_page'
) );
$wp_customize->add_control(
    new glblog_Customize_Post_Dropdown_Control(
        $wp_customize,
        'glblog-feature-post-two',
        array(
            'label'		=> __( 'Select Post Two', 'glblog' ),
            'section'   => 'glblog-feature-side',
            'settings'  => 'glblog-feature-post-two',
            'type'	  	=> 'post_dropdown',
            'priority'  => 60
        )
    )
);

/*slider side post three*/
$wp_customize->add_setting( 'glblog-feature-post-three', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['glblog-feature-post-three'],
    // 'sanitize_callback' => 'glblog_sanitize_page'
) );
$wp_customize->add_control(
    new glblog_Customize_Post_Dropdown_Control(
        $wp_customize,
        'glblog-feature-post-three',
        array(
            'label'		=> __( 'Select Post Three', 'glblog' ),
            'section'   => 'glblog-feature-side',
            'settings'  => 'glblog-feature-post-three',
            'type'	  	=> 'post_dropdown',
            'priority'  => 60
        )
    )
);

}
add_action('customize_register', 'glblog_featured_customize_register');