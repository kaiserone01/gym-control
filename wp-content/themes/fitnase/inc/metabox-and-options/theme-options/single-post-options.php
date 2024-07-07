<?php
//Single Post

CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Single Post / Post Details', 'fitnase' ),
	'id'     => 'single_post_options',
	'icon'   => 'fa fa-pencil',
	'fields' => array(

		array(
			'id'      => 'single_post_default_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Layout', 'fitnase' ),
			'options' => array(
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'fitnase' ),
				'full-width'    => esc_html__( 'Full Width', 'fitnase' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'fitnase' ),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__( 'Select single post layout', 'fitnase' ),
		),


		array(
			'id'         => 'single_post_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'default' => 'fitnase-sidebar',
			'dependency' => array( 'single_post_default_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select default sidebar for all posts. You can override this settings on individual post.', 'fitnase' ),
		),

		array(
			'id'      => 'hide_single_post_banner_title',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Hide Post Banner Title', 'fitnase' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'fitnase' ),
				'no'  => esc_html__( 'No', 'fitnase' ),
			),
			'default' => 'no',
			'desc'    => esc_html__( 'Hide banner title. You can change this settings on individual post.', 'fitnase' ),
		),

		array(
			'id'       => 'show_post_default_title',
			'type'     => 'switcher',
			'title'    => esc_html__('Show Post Title On Banner?', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Show post title on single post banner area. Default title is "Blog" for all single post.', 'fitnase'),
			'default'  => false,
			'dependency' => array( 'hide_single_post_banner_title', '==', 'no' ),
		),

		array(
			'id'         => 'post_banner_title',
			'type'       => 'text',
			'title'      => esc_html__('Banner Default Title', 'fitnase'),
			'desc'       => esc_html__('Default banner title for all post.', 'fitnase'),
			'dependency' => array( 'show_post_default_title|hide_single_post_banner_title', '==|==', 'false|no' ),
		),

		array(
			'id'      => 'hide_single_post_breadcrumb',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Hide Post Breadcrumb', 'fitnase' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'fitnase' ),
				'no'  => esc_html__( 'No', 'fitnase' ),
			),
			'default' => 'yes',
			'desc'    => esc_html__( 'Show / Hide Post breadcrumb. You can change this settings on individual post.', 'fitnase' ),
		),

		array(
			'id'       => 'single_post_author',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Author Name', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Hide or show author name on post details page.', 'fitnase'),
			'default'  => true
		),

		array(
			'id'       => 'single_post_date',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Date', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Hide or show date on post details page.', 'fitnase'),
			'default'  => true
		),

		array(
			'id'       => 'single_post_cmnt',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Comments Number', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Hide or show comments number on post details page.', 'fitnase'),
			'default'  => true,
		),

		array(
			'id'       => 'single_post_cat',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Categories', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Hide or show categories on post details page.', 'fitnase'),
			'default'  => true
		),

		array(
			'id'       => 'single_post_tag',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Tags', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Hide or show tags on post details page.', 'fitnase'),
			'default'  => true
		),

		array(
			'id'       => 'post_share',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Share icons', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Hide or show social share icons on post details page.', 'fitnase'),
			'default'  => true
		),

		array(
			'id'       => 'prev_next_post',
			'type'     => 'switcher',
			'title'    => esc_html__('Previous / Next Post Thumbnail', 'fitnase'),
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Hide or show previous / next Post thumbnail on post details page.', 'fitnase'),
			'default'  => true
		),

		array(
			'id'       => 'post_details_link_color',
			'type'     => 'color',
			'title'    => esc_html__('link Color', 'fitnase'),
			'desc'     => esc_html__('Select link color.', 'fitnase'),
			'output'   => array(

				'color' => '.post-details-wrapper .entry-content a',
			)
		),

		array(
			'id'       => 'post_details_link_hover_color',
			'type'     => 'color',
			'title'    => esc_html__('link Hover Color', 'fitnase'),
			'desc' => esc_html__('Select link hover color', 'fitnase'),
			'output'   => array(

				'color' => '.post-details-wrapper .entry-content a:hover',
			)
		),
	)
) );