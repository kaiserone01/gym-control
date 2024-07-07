<?php
namespace Elementor;

class Fitnase_Home_Slider_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_home_slider';
	}

	public function get_title() {
		return esc_html__( 'Home Slider', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		//Content tab start
		$this->start_controls_section(
			'slider_content',
			[
				'label' => esc_html__( 'Add Slides', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
		    'slide_subtitle',
		    [
		        'label'       => __( 'Subtitle', 'fitnase-core' ),
		        'type'        => Controls_Manager::TEXTAREA,
		        'rows'        => 5,
		        'default' => 'Since - 1998.',
		        'label_block' => true,
		    ]
		);

		$repeater->add_control(
			'slide_title',
			[
				'label' => esc_html__( 'Title', 'fitnase-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<h2>Make Your Body Shape</h2>',
				'description' => __( 'Use Heading ( H1 - H6 ) for title text.' , 'fitnase-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_desc',
			[
				'label'       => __( 'Description Text', 'fitnase-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<p>It is a long established fact that reader will distracted readable content of page when looking its layout.</p>',
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'slide_image',
			[
				'label' => __( 'Slide Image', 'fitnase-core' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'btn1_text',
			[
				'label' => __( 'Button One Text', 'fitnase-core' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
				'label_block' => true,
				'default' => 'Read More',
				'placeholder' => __( 'Type button text here.', 'fitnase-core' ),
			]
		);

		$repeater->add_control(
			'btn1_url',
			[
				'label' => __( 'Button One URL', 'fitnase-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'fitnase-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		//Button 2 Text
		$repeater->add_control(
			'btn2_text',
			[
				'label' => __( 'Button Two Text', 'fitnase-core' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
				'label_block' => true,
				'placeholder' => __( 'Type button text here.', 'fitnase-core' ),
			]
		);

		//Button 2 Url
		$repeater->add_control(
			'btn2_url',
			[
				'label' => __( 'Button Two URL', 'fitnase-core' ),
				'type' => Controls_Manager::URL,
				'separator' => 'before',
				'placeholder' => __( 'https://your-link.com', 'fitnase-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'slide_items',
			[
				'label' => __( 'Slide List', 'fitnase-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'slide_subtitle' => 'Since - 1998',
						'slide_title' => '<h2>Make Your Body Shape</h2>',
						'slide_desc' => '<p>It is a long established fact that reader will distracted readable content of page when looking its layout.</p>',
					],
				],
				'title_field' => '{{{ slide_title }}}',
			]
		);

		$this->end_controls_section();

		//Start slider  options control
		$this->start_controls_section(
			'home_slider_options',
			[
				'label' => __( 'Slider Options', 'fitnase-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[
				'label' => __( 'Slider Height (px)', 'fitnase-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 1500,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .ep-home-slider-area .ep-single-slide-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'fitnase-core' ),
				'type' => Controls_Manager::SWITCHER,
				'show_label' => true,
				'label_block' => false,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label' => __( 'Autoplay Interval', 'fitnase-core' ),
				'type' => Controls_Manager::SELECT,
				'show_label' => true,
				'label_block' => false,
				'options' => [
					'2000'  => __( '2 seconds', 'fitnase-core' ),
					'3000'  => __( '3 seconds', 'fitnase-core' ),
					'4000'  => __( '4 seconds', 'fitnase-core' ),
					'5000'  => __( '5 seconds', 'fitnase-core' ),
					'6000'  => __( '6 seconds', 'fitnase-core' ),
					'7000'  => __( '7 seconds', 'fitnase-core' ),
					'8000'  => __( '8 seconds', 'fitnase-core' ),
					'9000'  => __( '9 seconds', 'fitnase-core' ),
					'10000'  => __( '10 seconds', 'fitnase-core' ),
				],
				'default' => '6000',
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'nav_arrow',
			[
				'label' => __( 'Navigation Arrow On Hover', 'fitnase-core' ),
				'type' => Controls_Manager::SWITCHER,
				'show_label' => true,
				'label_block' => false,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'nav_dots',
			[
				'label' => __( 'Navigation Dots', 'fitnase-core' ),
				'type' => Controls_Manager::SWITCHER,
				'show_label' => true,
				'label_block' => false,
				'default' => 'no',
			]
		);

		$this->add_control(
			'slider_animation',
			[
				'label' => __( 'Animation', 'fitnase-core' ),
				'type' => Controls_Manager::SWITCHER,
				'show_label' => true,
				'label_block' => false,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
		//Slider  options control end


		$this->start_controls_section(
			'content_setting',
			[
				'label' => esc_html__( 'Content', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'xxl_column',
			[
				'label'   => __( 'Extra Large Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xxl-5',
				'options' => [
					'col-xxl-1' => __( '1 Column', 'fitnase-core' ),
					'col-xxl-2'  => __( '2 Column', 'fitnase-core' ),
					'col-xxl-3'  => __( '3 Column', 'fitnase-core' ),
					'col-xxl-4'  => __( '4 Column', 'fitnase-core' ),
					'col-xxl-5'  => __( '5 Column', 'fitnase-core' ),
					'col-xxl-6'  => __( '6 Column', 'fitnase-core' ),
					'col-xxl-7'  => __( '7 Column', 'fitnase-core' ),
					'col-xxl-8'  => __( '8 Column', 'fitnase-core' ),
					'col-xxl-9'  => __( '9 Column', 'fitnase-core' ),
					'col-xxl-10'  => __( '10 Column', 'fitnase-core' ),
					'col-xxl-11'  => __( '11 Column', 'fitnase-core' ),
					'col-xxl-12'  => __( '12 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'desktop_column',
			[
				'label'   => __( 'Desktop Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-6',
				'options' => [
					'col-xl-1' => __( '1 Column', 'fitnase-core' ),
					'col-xl-2'  => __( '2 Column', 'fitnase-core' ),
					'col-xl-3'  => __( '3 Column', 'fitnase-core' ),
					'col-xl-4'  => __( '4 Column', 'fitnase-core' ),
					'col-xl-5'  => __( '5 Column', 'fitnase-core' ),
					'col-xl-6'  => __( '6 Column', 'fitnase-core' ),
					'col-xl-7'  => __( '7 Column', 'fitnase-core' ),
					'col-xl-8'  => __( '8 Column', 'fitnase-core' ),
					'col-xl-9'  => __( '9 Column', 'fitnase-core' ),
					'col-xl-10'  => __( '10 Column', 'fitnase-core' ),
					'col-xl-11'  => __( '11 Column', 'fitnase-core' ),
					'col-xl-12'  => __( '12 Column', 'fitnase-core' ),
				],
			]
		);
		

		$this->add_control(
			'ipad_pro_column',
			[
				'label'   => __( 'iPad Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-7',
				'options' => [
					'col-lg-1' => __( '1 Column', 'fitnase-core' ),
					'col-lg-2'  => __( '2 Column', 'fitnase-core' ),
					'col-lg-3'  => __( '3 Column', 'fitnase-core' ),
					'col-lg-4'  => __( '4 Column', 'fitnase-core' ),
					'col-lg-5'  => __( '5 Column', 'fitnase-core' ),
					'col-lg-6'  => __( '6 Column', 'fitnase-core' ),
					'col-lg-7'  => __( '7 Column', 'fitnase-core' ),
					'col-lg-8'  => __( '8 Column', 'fitnase-core' ),
					'col-lg-9'  => __( '9 Column', 'fitnase-core' ),
					'col-lg-10'  => __( '10 Column', 'fitnase-core' ),
					'col-lg-11'  => __( '11 Column', 'fitnase-core' ),
					'col-lg-12'  => __( '12 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'ipad_column',
			[
				'label'   => __( 'iPad Column', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-9',
				'options' => [
					'col-md-1' => __( '1 Column', 'fitnase-core' ),
					'col-md-2'  => __( '2 Column', 'fitnase-core' ),
					'col-md-3'  => __( '3 Column', 'fitnase-core' ),
					'col-md-4'  => __( '4 Column', 'fitnase-core' ),
					'col-md-5'  => __( '5 Column', 'fitnase-core' ),
					'col-md-6'  => __( '6 Column', 'fitnase-core' ),
					'col-md-7'  => __( '7 Column', 'fitnase-core' ),
					'col-md-8'  => __( '8 Column', 'fitnase-core' ),
					'col-md-9'  => __( '9 Column', 'fitnase-core' ),
					'col-md-10'  => __( '10 Column', 'fitnase-core' ),
					'col-md-11'  => __( '11 Column', 'fitnase-core' ),
					'col-md-12'  => __( '12 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => esc_html__( 'Content Margin', 'fitnase-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-slider-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Subtitle Style
		$this->start_controls_section(
			'subtitle_style_options',
			[
				'label' => esc_html__( 'Subtitle', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typo',
				'label' => __( 'Typography', 'fitnase-core' ),
				'selector' => '
                    {{WRAPPER}} .slide-subtitle
                ',
			]
		);

		$this->add_control(
		    'subtitle_color',
		    [
		        'label'       => esc_html__('Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
		        'selectors'   => [
		            '{{WRAPPER}} .slide-subtitle' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .slide-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// Title Style
		$this->start_controls_section(
			'title_style_options',
			[
				'label' => esc_html__( 'Title', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'label' => __( 'Typography', 'fitnase-core' ),
				'selector' => '
                    {{WRAPPER}} .ep-slide-title h1,
                    {{WRAPPER}} .ep-slide-title h2,
                    {{WRAPPER}} .ep-slide-title h3,
                    {{WRAPPER}} .ep-slide-title h4,
                    {{WRAPPER}} .ep-slide-title h5,
                    {{WRAPPER}} .ep-slide-title h6
                ',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__('Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-slide-title h1,{{WRAPPER}} .ep-slide-title h2,{{WRAPPER}} .ep-slide-title h3,
                    {{WRAPPER}} .ep-slide-title h4,{{WRAPPER}} .ep-slide-title h5,{{WRAPPER}} .ep-slide-title h6' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ep-slide-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Description Style
		$this->start_controls_section(
			'description_style_options',
			[
				'label' => esc_html__( 'Description', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typo',
				'label' => __( 'Typography', 'fitnase-core' ),
				'selector' => '
                    {{WRAPPER}} .ep-slide-desc
                ',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'       => esc_html__('Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-slide-desc' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ep-slide-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// Start Button section
		$this->start_controls_section(
			'button_style_options',
			[
				'label' => esc_html__('Button Style', 'fitnase-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
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
			'button_default_bg',
			[
				'label'     => esc_html__('Background Color', 'fitnase-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slider-button-wrapper .ep-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_default_border',
			[
				'label'     => esc_html__('Border Color', 'fitnase-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slider-button-wrapper .ep-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_default_text_color',
			[
				'label'     => esc_html__('Text Color', 'fitnase-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slider-button-wrapper .ep-button' => 'color: {{VALUE}};',
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
			'button_hover_bg',
			[
				'label'     => esc_html__('Background Color', 'fitnase-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slider-button-wrapper .ep-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border',
			[
				'label'     => esc_html__('Border Color', 'fitnase-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slider-button-wrapper .ep-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__('Text Color', 'fitnase-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slider-button-wrapper .ep-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();//Hover style tab end

		$this->end_controls_section();// End Button section


		$this->start_controls_section(
			'slider_dot_style',
				[
				'label' => esc_html__( 'Slider Dot And Arrow', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'nav_arrow',
							'operator' => '==',
							'value' => [
								'yes',
							],
						],
						[
							'name' => 'nav_dots',
							'operator' => '==',
							'value' => [
								'yes',
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'dot_color',
			[
				'label'       => esc_html__('Dot Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-home-slider-area .slick-dots button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'nav_dots' => 'yes',
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'       => esc_html__('Active Dot Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-home-slider-area .slick-dots .slick-active button,
					{{WRAPPER}}  .ep-home-slider-area .slick-dots button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'nav_dots' => 'yes',
				],
			]
		);

		$this->add_control(
			'arrow_bg',
			[
				'label'       => esc_html__('Arrow Background Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-home-slider-area .slick-arrow' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'nav_arrow' => 'yes',
				],
			]
		);

		$this->add_control(
			'arrow_hover_bg',
			[
				'label'       => esc_html__('Arrow Background Hover Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-home-slider-area .slick-arrow:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'nav_arrow' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	//Render In HTML
	protected function render() {
		$settings = $this->get_settings_for_display();
		$sliderId = rand(10, 1000);
		$ep_column = $settings['xxl_column'].' '. $settings['desktop_column']. ' '. $settings['ipad_pro_column']. ' '. $settings['ipad_column'];
		if(is_rtl()){
			$slide_dir = 'dir="rtl"';
			$slide_rtl = 'rtl: true,';
		}else{
			$slide_dir = '';
			$slide_rtl = '';
		}
		?>
		<div class="ep-home-slider-area">
			<div <?php echo $slide_dir;?>  id="ep-home-slider-<?php echo esc_attr($sliderId);?>" class="ep-home-slider-wrapper">

				<?php
				if($settings['slide_items']){
					foreach($settings['slide_items'] as $slider){ ?>

						<div class="ep-single-slide-item ep-cover-bg" style="background-image: url(<?php echo esc_url($slider['slide_image']['url'])?>)">

                            <div class="container">
                                <div class="row">
                                    <div class="<?php echo $ep_column;?>">
                                        <div class="ep-slider-content-wrapper">
                                            <div class="ep-slider-content">

                                                <span class="slide-subtitle ep-primary-color ep-heading-fonts" data-animation="fadeInUp" data-delay=".5s"><?php echo $slider['slide_subtitle'];?></span>
                                                <div class="ep-slide-title" data-animation="fadeInUp" data-delay="1s">
                                                    <?php echo $slider['slide_title'];?>
                                                </div>

                                                <div class="ep-slide-desc" data-animation="fadeInUp" data-delay="1.5s">
                                                    <?php echo $slider['slide_desc'];?>
                                                </div>

                                                <div class="slider-button-wrapper">

                                                    <?php if(!empty($slider['btn1_text'])) :
                                                        $target = $slider['btn1_url']['is_external'] ? ' target="_blank"' : '';
                                                        $nofollow = $slider['btn1_url']['nofollow'] ? ' rel="nofollow"' : '';
                                                        ?>
                                                        <a data-animation="fadeInUp"  data-delay="2s" href="<?php echo esc_url($slider['btn1_url']['url'])?>" class="ep-button" <?php echo  $target . $nofollow?>><?php echo esc_html($slider['btn1_text']) ?><i class="flaticon-double-right-arrow"></i></a>
                                                    <?php endif;?>

                                                    <?php if(!empty($slider['btn2_text'])) :
                                                        $target2 = $slider['btn2_url']['is_external'] ? ' target="_blank"' : '';
                                                        $nofollow2 = $slider['btn2_url']['nofollow'] ? ' rel="nofollow"' : '';
                                                        ?>
                                                        <a data-animation="fadeInUp"  data-delay="2.5s" href="<?php echo esc_url($slider['btn2_url']['url'])?>" class="ep-button slider-button-two" <?php echo  $target2 . $nofollow2?>><?php echo esc_html($slider['btn2_text']) ?><i class="flaticon-double-right-arrow"></i></a>
                                                    <?php endif;?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						<?php

					}
				}
				?>
			</div>
		</div>


		<?php if($settings['slide_items'] && count($settings['slide_items']) > 1 ) :?>

			<script>
                (function ($) {
                    "use strict";
                    //Documnet Ready Function
                    $( document ).ready(function() {
                        // slider - active
                        function homeSlider() {
                            var SliderActive = $('#ep-home-slider-<?php echo esc_js($sliderId)?>');

                            SliderActive.slick({
                                slidesToShow: 1,
                                autoplay: <?php echo json_encode($settings['autoplay'] == 'yes' ? true : false); ?>,
                                autoplaySpeed: <?php echo json_encode($settings['autoplay_interval'])?>,
                                speed: 1000, // slide speed
                                dots: <?php echo json_encode($settings['nav_dots'] == 'yes' ? true : false); ?>,
                                fade: true,
                                draggable: true,
                                pauseOnHover: false,
								<?php echo $slide_rtl;?>
                                arrows: <?php echo json_encode($settings['nav_arrow'] == 'yes' ? true : false); ?>,
                                prevArrow: '<i class="slick-arrow slick-prev fas fa-angle-double-left ep-primary-bg"></i>',
                                nextArrow: '<i class="slick-arrow slick-next fas fa-angle-double-right ep-primary-bg"></i>',
                                responsive: [
                                    {
                                        breakpoint: 992,
                                        settings: {
                                            //768-991
                                            arrows:false
                                        }
                                    },
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            // 0 -767
                                            dots:<?php echo json_encode($settings['nav_dots'] == 'yes' ? true : false); ?>,
                                            arrows:false
                                        }
                                    }
                                ]
                            });

							<?php if($settings['slider_animation'] === 'yes') :?>
                            function doAnimations(elements) {
                                var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                                elements.each(function () {
                                    var $this = $(this);
                                    var $animationDelay = $this.data('delay');
                                    var $animationType = 'animated ' + $this.data('animation');
                                    $this.css({
                                        'animation-delay': $animationDelay,
                                        '-webkit-animation-delay': $animationDelay
                                    });
                                    $this.addClass($animationType).one(animationEndEvents, function () {
                                        $this.removeClass($animationType);
                                    });
                                });
                            }

                            SliderActive.on('init', function (e, slick) {
                                var $firstAnimatingElements = $('.ep-single-slide-item:first-child').find('[data-animation]');
                                doAnimations($firstAnimatingElements);
                            });

                            SliderActive.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
                                var $animatingElements = $('.ep-single-slide-item[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
                                doAnimations($animatingElements);
                            });
							<?php endif;?>
                        }
                        homeSlider();

                    });
                })(jQuery);
			</script>

		<?php endif; ?>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Home_Slider_Widget );
