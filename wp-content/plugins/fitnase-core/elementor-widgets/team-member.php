<?php
namespace Elementor;

class Fitnase_Team_Member_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_team_member';
	}

	public function get_title() {
		return esc_html__( 'Team Member', 'fitnase-core' );
	}

	public function get_icon() {

		return 'fas fa-users';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'team_member_option',
			[
				'label' => esc_html__( 'Team Members', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'member_name',
			[
				'label'       => esc_html__( 'Member Name', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Richard Steele',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'designation',
			[
				'label'       => __( 'Designation', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Senior Trainer',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'       => __( 'Member Image', 'fitnase-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
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
			'team_animation_duration',
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
			'members',
			[
				'label'       => __( 'Member List', 'fitnase-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'member_name' => 'Richard Steele',
						'designation' => 'Senior Trainer',
					],
				],
				'title_field' => '{{{ member_name }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'column_settings',
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
		    'box_style',
		    [
		        'label' => esc_html__( 'Box', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'box_border_color',
		    [
		        'label'       => esc_html__('Border Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .right-border .ep-single-member:before,{{WRAPPER}} .bottom-border .ep-single-member:after' => 'background-color: {{VALUE}};',
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
		            '{{WRAPPER}} .ep-single-member' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ep-single-member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->start_controls_tabs('ep_box_style_tabs');
		
		//Default style tab start
		$this->start_controls_tab(
		    'ep_box_style_default',
		    [
		        'label' => esc_html__('Default', 'fitnase-core'),
		    ]
		);

		$this->add_control(
		    'box_bg_color',
		    [
		        'label'       => esc_html__('Background Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-member-info-wrapper,{{WRAPPER}} .ep-member-info-wrapper:before' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
			'info_top_border_color',
			[
				'label'       => esc_html__('Info Top Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-member-info-wrapper:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'       => esc_html__('Name Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-member-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'designation_color',
			[
				'label'       => esc_html__('Designation Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-member-designation' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();//Default style tab end
		
		//Hover style tab start
		$this->start_controls_tab(
		    'ep_box_style_hover',
		    [
		        'label' => esc_html__('Hover', 'fitnase-core'),
		    ]
		);

		$this->add_control(
			'box_bg_hover_color',
			[
				'label'       => esc_html__('Background Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-member-img-and-info:hover .ep-member-info-wrapper,{{WRAPPER}} .ep-member-img-and-info:hover .ep-member-info-wrapper:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_top_border_hover_color',
			[
				'label'       => esc_html__('Info Top Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-member-img-and-info:hover .ep-member-info-wrapper:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'designation_hover_color',
			[
				'label'       => esc_html__('Designation Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-member-img-and-info:hover .ep-member-designation' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column']. ' '. $settings['sm_column'];
		$count = count($settings['members']);
		?>
		<div class="ep-team-member-wrapper ep-total-<?php echo $count;?>-members">
			<div class="row">

				<?php
				if ( $settings['members'] ) {
					foreach ( $settings['members'] as $member) {
						$name = $member['member_name'];
						$designation = $member['designation'];
						$image_src   = $member['image']['url'];
						$image_alt   = get_post_meta( $member['image']['id'], '_wp_attachment_image_alt', true );
						$image_title = get_the_title( $member['image']['id'] );

						$details_url   = $member['details_url']['url'];
						$target   = $member['details_url']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $member['details_url']['nofollow'] ? ' rel="nofollow"' : '';

						if ( $member['entrance_animation'] ) {
							$ep_animation          = ' wow' . ' ' . $member['entrance_animation'];
							$ep_animation_duration = $member['team_animation_duration'];
						} else {
							$ep_animation          = '';
							$ep_animation_duration = '';
						}
					    ?>

                        <div class="<?php echo $ep_column.$ep_animation;?>" <?php echo $ep_animation_duration;?>>
                            <div class="ep-single-member">
                                <a href="<?php echo esc_url($details_url);?>" class="ep-member-img-and-info" <?php echo $target . $nofollow?>>
                                    <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr( $image_title );?>">

                                    <div class="ep-member-info-wrapper ep-transition">
                                        <div class="ep-member-info">
                                            <h4 class="ep-member-name"><?php echo $name;?></h4>
                                            <span class="ep-member-designation ep-transition"><?php echo $designation;?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
					<?php }
				}
				?>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Team_Member_Widget );