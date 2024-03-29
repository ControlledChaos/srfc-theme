<?php
/**
 * Front page content template.
 *
 * @package    WordPress
 * @subpackage Sequoia_Riverfront_Cabins
 * @since      1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<?php if ( class_exists( 'acf' ) ) {
		get_template_part( 'template-parts/front-hero', 'acf' );
	} else {
		get_template_part( 'template-parts/front-hero', 'no-acf' );
	} ?>
	<div class="entry-content" itemprop="articleBody">
		<?php the_content();

		// WP_Query arguments.
		$args = [
			'post_type' => [ 'cabin' ],
			'orderby'   => 'menu_order',
		];

		// The Query.
		$query = new WP_Query( $args );

		?>
	</div>
</article>
