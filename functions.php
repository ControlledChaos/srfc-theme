<?php
/**
 * Sequoia Riverfront Cabins Theme functions
 *
 * @package    WordPress
 * @subpackage Sequoia_Riverfront_Cabins
 * @author     Greg Sweet <greg@ccdzine.com>
 * @copyright  Copyright (c) Greg Sweet
 * @link       https://github.com/ControlledChaos/srfc-theme
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0.0
 */

namespace SRFC_Theme\Functions;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Define the companion plugin path: directory and core file name.
 *
 * This theme is designed to coordinate with a companion plugin.
 * Change the following path to the new name of the starter companion
 * plugin, found at the following link.
 *
 * @link   https://github.com/ControlledChaos/srfc-plugin
 *
 * @since  1.0.0
 * @return string Returns the plugin path.
 */
if ( ! defined( 'SRFC_PLUGIN' ) ) {
	define( 'SRFC_PLUGIN', 'srfc-plugin/srfc-plugin.php' );
}

/**
 * Define the companion plugin prefix for filters and options.
 *
 * The default prefix of Sequoia Riverfront Cabins is `srfc`. If you
 * have renamed the companion plugin then change the prefix here.
 *
 * Do not include a trailing hyphen (-) or an trailibg underscore (_).
 *
 * @link   https://github.com/ControlledChaos/srfc-plugin
 *
 * @since  1.0.0
 * @return string Returns the prefix without trailing character.
 */
if ( is_plugin_active( SRFC_PLUGIN ) && ! defined( 'SRFC_PLUGIN_PREFIX' ) ) {
	define( 'SRFC_PLUGIN_PREFIX', 'srfc' );
}

/**
 * Sequoia Riverfront Cabins functions class
 *
 * @since  1.0.0
 * @access public
 */
final class Functions {

	/**
	 * Return the instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {

			$instance = new self;

			// Theme dependencies.
			$instance->dependencies();

		}

		return $instance;
	}

	/**
	 * Constructor magic method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Swap html 'no-js' class with 'js'.
		add_action( 'wp_head', [ $this, 'js_detect' ], 0 );

		// Theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup' ] );

		// Register widgets.
        add_action( 'widgets_init', [ $this, 'widgets' ] );

		// Disable custom colors in the editor.
		add_action( 'after_setup_theme', [ $this, 'editor_custom_color' ] );

		// Remove unpopular meta tags.
		add_action( 'init', [ $this, 'head_cleanup' ] );

		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

		// Admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );

		// Frontend styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_styles' ] );

		/**
		 * Admin styles.
		 *
		 * Call late to override plugin styles.
		 */
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ], 99 );

		// Login styles.
		add_action( 'login_enqueue_scripts', [ $this, 'login_styles' ] );

		// jQuery UI fallback for HTML5 Contact Form 7 form fields.
		add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

		// Remove WooCommerce styles.
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	}

	/**
	 * JS Replace
	 *
	 * Replaces 'no-js' class with 'js' in the <html> element
	 * when JavaScript is detected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function js_detect() {

		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

	}

	/**
	 * Theme setup
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup() {

		/**
		 * Load domain for translation.
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'srfc-theme' );

		/**
		 * Add theme support.
		 *
		 * @since 1.0.0
		 */

		// Browser title tag support.
		add_theme_support( 'title-tag' );

		// Background color & image support.
		add_theme_support( 'custom-background' );

		// RSS feed links support.
		add_theme_support( 'automatic-feed-links' );

		// HTML 5 tags support.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gscreenery',
			'caption'
		 ] );

		// Register post formats.
		add_theme_support( 'post-formats', [
			'aside',
			'gscreenery',
			'video',
			'image',
			'audio',
			'link',
			'quote',
			'status',
			'chat'
		 ] );

		/**
		 * Color arguments.
		 *
		 * Some admin colors used here for demonstration.
		 */
		$color_args = [
			[
				'name'  => __( 'Dark Gray', 'srfc-theme' ),
				'slug'  => 'srfc-dark-gray',
				'color' => '#333333',
			],
			[
				'name'  => __( 'Gray', 'srfc-theme' ),
				'slug'  => 'srfc-gray',
				'color' => '#888888',
			],
			[
				'name'  => __( 'Pale Gray', 'srfc-theme' ),
				'slug'  => 'srfc-pale-gray',
				'color' => '#cccccc',
			],
			[
				'name'  => __( 'White', 'srfc-theme' ),
				'slug'  => 'srfc-white',
				'color' => '#ffffff',
			]
		];

		// Apply a filter to editor arguments.
		$colors = apply_filters( 'srfc_editor_colors', $color_args );

		// Add color support.
		add_theme_support( 'editor-color-palette', $colors );

		add_theme_support( 'align-wide' );

		/**
		 * Add theme support.
		 *
		 * @since 1.0.0
		 */

		// Customizer widget refresh support.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		// TODO: add Fancybox to WC products.
		// add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Beaver Builder support.
		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );

		// Featured image support.
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add image sizes.
		 *
		 * Three sizes per aspect ratio so that WordPress
		 * will use srcset for responsive images.
		 *
		 * @since 1.0.0
		 */

		// 16:9 HD Video.
		add_image_size( __( 'video', 'srfc-theme' ), 1280, 720, true );
		add_image_size( __( 'video-md', 'srfc-theme' ), 960, 540, true );
		add_image_size( __( 'video-sm', 'srfc-theme' ), 640, 360, true );

		// 21:9 Cinemascope.
		add_image_size( __( 'banner', 'srfc-theme' ), 1280, 549, true );
		add_image_size( __( 'banner-md', 'srfc-theme' ), 960, 411, true );
		add_image_size( __( 'banner-sm', 'srfc-theme' ), 640, 274, true );

		// Add image size for meta tags if companion plugin is not activated.
		if ( ! is_plugin_active( SRFC_PLUGIN ) ) {
			add_image_size( __( 'Meta Image', 'srfc-theme' ), 1200, 630, true );
		}

		/**
		 * Add header image support.
		 *
		 * @since 1.0.0
		 */

		// Header arguments.
		$header_args = [
			'default-image'          => '',
			'width'                  => 1280,
			'height'                 => 549,
			'flex-height'            => true,
			'flex-width'             => true,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => true,
			'default-text-color'     => '',
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		];

		// Apply a filter to header arguments.
		$header = apply_filters( 'srfc_header_image', $header_args );

		// Add header support.
		add_theme_support( 'custom-header', $header );

		/**
		 * Add logo support.
		 *
		 * @since 1.0.0
		 */

		// Custom logo support.
		$logo_args = [
			'width'       => 180,
			'height'      => 180,
			'flex-width'  => true,
			'flex-height' => true
		];

		// Apply a filter to logo arguments.
		$logo = apply_filters( 'srfc_header_image', $logo_args );

		// Add logo support.
		add_theme_support( 'custom-logo', $logo );

		 /**
		 * Set content width.
		 *
		 * @since 1.0.0
		 */

		if ( ! isset( $content_width ) ) {
			$content_width = 1280;
		}

		/**
		 * Register theme menus.
		 *
		 * @since  1.0.0
		 */
		register_nav_menus( [
			'main'   => __( 'Main Menu', 'srfc-theme' ),
			'footer' => __( 'Footer Menu', 'srfc-theme' ),
			'social' => __( 'Social Menu', 'srfc-theme' )
		] );

		/**
		 * Add stylesheet for the content editor.
		 *
		 * @since 1.0.0
		 */
		add_editor_style( '/assets/css/editor-style.css', [ 'srfc-admin' ], '', 'screen' );

		/**
		 * Disable Jetpack open graph. We have the open graph tags in the theme.
		 *
		 * @since 1.0.0
		 */
		if ( class_exists( 'Jetpack' ) ) {
			add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
		}

	}

	/**
	 * Register widgets
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function widgets() {

		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'srfc-theme' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'srfc-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );

	}

	/**
	 * Theme support for disabling custom colors in the editor
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool Returns true for the color picker.
	 */
	public function editor_custom_color() {

		$disable = add_theme_support( 'disable-custom-colors', [] );

		// Apply a filter for conditionally disabling the picker.
		$custom_colors = apply_filters( 'srfc_editor_custom_colors', '__return_false' );

		return $custom_colors;

	}

	/**
	 * Clean up meta tags from the <head>
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function head_cleanup() {

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_site_icon', 99 );
	}

	/**
	 * Frontend scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'srfc-theme-navigation', get_theme_file_uri(  '/assets/js/navigation.js', [], '', true ) );

		wp_enqueue_script( 'srfc-theme-skip-link-focus-fix', get_theme_file_uri(  '/assets/js/skip-link-focus-fix.js', [], '', true ) );

		// Comments scripts.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/**
	 * Admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {}

	/**
	 * Frontend styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_styles() {

		/**
		 * Theme sylesheet
		 *
		 * This enqueues the minified stylesheet compiled from SASS (.scss) files.
		 * The main stylesheet, in the root directory, only contains the theme header but
		 * it is necessary for theme activation. DO NOT delete the main stylesheet!
		 */
		wp_enqueue_style( 'srfc-theme', get_template_directory_uri() . '/assets/css/style.min.css', array(), '' );

		// Print styles.
		wp_enqueue_style( 'srfc-print', get_theme_file_uri( '/assets/css/print.min.css' ), [], '', 'print' );

	}

	/**
	 * Admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {}

	/**
	 * Login styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function login_styles() {

		wp_enqueue_style( 'custom-login', get_theme_file_uri( '/assets/css/login.css' ), [], '', 'screen' );

	}

	/**
	 * Theme dependencies
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		require get_theme_file_path( '/includes/custom-header.php' );
		require get_theme_file_path( '/includes/template-tags.php' );
		require get_theme_file_path( '/includes/template-functions.php' );
		require get_theme_file_path( '/includes/customizer.php' );

	}

}

/**
 * Get an instance of the Functions class
 *
 * This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function srfc_theme() {

	$srfc_theme = Functions::get_instance();

	return $srfc_theme;

}

// Run the Functions class.
srfc_theme();