<?php
// Create typography section
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Typography', 'fitnase' ),
	'id'     => 'typography_options',
	'icon'   => 'fa fa-text-width',
	'fields' => array(

		array(
			'id'             => 'body_typo',
			'type'           => 'typography',
			'title'          => esc_html__( 'Body Font', 'fitnase' ),
			'desc'           => esc_html__( 'Select primary ( body ) typography.', 'fitnase' ),
			'output'         => 'body',
			'text_align'     => false,
			'text_transform' => false,
			'color'          => true,
			'extra_styles'   => true,
			'default'        => array(
				'font-family'  => 'Roboto',
				'type'         => 'google',
				'unit'         => 'px',
				'font-weight'  => '400',
				'extra-styles' => array( '500'),
			),

		),

		array(
			'id'             => 'heading_typo',
			'type'           => 'typography',
			'title'          => esc_html__( 'Heading Font', 'fitnase' ),
			'desc'           => esc_html__( 'Select Secondary ( heading & bold ) typography.', 'fitnase' ),
			'output'         => 'h1,h2,h3,h4,h5,h6',
			'text_align'     => false,
			'text_transform' => false,
			'color'          => false,
			'extra_styles'   => true,
			'default'        => array(
				'font-family'  => 'Oswald',
				'type'         => 'google',
				'unit'         => 'px',
				'font-weight'  => '700',
				'extra-styles' => array('500'),
			),
		),
	),
) );