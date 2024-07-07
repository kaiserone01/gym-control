<?php
/**
 * @package Fitnase
 */

//Get theme options
if ( ! function_exists( 'fitnase_option' ) ) {
	function fitnase_option( $option = '', $default = null ) {
		$defaults = fitnase_default_theme_options();
		$options  = get_option( 'fitnase_theme_options' );
		$default  = ( ! isset( $default ) && isset( $defaults[ $option ] ) ) ? $defaults[ $option ] : $default;

		return ( isset( $options[ $option ] ) ) ? $options[ $option ] : $default;
	}
}

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Adds custom classes to the array of body classes.
 */
function fitnase_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'fitnase-woo-active';
	}else{
		$classes[] = 'fitnase-woo-deactivate';
	}

	//Check Elementor Page Builder Used or not
	$elementor_used = get_post_meta(get_the_ID(), '_elementor_edit_mode', true);

	if(is_archive() || is_search()){
		$classes[]        = !!$elementor_used ? 'page-builder-not-used' : 'page-builder-not-used';
	}else{
		$classes[]        = !!$elementor_used ? 'page-builder-used' : 'page-builder-not-used';
	}

	return $classes;
}
add_filter( 'body_class', 'fitnase_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function fitnase_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'fitnase_pingback_header' );


/**
 * Words limit
 */
function fitnase_words_limit($text, $limit) {
	$words = explode(' ', $text, ($limit + 1));

	if (count($words) > $limit) {
		array_pop($words);
	}

	return implode(' ', $words);
}


/**
 * Get excluded sidebar list
 */
if( ! function_exists( 'fitnase_sidebars' ) ) {
	function fitnase_sidebars() {
		$default = esc_html__('Default', 'fitnase');
		$options = array($default);
		// set ids of the registered sidebars for exclude
		$exclude = array( 'fitnase-footer-widget', 'fitnase-toggle-sidebar' );

		global $wp_registered_sidebars;

		if( ! empty( $wp_registered_sidebars ) ) {
			foreach( $wp_registered_sidebars as $sidebar ) {
				if( ! in_array( $sidebar['id'], $exclude ) ) {
					$options[$sidebar['id']] = $sidebar['name'];
				}
			}
		}

		return $options;
	}
}


/**
 * Iframe embed
 */

function fitnase_iframe_embed( $tags, $context ) {
	if ( 'post' === $context ) {
		$tags['iframe'] = array(
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		);
	}
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'fitnase_iframe_embed', 10, 2 );



/**
 * Next - Prev Post Link
 */
if ( !function_exists( 'fitnase_next_prev_post_link' ) ) {
	function fitnase_next_prev_post_link(){ ?>

		<div class="row single-blog-next-prev">

			<?php
			$prev_post = get_previous_post();

			if(!empty( get_previous_post_link())){
				$prev_thumbnail = get_the_post_thumbnail($prev_post->ID, array(85,85) );
				if(!empty($prev_thumbnail)){
					$prev_thumb_class ='have-thumb';
				}else{
					$prev_thumb_class = 'no-thumb';
				}
			}

			$next_post = get_next_post();

			if(!empty( get_next_post_link())){
				$next_thumbnail = get_the_post_thumbnail($next_post->ID, array(85,85) );
				if(!empty($next_thumbnail)){
					$next_thumb_class ='have-thumb';
				}else{
					$next_thumb_class = 'no-thumb';
				}
			}
			?>

			<div class="col-6 prev-post-nav-wrap <?php echo esc_attr($prev_thumb_class);?>">
				<div class="post-nav-container">

					<?php if ( !empty( get_previous_post_link())){ ?>
						<?php
						previous_post_link('%link',"<div class='blog-next-prev-img post-prev-img'><i class='fas fa-arrow-left'></i>$prev_thumbnail</div>");
						?>

						<?php  ?>
					<?php } ?>
				</div>
			</div>


			<?php if ( !empty( get_next_post_link())){ ?>
				<div class=" col-6 next-post-nav-wrap <?php echo esc_attr($next_thumb_class);?>">
					<div class="post-nav-container">
						<?php
						next_post_link('%link',"<div class='blog-next-prev-img post-next-img'><i class='fas fa-arrow-right'></i>$next_thumbnail</div>");
						?>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
	}
}


/**
 * Check if a post is a custom post type.
 *
 * @param mixed $post Post object or ID
 *
 * @return boolean
 */
function fitnase_custom_post_types( $post = null ) {
	$custom_post_list = get_post_types( array( '_builtin' => false ) );

	// there are no custom post types
	if ( empty ( $custom_post_list ) ) {
		return false;
	}

	$custom_types     = array_keys( $custom_post_list );
	$current_post_type = get_post_type( $post );

	// could not detect current type
	if ( ! $current_post_type ) {
		return false;
	}

	return in_array( $current_post_type, $custom_types );
}


/**
 * Add span tag in archive list count number
 */
function fitnase_add_span_archive_count($links) {
	$links = str_replace('</a>&nbsp;(', '</a> <span class="post-count-number">(', $links);
	$links = str_replace(')', ')</span>', $links);
	return $links;
}

add_filter('get_archives_link', 'fitnase_add_span_archive_count');


/**
 * Add span tag in category list count number
 */

function fitnase_add_span_category_count($links) {
	$links = str_replace('</a> (', '</a> <span class="post-count-number">(', $links);
	$links = str_replace(')', ')</span>', $links);
	return $links;
}

add_filter('wp_list_categories', 'fitnase_add_span_category_count');


/**
 * Image id from url
 */
if ( ! function_exists( 'fitnase_image_id_by_url' ) ) {
	function fitnase_image_id_by_url($image_url) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
		return $attachment[0];
	}
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
if ( ! function_exists( 'fitnase_posted_on' ) ) :

	function fitnase_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
		/* translators: %s: post date. */
			esc_html_x( ' %s', 'post date', 'fitnase' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on"><i class="far fa-calendar-check"></i>' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;


/**
 * Prints HTML with meta information for the current author.
 */
if ( ! function_exists( 'fitnase_posted_by' ) ) :

	function fitnase_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( ' %s', 'post author', 'fitnase' ),
			'<span class="author vcard">' . esc_html( get_the_author() ) . '</span>'
		);

		echo '<span class="byline"><i class="far fa-user"></i> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

/**
 * Prints HTML with meta information for the tags.
 */
if ( ! function_exists( 'fitnase_post_tags' ) ) :

	function fitnase_post_tags() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html_x('', 'list item separator', 'fitnase'));
			if ($tags_list) {
				/* translators: 1: list of tags. */
				printf('<span class="tags-links"><span class="tag-title">' .esc_html__('Tags:','fitnase').'</span>' .esc_html__(' %1$s', 'fitnase') . '</span>', $tags_list); // WPCS: XSS OK.


			}

		}
	}
endif;

/**
 * Prints HTML with meta information for the categories.
 */

if ( ! function_exists( 'fitnase_post_categories' ) ) :

	function fitnase_post_categories() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(esc_html__(', ', 'fitnase'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<span class="cat-links"><i class="far fa-folder"></i>' . esc_html__('%1$s', 'fitnase') . '</span>', $categories_list); // WPCS: XSS OK.
			}

		}
	}
endif;

/**
 * Prints post's first category
 */

if ( ! function_exists( 'fitnase_post_first_category' ) ) :

	function fitnase_post_first_category(){

		$post_category_list = get_the_terms(get_the_ID(), 'category');

		$post_first_category = $post_category_list[0];
		if ( ! empty( $post_first_category->slug )) {
			echo '<span class="cat-links"><i class="far fa-folder"></i><a href="'.get_term_link( $post_first_category->slug, 'category' ).'">' . $post_first_category->name . '</a></span>';
		}

	}
endif;

/**
 * Prints HTML with meta information for the comments.
 */
if ( ! function_exists( 'fitnase_comment_count' ) ) :

	function fitnase_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) && get_comments_number() != 0) {
			echo '<span class="comments-link"><i class="far fa-comments"></i>';
			comments_popup_link('', ''.esc_html__('1', 'fitnase').' <span class="comment-count-text">'.esc_html__('Comment', 'fitnase').'</span>', '% <span class="comment-count-text">'.esc_html__('Comments', 'fitnase').'</span>');
			echo '</span>';
		}
	}
endif;