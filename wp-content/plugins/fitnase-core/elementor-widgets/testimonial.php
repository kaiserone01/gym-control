<?php
namespace Elementor;

class Fitnase_Testimonial_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_testimonial';
	}

	public function get_title() {
		return esc_html__( 'Testimonial', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'testimonial_settings',
			[
				'label' => esc_html__( 'Testimonials', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
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

		$repeater->add_control(
			'name',
			[
				'label'       => esc_html__( 'Name', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Bernice Grant',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'designation',
			[
				'label'       => esc_html__( 'Designation', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Senior Trainer',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'fitnase-core' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => '<p>“ Printing and typesetting industry hasen been industry standard dummy text ever since the 500 when unknown prnter took a galleys of type and scrambled to make typeing industry has been industry specimen book has survived. Lorem ipsum is most used demo text on demo website. "</p>',
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => esc_html__( 'Testimonials List', 'fitnase-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'name'        => 'Bernice Grant',
						'designation' => 'Senior Trainer',
						'description' => '<p>“ Printing and typesetting industry hasen been industry standard dummy text ever since the 500 when unknown prnter took a galleys of type and scrambled to make typeing industry has been industry specimen book has survived. Lorem ipsum is most used demo text on demo website. "</p>',
					],
				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();

		// Slider Options
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
				'label'       => esc_html__( 'Autoplay', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'fade',
			[
				'label'       => esc_html__( 'Fade Effect', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'no',
			]
		);

		$this->add_control(
			'arrows',
			[
				'label'       => esc_html__( 'Navigation Arrows', 'fitnase-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'desktop_column',
			[
				'label'       => esc_html__( 'Column On Desktop', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'fitnase-core' ),
					2 => __( '2 Column', 'fitnase-core' ),
					3 => __( '3 Column', 'fitnase-core' ),
					4 => __( '4 Column', 'fitnase-core' ),
				],
				'default'     => 1,
			]
		);

		$this->add_control(
			'tab_column',
			[
				'label'       => __( 'Column On Tablet', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'fitnase-core' ),
					2 => __( '2 Column', 'fitnase-core' ),
					3 => __( '3 Column', 'fitnase-core' ),
					4 => __( '4 Column', 'fitnase-core' ),
				],
				'default'     => 1,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_style',
			[
				'label' => esc_html__( 'Style', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'shape_color',
			[
				'label'       => esc_html__('Image Shape Color One', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-image-shape-one,{{WRAPPER}} .ep-image-shape-two' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shape_color_two',
			[
				'label'       => esc_html__('Image Shape Color Two', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-image-shape-one:before,{{WRAPPER}} .ep-image-shape-two:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'       => esc_html__('Image Border Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-image' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		$testimonial_id = rand(10, 10000);
		?>
        <div class="ep-testimonial-slider-wrapper">
            <div id="ep-testimonial-<?php echo esc_attr($testimonial_id);?>" class="row">
				<?php
				if ( $settings['testimonials'] ) {
					foreach ( $settings['testimonials'] as $testimonial ) {
						$image_src = $testimonial['selected_image']['url'];
						$image_alt   = get_post_meta( $testimonial['selected_image']['id'], '_wp_attachment_image_alt', true );
						$image_title = get_the_title( $testimonial['selected_image']['id'] );
						?>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="ep-image-widget-wrapper">
                                        <div class="ep-image">
                                            <div class="ep-image-shape-one ep-primary-bg"></div>
                                            <div class="ep-image-shape-two ep-primary-bg"></div>
                                            <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr( $image_title );?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8 col-md-8 my-auto">
                                    <div class="ep-testimonial-item">
                                        <div class="ep-testimonial-desc">
											<?php echo $testimonial['description']; ?>
                                        </div>
                                        <div class="ep-testimonial-shape-two ep-primary-bg">
                                            <div class="ep-testimonial-shape-three"></div>
                                        </div>

                                        <div class="ep-testimonial-info">
                                            <h6 class="name"><?php echo $testimonial['name'];?></h6>
                                            <span class="designation ep-primary-color"><?php echo $testimonial['designation'];?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php }
				} ?>
            </div>

            <script>
                (function ($) {
                    "use strict";
                    $(document).ready(function () {
                        $("#ep-testimonial-<?php echo esc_js($testimonial_id);?>").slick({
                            slidesToShow: <?php echo json_encode( $settings['desktop_column'] )?>,
                            autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                            autoplaySpeed: 4000,
                            speed: 1500, // slide speed
                            dots: false,
                            arrows: <?php echo json_encode( $settings['arrows'] == 'yes' ? true : false ); ?>,
                            prevArrow: '<i class="slick-arrow slick-prev flaticon-right-arrow"></i>',
                            nextArrow: '<i class="slick-arrow slick-next flaticon-right-arrow"></i>',
                            infinite:  true,
                            fade: <?php echo json_encode( $settings['fade'] == 'yes' ? true : false ); ?>,
                            pauseOnHover: false,
                            centerMode: false,
                            responsive: [
                                {
                                    breakpoint: 1025,
                                    settings: {
                                        slidesToShow: <?php echo json_encode( $settings['tab_column'] )?>, // 992-1024
                                    }
                                },
                                {
                                    breakpoint: 992,
                                    settings: {
                                        slidesToShow: <?php echo json_encode( $settings['tab_column'] )?>, //768-991
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 1, // 0 -767
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

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Testimonial_Widget );