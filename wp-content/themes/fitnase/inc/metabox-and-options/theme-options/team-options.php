<?php
//Team Options
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Team Options', 'fitnase' ),
	'id'     => 'team_options',
	'icon'   => 'fa fa-users',
	'fields' => array(

		array(
			'id'      => 'team_default_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Team Layout', 'fitnase' ),
			'options' => array(
				'full-width'    => esc_html__( 'Full Width', 'fitnase' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'fitnase' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'fitnase' ),
			),
			'default' => 'full-width',
			'desc'    => esc_html__( 'Select team layout.', 'fitnase' ),
		),

		array(
			'id'         => 'team_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'default'    => 'fitnase-team-sidebar',
			'dependency' => array( 'team_default_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select default sidebar for all team members. You can override this settings on individual team member.', 'fitnase' ),
		),

		array(
			'id'    => 'team_url_slug',
			'type'  => 'text',
			'default' => 'team',
			'title' => esc_html__( 'URL Slug', 'fitnase' ),
			'desc'  => esc_html__( 'Change team slug on URL. Don\'t forget to reset permalink after change this.', 'fitnase' ),
		),

	)
) );