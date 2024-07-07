<?php
namespace Elementor;

class Fitnase_Service_Box_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_service_box';
	}

	public function get_title() {
		return esc_html__( 'Service Box', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'service_box_settings',
			[
				'label' => esc_html__( 'Service Box', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'thumbnail',
			[
				'label'       => __( 'Thumbnail Image', 'fitnase-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => 'Weight Lifting',
				'label_block' => true,
			]
		);

		$repeater->add_control(
		    'desc',
		    [
		        'label'       => __( 'Description', 'fitnase-core' ),
		        'type'        => Controls_Manager::WYSIWYG,
		        'default'     => 'It is long estabas and many lished fact will been distracted atempts by them content system and looking for its layout.',
		        'label_block' => true,
		    ]
		);

		$repeater->add_control(
			'details_url',
			[
				'label'         => __( 'Details URL', 'fitnase-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'fitnase-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
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
			'service_animation_duration',
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
			'services',
			[
				'label'       => __('Service List', 'fitnase-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'        => 'Weight Lifting',
						'desc' => 'It is long estabas and many lished fact will been distracted atempts by them content system and looking for its layout.',
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
				'default' => 'col-xl-4',
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
				'default' => 'col-md-6',
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
		    'box_style_option',
		    [
		        'label' => esc_html__( 'Box', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'border_color',
		    [
		        'label'       => esc_html__('Border Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-single-service-box' => 'border-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'box_margin',
		    [
		        'label'      => esc_html__( 'Margin', 'fitnase-core' ),
		        'type'       => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%', 'em' ],
		        'selectors'  => [
		            '{{WRAPPER}} .ep-single-service-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label'      => esc_html__( 'Padding', 'fitnase-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-single-service-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    'title_style_option',
		    [
		        'label' => esc_html__( 'Title', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'title_typo',
		        'label' => esc_html__( 'Typography', 'fitnase-core' ),
		        'selector' => '{{WRAPPER}} .ep-service-title',
		    ]
		);

		$this->add_control(
		    'title_color',
		    [
		        'label'       => esc_html__('Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-service-title' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'       => esc_html__('Hover Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-service-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    'description_style',
		    [
		        'label' => esc_html__( 'Description', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'desc_typo',
		        'label' => esc_html__( 'Typography', 'fitnase-core' ),
		        'selector' => '{{WRAPPER}} .ep-service-desc',
		    ]
		);

        $this->add_control(
            'desc_color',
            [
                'label'       => esc_html__('Color', 'fitnase-core'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .ep-service-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
		    'icon_style',
		    [
		        'label' => esc_html__( 'Details Url Icon', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'icon_color',
		    [
		        'label'       => esc_html__('Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-service-url' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'icon_hover_color',
		    [
		        'label'       => esc_html__('Hover Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-service-url:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->end_controls_section();
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column']. ' '. $settings['sm_column'];
		?>
		<div class="ep-service-box-wrapper">
            <div class="row">
                <?php if ( $settings['services'] ) {
                    foreach ( $settings['services'] as $service ) {
	                    $image_src   = wp_get_attachment_image_url( $service['thumbnail']['id'], 'fitnase-service' );
                        $image_alt   = get_post_meta( $service['thumbnail']['id'], '_wp_attachment_image_alt', true );
                        $image_title = get_the_title( $service['thumbnail']['id'] );
	                    $title = $service['title'];

	                    $details_url = $service['details_url']['url'];
	                    $target   = $service['details_url']['is_external'] ? ' target="_blank"' : '';
	                    $nofollow = $service['details_url']['nofollow'] ? ' rel="nofollow"' : '';

	                    if ( $service['entrance_animation'] ) {
		                    $td_animation          = 'wow' . ' ' . $service['entrance_animation'];
		                    $td_animation_duration = $service['service_animation_duration'];
	                    } else {
		                    $td_animation          = '';
		                    $td_animation_duration = '';
	                    }
                        ?>
                        <div class="<?php echo $ep_column;?>">
                            <div class="ep-single-service-box <?php echo $td_animation;?>" <?php echo $td_animation_duration;?>>
                                <div class="ep-service-image">
                                    <div class="ep-service-overlay ep-transition"></div>
                                    <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php echo esc_attr( $image_title );?>">

                                    <a href="<?php echo esc_url($details_url);?>" <?php echo $target . $nofollow ?> class="ep-service-url">
                                        <span class="ep-plus-icon"></span>
                                    </a>
                                </div>

                                <a href="<?php echo esc_url($details_url);?>" <?php echo $target . $nofollow ?>>
                                    <h3 class="ep-service-title ep-transition"><?php echo esc_html($title);?></h3>
                                </a>

                                <div class="ep-service-desc">
                                    <?php echo $service['desc'];?>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
		</div>
		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Service_Box_Widget );