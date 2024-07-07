<?php

CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Error 404', 'fitnase' ),
	'id'     => 'archive_page_options',
	'icon'   => 'fa fa-exclamation-triangle',
	'fields' => array(
		array(
			'id'       => 'error_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Error Banner', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Enable or disable error / not found page banner.', 'fitnase' ),
		),

		array(
			'id'                    => 'error_banner_background_options',
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
			'dependency'            => array( 'error_banner', '==', true ),
			'output'                => '.banner-area.error-page-banner',
			'desc'                  => esc_html__( 'If you want different banner background settings for error / not found page then select error / not found page banner background options from here.', 'fitnase' ),
		),

		array(
			'id'         => 'error_page_title',
			'type'       => 'text',
			'title'      => esc_html__( 'Error Banner Title', 'fitnase' ),
			'desc'       => esc_html__( 'Type error banner title here.', 'fitnase' ),
			'dependency' => array( 'error_banner', '==', true ),
		),

		array(
			'id'            => 'not_found_text',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Not Found Text', 'fitnase' ),
			'tinymce'       => true,
			'quicktags'     => true,
			'media_buttons' => false,
			'height'        => '150px',
			'desc'          => esc_html__( 'Type not found text here.', 'fitnase' ),
		),

		array(
			'id'       => 'go_back_home',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Go Back Home Button', 'fitnase' ),
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Enable or disable go back home button.', 'fitnase' ),
			'default'  => true
		),
	)
) );