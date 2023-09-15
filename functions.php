<?php
/**
 * cmk23 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cmk23
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	// define( '_S_VERSION', '1.0.1' );
	// Replace the version by the last modified time of style.css file.
	define( '_S_VERSION', filemtime( get_template_directory() . '/style.css' ) );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cmk23_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on cmk23, use a find and replace
		* to change 'cmk23' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'cmk23', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'cmk23' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cmk23_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'cmk23_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cmk23_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cmk23_content_width', 640 );
}
add_action( 'after_setup_theme', 'cmk23_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// ANCHOR - Register Widget Areas
function cmk23_widgets_init() {
	function gen_widget($id, $name){
		return array(
			'name'          => esc_html__( $name, 'cmk23' ),
			'id'            => $id,
			'description'   => esc_html__( 'Add widgets here.', 'cmk23' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		);
	}

	register_sidebar( gen_widget( "sidebar-1", "Sidebar" ) );
	register_sidebar( gen_widget( "footer-1", "Footer 1" ) );
	register_sidebar( gen_widget( "footer-2", "Footer 2" ) );
	register_sidebar( gen_widget( "footer-3", "Footer 3" ) );
	register_sidebar( gen_widget( "footer-4", "Footer 4" ) );
}
add_action( 'widgets_init', 'cmk23_widgets_init' );

// ANCHOR - Load Template Parts
function cmk32_get_template_part( $template_name, $part_name=null, $args = array() ) {
	ob_start();
	get_template_part($template_name, $part_name, $args);
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}

/**
 * Enqueue scripts and styles.
 */
function cmk23_scripts() {
	wp_enqueue_style( 'cmk23-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'cmk23-style', 'rtl', 'replace' );

	wp_enqueue_script( 'cmk23-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cmk23_scripts' );

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

/* Allow SVG
---------------------------------------- */

add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
  global $wp_version;
  if ( $wp_version !== '4.7.1' ) { return $data; }
  $filetype = wp_check_filetype( $filename, $mimes );
  return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
  ];
}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

/* Append JS Files
---------------------------------------- */
function my_javascripts() {
	wp_enqueue_script( 'theme-main-js', 
		get_template_directory_uri() . '/js/main.js',
		array(), 
		filemtime(get_template_directory() . '/js/main.js'),
	);

	wp_enqueue_script( 'swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js' );
	wp_enqueue_style( 'swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/css/swiper.min.css' );
}
add_action( 'wp_enqueue_scripts', 'my_javascripts' );

// ANCHOR - Add Admin CSS
function my_admin_theme_style() {
	wp_enqueue_script( 'theme-main', 
		get_template_directory_uri() . '/js/main.js',
		array(), 
		filemtime(get_template_directory() . '/js/main.js'),
	);
	wp_enqueue_style(
		'my-admin-theme',
		get_template_directory_uri() . '/adminstyle.css',
		array(),
		filemtime(get_template_directory() . '/adminstyle.css')
	);
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');

// ANCHOR - Add Plugin Update Checker
require get_template_directory() . '/puc/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://raw.githubusercontent.com/caminkunick/wp-theme-cmk23/main/theme.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'cmk23'
);

// ANCHOR - Svg Support
function cmk23_cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cmk23_cc_mime_types');

// ANCHOR - Shortcodes
require get_template_directory() . '/inc/shortcode-slideshow.php';
require get_template_directory() . '/inc/shortcode-jpaenc.php';
require get_template_directory() . '/inc/shortcode-highlight.php';
require get_template_directory() . '/inc/shortcode-staff.php';

// ANCHOR - Post Metabox
require get_template_directory() . '/inc/metabox-staff.php';

// ANCHOR - Add custom post type if not exists
function cmk23_add_custom_post_type() {
	if ( ! post_type_exists( 'book' ) ) {
		register_post_type( 'book',
			array(
				'labels' => array(
					'name' => __( 'Books' ),
					'singular_name' => __( 'Book' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'book'),
				'show_in_rest' => true,
				'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
				'menu_icon' => 'dashicons-book',
				'taxonomies' => array('post_tag','category'),
			)
		);
	}
	if ( ! post_type_exists( 'staff' ) ) {
		register_post_type( 'staff',
			array(
				'labels' => array(
					'name' => __( 'Staff' ),
					'singular_name' => __( 'Staff' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'staff'),
				'show_in_rest' => true,
				'supports' => array('title', 'editor', 'thumbnail'),
				'menu_icon' => 'dashicons-groups',
				'taxonomies' => array('post_tag','category'),
			)
		);
	}
}
add_action( 'init', 'cmk23_add_custom_post_type' );