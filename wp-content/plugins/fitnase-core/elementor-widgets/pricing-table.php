<?php
namespace Elementor;

class Fitnase_Pricing_Table_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_pricing_table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'procing_table_options',
			[
				'label' => esc_html__( 'Pricing Table', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'title',
		    [
		        'label'       => __( 'Title', 'fitnase-core' ),
		        'label_block'       => true,
		        'type'        => Controls_Manager::TEXT,
		        'default'     => 'Basic Package'
		    ]
		);

		$this->add_control(
			'price',
			[
				'label'       => __( 'Price', 'fitnase-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '$550'
			]
		);

		$this->add_control(
			'duration',
			[
				'label'       => __( 'Duration', 'fitnase-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Monthly'
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
		    'feature',
		    [
		        'label'       => __( 'Features List', 'fitnase-core' ),
		        'type'        => Controls_Manager::TEXT,
		        'default'     => '5 Days In A Week',
		        'label_block' => true,
		    ]
		);

		$repeater->add_control(
		    'icon_color',
		    [
		        'label'       => esc_html__('Icon Color', 'fitnase-core'),
		        'type'        => Controls_Manager::COLOR,
                'default' => '#ff5e17',
		    ]
		);

		$repeater->add_control(
			'text_color',
			[
				'label'       => esc_html__('Text Color', 'fitnase-core'),
				'type'        => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
		    'features_list',
		    [
		        'label'       => __( 'Features List', 'fitnase-core' ),
		        'type'        => Controls_Manager::REPEATER,
		        'fields'      => $repeater->get_controls(),
		        'default'     => [
		            [
		                'feature' => '5 Days In A Week',
		            ],
		        ],
		        'title_field' => '{{{ feature }}}',
		    ]
		);

		$this->add_control(
		    'btn_text',
		    [
		        'label'       => __( 'Button Text', 'fitnase-core' ),
		        'label_block'       => true,
		        'type'        => Controls_Manager::TEXT,
		        'default'     => 'Get Started Now'
		    ]
		);

		$this->add_control(
			'btn_url',
			[
				'label'       => __( 'Button Url', 'fitnase-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '#'
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="ep-pricing-wrapper">
			<h4 class="ep-pricing-title"><?php echo $settings['title'];?></h4>

			<div class="ep-pricing-price-wrapper text-center">
				<div class="ep-price-box">
					<h6 class="ep-pricing-price ep-primary-color"><?php echo $settings['price'];?></h6>
					<span class="ep-pricing-duration"><?php echo $settings['duration'];?></span>
				</div>
			</div>

			<div class="ep-pricing-features">
				<ul class="ep-list-style">
					<?php if ( $settings['features_list'] ) {
						foreach ( $settings['features_list'] as $list ) {
						    $icon_color = $list['icon_color'];
						    $text_color = $list['text_color'];
						    ?>
                            <li <?php if($text_color){ echo 'style="color:'.$text_color.'"';}?>><i class="fas fa-check" <?php if($icon_color){ echo 'style="color:'.$icon_color.'"';}?>></i><?php echo $list['feature'];?></li>
						<?php }
					} ?>
				</ul>
			</div>

			<div class="ep-pricing-button">
				<a href="<?php echo $settings['btn_url'];?>" class="ep-button"><?php echo $settings['btn_text'];?></a>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Pricing_Table_Widget );