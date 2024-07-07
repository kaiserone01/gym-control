<?php
/**
 * Single Product Meta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$show_sku = fitnase_option('product_sku', true);
$show_cat = fitnase_option('product_cat', true);
$show_tag = fitnase_option('product_tag', true);

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( $show_sku == true && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'fitnase' ); ?> <span class="sku"><?php echo esc_html( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'fitnase' ); ?></span></span>
	<?php endif; ?>

	<?php if($show_cat == true) {
		echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'fitnase') . ' ', '</span>');
	}?>

	<?php if($show_tag == true){
        echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'fitnase' ) . ' ', '</span>' );
    }?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>