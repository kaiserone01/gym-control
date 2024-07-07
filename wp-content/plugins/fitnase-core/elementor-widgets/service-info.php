<?php
namespace Elementor;

class Fitnase_Service_Info_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_service_info';
	}

	public function get_title() {
		return esc_html__( 'Service Info', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-alert';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'service_info_settings',
			[
				'label' => esc_html__( 'Service Info', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
		    'title',
		    [
		        'label'       => __( 'Title', 'fitnase-core' ),
		        'type'        => Controls_Manager::TEXT,
		        'default'     => 'Trainer',
		        'label_block' => true,
		    ]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle', 'fitnase-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ' // Roland Whisen.',
				'label_block' => true,
			]
		);

		$this->add_control(
		    'service_info',
		    [
		        'label'       => __( 'Testimonials List', 'fitnase-core' ),
		        'type'        => Controls_Manager::REPEATER,
		        'fields'      => $repeater->get_controls(),
		        'default'     => [
		            [
		                'title' => 'Trainer',
		                'subtitle' => ' // Roland Whisen.',
		            ],
		        ],
		        'title_field' => '{{{ title }}}',
		    ]
		);

		$this->end_controls_section();
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="ep-service-info">
			<ul class="ep-list-style ep-list-inline">
				<?php if ( $settings['service_info'] ) {
					foreach ( $settings['service_info'] as $info ) { ?>
						<li><span class="ep-primary-color"><?php echo $info['title'];?></span><?php echo $info['subtitle'];?></li>
					<?php }
				} ?>
			</ul>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Service_Info_Widget );