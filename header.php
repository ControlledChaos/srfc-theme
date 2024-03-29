<?php
/**
 * The header for the theme
 *
 * @package    WordPress
 * @subpackage Sequoia_Riverfront_Cabins
 * @since      1.0.0
 */

// Set up connonical URL.
if ( is_home() && ! is_front_page() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} elseif ( is_archive() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} else {
    $canonical = get_permalink();
}

?>
<!doctype html>
<?php do_action( 'before_html' ); ?>
<html <?php language_attributes(); ?> class="no-js">
<head id="<?php echo get_bloginfo( 'wpurl' ); ?>" data-template-set="<?php echo get_template(); ?>">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open() ) {
		echo sprintf( '<link rel="pingback" href="%s" />', get_bloginfo( 'pingback_url' ) );
	} ?>
	<link href="<?php echo $canonical; ?>" rel="canonical" />
	<?php if ( is_search() ) { echo '<meta name="robots" content="noindex,nofollow" />'; } ?>

	<!-- Prefetch font URLs -->
	<link rel='dns-prefetch' href='//fonts.adobe.com'/>
	<link rel='dns-prefetch' href='//fonts.google.com'/>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site" itemscope="itemscope" itemtype="<?php srfc_site_schema(); ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ip-theme' ); ?></a>
	<div id="header-nav-wrap" class="header-nav-wrap">
		<div class="global-wrapper">
			<nav id="site-navigation" class="main-navigation" role="directory" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<div class="nav-wrap">
					<?php wp_nav_menu( [
						'theme_location' => 'main',
						'menu_id'        => 'primary-menu'
					] ); ?>
				</div>
			</nav>
			<header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/Organization">
				<?php if ( is_front_page() ) {
					get_template_part( 'template-parts/site-branding', 'front-page' );
				} else {
					get_template_part( 'template-parts/site-branding' );
				} ?>
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'ip-theme' ); ?></button>
			</header>
		</div>
	</div>
	<div id="content" class="site-content">