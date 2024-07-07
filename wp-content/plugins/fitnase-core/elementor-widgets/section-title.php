<?php

namespace Elementor;

class Fitnase_Section_Title_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_section_title';
	}

	public function get_title() {
		return esc_html__( 'Section Title', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-t-letter';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'section_title_options',
			[
				'label' => esc_html__( 'Section Title', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'fitnase-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'OUR BEST FEATURES',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'fitnase-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<h2>Why choose us?</h2>',
				'label_block' => true,
				'description' => __( 'Use H1 - H6 for title.', 'fitnase-core' ),
			]
		);

		$this->add_control(
			'title_shape',
			[
				'label'     => esc_html__( 'Enable Title Shape', 'fitnase-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'fitnase-core' ),
				'label_off' => esc_html__( 'No', 'fitnase-core' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'fitnase-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			[
				'label'     => esc_html__( 'Subtitle', 'fitnase-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'label'    => esc_html__( 'Typography', 'fitnase-core' ),
				'selector' => '{{WRAPPER}} .ep-section-subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-section-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => esc_html__( 'Margin', 'fitnase-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label'     => esc_html__( 'Title', 'fitnase-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'fitnase-core' ),
				'selector' => '{{WRAPPER}} .ep-section-title h1, {{WRAPPER}} .ep-section-title h2, {{WRAPPER}} .ep-section-title h3, {{WRAPPER}} .ep-section-title h4, {{WRAPPER}} .ep-section-title h5, {{WRAPPER}} .ep-section-title h6',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-section-title h1, {{WRAPPER}} .ep-section-title h2, {{WRAPPER}} .ep-section-title h3, {{WRAPPER}} .ep-section-title h4, {{WRAPPER}} .ep-section-title h5, {{WRAPPER}} .ep-section-title h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
		    'shape_color',
		    [
		        'label'       => esc_html__('Shape Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-section-title-content:before' => 'border-color: {{VALUE}};',
		        ],
                'condition' => [
                    'title_shape' => 'yes',
                ],
		    ]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'fitnase-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_style',
			[
				'label'     => esc_html__( 'Description', 'fitnase-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Typography', 'fitnase-core' ),
				'selector' => '{{WRAPPER}} .ep-section-description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-section-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => esc_html__( 'Margin', 'fitnase-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_style',
			[
				'label' => esc_html__( 'Wrapper', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Width (%)', 'fitnase-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-title-content' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'fitnase-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,

				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'fitnase-core' ),
						'icon'  => 'fa fa-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Center', 'fitnase-core' ),
						'icon'  => 'fa fa-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Right', 'fitnase-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],

				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .ep-section-title-wrapper' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .ep-section-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'entrance_animation',
			[
				'label'        => esc_html__( 'Entrance Animation', 'fitnase-core' ),
				'type'         => Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
			]
		);

		$this->add_control(
			'wrapper_animation_duration',
			[
				'label'     => esc_html__( 'Animation Duration', 'fitnase-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'data-wow-duration="1.25s"',
				'options'   => [
					'data-wow-duration="2s"'    => __( 'Slow', 'fitnase-core' ),
					'data-wow-duration="1.25s"' => __( 'Normal', 'fitnase-core' ),
					'data-wow-duration=".75s"'  => __( 'Fast', 'fitnase-core' ),
				],
				'condition' => [
					'entrance_animation!' => '',
				]
			]
		);

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		$allowed_html = array(
			'h1'   => array(),
			'h2'   => array(),
			'h3'   => array(),
			'h4'   => array(),
			'h5'   => array(),
			'h6'   => array(),
			'span' => array( 'style' => array(), ),
		);

		$sub_title   = $settings['subtitle'];
		$title       = $settings['title'];
		$description = $settings['description'];

		if ( $settings['entrance_animation'] ) {
			$ep_animation          = 'wow' . ' ' . $settings['entrance_animation'];
			$ep_animation_duration = $settings['wrapper_animation_duration'];
		} else {
			$ep_animation          = '';
			$ep_animation_duration = '';
		}

		?>

		<div class="ep-section-title-wrapper <?php echo esc_attr( $ep_animation ); ?>" <?php echo esc_attr( $ep_animation_duration ); ?>>
			<div class="ep-section-title-content <?php if($settings['title_shape'] == 'yes'){echo 'shape-enable';} ?>">
				<?php if ( $sub_title ) : ?>
					<span class="ep-section-subtitle ep-primary-color"><?php echo esc_html( $sub_title ); ?></span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<div class="ep-section-title">
						<?php echo wp_kses( $title, $allowed_html ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<div class="ep-section-description">
						<?php echo wp_kses_post( $description ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Section_Title_Widget );