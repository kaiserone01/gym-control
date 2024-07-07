<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * Post Share
 */

require_once ('post-share.php');

/*
 * Hide Meta Box On Blog & WooCommerce page
 */

if ( ! function_exists( 'fitnase_hide_metabox' ) ) {
	function fitnase_hide_metabox() {

		global $post, $post_type;

		if( class_exists( 'WooCommerce' ) && is_object( $post ) && $post_type === 'page' ) {
			$exclude   = array();
			$exclude[] = get_option( 'woocommerce_shop_page_id' );
			$exclude[] = get_option( 'woocommerce_cart_page_id' );
			$exclude[] = get_option( 'woocommerce_checkout_page_id' );
			$exclude[] = get_option( 'woocommerce_myaccount_page_id' );
			$exclude[] = get_option( 'page_for_posts' );
			$exclude[] = get_option( 'wishlist_page_id' );
			if( in_array( $post->ID, $exclude ) ) {
				echo '<style type="text/css">';
				echo '#fitnase_common_meta{ display: none !important; }';
				echo '</style>';
			}
		}else{
			if(is_object( $post ) && $post_type === 'page'){
				$exclude   = array();
				$exclude[] = get_option( 'page_for_posts' );
				if( in_array( $post->ID, $exclude ) ) {
					echo '<style type="text/css">';
					echo '#fitnase_common_meta{ display: none !important; }';
					echo '</style>';
				}
			}
		}

		echo '<style type="text/css">';
		echo '
		.elementor-editor-active .edit-post-visual-editor .block-editor-writing-flow__click-redirect{min-height:5vh}
		';
		echo '</style>';

	}

	add_action( 'admin_head', 'fitnase_hide_metabox' );
}

// Team Member List
if(! function_exists('fitnase_team_member_list')){
	function fitnase_team_member_list() {
		$team_list = array();
		$team_query = new WP_Query(array(
			'post_type' =>  array('fitnase_team'),
			'posts_per_page'    =>  -1,
		));
		while ($team_query->have_posts()) :
			$team_query->the_post();
			$team_list[get_the_id()]  = get_the_title();
		endwhile;
		wp_reset_postdata();
		return $team_list;
	}
}

// Change Team Title Placeholder
function fitnase_change_team_title_placeholder( $title ){
	$screen = get_current_screen();

	if  ( 'fitnase_team' == $screen->post_type ) {
		$title = __('Member Name', 'fitnase-core');
	}

	return $title;
}

add_filter( 'enter_title_here', 'fitnase_change_team_title_placeholder' );

//Post Category
function ep_fitnase_post_categories() {
	$terms = get_terms( array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
	) );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
	}

	return $options;
}

//Post List
function fitnase_get_post_title_as_list( ) {
	$args = wp_parse_args( array(
		'post_type'   => 'post',
		'order'   => 'desc',
		'numberposts' => -1,
	) );

	$posts = get_posts( $args );

	if ( $posts ) {
		foreach ( $posts as $post ) {
			$post_options[ $post->ID ] = $post->post_title;
		}
	}

	return $post_options;
}

//Get Excerpt
function fitnase_get_excerpt( $post_id, $excerpt_length ) {
	$the_post = get_post( $post_id ); //Gets post ID

	$the_excerpt = null;
	if ( $the_post ) {
		$the_excerpt = $the_post->post_excerpt ? $the_post->post_excerpt : $the_post->post_content;
	}

	$the_excerpt = strip_tags( strip_shortcodes( $the_excerpt ) ); //Strips tags and images
	$words       = explode( ' ', $the_excerpt, $excerpt_length + 1 );

	if ( count( $words ) > $excerpt_length ) :
		array_pop( $words );
		array_push( $words, '…' );
		$the_excerpt = implode( ' ', $words );
	endif;

	return $the_excerpt;
}