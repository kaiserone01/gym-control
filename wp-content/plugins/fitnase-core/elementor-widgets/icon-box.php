<?php
namespace Elementor;

class Fitnase_Icon_Box_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_icon_box';
	}

	public function get_title() {
		return esc_html__( 'Icon Box', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'icon_boxe_options',
			[
				'label' => esc_html__( 'Icon Box', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'type',
			[
				'label'       => __( 'Icon Type', 'fitnase-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'icon'  => [
						'title' => __( 'Icon', 'fitnase-core' ),
						'icon'  => 'fa fa-smile-o',
					],
					'image' => [
						'title' => __( 'Image', 'fitnase-core' ),
						'icon'  => 'fa fa-image',
					],
				],
				'default'     => 'icon',
				'toggle'      => false,
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'       => __( 'Select Icon', 'fitnase-core' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block'      => true,
				'default'          => [
					'value'   => 'flaticon-exercise-1',
					'library' => 'fitnase-fitness-icon',
				],
				'condition'        => [
					'type' => 'icon'
				]
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'     => __( 'Image', 'fitnase-core' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'type' => 'image'
				],
				'dynamic'   => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => 'Progression',
				'label_block' => true,
			]
		);

		$repeater->add_control(
		    'desc',
		    [
		        'label'       => __( 'Description', 'fitnase-core' ),
		        'type'        => Controls_Manager::WYSIWYG,
		        'default'     => 'It is a long estabas lished facts will be distracted by the content looking at its layout.',
		        'label_block' => true,
		    ]
		);

		$repeater->add_control(
			'entrance_animation',
			[
				'label' => __( 'Entrance Animation', 'fitnase-core' ),
				'type' => Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
				'separator' => 'before ',
			]
		);

		$repeater->add_control(
			'box_animation_duration',
			[
				'label'     => __( 'Animation Duration', 'fitnase-core' ),
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

		$this->add_control(
			'icon_boxes',
			[
				'label'       => __('Icon Boxes', 'fitnase-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'        => 'Progression',
						'desc' => 'It is a long estabas lished facts will be distracted by the content looking at its layout.',
						'selected_icon' => 'flaticon-exercise-1',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'column_options',
			[
				'label' => esc_html__( 'Column', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'xl_column',
			[
				'label'   => __( 'Desktop', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-6',
				'options' => [
					'col-xl-12'   => __( '1 Column', 'fitnase-core' ),
					'col-xl-6'    => __( '2 Column', 'fitnase-core' ),
					'col-xl-4'    => __( '3 Column', 'fitnase-core' ),
					'col-xl-3'    => __( '4 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'lg_column',
			[
				'label'   => __( 'iPad Pro', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-4',
				'options' => [
					'col-lg-12'   => __( '1 Column', 'fitnase-core' ),
					'col-lg-6'    => __( '2 Column', 'fitnase-core' ),
					'col-lg-4'    => __( '3 Column', 'fitnase-core' ),
					'col-lg-3'    => __( '4 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'md_column',
			[
				'label'   => __( 'iPad', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-4',
				'options' => [
					'col-md-12'   => __( '1 Column', 'fitnase-core' ),
					'col-md-6'    => __( '2 Column', 'fitnase-core' ),
					'col-md-4'    => __( '3 Column', 'fitnase-core' ),
					'col-md-3'    => __( '4 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'sm_column',
			[
				'label'   => __( 'Mobile', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-12',
				'options' => [
					'col-12'   => __( '1 Column', 'fitnase-core' ),
					'col-6'    => __( '2 Column', 'fitnase-core' ),
					'col-4'    => __( '3 Column', 'fitnase-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    'box_style',
		    [
		        'label' => esc_html__( 'Box', 'themedraft-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
		    'box_padding',
		    [
		        'label'      => esc_html__( 'Box Padding', 'themedraft-core' ),
		        'type'       => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%', 'em' ],
		        'selectors'  => [
		            '{{WRAPPER}} .ep-single-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'box_bg',
		    [
		        'label'       => esc_html__('Background Color', 'themedraft-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-single-icon-box' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'box_border_radius',
		    [
		        'label'      => esc_html__( 'Border Radius', 'themedraft-core' ),
		        'type'       => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%', 'em' ],
		        'selectors'  => [
		            '{{WRAPPER}} .ep-single-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();

		// Icon Style
		$this->start_controls_section(
		    'ep_icon_style_options',
		    [
		        'label' => esc_html__('Icon', 'fitnase-core'),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
			'icon_bg_size',
			[
				'label' => esc_html__( 'Icon Background Size', 'fitnase-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .ep-icon-box-icon' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
		    'icon_size',
		    [
		        'label' => esc_html__( 'Icon Size', 'fitnase-core' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'range' => [
		            'px' => [
		                'min' => 0,
		                'max' => 150,
		            ],
		        ],
		        'devices' => [ 'desktop', 'tablet', 'mobile' ],

		        'selectors' => [
		            '{{WRAPPER}} .ep-icon-box-icon' => 'font-size: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .ep-icon-box-icon img,{{WRAPPER}} .ep-icon-box-icon svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);



		$this->start_controls_tabs('ep_button_style_tabs');

		//Default style tab start
		$this->start_controls_tab(
		    'ep_btn_style_default',
		    [
		        'label' => esc_html__('Normal', 'fitnase-core'),
		    ]
		);

		$this->add_control(
		    'icon_bg_color',
		    [
		        'label'       => esc_html__('Background Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-icon-box-icon' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
			'icon_color',
			[
				'label'       => esc_html__('Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-icon-box-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ep-icon-box-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();//Default style tab end

		//Hover style tab start
		$this->start_controls_tab(
		    'ep_btn_style_hover',
		    [
		        'label' => esc_html__('Hover', 'fitnase-core'),
		    ]
		);

		$this->add_control(
			'icon_hover_bg_color',
			[
				'label'       => esc_html__('Background Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-single-icon-box:hover .ep-icon-box-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'       => esc_html__('Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-single-icon-box:hover .ep-icon-box-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ep-single-icon-box:hover .ep-icon-box-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();//Hover style tab end

		$this->end_controls_section();// End Button section
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column']. ' '. $settings['sm_column'];
		?>

		<div class="ep-icon-box-wrapper">
			<div class="row">

				<?php
				if($settings['icon_boxes']){
					foreach ($settings['icon_boxes'] as $icon_box){
						$title =  $icon_box['title'];
						$desc =  $icon_box['desc'];

						if ( $icon_box['entrance_animation'] ) {
							$ep_animation          = 'wow' . ' ' . $icon_box['entrance_animation'];
							$ep_animation_duration = $icon_box['box_animation_duration'];
						} else {
							$ep_animation          = '';
							$ep_animation_duration = '';
						}
						?>

						<div class="<?php echo $ep_column;?>">
							<div class="ep-single-icon-box <?php echo $ep_animation;?>" <?php echo $ep_animation_duration;?>>
								<div class="ep-icon-box-icon ep-primary-color ep-transition">
									<?php if ( $icon_box['type'] === 'image' ) :
										if ( $icon_box['image']['url'] || $icon_box['image']['id'] ) :
											?>
											<img src="<?php echo $icon_box['image']['url']; ?>" alt="<?php echo get_post_meta( $icon_box['image']['id'], '_wp_attachment_image_alt', true ); ?>">
										<?php endif;
									elseif ( ! empty( $icon_box['icon'] ) || ! empty( $icon_box['selected_icon'] ) ) :
										fitnase_custom_icon_render( $icon_box, 'icon', 'selected_icon' );
									endif; ?>
								</div>

								<h3 class="ep-icon-box-title"><?php echo esc_html($title);?></h3>

								<div class="ep-icon-box-desc">
									<?php echo wp_kses_post($desc);?>
								</div>
							</div>
						</div>

				<?php	}
				}
				?>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Icon_Box_Widget );