<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function fitnase_register_custom_posts() {

	// service
	if(function_exists('fitnase_option')){
		$service_slug = fitnase_option('service_url_slug');
	}else{
		$service_slug = 'service';
	}
	
	register_post_type( 'fitnase_service',
		array(
			'labels'       => array(
				'name'                  => esc_html__( 'Services', 'fitnase-core' ),
				'singular_name'         => esc_html__( 'Service', 'fitnase-core' ),
				//'all_items'           => esc_html__(  'All Items', 'epfitness' ),
				//'add_new_item'        => esc_html__(  'Add New Item', 'epfitness' ),
				'add_new'             => esc_html__(  'Add New', 'epfitness' ),
				'new_item'            => esc_html__(  'New Item', 'epfitness' ),
				'edit_item'           => esc_html__(  'Edit Item', 'epfitness' ),
				'update_item'         => esc_html__(  'Update Item', 'epfitness' ),
				'view_item'           => esc_html__(  'View Item', 'epfitness' ),
				'search_items'        => esc_html__(  'Search Item', 'epfitness' ),
				'not_found'           => esc_html__(  'Not found', 'epfitness' ),
				'not_found_in_trash'  => esc_html__(  'Not found in Trash', 'epfitness' ),
			),
			'rewrite' 				=> array('slug' => _x( $service_slug, 'URL slug', 'fitnase-core' )),			
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				//'show_in_rest'    => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
		)
	);
	
	register_taxonomy(
		'fitnase_service_cat',
		'fitnase_service',
		array(
			'hierarchical'      => true,
			'label'             => esc_html__( 'Service Categories', 'fitnase-core' ),
			'query_var'         => true,
			'show_admin_column' => true,
			//'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$service_slug.'-category',
				'with_front' => true,
			)
		)
	);

	register_taxonomy(
		'fitnase_service_tag',
		'fitnase_service',
		array(
			'hierarchical'      => false,
			'label'             => esc_html__( 'Service Tags', 'fitnase-core' ),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			//'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$service_slug.'-tag',
				'with_front' => true,
			),
		)
	);


	//Team Members
	if(function_exists('fitnase_option')){
		$team_slug = fitnase_option('team_url_slug');
	}else{
		$team_slug = 'team';
	}

	register_post_type('fitnase_team',
		array(
			'labels'       => array(
				'name'                  => esc_html__('Team Members', 'fitnase-core'),
				'singular_name'         => esc_html__('Team Member', 'fitnase-core'),
				'add_new_item'          => esc_html__('Add New Member', 'fitnase-core'),
				'all_items'             => esc_html__('All Members', 'fitnase-core'),
				'add_new'               => esc_html__('Add New', 'fitnase-core'),
				'edit_item'             => esc_html__('Edit Member', 'fitnase-core'),
				'featured_image'        => esc_html__('Member Image', 'fitnase-core'),
				'set_featured_image'    => esc_html__('Set member image', 'fitnase-core'),
				'remove_featured_image' => esc_html__('Remove member image', 'fitnase-core'),
				'use_featured_image'    => esc_html__('Use as member image', 'fitnase-core'),
			),
			'rewrite'      => array(
				'slug'       => $team_slug,
				'with_front' => true,
			),
			'hierarchical' => true,
			'public'       => true,
			'menu_icon'    => 'dashicons-businessman',
			//'show_in_rest'    => true,
			'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes'),
		)
	);

	register_taxonomy(
		'fitnase_team_cat',
		'fitnase_team',
		array(
			'hierarchical'      => true,
			'label'             => esc_html__('Team Categories', 'fitnase-core'),
			'query_var'         => true,
			'show_admin_column' => true,
			//'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$team_slug.'-category',
				'with_front' => true,
			)
		)
	);

	register_taxonomy(
		'fitnase_team_tag',
		'fitnase_team',
		array(
			'hierarchical'          => false,
			'label'                 => esc_html__( 'Team Tags', 'fitnase-core' ),
			'show_ui'               => true,
			'show_admin_column'          => true,
			'query_var'             => true,
			//'show_in_rest'    => true,
			'rewrite'               => array(
				'slug'       => ''.$team_slug.'-tag',
				'with_front' => true,
			),
		)
	);

	// Project
	/*if(function_exists('fitnase_option')){
		$project_slug = fitnase_option('project_url_slug');
	}else{
		$project_slug = 'project';
	}

	register_post_type( 'fitnase_project',
		array(
			'labels'       => array(
				'name'                  => esc_html__( 'Projects', 'fitnase-core' ),
				'singular_name'         => esc_html__( 'Project', 'fitnase-core' ),
				'add_new_item'          => esc_html__( 'Add New Project', 'fitnase-core' ),
				'all_items'             => esc_html__( 'All Projects', 'fitnase-core' ),
				'add_new'               => esc_html__( 'Add New', 'fitnase-core' ),
				'edit_item'             => esc_html__( 'Edit Project', 'fitnase-core' ),
				'featured_image'        => esc_html__( 'Project Image', 'fitnase-core' ),
				'set_featured_image'    => esc_html__( 'Set Project Image', 'fitnase-core' ),
				'remove_featured_image' => esc_html__( 'Remove Project Image', 'fitnase-core' ),
				'use_featured_image'    => esc_html__( 'Use as project image', 'fitnase-core' ),
			),
			'rewrite'      => array(
				'slug'       => $project_slug,
				'with_front' => true,
			),
			'hierarchical' => true,
			'public'       => true,
			'menu_icon'    => 'dashicons-schedule',
			//'show_in_rest'    => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'fitnase_project_cat',
		'fitnase_project',
		array(
			'hierarchical'      => true,
			'label'             => esc_html__( 'Project Categories', 'fitnase-core' ),
			'query_var'         => true,
			'show_admin_column' => true,
			//'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$project_slug.'-category',
				'with_front' => true,
			)
		)
	);

	register_taxonomy(
		'fitnase_project_tag',
		'fitnase_project',
		array(
			'hierarchical'          => false,
			'label'                 => esc_html__( 'Project Tags', 'fitnase-core' ),
			'show_ui'               => true,
			'show_admin_column'          => true,
			'query_var'             => true,
			//'show_in_rest'    => true,
			'rewrite'               => array(
				'slug'       => ''.$project_slug.'-tag',
				'with_front' => true,
			),
		)
	);*/
}

add_action( 'init', 'fitnase_register_custom_posts' );