<?php
namespace Elementor;
use WP_Query;
class Fitnase_Recent_Posts_Widget extends Widget_Base {

	public function get_name() {

		return 'fitnase_recent_posts';
	}

	public function get_title() {
		return esc_html__( 'Recent Posts', 'fitnase-core' );
	}

	public function get_icon() {

		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'fitnase_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'recent_post_settings',
			[
				'label' => __( 'Post Settings', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_count',
			[
				'label'   => __( 'Number Of Post To Show', 'fitnase-core' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 3,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => __( 'Categories', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => ep_fitnase_post_categories(),
			]
		);

		$this->add_control(
			'exclude_post',
			[
				'label'       => __( 'Exclude Posts', 'fitnase-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => fitnase_get_post_title_as_list(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'recent_post_layout_settings',
			[
				'label' => __( 'Post Column & Layout', 'fitnase-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'columns_desktop',
			[
				'label'   => __( 'Columns On Desktop', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-4',
				'options' => [
					'col-lg-12' => __( '1 Column', 'fitnase-core' ),
					'col-lg-6'  => __( '2 Column', 'fitnase-core' ),
					'col-lg-4'  => __( '3 Column', 'fitnase-core' ),
					'col-lg-3'  => __( '4 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'columns_tab',
			[
				'label'   => __( 'Columns On Tablet', 'fitnase-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-sm-6',
				'options' => [
					'col-sm-12' => __( '1 Column', 'fitnase-core' ),
					'col-sm-6'  => __( '2 Column', 'fitnase-core' ),
					'col-sm-4'  => __( '3 Column', 'fitnase-core' ),
					'col-sm-3'  => __( '4 Column', 'fitnase-core' ),
				],
			]
		);

		$this->add_control(
			'title_word',
			[
				'label'   => __( 'Title Word Count', 'fitnase-core' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => '',
				'step'    => 1,
				'default' => 8,
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => __( 'Show Date', 'fitnase-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['columns_desktop'].' '.$settings['columns_tab'];
		?>

		<div class="ep-recent-post-wrapper">
			<div class="row">
				<?php
				if ( ! empty( $settings['category'] ) ) {
					$post_query = new WP_Query( array(
						'post_type'           => 'post',
						'posts_per_page'      => $settings['post_count'],
						'ignore_sticky_posts' => 1,
						'post__not_in'        => $settings['exclude_post'],
						'tax_query'           => array(
							array(
								'taxonomy' => 'category',
								'terms'    => $settings['category'],
								'field'    => 'slug',
							)
						)
					) );
				} else {

					$post_query = new WP_Query(
						array(
							'posts_per_page'      => $settings['post_count'],
							'post_type'           => 'post',
							'ignore_sticky_posts' => 1,
							'post__not_in'        => $settings['exclude_post'],
						)
					);
				}

				while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

				<div class="<?php echo $ep_column;?>">
					<div class="ep-recent-post-item">
						<a href="<?php echo esc_url( get_the_permalink() );?>" class="ep-recent-post-thumbnail">
							<img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
						</a>

                        <div class="ep-recent-post-content">
					        <?php if($settings['show_date'] == 'yes') : ?>
                            <div class="ep-recent-post-date"><?php fitnase_posted_on(); ?></div>
                            <?php endif; ?>
                            <a href="<?php echo esc_url( get_the_permalink() );?>" class="ep-rpt-url">
                                <h4 class="ep-recent-post-title"><?php echo wp_trim_words(get_the_title(), $settings['title_word'], ' ...');?></h4>
                            </a>

                            <a href="<?php echo esc_url( get_the_permalink() );?>" class="ep-recent-post-url">
                                <i class="flaticon-right-arrow"></i>
                            </a>
                        </div>

					</div>
				</div>

				<?php
				endwhile;
				wp_reset_query();
				?>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Fitnase_Recent_Posts_Widget );