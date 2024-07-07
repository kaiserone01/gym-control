<?php

/**
 * Fitnase Recent Post Widgets
 */
class Fitnase_Recent_Posts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'fitnase-recent-posts', esc_html__( 'Fitnase : Recent Posts', 'fitnase-core' ), array(
			'description' => esc_html__( 'Fitnase recent posts widget', 'fitnase-core' ),
		) );
	}

	public function widget( $args, $instance ) {
		?>
		<?php echo wp_kses_post( $args['before_widget'] ); ?>
		<?php if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] ) . apply_filters( 'widget_title', esc_html( $instance['title'] ) ) . wp_kses_post( $args['after_title'] );
		}
		?>
		<ul class="ep-recent-post-widget">
			<?php
			$title_word_count = ! empty( $instance['title_word_count'] ) ? $instance['title_word_count'] : 8;
			$post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : 4;

			$resent_post = new WP_Query( array(
				'post_type'           => 'post',
				'posts_per_page'      => $post_count,
				'ignore_sticky_posts' => true
			) );
			while ( $resent_post->have_posts() ) : $resent_post->the_post();
				?>

				<li <?php if ( has_post_thumbnail() ) {echo 'class= "li-have-thumbnail"';} ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<img src="<?php the_post_thumbnail_url( 'thumbnail' ) ?>"
						     alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
					<?php endif; ?>

					<div class="ep-recent-post-title-and-date">
						<h6><a class="ep-recent-post-widget-title"
						       href="<?php echo esc_url( get_permalink() ); ?>"><?php echo wp_trim_words(get_the_title(), $title_word_count,' ...'); ?></a>
						</h6>

						<div class="ep-recent-widget-date"><?php if(function_exists('fitnase_posted_on')){fitnase_posted_on();} ?></div>
					</div>
				</li>
			<?php endwhile; wp_reset_postdata();?>
		</ul>
		<?php echo wp_kses_post( $args['after_widget'] ); ?>
		<?php
	}


	public function form( $instance ) {
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$title_word_count      = ! empty( $instance['title_word_count'] ) ? $instance['title_word_count'] : 10;
		$post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : 4;
		$category   = ! empty( $instance['category'] ) ? $instance['category'] : array();

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title :', 'fitnase-core' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_word_count' ) ); ?>"><?php echo esc_html__( 'Title Word Count :', 'fitnase-core' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_word_count' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title_word_count' ) ); ?>" type="number" min="1"
			       value="<?php echo esc_attr( $title_word_count ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_count' ) ); ?>"><?php echo esc_html__( 'Post Count:', 'fitnase-core' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_count' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'post_count' ) ); ?>" type="number" min="-1"
			       value="<?php echo esc_attr( $post_count ); ?>">
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ){
		$instance                  = $old_instance;

		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['title_word_count']         = ( ! empty( $new_instance['title_word_count'] ) ) ? sanitize_text_field( $new_instance['title_word_count'] ) : 10;

		$instance['post_count']      = ( ! empty( $new_instance['post_count'] ) ) ? sanitize_text_field( $new_instance['post_count'] ) : 4;

		return $instance;
	}
}

function fitnase_recent_posts() {
	register_widget( 'Fitnase_Recent_Posts_Widget' );
}


add_action( 'widgets_init', 'fitnase_recent_posts' );