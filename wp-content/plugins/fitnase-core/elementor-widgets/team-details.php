<?php
namespace Elementor;

class Fitnase_Team_Details_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_team_details';
	}

	public function get_title() {
		return esc_html__( 'Team Details', 'fitnase-core' );
	}

	public function get_icon() {

		return 'fas fa-users';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'team_details_options',
			[
				'label' => esc_html__( 'Member Details', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
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

		$this->add_control(
		    'name',
		    [
		        'label'       => __( 'Name', 'fitnase-core' ),
		        'label_block'       => true,
		        'type'        => Controls_Manager::TEXT,
		        'default'     => 'Ken Harrington',
		    ]
		);

		$this->add_control(
		    'designation',
		    [
		        'label'       => __( 'Designation', 'fitnase-core' ),
		        'label_block'       => true,
		        'type'        => Controls_Manager::TEXT,
		        'default'     => 'Senior Trainer',
		    ]
		);

		$this->add_control(
		    'description',
		    [
		        'label'       => __( 'Description', 'fitnase-core' ),
		        'type'        => Controls_Manager::WYSIWYG,
		        'default'     => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry been industry\'s
                                dummy text ever sence the 150 when an unknown printer took galley type and scrambled makes
                                as type specimen book Ithas surived not only five centuries, but also leap intor electronic andes
                                specimen.</p>

                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry been industry\'s
                                dummy text ever sence the 150 when an unknown printer took galley type and scrambled makes
                                as type specimen book Ithas surived not only five centuries, but also leap intor electronic andes
                                specimen book Ithas surived and not only five centuris, but also the took galley type and scrambled.</p>',
		        'label_block' => true,
		    ]
		);

		$this->add_control(
			'contact',
			[
				'label'       => __( 'Contact', 'fitnase-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<ul>
                                <li><a href="tel:123456">Call: +88 569 745 87,</a></li>
                                <li><a href="mailto:fitnase@e-plugins.com">Email: fitnase@e-plugins.com</a></li>
                            </ul>',
				'description'     => __( 'Create an Ul list', 'fitnase-core' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		    'member_social_option',
		    [
		        'label' => esc_html__( 'Social Option', 'fitnase-core' ),
		        'tab'   => Controls_Manager::TAB_CONTENT,
		    ]
		);

		$repeater = new Repeater();


		$repeater->add_control(
		    'social_icon',
		    [
		        'label'            => esc_html__( 'Select Icon', 'fitnase-core' ),
		        'type'             => Controls_Manager::ICONS,
		        'fa4compatibility' => 'icon',
		        'label_block'      => true,
		        'default'          => [
		            'value'   => 'fab fa-facebook-f',
		            'library' => 'bold',
		        ],
		    ]
		);

		$repeater->add_control(
		    'url',
		    [
		        'label'       => __( 'Profile Url', 'fitnase-core' ),
		        'label_block'       => true,
		        'type'        => Controls_Manager::TEXT,
		        'default'     => '#',
		    ]
		);

		$this->add_control(
		    'icons',
		    [
		        'label'       => __( 'Social Icon List', 'fitnase-core' ),
		        'type'        => Controls_Manager::REPEATER,
		        'fields'      => $repeater->get_controls(),
		        'title_field' => '<i class="{{{social_icon.value}}}"></i>',
		    ]
		);

		$this->end_controls_section();
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		$image_src = $settings['image']['url'];
		$image_alt = get_post_meta( $settings['image']['id'], '_wp_attachment_image_alt', true );
		$image_title = get_the_title( $settings['image']['id']);
		?>

		<div class="ep-team-details-wrapper">
            <div class="row">
                <div class="col-xl-4 col-lg-5 text-center">
                    <div class="ep-member-image-and-social">
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">

                        <div class="ep-member-social ep-primary-bg">
                            <ul class="widget-social-icons ep-list-style ep-list-inline">
                                <?php if($settings['icons']){
                                    foreach ($settings['icons'] as $icon){ ?>
                                        <li><a href="<?php echo $icon['url'];?>" target="_blank"><i class="<?php echo $icon['social_icon']['value'];?>"></i></a></li>
                                <?php    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-7 my-auto">
                    <div class="member-details-info">
                        <h2 class="ep-member-name"><?php echo $settings['name'];?></h2>
                        <span class="ep-member-designation ep-primary-color"><?php echo $settings['designation'];?></span>

                        <div class="ep-member-description">
	                        <?php echo $settings['description'];?>
                        </div>

                        <div class="ep-member-contact ep-secondary-font ep-list-style ep-list-inline">
	                        <?php echo $settings['contact'];?>
                        </div>
                    </div>
                </div>
            </div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Team_Details_Widget );