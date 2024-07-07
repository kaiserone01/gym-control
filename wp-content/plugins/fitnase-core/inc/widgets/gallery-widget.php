<?php

// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

	CSF::createWidget( 'fitnase_gallery_widget', array(
		'title'       => esc_html__( 'Fitnase : Gallery Widget ', 'fitnase-core' ),
		'classname'   => 'ep_gallery_widget',
		'description' => esc_html__( 'Fitnase photo gallery widget.', 'fitnase-core' ),
		'fields'      => array(

			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => esc_html__( 'Title', 'fitnase-core' ),
			),

			array(
				'id'    => 'gallery_items',
				'type'  => 'gallery',
				'title' => esc_html__( 'Gallery', 'fitnase-core' ),
			),

			array(
				'id'       => 'lightbox_slider',
				'type'     => 'switcher',
				'title'    => esc_html__( 'Enable Lightbox Slider', 'fitnase-core' ),
				'default'  => true,
				'text_on'  => esc_html__( 'Yes', 'fitnase-core' ),
				'text_off' => esc_html__( 'No', 'fitnase-core' ),
			),

		)
	) );

	//
	// Front-end display of widget
	// Attention: This function named considering above widget base id.
	//
	if ( ! function_exists( 'fitnase_gallery_widget' ) ) {
		function fitnase_gallery_widget( $args, $instance ) {

			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}

			$image_id = explode( ',', $instance['gallery_items'] ); ?>
            <div class="ep-gallery-photo-wrapper">
				<?php
				foreach ( $image_id as $gallery_item ) { ?>
                    <a class="ep-gallery-photo-url <?php if ( $instance['lightbox_slider'] == true ) {
						echo 'ep-popup-image';
					} ?>" href="<?php echo wp_get_attachment_url( $gallery_item ); ?>">
                        <div class="ep-gallery-photo-item"
                             style="background-image: url(<?php echo wp_get_attachment_url( $gallery_item ); ?>)">
                            <div class="ep-gallery-photo-overlay ep-primary-bg ep-transition">
                                <div class="ep-gallery-photo-plus">+</div>
                            </div>
                        </div>
                    </a>
					<?php
				}
				?>
            </div>

			<?php
			echo $args['after_widget'];
		}
	}
}