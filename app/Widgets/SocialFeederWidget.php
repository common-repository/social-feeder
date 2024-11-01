<?php

/**
 * Social Feeder Widget.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.1
 */
class SocialFeederWidget extends WP_Widget
{
    /**
     * Constructor.
     * @since 1.0.0
     */
    public function __construct( $id = '', $name = '', $args = array() )
    {
        parent::__construct( 
            'social-feeder-widget',
            __( 'Social Feeder', 'social-feeder' ),
            [ 'classname' => 'SocialFeederWidget', 'description' => __( 'Displays Social Media feed.', 'social-feeder' ) ]
         );
    }
    /**
     * Widget display functionality.
     * @since 1.0.0
     *
     * @param array $args     Arguments for the theme.
     * @param class $instance Parameters.
     */
    public function widget( $args, $instance )
    {
        // Prepare
        $social_feeder = get_social_feeder();
        $social_feeder->limit = $instance['limit'];
        $social_feeder->direction = $instance['direction'];
        if ( !empty( $instance['width'] ) ) {
            $social_feeder->width = $instance['width'];
        }
        if ( !empty( $instance['height'] ) ) {
            $social_feeder->height = $instance['height'];
        }
        $social_feeder = apply_filters( 'socialfeeder_model_widget', $social_feeder, $instance );
        $feeds = $social_feeder->feeds;
        $title = apply_filters( 'widget_title', $instance['title'] );
        do_action( 'socialfeeder_enqueue', $social_feeder );
        // Before widget
        echo $args['before_widget'];
        // Title
        if ( !empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        // Widget
        socialfeeder()->view( 'wrapper', apply_filters( 'socialfeeder_wrapper_params', [
            'feeds' => &$feeds,
            'social_feeder' => &$social_feeder,
            'args' => &$args,
            'theme' => $social_feeder->theme ? $social_feeder->theme : 'default',
            'classes' => socialfeeder()->{'_c_return_ThemeController@classes'}( $social_feeder, count( $feeds ), 'type-widget' ),
            'styles' => socialfeeder()->{'_c_return_ThemeController@styles'}( $social_feeder ),
        ] ) );
        // After widget
        echo $args['after_widget'];
    }
    /**
     * Widget update functionality.
     * @since 1.0.0
     *
     * @param array $new_instance Widget instance.
     * @param array $instance     Old widget instance.
     *
     * @return array
     */
    public function update( $new_instance, $instance )
    {
        $instance['title'] = $new_instance['title'];
        $instance['limit'] = intval( $new_instance['limit'] );
        $instance['direction'] = $new_instance['direction'];
        $instance['width'] = $new_instance['width'];
        $instance['height'] = $new_instance['height'];
        return apply_filters( 'socialfeeder_widget_instance_save', $instance, $new_instance );
    }
    /**
     * Widget update functionality.
     * @since 1.0.0
     *
     * @param array $new_instance Widget instance.
     * @param array $old_instance Widget instance.
     *
     * @return array
     */
    public function form( $instance )
    {
        $social_feeder = get_social_feeder();
        // Get info
        $instance = apply_filters( 
            'socialfeeder_widget_instance_form',
            wp_parse_args( ( array ) $instance, apply_filters( 
                'socialfeeder_widget_instance_default',
                [
                    'title' => '',
                    'limit' => $social_feeder->limit ? $social_feeder->limit : 4,
                    'direction' => 'column',
                    'width' => null,
                    'height' => null,
                ],
                $social_feeder
             ) ),
            $social_feeder
        );
        // Display form
        socialfeeder()->view( 'admin.widgets.form', [
            'widget' => &$this,
            'instance' => &$instance,
            'social_feeder' => &$social_feeder,
            'directions' => apply_filters( 'socialfeeder_directions', [ 'column' => __( 'Vertical', 'social-feeder' ), 'row' => __( 'Horizontal', 'social-feeder' ) ] ),
        ] );
    }
}