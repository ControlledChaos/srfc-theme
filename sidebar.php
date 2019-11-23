<?php
/**
 * The sidebar containing the main widget area
 *
 * @package SRFC_Theme
 */

// Bail if the sidebar has no widgets.
if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}

?>

<aside id="secondary" class="widget-area sidebar-widget-area">
	<?php dynamic_sidebar( 'sidebar' ); ?>
</aside>
