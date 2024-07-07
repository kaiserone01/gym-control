<?php
$fitnase_common_meta = 'fitnase_common_meta';

// Create a metabox
CSF::createMetabox( $fitnase_common_meta, array(
	'title'     => esc_html__( 'Settings', 'fitnase' ),
	'post_type' => array( 'page', 'post','fitnase_team','fitnase_service','product' ),
	'data_type' => 'serialize',
) );

// Create layout section
CSF::createSection( $fitnase_common_meta, array(
	'title'  => esc_html__( 'Layout Settings ', 'fitnase' ),
	'icon'   => 'fa fa-calculator',
	'fields' => array(

		array(
			'id'      => 'layout_meta',
			'type'    => 'select',
			'title'   => esc_html__( 'Layout', 'fitnase' ),
			'options' => array(
				'default'       => esc_html__( 'Default', 'fitnase' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'fitnase' ),
				'full-width'    => esc_html__( 'Full Width', 'fitnase' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'fitnase' ),
			),
			'default' => 'default',
			'desc'    => esc_html__( 'Select layout', 'fitnase' ),
		),

		array(
			'id'         => 'sidebar_meta',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'dependency' => array( 'layout_meta', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select sidebar you want to show with this page.', 'fitnase' ),
		),
	)
) );

// Create layout section
CSF::createSection( $fitnase_common_meta, array(
	'title'  => esc_html__( 'Header Settings ', 'fitnase' ),
	'icon'   => 'fa fa-header',
	'fields' => array(

		array(
			'id'           => 'header_logo_meta',
			'type'         => 'media',
			'title'        => esc_html__( 'Header Logo', 'fitnase' ),
			'library'      => 'image',
			'url'          => false,
			'button_title' => esc_html__( 'Upload Logo', 'fitnase' ),
			'desc'         => esc_html__( 'Upload logo image', 'fitnase' ),

		),

		array(
			'id'          => 'main_menu_meta',
			'type'        => 'select',
			'title'       => esc_html__( 'Header Menu', 'fitnase' ),
			'options'     => 'menus',
			'placeholder' => esc_html__( 'Default', 'fitnase' ),
			'desc'        => esc_html__( 'You can select a different menu for this page from here.', 'fitnase' ),
		),
	)
) );

// Create a section
CSF::createSection( $fitnase_common_meta, array(
	'title'  => esc_html__( 'Banner Settings', 'fitnase' ),
	'icon'   => 'fa fa-flag-o',
	'fields' => array(
		array(
			'id'       => 'enable_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Banner', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Enable or disable banner.', 'fitnase' ),
		),

		array(
			'id'                    => 'banner_background_meta',
			'type'                  => 'background',
			'title'                 => esc_html__( 'Banner Background', 'fitnase' ),
			'background_gradient'   => true,
			'background_origin'     => false,
			'background_clip'       => false,
			'background_blend-mode' => false,
			'background_attachment' => false,
			'background_size'       => false,
			'background_position'   => false,
			'background_repeat'     => false,
			'dependency'            => array( 'enable_banner', '==', true ),
			'output'                => '.banner-area.post-banner,.banner-area.page-banner,.banner-area.service-banner,.banner-area.team-banner,.banner-area.project-banner',
			'desc'                  => esc_html__( 'Select banner background color and image', 'fitnase' ),
		),

		array(
			'id'         => 'hide_banner_title_meta',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Hide Title', 'fitnase' ),
			'options'    => array(
				'default' => esc_html__( 'Default', 'fitnase' ),
				'yes'     => esc_html__( 'Yes', 'fitnase' ),
				'no'      => esc_html__( 'No', 'fitnase' ),
			),
			'default'    => 'default',
			'desc'       => esc_html__( 'Hide or show banner title.', 'fitnase' ),
			'dependency' => array( 'enable_banner', '==', true ),
		),

		array(
			'id'         => 'custom_title',
			'type'       => 'text',
			'title'      => esc_html__( 'Banner Custom Title', 'fitnase' ),
			'dependency' => array( 'enable_banner|hide_banner_title_meta', '==|!=', 'true|yes' ),
			'desc'       => esc_html__( 'If you want to use custom title write title here.If you don\'t, leave it empty.', 'fitnase' )
		),


		array(
			'id'         => 'hide_banner_breadcrumb_meta',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Hide Breadcrumb', 'fitnase' ),
			'options'    => array(
				'default' => esc_html__( 'Default', 'fitnase' ),
				'yes'     => esc_html__( 'Yes', 'fitnase' ),
				'no'      => esc_html__( 'No', 'fitnase' ),
			),
			'default'    => 'default',
			'desc'       => esc_html__( 'Hide or show banner breadcrumb.', 'fitnase' ),
			'dependency' => array( 'enable_banner', '==', true ),
		),

		array(
			'id'         => 'banner_text_align_meta',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Banner Text Align', 'fitnase' ),
			'options'    => array(
				'default' => esc_html__( 'Default', 'fitnase' ),
				'start'   => esc_html__( 'Left', 'fitnase' ),
				'center' => esc_html__( 'Center', 'fitnase' ),
				'end'  => esc_html__( 'Right', 'fitnase' ),
			),
			'default'    => 'default',
			'dependency' => array( 'enable_banner', '==', true ),
			'desc'       => esc_html__( 'Select page banner text align.', 'fitnase' ),
		),

		array(
			'id'         => 'banner_height_meta',
			'type'       => 'dimensions',
			'title'      => esc_html__( 'Banner Height', 'fitnase' ),
			'output'     => '.banner-area.post-banner,.banner-area.page-banner,.banner-area.service-banner,.banner-area.team-banner',
			'width'      => false,
			'height'     => true,
			'desc'       => esc_html__( 'Select banner height.', 'fitnase' ),
			'dependency' => array( 'enable_banner', '==', true ),
		),
	)
) );