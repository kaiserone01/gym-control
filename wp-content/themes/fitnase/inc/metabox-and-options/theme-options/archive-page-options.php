<?php
//Archive Options

CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Archive Page', 'fitnase' ),
	'id'     => 'archive_page_options',
	'icon'   => 'fa fa-file-archive-o',
	'fields' => array(
		array(
			'id'      => 'archive_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Archive Layout', 'fitnase' ),
			'options' => array(
				'full-width'    => esc_html__( 'Full Width', 'fitnase' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'fitnase' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'fitnase' ),
				'grid'          => esc_html__( 'Grid Full', 'fitnase' ),
				'grid-ls'       => esc_html__( 'Grid With Left Sidebar', 'fitnase' ),
				'grid-rs'       => esc_html__( 'Grid With Right Sidebar', 'fitnase' ),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__( 'Select archive page layout.', 'fitnase' ),
		),

		array(
			'id'       => 'archive_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Archive Banner', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Enable or disable archive page banner.', 'fitnase' ),
		),

		array(
			'id'                    => 'archive_banner_background_options',
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
			'dependency'            => array( 'archive_banner', '==', true ),
			'output'                => '.banner-area.archive-banner',
			'desc'                  => esc_html__( 'If you want different banner background settings for archive page then select archive page banner background Options from here.', 'fitnase' ),
		),
	)
) );