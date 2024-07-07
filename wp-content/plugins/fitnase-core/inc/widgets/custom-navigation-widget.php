<?php

class fitnase_nav_menu_widget extends WP_Widget {


    public function __construct() {
        $widget_ops = array(
            'description' => __( 'Add a navigation menu to your sidebar.', 'fitnase-core' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'fitnase_nav_menu', __('Fitnase : Navigation Menu', 'fitnase-core'), $widget_ops );
    }


    public function widget( $args, $instance ) {
        // Get menu
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

        if ( ! $nav_menu ) {
            return;
        }

        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';

        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo wp_kses_post($args['before_widget']);

        if ( $title ) {
            echo wp_kses_post($args['before_title']) . $title . wp_kses_post($args['after_title']);
        }

        $nav_menu_args = array(
            'fallback_cb' => '',
            'menu'        => $nav_menu
        );

        wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );

        echo wp_kses_post($args['after_widget']);
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = sanitize_text_field( $new_instance['title'] );
        }
        if ( ! empty( $new_instance['nav_menu'] ) ) {
            $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        }
        return $instance;
    }

    public function form( $instance ) {
        global $wp_customize;
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

        // Get menus
        $menus = wp_get_nav_menus();

        // If no menus exists, direct the user to go and create some.
        ?>
        <p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
            <?php
            if ( $wp_customize instanceof WP_Customize_Manager ) {
                $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
            } else {
                $url = admin_url( 'nav-menus.php' );
            }
            ?>
            <?php echo sprintf( __( 'No menus have been created yet. <a href="%s">Create some</a>.','fitnase-core' ), esc_attr( $url ) ); ?>
        </p>
        <div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo __( 'Title:', 'fitnase-core' ) ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>"><?php echo __( 'Select Menu:','fitnase-core' ); ?></label>
                <select id="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'nav_menu' )); ?>">
                    <option value="0"><?php echo __( '&mdash; Select &mdash;', 'fitnase-core' ); ?></option>
                    <?php foreach ( $menus as $menu ) : ?>
                        <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
                            <?php echo esc_html( $menu->name ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
                <p class="edit-selected-nav-menu" style="<?php if ( ! $nav_menu ) { echo 'display: none;'; } ?>">
                    <button type="button" class="button"><?php echo __( 'Edit Menu', 'fitnase-core' ) ?></button>
                </p>
            <?php endif; ?>
        </div>
        <?php
    }
}

add_action('widgets_init', 'fitnase_nav_menu');

function fitnase_nav_menu() {
    register_widget('fitnase_nav_menu_widget');
}