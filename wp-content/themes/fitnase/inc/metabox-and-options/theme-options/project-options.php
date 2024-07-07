<?php
//Project Option
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Project Options', 'fitnase' ),
	'id'     => 'project_options',
	'icon'   => 'fa fa-th',
	'fields' => array(
		array(
			'id'      => 'project_default_layout',
			'type'    => 'select',
			'title'   => esc_html__('Project Layout', 'fitnase'),
			'options' => array(
				'full-width'  => esc_html__('Full Width', 'fitnase'),
				'left-sidebar'  => esc_html__('Left Sidebar', 'fitnase'),
				'right-sidebar' => esc_html__('Right Sidebar', 'fitnase'),
			),
			'default' => 'full-width',
			'desc'    => esc_html__('Select project layout.', 'fitnase'),
		),

		array(
			'id'         => 'project_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'default' => 'fitnase-project-sidebar',
			'dependency' => array( 'project_default_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select default sidebar for all projects. You can override this settings on individual project.', 'fitnase' ),
		),

		array(
			'id'    => 'project_url_slug',
			'type'  => 'text',
			'default' => 'project',
			'title' => esc_html__( 'URL Slug', 'fitnase' ),
			'desc'  => esc_html__( 'Change project slug on URL. Don\'t forget to reset permalink after change this.', 'fitnase' ),
		),
	)
) );