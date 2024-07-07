<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fitnase
 */

get_header();
$blog_layout = fitnase_option('blog_layout', 'right-sidebar');
$enable_banner = fitnase_option('blog_banner', true);
$banner_title = fitnase_option('blog_title');
$enable_blog_banner_title = fitnase_option( 'enable_blog_banner_title', true );
$blog_breadcrumb = fitnase_option( 'enable_blog_banner_breadcrumb', true );
$banner_text_align = fitnase_option('banner_default_text_align', 'left');
?>

<?php if($enable_banner == true) : ?>
    <div class="banner-area blog-banner">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="banner-content text-<?php echo esc_attr( $banner_text_align ); ?>">
	                    <?php if($enable_blog_banner_title == true) : ?>
                        <h2 class="banner-title">
							<?php echo esc_html($banner_title);?>
                        </h2>
                        <?php endif; ?>
                        
						<?php if ( function_exists( 'bcn_display' ) && $blog_breadcrumb == true) :?>
                            <div class="breadcrumb-container">
								<?php bcn_display();?>
                            </div>
						<?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <div id="primary" class="content-area layout-<?php echo esc_attr($blog_layout);?>">
        <div class="container">
			<?php
			if($blog_layout == 'grid'){
				get_template_part( 'template-parts/post/post-grid');
			}else{
				get_template_part( 'template-parts/post/post-sidebar');
			}
			?>
        </div>
    </div><!-- #primary -->

<?php
get_footer();