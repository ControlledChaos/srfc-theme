<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package SRFC_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php srfc_theme_post_thumbnail(); ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<div class="entry-content" itemprop="articleBody">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'srfc-theme' ),
			'after'  => '</div>',
		) );
		?>
	</div>
</article>
