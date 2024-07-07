<?php
namespace Elementor;

class Fitnase_Brand_Image_Slider_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_brand_slider';
	}

	public function get_title() {
		return esc_html__( 'Brand Slider', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'brand_images',
			[
				'label' => esc_html__( 'Brand Image', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'brand_name',
			[
				'label'       => esc_html__( 'Brand Name', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'This field is optional.', 'fitnase-core' ),
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'       => esc_html__( 'Image', 'fitnase-core' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'image_link',
			[
				'label'         => esc_html__( 'Image Link', 'fitnase-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_url( 'https://your-link.com' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'brands',
			[
				'label'       => esc_html__( 'Images', 'fitnase-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ brand_name }}}',
			]
		);

		$this->add_control(
		    'grayscale',
		    [
		        'label'     => esc_html__( 'Gray Scale', 'fitnase-core' ),
		        'type'      => Controls_Manager::SWITCHER,
		        'label_on'  => esc_html__( 'Yes', 'fitnase-core' ),
		        'label_off' => esc_html__( 'No', 'fitnase-core' ),
		        'default'   => 'yes',
		    ]
		);

		$this->end_controls_section();

		//Slider Options
		$this->start_controls_section(
			'brand_slider_options',
			[
				'label' => __( 'Slider Options', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'slider_height',
			[
				'label' => esc_html__( 'Height', 'fitnase-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'description' => esc_html__('Use same as image height.', 'fitnase-core'),
				'selectors' => [
					'{{WRAPPER}} .ep-single-brand-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'autoplay',
			[
				'label'       => __( 'Autoplay', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'no',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'       => __( 'Autoplay Interval', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					'2000'  => __( '2 seconds', 'fitnase-core' ),
					'3000'  => __( '3 seconds', 'fitnase-core' ),
					'4000'  => __( '4 seconds', 'fitnase-core' ),
					'5000'  => __( '5 seconds', 'fitnase-core' ),
					'6000'  => __( '6 seconds', 'fitnase-core' ),
					'7000'  => __( '7 seconds', 'fitnase-core' ),
					'8000'  => __( '8 seconds', 'fitnase-core' ),
					'9000'  => __( '9 seconds', 'fitnase-core' ),
					'10000' => __( '10 seconds', 'fitnase-core' ),
				],
				'default'     => '4000',
				'condition'   => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'infinity_loop',
			[
				'label'       => __( 'Loop', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'desktop_count',
			[
				'label'   => __( 'Desktop Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 5,
				'options' => [
					1  => __( '1 Column', 'fitnase-core' ),
					2  => __( '2 Column', 'fitnase-core' ),
					3  => __( '3 Column', 'fitnase-core' ),
					4  => __( '4 Column', 'fitnase-core' ),
					5  => __( '5 Column', 'fitnase-core' ),
					6  => __( '6 Column', 'fitnase-core' ),
					7  => __( '7 Column', 'fitnase-core' ),
					8  => __( '8 Column', 'fitnase-core' ),
					9  => __( '9 Column', 'fitnase-core' ),
					10 => __( '10 Column', 'fitnase-core' ),
					11 => __( '11 Column', 'fitnase-core' ),
					12 => __( '12 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'ipad_pro_count',
			[
				'label'   => __( 'Ipad Pro Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 4,
				'options' => [
					1  => __( '1 Column', 'fitnase-core' ),
					2  => __( '2 Column', 'fitnase-core' ),
					3  => __( '3 Column', 'fitnase-core' ),
					4  => __( '4 Column', 'fitnase-core' ),
					5  => __( '5 Column', 'fitnase-core' ),
					6  => __( '6 Column', 'fitnase-core' ),
					7  => __( '7 Column', 'fitnase-core' ),
					8  => __( '8 Column', 'fitnase-core' ),
					9  => __( '9 Column', 'fitnase-core' ),
					10 => __( '10 Column', 'fitnase-core' ),
					11 => __( '11 Column', 'fitnase-core' ),
					12 => __( '12 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'tab_count',
			[
				'label'   => __( 'Tablet Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 4,
				'options' => [
					1  => __( '1 Column', 'fitnase-core' ),
					2  => __( '2 Column', 'fitnase-core' ),
					3  => __( '3 Column', 'fitnase-core' ),
					4  => __( '4 Column', 'fitnase-core' ),
					5  => __( '5 Column', 'fitnase-core' ),
					6  => __( '6 Column', 'fitnase-core' ),
					7  => __( '7 Column', 'fitnase-core' ),
					8  => __( '8 Column', 'fitnase-core' ),
					9  => __( '9 Column', 'fitnase-core' ),
					10 => __( '10 Column', 'fitnase-core' ),
					11 => __( '11 Column', 'fitnase-core' ),
					12 => __( '12 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'mobile_count',
			[
				'label'   => __( 'Mobile Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 3,
				'options' => [
					1 => __( '1 Column', 'fitnase-core' ),
					2 => __( '2 Column', 'fitnase-core' ),
					3 => __( '3 Column', 'fitnase-core' ),
					4 => __( '4 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'entrance_animation',
			[
				'label' => __( 'Entrance Animation', 'fitnase-core' ),
				'type' => Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
				'separator' => 'before ',
			]
		);

		$this->add_control(
			'brand_animation_duration',
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

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$slider_id = rand(100, 1000);
		if ( $settings['entrance_animation'] ) {
			$td_animation          = 'wow' . ' ' . $settings['entrance_animation'];
			$td_animation_duration = $settings['brand_animation_duration'];
		} else {
			$td_animation          = '';
			$td_animation_duration = '';
		}
		?>
		<div class="ep-brand-image-wrapper <?php echo $td_animation;?>" <?php echo $td_animation_duration;?>>

            <div id="ep-brand-image-slider-<?php echo $slider_id;?>" class="row">
	            <?php foreach ( $settings['brands'] as $brand ) :
	            $image_src = $brand['image']['url'];
	            $image_alt = get_post_meta( $brand['image']['id'], '_wp_attachment_image_alt', true );
	            $image_title = get_the_title( $brand['image']['id']);

	            $image_link = $brand['image_link']['url'];
	            $target = $brand['image_link']['is_external'] ? ' target="_blank"' : '';
	            $nofollow = $brand['image_link']['nofollow'] ? ' rel="nofollow"' : '';
	            ?>

                <div class="col-12 <?php if($settings['grayscale'] == 'yes'){echo 'ep-image-grayscale';} ?>">
                    <div class="ep-single-brand-image">
                        <div class="ep-brand-image">
                            <?php if(!empty($image_link)) : ?>
                            <a href="<?php echo $brand['image_link']['url'] ?>" <?php echo $target . $nofollow;?>>
                                <?php endif; ?>
                                <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">
                                <?php if($image_link) : ?>
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
	            <?php endforeach; ?>
            </div>
		</div>


		<script>
            (function ($) {
                "use strict";
                $(document).ready(function () {
                    $("#ep-brand-image-slider-<?php echo $slider_id;?>").slick({
                        slidesToShow: <?php echo json_encode( $settings['desktop_count'] )?>,
                        autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                        autoplaySpeed: <?php echo json_encode( $settings['autoplay_interval'] )?>, //interval
                        speed: 1500, // slide speed
                        dots: false,
                        arrows: false,
                        prevArrow: '<i class="slick-arrow slick-prev eicon-chevron-left"></i>',
                        nextArrow: '<i class="slick-arrow slick-next eicon-chevron-right"></i>',
                        infinite: <?php echo json_encode( $settings['infinity_loop'] == 'yes' ? true : false ); ?>,
                        pauseOnHover: false,
                        centerMode: false,
                        responsive: [
                            {
                                breakpoint: 1025,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['ipad_pro_count'] )?>,
                                }
                            },

                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['tab_count'] )?>, //768-991
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['mobile_count'] )?>, // 0 -767
                                }
                            }
                        ]
                    });
                });
            })(jQuery);
		</script>
		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Brand_Image_Slider_Widget );