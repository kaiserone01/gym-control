<?php
namespace Elementor;

class Fitnase_Image_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_image';
	}

	public function get_title() {
		return esc_html__( 'Fitnase Image', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-image';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {
		$this->start_controls_section(
			'image_settings',
			[
				'label' => esc_html__( 'Image', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'selected_image',
			[
				'label'       => __( 'Image', 'fitnase-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_responsive_control(
			'image_align',
			[
				'label'       => esc_html__('Image Align', 'fitnase-core'),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,

				'options' => [
					'left' => [
						'title' => __('Left', 'fitnase-core'),
						'icon'  => 'eicon-h-align-left',
					],

					'center' => [
						'title' => __('Center', 'fitnase-core'),
						'icon'  => 'eicon-h-align-center',
					],

					'right' => [
						'title' => __('Right', 'fitnase-core'),
						'icon'  => 'eicon-h-align-right',
					],
				],

				'devices' => ['desktop', 'tablet', 'mobile'],

				'selectors' => [
					'{{WRAPPER}} .ep-image-widget-wrapper' => 'text-align: {{VALUE}};',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    'image_style',
		    [
		        'label' => esc_html__( 'Fitnase Image', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'shape_color',
		    [
		        'label'       => esc_html__('Shape Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-image-shape-one,{{WRAPPER}} .ep-image-shape-two' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
			'shape_color_two',
			[
				'label'       => esc_html__('Small Shape Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-image-shape-one:before,{{WRAPPER}} .ep-image-shape-two:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
		    'border_color',
		    [
		        'label'       => esc_html__('Border Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-image' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
			'wrapper_margin',
			[
				'label'      => esc_html__( 'Margin', 'fitnase-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-image-widget-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__( 'Padding', 'fitnase-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-image-widget-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$image_src = $settings['selected_image']['url'];
		$image_alt   = get_post_meta( $settings['selected_image']['id'], '_wp_attachment_image_alt', true );
		$image_title = get_the_title( $settings['selected_image']['id'] );
		?>
		<div class="ep-image-widget-wrapper">
            <div class="ep-image">
                <div class="ep-image-shape-one ep-primary-bg"></div>
                <div class="ep-image-shape-two ep-primary-bg"></div>
                <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr( $image_title );?>">
            </div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Image_Widget );