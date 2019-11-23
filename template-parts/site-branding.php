<?php
/**
 * Site branding
 *
 * @package    WordPress
 * @subpackage Sequoia_Riverfront_Cabins
 * @since      1.0.0
 */

// Get the site description.
$description = get_bloginfo( 'description', 'display' );

// Set up the description element.
if ( $description ) {
	$description = sprintf(
		'<p class="site-description">%1s</p>',
		$description
	);
} else {
	$description = sprintf(
		'<p class="site-description">%1s</p>',
		__( 'Vacation Lodging in Three Rivers, Califonia', 'srfc-theme' )
	);
}

?>
<div class="site-branding">
	<div class="site-logo"><?php the_custom_logo(); ?></div>
	<div class="site-title-description">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<p class="site-title"><?php bloginfo( 'name' ); ?></p>
			<?php echo $description; ?>
		</a>
	</div>
</div>