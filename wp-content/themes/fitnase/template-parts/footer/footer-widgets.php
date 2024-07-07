<?php

$footer_image = fitnase_option('footer_image');

if(is_active_sidebar('fitnase-footer-widget')) :
    ?>
	<div class="footer-widget-area ep-cover-bg">
	    <?php if(!empty($footer_image['url'])) : ?>
        <div class="footer-left-image">
            <img src="<?php echo esc_url($footer_image['url']); ?>" alt="<?php echo esc_attr($footer_image['alt']); ?>">
        </div>
        <?php endif; ?>

		<div class="container">
			<div class="row">
				<?php dynamic_sidebar( "fitnase-footer-widget" ) ?>
			</div>
		</div>
	</div>
<?php endif;?>