<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // If this file is called directly, abort.

class Fitnase_ContactForm7_Widget extends Widget_Base {

	public function get_name() {
		return 'fitnase_contact_form_seven';
	}

	public function get_title() {
		return __( 'Contact Form7', 'fitnase-core' );
	}

	public function get_icon() {
		return 'eicon-mail';
	}

	public function get_categories() {
		return array( 'fitnase_elements' );
	}


	protected function register_controls() {


		$this->start_controls_section(
			'contact_form_options',
			[
				'label' => __( 'Contact Form', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wpcf7_form_list',
			[
				'label'       => __( 'Select Contact Form', 'fitnase-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => $this->fitnase_contact_form(),
			]
		);

		$this->add_control(
			'extra_css_class',
			[
				'label'       => esc_html__( 'Extra Css Classes', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you want to use extra css classes type class name here', 'fitnase-core' ),
				'label_block' => true,
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
			'form_animation_duration',
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

		$this->start_controls_section(
			'fitnase_contact_field_style',
			[
				'label' => __( 'Field Style', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'field_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container select'   => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container input'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container select'                         => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container .ep-form-control-wrapper input' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container textarea'                       => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_border_color_on_focus',
			[
				'label'     => esc_html__( 'Border Color On Focus', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container select:focus'   => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container input:focus'    => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container textarea:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container ::placeholder'           => 'color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container :-ms-input-placeholder'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container ::-ms-input-placeholder' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container select'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container input'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container textarea' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_icon_color',
			[
				'label'     => esc_html__( 'Field Icon Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-form-control-wrapper i'               => 'color: {{VALUE}};',
					'{{WRAPPER}} .ep-form-control-wrapper.dropdown:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'textarea_height',
			[
				'label'      => __( 'Textarea Height', 'fitnase-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .fitnase-contact-form-container textarea' => 'height: {{SIZE}}px;',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'fitnase_contact_submit_style',
			[
				'label' => __( 'Submit Button', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		//Normal & hover option start
		$this->start_controls_tabs( 'td_btn_styles' );

		//Normal style start
		$this->start_controls_tab(
			'btn_normal_style',
			[
				'label' => esc_html__( 'Normal', 'fitnase-core' ),
			]
		);

		$this->add_control(
			'normal_txt_color',
			[
				'label'     => esc_html__( 'Text Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container input[type="submit"]'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container button[type="submit"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container input[type="submit"]'  => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container button[type="submit"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container input[type="submit"]'  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container button[type="submit"]' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		//Normal style end

		//Hover style start
		$this->start_controls_tab(
			'btn_hover_style',
			[
				'label' => esc_html__( 'Hover', 'fitnase-core' ),
			]
		);

		$this->add_control(
			'hover_txt_color',
			[
				'label'     => esc_html__( 'Text Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container input[type="submit"]:hover'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container button[type="submit"]:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container input[type="submit"]:hover'  => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container button[type="submit"]:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'fitnase-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fitnase-contact-form-container input[type="submit"]:hover'  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fitnase-contact-form-container button[type="submit"]:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		//Hover style end
		$this->end_controls_tabs();
		//Normal & hover option end

		$this->end_controls_section();

	}

	protected function fitnase_contact_form() {

		if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
			return array();
		}

		$forms = \WPCF7_ContactForm::find( array(
			'orderby' => 'title',
			'order'   => 'ASC',
		) );

		if ( empty( $forms ) ) {
			return array();
		}

		$result = array();

		foreach ( $forms as $item ) {
			$key            = sprintf( '%1$s::%2$s', $item->id(), $item->title() );
			$result[ $key ] = $item->title();
		}

		return $result;
	}


	protected function render() {

		$settings = $this->get_settings();

		if ( $settings['entrance_animation'] ) {
			$td_animation          = 'wow' . ' ' . $settings['entrance_animation'];
			$td_animation_duration = $settings['form_animation_duration'];
		} else {
			$td_animation          = '';
			$td_animation_duration = '';
		}

		if ( ! empty( $settings['wpcf7_form_list'] ) ) { ?>
            <div class="fitnase-contact-form-container <?php echo $td_animation;?> <?php echo $settings['extra_css_class']; ?>" <?php echo $td_animation_duration;?>>
				<?php echo do_shortcode( '[contact-form-7 id="' . $settings['wpcf7_form_list'] . '" ]' ); ?>
            </div>
			<?php
		}
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_ContactForm7_Widget );