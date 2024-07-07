<?php

// Create banner options
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Banner Options', 'fitnase' ),
	'id'     => 'banner_default_options',
	'icon'   => 'fa fa-flag-o',
	'fields' => array(

		array(
			'id'                    => 'banner_default_background',
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
			'output'                => '.banner-area',
			'desc'                  => esc_html__( 'Select banner background color and image. You can change this settings on individual page / post.', 'fitnase' ),
		),

		array(
			'id'      => 'banner_default_text_align',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Banner Text Align', 'fitnase' ),
			'options' => array(
				'start'   => esc_html__( 'Left', 'fitnase' ),
				'center' => esc_html__( 'Center', 'fitnase' ),
				'end'  => esc_html__( 'Right', 'fitnase' ),
			),
			'default' => 'start',
			'desc'    => esc_html__( 'Select banner text align. You can change this settings on individual page / post.', 'fitnase' ),
		),

		array(
			'id'      => 'hide_banner_title',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Hide Banner Title', 'fitnase' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'fitnase' ),
				'no'  => esc_html__( 'No', 'fitnase' ),
			),
			'default' => 'no',
			'desc'    => esc_html__( 'Hide banner title. You can change this settings on individual page / post.', 'fitnase' ),
		),

		array(
			'id'      => 'hide_banner_breadcrumb',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Hide Banner Breadcrumb', 'fitnase' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'fitnase' ),
				'no'  => esc_html__( 'No', 'fitnase' ),
			),
			'default' => 'no',
			'desc'    => esc_html__( 'Hide banner breadcrumb. You can change this settings on individual page / post.', 'fitnase' ),
		),

		array(
			'id'            => 'banner_default_height',
			'type'          => 'dimensions',
			'title'         => esc_html__( 'Banner Height', 'fitnase' ),
			'output'        => '.banner-area',
			'width'         => false,
			'height'        => true,
			'desc'          => esc_html__( 'Select banner height. You can change this settings on individual page / post.', 'fitnase' ),
		),
	)
) );