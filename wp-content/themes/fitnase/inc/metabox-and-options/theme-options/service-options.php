<?php
//Service Option
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Service Options', 'fitnase' ),
	'id'     => 'service_options',
	'icon'   => 'fa fa-th',
	'fields' => array(
		array(
			'id'      => 'service_default_layout',
			'type'    => 'select',
			'title'   => esc_html__('Service Layout', 'fitnase'),
			'options' => array(
				'full-width'  => esc_html__('Full Width', 'fitnase'),
				'left-sidebar'  => esc_html__('Left Sidebar', 'fitnase'),
				'right-sidebar' => esc_html__('Right Sidebar', 'fitnase'),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__('Select service layout.', 'fitnase'),
		),

		array(
			'id'         => 'service_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'default' => 'fitnase-service-sidebar',
			'dependency' => array( 'service_default_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select default sidebar for all services. You can override this settings on individual service.', 'fitnase' ),
		),

		array(
			'id'    => 'service_url_slug',
			'type'  => 'text',
			'default' => 'service',
			'title' => esc_html__( 'URL Slug', 'fitnase' ),
			'desc'  => esc_html__( 'Change service slug on URL. Don\'t forget to reset permalink after change this.', 'fitnase' ),
		),
	)
) );