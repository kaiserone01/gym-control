<?php
$header_cta_button = fitnase_option('header_cta_button', false);
$header_cta_text = fitnase_option('cta_text');
$header_cta_url = fitnase_option('cta_url');
$header_cart = fitnase_option('header_cart', false);
?>

<div class="header-buttons-area">
	<ul class="header-buttons-wrapper ep-list-style">
		<?php if(class_exists( 'WooCommerce' ) && $header_cart == true): ?>
            <li class="header-mini-cart">
                <a class="ep-header-cart-url" href="<?php echo esc_url( wc_get_cart_url() );?>">
                    <i class="flaticon-shopping-cart"></i>
                    <span class="cart-product-count"><?php echo WC()->cart->get_cart_contents_count();?></span>
                </a>
                <div class="ep-header-cart-products">
					<?php the_widget( 'WC_Widget_Cart' ); ?>
                </div>
            </li>
		<?php endif; ?>

		<?php if($header_cta_button == true) : ?>
        <li class="header-button">
            <a class="ep-button" href="<?php echo esc_attr($header_cta_url);?>"><?php echo esc_html($header_cta_text);?></a>
        </li>
		<?php endif; ?>
		<li class="mobile-menu-trigger"><span></span><span></span><span></span></li>
	</ul>
</div>
