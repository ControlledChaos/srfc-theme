<?php
/**
 * Front page hero image
 *
 * This tamplate is used only if Advanced Custom Fields is not active.
 *
 * @package    WordPress
 * @subpackage Sequoia_Riverfront_Cabins
 * @since      1.0.0
 */

// Hero heading.
$heading = sprintf(
	'<h3>%1s</h3>',
	__( 'Welcome to Three Rivers, California', 'srfc-theme' )
);

// Hero message.
$message = sprintf(
	'<p>%1s</p>',
	__( 'Enjoy our rustic cabins with prime river access', 'srfc-theme' )
);

?>
 <div class="front-page-hero">
 	<style>.custom-header-media:before { background: rgba(0, 0, 0, 0.30)}</style>
	<div class="front-page-hero-media custom-header-media">
		<div id="wp-custom-header" class="wp-custom-header">
			<img src="<?php echo get_theme_file_uri( '/assets/images/kaweah-river-scene.jpg' ); ?>" width="2048" height="878" alt="Sequoia Riverfront Cabins" />
		</div>
	</div>
	<div class="front-page-hero-content">
		<div class="global-wrapper hero-wrapper">
			<?php echo $heading; ?>
			<?php echo $message; ?>
		</div>
	</div>
</div>