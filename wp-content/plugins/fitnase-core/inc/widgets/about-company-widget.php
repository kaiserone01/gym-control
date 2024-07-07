<?php

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

	CSF::createWidget( 'widget_fitnase_about_company_widget', array(
		'title'       => esc_html__('Fitnase : About Company Widget ', 'fitnase-core'),
		'classname'   => 'widget_fitnase_about_company_widget',
		'description' => esc_html__('Fitnase about company widget.', 'fitnase-core'),
		'fields'      => array(

			array(
				'id'      => 'title',
				'type'    => 'text',
				'title'   => esc_html__('Title' , 'fitnase-core'),
			),

			array(
				'id'           => 'image',
				'type'         => 'media',
				'title'        => esc_html__('Image', 'fitnase'),
				'library'      => 'image',
				'url'          => false,
				'button_title' => esc_html__('Upload Image', 'fitnase'),

			),

			array(
				'id'      => 'image_url',
				'type'    => 'text',
				'title'   => esc_html__('Image Url' , 'fitnase-core'),
			),

			array(
				'id'            => 'description',
				'type'          => 'wp_editor',
				'media_buttons' => false,
				'height'        => '100px',
				'title'         => esc_html__('Description', 'fitnase-core'),
			),

			array(
				'id'      => 'social_title',
				'type'    => 'text',
				'default'    => 'Follow Us Today:',
				'title'   => esc_html__('Social Title' , 'fitnase-core'),
			),

			array(
				'id'           => 'social_icon_list',
				'type'         => 'group',
				'title'        => esc_html__('Social Profiles', 'fitnase-core'),
				'button_title' => esc_html__('Add New Profile', 'fitnase-core'),
				'fields'       => array(

					array(
						'id'      => 'site_name',
						'type'    => 'text',
						'title'   => esc_html__('Social Site Name' , 'fitnase-core'),
					),

					array(
						'id'    => 'icon',
						'type'  => 'icon',
						'title' => esc_html__('Icon', 'fitnase-core'),
						'desc'  => esc_html__('Select icon', 'fitnase-core'),
					),

					array(
						'id'      => 'profile_url',
						'type'    => 'text',
						'title'   => esc_html__('Social Profile URL' , 'fitnase-core'),
					),

				),
				'default'      => array(
					array(
						'site_name' => 'Facebook',
						'icon' => 'fab fa-facebook-f',
						'profile_url' => '#',
					),
				),
			),
		)
	) );

	//
	// Front-end display of widget
	// Attention: This function named considering above widget base id.
	//
	if( ! function_exists( 'widget_fitnase_about_company_widget' ) ) {
		function widget_fitnase_about_company_widget( $args, $instance ) {

			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>

			<?php if($instance['image']['url']) :
				$image_src = $instance['image']['url'];
				$image_alt = $instance['image']['alt'];
				$image_url = $instance['image_url'];
				?>
				<div class="about-info-img">
					<?php if($image_url) : ?>
						<a href="<?php echo esc_url($image_url);?>">
							<img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>">
						</a>
					<?php else :?>
						<img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>">
					<?php endif;?>
				</div>
			<?php endif;?>

			<?php if($instance['description']) : ?>
				<div class="widget-about-description">
					<?php echo nl2br($instance['description']);?>
				</div>
			<?php endif; ?>


			<?php if($instance['social_title']) : ?>
                <div class="widget-social-title">
					<?php echo $instance['social_title'];?>
                </div>
			<?php endif; ?>

			<?php if ($instance['social_icon_list']) :?>
				<ul class="widget-social-icons footer-social-icon ep-list-inline">
					<?php foreach ($instance['social_icon_list'] as $social){ ?>
						<li><a href="<?php echo esc_url($social['profile_url']);?>" target="_blank"><i class="<?php echo esc_attr($social['icon']);?>"></i></a></li>
					<?php } ?>
				</ul>
			<?php endif; ?>

			<?php
			echo $args['after_widget'];
		}
	}
}