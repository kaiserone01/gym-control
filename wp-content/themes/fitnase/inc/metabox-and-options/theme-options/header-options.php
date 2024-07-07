<?php
// Create header Settings section
CSF::createSection( $fitnase_theme_option, array(
	'title' => esc_html__( 'Header Settings', 'fitnase' ),
	'id'    => 'header_options',
	'icon'  => 'fa fa-header',
) );


CSF::createSection( $fitnase_theme_option, array(
	'parent' => 'header_options',
	'title'  => esc_html__( 'Logo & Menu', 'fitnase' ),
	'icon'   => 'fa fa-credit-card',
	'fields' => array(

		array(
			'id'           => 'header_default_logo',
			'type'         => 'media',
			'title'        => esc_html__( 'Header Logo', 'fitnase' ),
			'library'      => 'image',
			'url'          => false,
			'button_title' => esc_html__( 'Upload Logo', 'fitnase' ),
			'desc'         => esc_html__( 'Upload logo image', 'fitnase' ),

		),

		array(
			'id'            => 'logo_image_size',
			'type'          => 'dimensions',
			'title'         => esc_html__( 'Logo Image Size', 'fitnase' ),
			'output'        => '.site-branding img',
			'width'         => true,
			'height'        => true,
			'desc'          => esc_html__( 'Select logo image size.', 'fitnase' ),
		),

		array(
			'id'      => 'menu_text_align',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Menu Text Align', 'fitnase' ),
			'options' => array(
				'start'   => esc_html__( 'Left', 'fitnase' ),
				'center' => esc_html__( 'Center', 'fitnase' ),
				'end'  => esc_html__( 'Right', 'fitnase' ),
			),
			'default' => 'end',
			'desc'    => esc_html__( 'Select menu text align.', 'fitnase' ),
		),

		array(
			'id'       => 'sticky_header',
			'type'     => 'switcher',
			'title'    => esc_html__('Enable Sticky Header', 'fitnase'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Enable / Disable sticky header.', 'fitnase'),
		),
	)
) );

CSF::createSection( $fitnase_theme_option, array(
	'parent' => 'header_options',
	'title'  => esc_html__( 'Header Top', 'fitnase' ),
	'icon'   => 'fas fa-level-up-alt',
	'fields' => array(

		array(
			'id'         => 'enable_header_top',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Enable Header Top', 'fitnase' ),
			'default'    => false,
			'text_on'    => esc_html__( 'Yes', 'fitnase' ),
			'text_off'   => esc_html__( 'No', 'fitnase' ),
			'desc'       => esc_html__( 'Enable / Disable header top info.', 'fitnase' ),
		),

		array(
			'id'           => 'header_top_info_text',
			'type'         => 'group',
			'title'        => esc_html__( 'Top Info Text', 'fitnase' ),
			'subtitle'     => esc_html__( 'Add / edit header top info text from here.', 'fitnase' ),
			'desc'         => esc_html__( 'Click "Add Info" button to add new Information.', 'fitnase' ),
			'button_title' => esc_html__( 'Add Info', 'fitnase' ),
			'fields'       => array(

				array(
					'id'            => 'info_text',
					'type'          => 'wp_editor',
					'media_buttons' => false,
					'height'        => '80px',
					'title'         => esc_html__( 'Info Text', 'fitnase' ),
					'desc'          => esc_html__( 'Type top left text here.', 'fitnase' ),
				),

				array(
					'id'    => 'info_icon',
					'type'  => 'icon',
					'title' => esc_html__( 'Icon', 'fitnase' ),
					'desc'  => esc_html__( 'Select icon', 'fitnase' ),
				),


			),
			'default'      => array(
				array(
					'info_text' => esc_html__( '430 E State St Lola, Wisconsin', 'fitnase' ),
					'info_icon' => 'flaticon-pin',
				),
			),

			'dependency' => array('enable_header_top','==','true','all'),
		),
	)
) );


// Header Button

CSF::createSection( $fitnase_theme_option, array(
	'parent' => 'header_options',
	'title'  => esc_html__( 'Header Buttons', 'fitnase' ),
	'icon'   => 'far fa-hand-pointer',
	'fields' => array(
		array(
			'id'         => 'header_cta_button',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Enable CTA Button', 'fitnase' ),
			'default'    => false,
			'text_on'    => esc_html__( 'Yes', 'fitnase' ),
			'text_off'   => esc_html__( 'No', 'fitnase' ),
			'desc'       => esc_html__( 'Enable / Disable header CTA button.', 'fitnase' ),
		),

		array(
			'id'    => 'cta_text',
			'type'  => 'text',
			'title' => esc_html__( 'Button Text', 'fitnase' ),
			'default'  => esc_html__( 'Call Now', 'fitnase' ),
			'desc'  => esc_html__( 'CTA button text here.', 'fitnase' ),
			'dependency'   => array( 'header_cta_button', '==', 'true' ),
		),

		array(
			'id'    => 'cta_url',
			'type'  => 'text',
			'title' => esc_html__( 'URL', 'fitnase' ),
			'default'  => 'tel:123456789',
			'desc'  => esc_html__( 'CTA button URL here.', 'fitnase' ),
			'dependency'   => array( 'header_cta_button', '==', 'true' ),
		),

		array(
			'id'         => 'header_cart',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Enable Header Cart', 'fitnase' ),
			'default'    => false,
			'text_on'    => esc_html__( 'Yes', 'fitnase' ),
			'text_off'   => esc_html__( 'No', 'fitnase' ),
			'desc'       => esc_html__( 'Enable / Disable header cart.', 'fitnase' ),
		),
	)
) );