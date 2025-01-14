<?php
/**
 * CreativeDisturbance functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CreativeDisturbance
 */

function displayVar() {
  $args = func_get_args();
  foreach ($args as $arg)
    echo '<pre>' . var_export($arg, true) . '</pre>';
}

if ( ! function_exists( 'creativedisturbance_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function creativedisturbance_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CreativeDisturbance, use a find and replace
		 * to change 'creativedisturbance' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'creativedisturbance', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'creativedisturbance' ),
		) );

    register_nav_menus( array(
      'primary' => __( 'Bootstrap Menu', 'creativedisturbance'),
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
		add_theme_support( 'custom-background', apply_filters( 'creativedisturbance_custom_background_args', array(
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
add_action( 'after_setup_theme', 'creativedisturbance_setup' );

function my_theme_archive_title( $title ) {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  } elseif ( is_author() ) {
    $title = '<span class="vcard">' . get_the_author() . '</span>';
  } elseif ( is_post_type_archive() ) {
    $title = post_type_archive_title( '', false );
  } elseif ( is_tax() ) {
    $title = single_term_title( '', false );
  }

  return $title;
}

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function creativedisturbance_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'creativedisturbance_content_width', 640 );
}
add_action( 'after_setup_theme', 'creativedisturbance_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function creativedisturbance_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'creativedisturbance' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'creativedisturbance' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'creativedisturbance_widgets_init' );

add_filter( 'body_class', 'custom_explore_class');
function custom_explore_class( $classes ) {
  if ( is_page('Explore'))
    $classes[] = 'explore-page';

  return $classes;
}

/**
 * Enqueue scripts and styles.
 */
function creativedisturbance_scripts() {
  wp_enqueue_style('raleway', 'https://fonts.googleapis.com/css?family=Raleway:300,400,400i,600,700');

	wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');

	wp_enqueue_script('jquery-slim', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array(), '3.3.1', true);

	wp_enqueue_script( 'popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array(), '1', true );
  wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array(), '1', true );

	wp_enqueue_script( 'creativedisturbance-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if (is_front_page()) {
    wp_enqueue_style('mapbox-style', 'https://api.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css');
	  wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js');
    wp_enqueue_script('map', get_template_directory_uri() . '/js/map.js', array(), '0.0.1', true);
  }

  if (is_page('Explore')) {
    wp_enqueue_script('slimselect', 'https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.7/slimselect.min.js', array(), '1.18.7', true);
    wp_enqueue_style('slimselect-style', 'https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.7/slimselect.min.css');
    wp_enqueue_script('map', get_template_directory_uri() . '/js/explore.js', array(), '0.0.1', true);
  }

  if (is_page('People')) {
    wp_enqueue_script('peopleFilter', get_template_directory_uri() . '/js/people-filter.js', array(), '0.0.1', true);
  }

  wp_enqueue_style( 'creativedisturbance-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'creativedisturbance_scripts' );

if ( ! file_exists( get_template_directory() . '/class-wp-bootstrap-navwalker.php' ) ) {
  // file does not exist... return an error.
  return new WP_Error( 'class-wp-bootstrap-navwalker-missing', __( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
  // file exists... require it.
  require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Custom CSS for the login page
// Create wp-login.css in your theme folder
function wpfme_loginCSS() {
  echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/style.css"/>';
}
add_action('login_head', 'wpfme_loginCSS');

// Filter wp_nav_menu() to add additional links and other output
function new_nav_menu_items($items) {
  $dropdownOpen = '<li itemscope="itemscope" id="menu-item-108" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children dropdown menu-item-108 nav-item"><a title="Channels" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-108">Channels</a><ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-108" id="channels-dropdown" role="menu">';

	$dropdownClose = '<li itemscope="itemscope" id="menu-item-141" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-141 nav-item"><a title="All Channels" href="' . get_site_url( null, '/channels', null) . '" class="dropdown-item">All Channels</a></li></ul></li>';

	$newItem = $dropdownOpen;

  $channelParams = array(
    'limit' => 15
  );
  $channels = pods('series', $channelParams);
  while($channels->fetch()) {
    $name = $channels->display('name');
    $id = $channels->display('term_id');
    $link = get_term_link($id);

    $newItem = $newItem . '<li itemscope="itemscope" class="menu-item menu-item-type-taxonomy menu-item-object-series nav-item"><a title="Papo ArteCiência" href="' . $link . '" class="dropdown-item">' . $name . '</a></li>';
  }
  $newItem = $newItem . $dropdownClose;

  $items = $newItem . $items;
  return $items;
}
add_filter( 'wp_nav_menu_items', 'new_nav_menu_items' );