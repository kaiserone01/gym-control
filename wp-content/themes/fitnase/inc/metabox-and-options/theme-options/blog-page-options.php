<?php

// Create blog page options
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Blog Page', 'fitnase' ),
	'id'     => 'blog_page_options',
	'icon'   => 'fa fa-pencil-square-o',
	'fields' => array(

		array(
			'id'      => 'blog_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Blog Layout', 'fitnase' ),
			'options' => array(
				'full-width'    => esc_html__( 'Full Width', 'fitnase' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'fitnase' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'fitnase' ),
				'grid'          => esc_html__( 'Grid Full', 'fitnase' ),
				'grid-ls'       => esc_html__( 'Grid With Left Sidebar', 'fitnase' ),
				'grid-rs'       => esc_html__( 'Grid With Right Sidebar', 'fitnase' ),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__( 'Select blog page layout.', 'fitnase' ),
		),

		array(
			'id'       => 'blog_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Blog Banner', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Enable or disable blog page banner.', 'fitnase' ),
		),

		array(
			'id'                    => 'blog_banner_background_options',
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
			'dependency'            => array( 'blog_banner', '==', true ),
			'output'                => '.banner-area.blog-banner',
			'desc'                  => esc_html__( 'If you want different banner background settings for blog page then select blog page banner background Options from here.', 'fitnase' ),
		),

		array(
			'id'       => 'enable_blog_banner_title',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Banner Title', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Hide / Show blog banner title.', 'fitnase' ),
			'dependency' => array( 'blog_banner', '==', true ),
		),

		array(
			'id'         => 'blog_title',
			'type'       => 'text',
			'title'      => esc_html__( 'Banner Title', 'fitnase' ),
			'desc'       => esc_html__( 'Type blog banner title here.', 'fitnase' ),
			'dependency' => array( 'blog_banner|enable_blog_banner_title', '==|==', 'true|true' ),
		),

		array(
			'id'       => 'enable_blog_banner_breadcrumb',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Banner Breadcrumb', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Hide / Show blog banner title.', 'fitnase' ),
			'dependency' => array( 'blog_banner', '==', true ),
		),

		array(
			'id'       => 'post_author',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Show Author Name', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Hide / Show post author name.', 'fitnase' ),
		),

		array(
			'id'       => 'post_date',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Show Post Date', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Hide / Show post date.', 'fitnase' ),
		),

		array(
			'id'         => 'cmnt_number',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Show Comment Number', 'fitnase' ),
			'default'    => true,
			'text_on'    => esc_html__( 'Yes', 'fitnase' ),
			'text_off'   => esc_html__( 'No', 'fitnase' ),
			'desc'       => esc_html__( 'Hide / Show post comment number.', 'fitnase' ),
			'dependency' => array( 'blog_layout', 'any', 'full-width,right-sidebar,left-sidebar' ),
		),

		array(
			'id'         => 'show_category',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Show Category Name', 'fitnase' ),
			'default'    => true,
			'text_on'    => esc_html__( 'Yes', 'fitnase' ),
			'text_off'   => esc_html__( 'No', 'fitnase' ),
			'desc'       => esc_html__( 'Hide / Show post category name.', 'fitnase' ),
			'dependency' => array( 'blog_layout', 'any', 'full-width,right-sidebar,left-sidebar' ),
		),

		array(
			'id'       => 'read_more_button',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Show Read More Button', 'fitnase' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Hide / Show post read more button.', 'fitnase' ),
		),

		array(
			'id'         => 'blog_read_more_text',
			'type'       => 'text',
			'title'      => esc_html__( 'Read More Button Text', 'fitnase' ),
			'desc'       => esc_html__( 'Type blog read more button here.', 'fitnase' ),
			'dependency' => array( 'read_more_button', '==', true ),
		),
	)
) );