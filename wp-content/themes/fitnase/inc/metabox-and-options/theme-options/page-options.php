<?php

// Create Page Options
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Page Options', 'fitnase' ),
	'id'     => 'page_options',
	'icon'   => 'fa fa-file-text-o',
	'fields' => array(
		array(
			'id'      => 'page_default_layout',
			'type'    => 'select',
			'title'   => esc_html__('Page Layout', 'fitnase'),
			'options' => array(
				'full-width'  => esc_html__('Full Width', 'fitnase'),
				'left-sidebar'  => esc_html__('Left Sidebar', 'fitnase'),
				'right-sidebar' => esc_html__('Right Sidebar', 'fitnase'),
			),
			'default' => 'full-width',
			'desc'    => esc_html__('Select page layout.', 'fitnase'),
		),

		array(
			'id'         => 'page_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'default' => 'fitnase-sidebar',
			'dependency' => array( 'page_default_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select default sidebar for all pages. You can override this settings on individual page.', 'fitnase' ),
		),
	)
) );