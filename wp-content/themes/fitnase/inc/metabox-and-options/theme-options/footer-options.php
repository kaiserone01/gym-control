<?php
// Create Footer section

CSF::createSection( $fitnase_theme_option, array(
	'title' => esc_html__( 'Footer Settings', 'fitnase' ),
	'id'    => 'all_footer_options',
	'icon'  => 'fa fa-wordpress',
) );


CSF::createSection( $fitnase_theme_option, array(
	'parent' => 'all_footer_options',
	'title'  => esc_html__( 'Footer Options', 'fitnase' ),
	'id'     => 'footer_options',
	'icon'   => 'fa fa-wordpress',
	'fields' => array(
		array(
			'id'      => 'footer_widget_column',
			'type'    => 'select',
			'title'   => esc_html__( 'Widget Column', 'fitnase' ),
			'desc'    => esc_html__( 'Select widget area column number.', 'fitnase' ),
			'options' => array(
				'col-lg-12' => esc_html__( '1 Column', 'fitnase' ),
				'col-lg-6'  => esc_html__( '2 Column', 'fitnase' ),
				'col-lg-4'  => esc_html__( '3 Column', 'fitnase' ),
				'col-lg-3'  => esc_html__( '4 Column', 'fitnase' ),
			),
			'default' => 'col-lg-3',
		),

		array(
			'id'                    => 'widget_area_background',
			'type'                  => 'background',
			'title'                 => esc_html__( 'Widget Area Background', 'fitnase' ),
			'background_gradient'   => false,
			'background_origin'     => false,
			'background_clip'       => false,
			'background_blend-mode' => false,
			'background_attachment' => true,
			'background_size'       => true,
			'background_position'   => true,
			'background_repeat'     => true,
			'output'                => '.footer-widget-area',
			'desc'                  => esc_html__( 'Select footer widget area background color and image.', 'fitnase' ),
		),

		array(
			'id'            => 'footer_info_left_text',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Footer Info Left Text', 'fitnase' ),
			'desc'          => esc_html__( 'Type footer info left text here.', 'fitnase' ),
			'tinymce'       => true,
			'quicktags'     => true,
			'media_buttons' => false,
			'height'        => '100px',
		),

		array(
			'id'            => 'copyright_text',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Copyright Text', 'fitnase' ),
			'desc'          => esc_html__( 'Type site copyright text here.', 'fitnase' ),
			'tinymce'       => true,
			'quicktags'     => true,
			'media_buttons' => false,
			'height'        => '100px',
		),

		array(
			'id'          => 'copyright_area_bg_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Copyright Area Background Color', 'fitnase' ),
			'desc'        => esc_html__( 'Select copyright area background color.', 'fitnase' ),
			'output'   => array(
				'background-color' => '.footer-bottom-area',
			),
		),

		array(
			'id'       => 'go_to_top_button',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Go Top Button', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Enable or disable go to top button.', 'fitnase' ),
		),
	)
) );