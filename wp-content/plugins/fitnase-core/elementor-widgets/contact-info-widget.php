<?php
namespace Elementor;

class Fitnase_Contact_Form_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_contact_info';
	}

	public function get_title() {
		return esc_html__( 'Contact Info', 'fitnase-core' );
	}

	public function get_icon() {
		return 'eicon-mail';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'info_box_options',
			[
				'label' => esc_html__( 'Info Box', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'fitnase-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Phone',
			]
		);

		$repeater->add_control(
		    'type',
		    [
		        'label'       => esc_html__( 'Icon Type', 'fitnase-core' ),
		        'type'        => Controls_Manager::CHOOSE,
		        'label_block' => false,
		        'options'     => [
		            'icon'  => [
		                'title' => esc_html__( 'Icon', 'fitnase-core' ),
		                'icon'  => 'fa fa-smile-o',
		            ],
		            'image' => [
		                'title' => esc_html__( 'Image', 'fitnase-core' ),
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
		        'label'            => esc_html__( 'Select Icon', 'fitnase-core' ),
		        'type'             => Controls_Manager::ICONS,
		        'fa4compatibility' => 'icon',
		        'label_block'      => true,
		        'default'          => [
		            'value'   => 'flaticon-telephone',
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
		        'label'     => esc_html__( 'Image', 'fitnase-core' ),
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
		    'desc',
		    [
		        'label'       => __( 'Description', 'fitnase-core' ),
		        'type'        => Controls_Manager::WYSIWYG,
		        'default'     => '<ul><li><a href="tel:1234567">+88 72 658 217 83</a></li><li><a href="tel:1234567">+88 95 768 467 94</a></li></ul>',
		        'description' => __( 'Use Unordered list or paragraph.', 'fitnase-core' ),
		        'label_block' => true,
		    ]
		);

		$this->add_control(
		    'info_boxes',
		    [
		        'label'       => __( 'Info Box List', 'fitnase-core' ),
		        'type'        => Controls_Manager::REPEATER,
		        'fields'      => $repeater->get_controls(),
		        'default'     => [
		            [
		                'title' => 'Phone',
		            ],
		        ],
		        'title_field' => '{{{ title }}}',
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    'info_box_column',
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
		    'contact_info_box_style',
		    [
		        'label' => esc_html__( 'Info Box', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'title_color',
		    [
		        'label'       => esc_html__('Title Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-info-box-title' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
			'icon_color',
			[
				'label'       => esc_html__('Icon Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-info-box-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ep-info-box-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
		    'text_color',
		    [
		        'label'       => esc_html__('Text Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-info-box-desc,{{WRAPPER}} .ep-info-box-desc a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label'       => esc_html__('Link Hover Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-info-box-desc a:hover' => 'color: {{VALUE}};',
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
		<div class="ep-contact-info-wrapper">
			<div class="row">
				<?php if ( $settings['info_boxes'] ) {
					foreach ( $settings['info_boxes'] as $info_box ) { ?>
						<div class="<?php echo $ep_column;?>">
							<div class="ep-info-box">
								<div class="ep-info-box-icon ep-primary-color">
									<?php if ( $info_box['type'] === 'image' ) :
									    if ( $info_box['image']['url'] || $info_box['image']['id'] ) :
									        ?>
								            <img src="<?php echo $info_box['image']['url']; ?>" alt="<?php echo get_post_meta( $info_box['image']['id'], '_wp_attachment_image_alt', true ); ?>">
									    <?php endif;
									elseif ( ! empty( $info_box['icon'] ) || ! empty( $info_box['selected_icon'] ) ) : ?>
									        <?php fitnase_custom_icon_render( $info_box, 'icon', 'selected_icon' ); ?>
									<?php endif; ?>
								</div>

                                <h3 class="ep-info-box-title ep-primary-color"><?php echo $info_box['title'];?></h3>

                                <div class="ep-info-box-desc ep-list-style">
									<?php echo $info_box['desc'];?>
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

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Contact_Form_Widget );