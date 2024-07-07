<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fitnase
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php
	if (is_page() || is_singular( 'post' ) || fitnase_custom_post_types() && get_post_meta( $post->ID, 'fitnase_common_meta', true ) ) {
		$common_meta = get_post_meta( $post->ID, 'fitnase_common_meta', true );
	} else {
		$common_meta = array();
	}

	$preloader    = fitnase_option( 'enable_preloader', true );

	wp_head();
	?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">


	<?php if($preloader == true) {
		$preloader_image = fitnase_option('preloader_image'); ?>
        <!-- Preloader -->
        <div class="preloader-wrapper">
            <div class="preloader bounce-active">
                <?php if(!empty($preloader_image['url'])) : ?>
                    <img src="<?php echo esc_url($preloader_image['url']); ?>" alt="<?php echo esc_attr($preloader_image['alt']); ?>">
                <?php else : ?>
                    <img src="<?php echo get_theme_file_uri('assets/images/preloader.png');?>" alt="<?php bloginfo( 'name' ); ?>">
                <?php endif; ?>
            </div>
        </div>
        <!-- Preloader End -->
		<?php
	}?>

    <!-- Mobile Menu -->
    <div class="mobile-menu-container ep-secondary-font">
        <div class="mobile-menu-close"></div>
        <div id="mobile-menu-wrap"></div>
    </div>
    <!-- Mobile Menu End -->

    <header class="header-area site-header">
		<?php get_template_part( 'template-parts/header/' . 'header-style-one' ); ?>
    </header>

    <div id="content" class="site-content">
        