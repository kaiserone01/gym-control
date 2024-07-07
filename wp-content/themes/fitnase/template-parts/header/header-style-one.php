<?php
$enable_header_top = fitnase_option('enable_header_top', false);
$top_info_text = fitnase_option('header_top_info_text');
$menu_align = fitnase_option('menu_text_align', 'end');
$sticky_header    = fitnase_option( 'sticky_header', true );
$allow_html = array(
	'a'      => array(
		'href'   => array(),
		'target' => array()
	),
	'p'      => array(),
);
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
	        <?php if($enable_header_top == true) : ?>
            <div class="header-top-are">
                <div class="row align-items-center text-center">
                    <div class="col-lg-12">
                        <div class="top-info">
		                    <?php if(is_array($top_info_text)) : ?>
                                <ul class="ep-list-style ep-list-inline">
				                    <?php foreach ($top_info_text as $top_info) : ?>
                                        <li>
                                            <i class="<?php echo esc_attr($top_info['info_icon']);?>"></i>
						                    <?php echo wp_kses($top_info['info_text'], $allow_html);?>
                                        </li>
				                    <?php endforeach;?>
                                </ul>
		                    <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
	        <?php endif; ?>

            <div class="main-menu-area" <?php if($sticky_header == true ){echo 'data-uk-sticky="top: 250; animation: uk-animation-slide-top;"';} ?>>
                <div class="row align-items-center">
                    <div class="col-lg-2 col-sm-3 col-6">
                        <?php get_template_part( 'template-parts/header/header-logo' ); ?>
                    </div>

                    <div class="col-lg-10 col-sm-9 col-6">
                        <div class="header-nav-and-buttons">
                            <div class="header-navigation-area text-<?php echo esc_attr($menu_align);?>">
                                <?php get_template_part( 'template-parts/header/header-menu' );?>
                            </div>
	                        <?php get_template_part( 'template-parts/header/header-buttons' );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

