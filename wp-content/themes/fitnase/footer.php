<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fitnase
 */
$go_to_top = fitnase_option('go_to_top_button', false);

$footer_allowed_html_tags = array(
	'a'      => array(
		'href'   => array(),
		'target' => array(),
	),
	'strong' => array(),
	'small'  => array(),
	'span'   => array(),
	'p'   => array(),
);
?>

</div><!-- #content -->

<footer class="site-footer">
	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

    <div class="footer-bottom-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="site-info-left">
						<?php
						$footer_info_left_text = fitnase_option('footer_info_left_text');
						echo wp_kses($footer_info_left_text, $footer_allowed_html_tags);
						?>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="site-copyright-text">
						<?php
						$copyright_text = fitnase_option('copyright_text');

						echo wp_kses($copyright_text, $footer_allowed_html_tags);
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<?php if($go_to_top == true) : ?>
        <div class="scroll-to-top"><i class="fas fa-angle-double-up"></i></div>
	<?php endif;?>
</footer><!-- #colophon -->


</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>