<?php
namespace Elementor;

class Fitnase_Video_Popup_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_video_popup';
	}

	public function get_title() {
		return esc_html__( 'Video Popup', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-youtube';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		//Content tab start
		$this->start_controls_section(
			'video_popup_settings',
			[
				'label' => esc_html__( 'Video Popup Options', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'video_url',
			[
				'label'       => esc_html__( 'Video Url', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block'        => true,
				'default'     => 'https://vimeo.com/100902001',
			]
		);

		$this->add_control(
			'overlay',
			[
				'label'     => esc_html__( 'Enable Overlay', 'fitnase-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'fitnase-core' ),
				'label_off' => esc_html__( 'No', 'fitnase-core' ),
				'default'   => 'no',
			]
		);

		$this->add_responsive_control(
			'button_size',
			[
				'label' => esc_html__( 'Button Size', 'fitnase-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .ep-video-popup-wrapper .ep-video-button:before, {{WRAPPER}} .ep-video-popup-wrapper .ep-video-button:after' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'video_height',
			[
				'label' => esc_html__( 'Height', 'fitnase-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1000,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .ep-video-popup-wrapper .ep-video-popup-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'entrance_animation',
			[
				'label' => esc_html__( 'Entrance Animation', 'fitnase-core' ),
				'type' => Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
			]
		);

		$this->add_control(
			'video_animation_duration',
			[
				'label'     => esc_html__( 'Animation Duration', 'fitnase-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'data-wow-duration="1.25s"',
				'options'   => [
					'data-wow-duration="2s"'    => esc_html__( 'Slow', 'fitnase-core' ),
					'data-wow-duration="1.25s"' => esc_html__( 'Normal', 'fitnase-core' ),
					'data-wow-duration=".75s"'  => esc_html__( 'Fast', 'fitnase-core' ),
				],
				'condition' => [
					'entrance_animation!' => '',
				]
			]
		);

		$this->end_controls_section();


		//Style tab start
		$this->start_controls_section(
			'video_popup_style',
			[
				'label' => esc_html__( 'Colors', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'video_background_image',
				'label' => esc_html__( 'Background', 'fitnase-core' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ep-video-popup-image',
			]
		);


		$this->add_control(
			'button_bg_color',
			[
				'label'       => esc_html__('Button Background Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-video-popup-wrapper .ep-video-button:before, {{WRAPPER}} .ep-video-popup-wrapper .ep-video-button:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label'       => esc_html__('Button Icon Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-video-popup-wrapper .ep-video-button i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'       => esc_html__('Overlay Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-video-popup-overlay' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'overlay' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		if($settings['entrance_animation']){
			$td_animation = 'wow'.' ' . $settings['entrance_animation'];
			$td_animation_duration = $settings['video_animation_duration'];
		}else{
			$td_animation ='';
			$td_animation_duration ='';
		}
		?>

		<div class="ep-video-popup-wrapper <?php echo esc_attr($td_animation);?>" <?php echo esc_attr($td_animation_duration);?>>
            <div class="ep-video-shape-one ep-primary-bg"></div>
            <div class="ep-video-shape-two ep-primary-bg"></div>
            <div class="ep-video-shape-three ep-primary-bg"></div>
			<div class="ep-video-popup-image ep-cover-bg">
				<?php if ($settings['overlay'] == 'yes') : ?>
					<div class="ep-video-popup-overlay"></div>
				<?php endif; ?>
				<a href="<?php echo esc_url($settings['video_url']);?>" class="ep-video-button mfp-iframe">
					<i class="fa fa-play"></i>
				</a>
			</div>
		</div>
		<script>
            jQuery(document).ready(function ($) {
                $(".ep-video-button").magnificPopup({
                    type: 'video',
                });
            });
		</script>

		<?php

	}

	//Template
	protected function _content_template() { ?>

		<div class="ep-video-popup-wrapper">
            <div class="ep-video-shape-one ep-primary-bg"></div>
            <div class="ep-video-shape-two ep-primary-bg"></div>
            <div class="ep-video-shape-three ep-primary-bg"></div>
			<div class="ep-video-popup-image">
				<# if ( settings.overlay == 'yes' ) { #>
				<div class="ep-video-popup-overlay"></div>
				<# } #>
				<a href="{{{settings.video_url}}}" class="ep-video-button mfp-iframe">
					<i class="fa fa-play"></i>
				</a>
			</div>
		</div>

		<script>
            jQuery(document).ready(function ($) {
                $(".ep-video-button").magnificPopup({
                    type: 'video',
                });
            });
		</script>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Video_Popup_Widget );