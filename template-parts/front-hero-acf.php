<?php
/**
 * Front page hero image
 *
 * This tamplate is used only if Advanced Custom Fields is active.
 *
 * @package    WordPress
 * @subpackage Sequoia_Riverfront_Cabins
 * @since      1.0.0
 */

// Get ACF fields for the hero  display.
$overlay = get_field( 'srfc_hero_overlay' );
$heading = get_field( 'srfc_hero_heading' );
$message = get_field( 'srfc_hero_message' );

// Image overlay opacity.
if ( $overlay ) {
	$overlay = $overlay;
} else {
	$overlay = 30;
}

// Hero heading.
if ( $heading ) {
	$heading = sprintf(
		'<h3>%1s</h3>',
		$heading
	);
} elseif ( is_customize_preview() ) {
	$heading = sprintf(
		'<h3>%1s</h3>',
		__( 'Welcome to Three Rivers, California', 'srfc-theme' )
	);
} else {
	$heading = sprintf(
		'<h3>%1s</h3>',
		__( 'Welcome to Three Rivers, California', 'srfc-theme' )
	);
}

// Hero message.
if ( $message ) {
	$message = $message;
} else {
	$message = sprintf(
		'<p>%1s</p>',
		__( 'Enjoy our rustic cabins with prime river access', 'srfc-theme' )
	);
}

?>
 <div class="front-page-hero">
 	<style>.custom-header-media:before { background: rgba(0, 0, 0, 0.<?php echo $overlay; ?>);}</style>
	<div class="front-page-hero-media custom-header-media">
		<?php the_custom_header_markup(); ?>
	</div>
	<div class="front-page-hero-content">
		<div class="global-wrapper hero-wrapper">
			<?php echo $heading; ?>
			<?php echo $message; ?>
		</div>
	</div>
</div>