<?php
namespace Elementor;

class Fitnase_Photo_gallery_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_photo_gallery';
	}

	public function get_title() {
		return esc_html__( 'Photo Gallery Slider', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'gallery_setting_options',
			[
				'label' => esc_html__( 'Photo Gallery Slider', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'       => __( 'Gallery Image', 'fitnase-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				//'description' => __( 'Use 430x430 size image for better user experience', 'fitnase-core' )
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'   => __( 'Title', 'fitnase-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 5,
				'default' => 'Beginner Pilates',
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Personal Training',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'details_link',
			[
				'label'         => __( 'Details URL', 'fitnase-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'fitnase-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'gallery_items',
			[
				'label'       => __( 'Gallery Items', 'fitnase-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title' => __( 'Beginner Pilates', 'fitnase-core' ),
						'subtitle'    => __( 'Personal Training', 'fitnase-core' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'       => __( 'Autoplay', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'nav_arrow',
			[
				'label'       => __( 'Navigation Arrow', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'       => __( 'Navigation Dots', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'desktop_count',
			[
				'label'       => __( 'Column On Desktop', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'fitnase-core' ),
					2 => __( '2 Column', 'fitnase-core' ),
					3 => __( '3 Column', 'fitnase-core' ),
					4 => __( '4 Column', 'fitnase-core' ),
				],
				'default'     => 3,
			]
		);

		$this->add_control(
			'ipad_pro_count',
			[
				'label'       => __( 'Column On iPad Pro', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'fitnase-core' ),
					2 => __( '2 Column', 'fitnase-core' ),
					3 => __( '3 Column', 'fitnase-core' ),
					4 => __( '4 Column', 'fitnase-core' ),
				],
				'default'     => 3,
			]
		);

		$this->add_control(
			'ipad_count',
			[
				'label'       => __( 'Column On iPad', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'fitnase-core' ),
					2 => __( '2 Column', 'fitnase-core' ),
					3 => __( '3 Column', 'fitnase-core' ),
					4 => __( '4 Column', 'fitnase-core' ),
				],
				'default'     => 2,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
		    'gallery_style_option',
		    [
		        'label' => esc_html__( 'Gallery Slider', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'title_color',
		    [
		        'label'       => esc_html__('Title Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .ep-gallery-title' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'       => esc_html__('Subtitle Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-gallery-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'       => esc_html__('Icon Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-details-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs('ep_gallery_style_tabs');

		//Default style tab start
		$this->start_controls_tab(
		    'ep_gallery_style_default',
		    [
		        'label' => esc_html__('Default', 'fitnase-core'),
		    ]
		);


		$this->add_control(
		    'arrow_bg_color',
		    [
		        'label'       => esc_html__('Arrow Background', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}};',
		        ],
                'condition' => [
                    'nav_arrow' => 'yes',
                ],
		    ]
		);

		$this->add_control(
			'dots_bg_color',
			[
				'label'       => esc_html__('Dots Background', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-photo-gallery-wrapper .slick-dots button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'dots' => 'yes',
				],
			]
		);

		$this->end_controls_tab();//Default style tab end

		//Hover style tab start
		$this->start_controls_tab(
		    'ep_gallery_style_hover',
		    [
		        'label' => esc_html__('Hover', 'fitnase-core'),
		    ]
		);

		$this->add_control(
			'arrow_hover_color',
			[
				'label'       => esc_html__('Arrow Background', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .slick-arrow:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'nav_arrow' => 'yes',
				],
			]
		);

		$this->add_control(
			'dots_bg_hover_color',
			[
				'label'       => esc_html__('Dots Background', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-photo-gallery-wrapper .slick-dots button:hover,
{{WRAPPER}} .ep-photo-gallery-wrapper .slick-dots .slick-active button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'dots' => 'yes',
				],
			]
		);

		$this->add_control(
		    'overlay_color',
		    [
		        'label'       => esc_html__('Overlay Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .gallery-image-overlay' => 'background: linear-gradient( 180deg, transparent, {{VALUE}});',
		        ],
		    ]
		);

		$this->end_controls_tabs();//Hover style tab end

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$slider_id = rand(100, 10000);
		?>
        <div class="ep-photo-gallery-wrapper">
            <div  id="td-gallery-slider-<?php echo $slider_id;?>" class="row">
				<?php if ( $settings['gallery_items'] ) {
					foreach ( $settings['gallery_items'] as $item ) {
					    $image_src = $item['image']['url'];
						$image_alt   = get_post_meta( $item['image']['id'], '_wp_attachment_image_alt', true );
						$image_title = get_the_title( $item['image']['id'] );

						$details_url   = $item['details_link']['url'];
						$target   = $item['details_link']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $item['details_link']['nofollow'] ? ' rel="nofollow"' : '';

					    ?>
                        <div class="col-12 ep-single-gallery-item">
                            <a href="<?php echo $details_url?>" class="ep-gallery-content" <?php echo  $target . $nofollow?>>
                                <div class="gallery-image-overlay ep-transition"></div>
                                <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr( $image_title );?>">

                                <div class="ep-gallery-info-wrapper ep-transition">
                                    <div class="ep-gallery-caption">
                                        <h4 class="ep-gallery-title"><?php echo $item['title'];?></h4>
                                        <span class="ep-gallery-subtitle ep-primary-color"><?php echo $item['subtitle'];?></span>
                                    </div>

                                    <div class="ep-details-icon ep-primary-color">
                                        <i class="flaticon-right-arrow"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

					<?php }
				} ?>
            </div>

            <script>
                (function ($) {
                    'use strict';
                    $(document).ready(function () {
                        $('#td-gallery-slider-<?php echo $slider_id;?>').slick({
                            slidesToShow: <?php echo json_encode( $settings['desktop_count'] );?>,
                            autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                            autoplaySpeed: 4000, //interval
                            speed: 1500, // slide speed
                            dots: <?php echo json_encode( $settings['dots'] == 'yes' ? true : false ); ?>,
                            arrows: <?php echo json_encode( $settings['nav_arrow'] == 'yes' ? true : false ); ?>,
                            prevArrow: '<i class="slick-arrow slick-prev fas fa-angle-double-left"></i>',
                            nextArrow: '<i class="slick-arrow slick-next fas fa-angle-double-right"></i>',
                            infinite:  true,
                            pauseOnHover: false,
                            centerMode: false,
                            responsive: [
                                {
                                    breakpoint: 1025,
                                    settings: {
                                        slidesToShow: <?php echo json_encode( $settings['ipad_pro_count'] );?>,
                                    }
                                },
                                {
                                    breakpoint: 992,
                                    settings: {
                                        slidesToShow: <?php echo json_encode( $settings['ipad_count'] );?>, //768-991
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 1, // 0 -767
                                        dots: false,
                                        arrows: false,
                                    }
                                }
                            ]
                        });
                    });
                })(jQuery);
            </script>
        </div>
		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Photo_gallery_Widget );