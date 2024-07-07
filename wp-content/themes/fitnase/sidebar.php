<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fitnase
 */


if ( is_page() || is_singular( 'post' ) || fitnase_custom_post_types() && get_post_meta( $post->ID, 'fitnase_common_meta', true ) ) {
	$common_meta = get_post_meta( $post->ID, 'fitnase_common_meta', true );
} else {
	$common_meta = array();
}

if ( is_array( $common_meta ) && array_key_exists( 'sidebar_meta', $common_meta ) && $common_meta['sidebar_meta'] != '0' ) {
	$selected_sidebar = $common_meta['sidebar_meta'];
} else if ( is_singular( 'post' ) ) {
	$selected_sidebar = fitnase_option( 'single_post_default_sidebar', 'fitnase-sidebar' );
} else if ( is_singular( 'page' ) ) {
	$selected_sidebar = fitnase_option( 'page_default_sidebar', 'fitnase-sidebar' );
}else if (is_singular('fitnase_service')) {
	$selected_sidebar = fitnase_option('service_default_sidebar', 'fitnase-service-sidebar');
}else if (is_singular('fitnase_team')) {
	$selected_sidebar = fitnase_option('team_default_sidebar', 'fitnase-team-sidebar');
}else if (function_exists('is_shop') && is_shop()) {
	$selected_sidebar = fitnase_option('shop_default_sidebar', 'fitnase-shop-sidebar');
} else if (is_singular('product') || function_exists('is_product_category') && is_product_category()) {
	$selected_sidebar = fitnase_option('product_default_sidebar', 'fitnase-shop-sidebar');
}else {
	$selected_sidebar = 'fitnase-sidebar';
}

?>

<aside class="sidebar-widget-area">
	<?php
	if ( is_active_sidebar( $selected_sidebar ) ) {
		dynamic_sidebar( $selected_sidebar );
	}
	?>
</aside>
