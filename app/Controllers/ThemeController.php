<?php

namespace SocialFeeder\Controllers;

use WPMVC\MVC\Controller;
/**
 * Theme and styles.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.1
 */
class ThemeController extends Controller
{
    /**
     * Enqueues / registers assets.
     * @since 1.0.0
     * 
     * @hook wp_enqueue_scripts
     */
    public function register_assets()
    {
        wp_register_style( 
            'font-awesome',
            assets_url( 'css/font-awesome.min.css', __FILE__ ),
            [],
            '4.7.0'
        );
        wp_register_style( 
            'social-feeder',
            assets_url( 'css/app.css', __FILE__ ),
            [ 'font-awesome' ],
            socialfeeder()->config->get( 'version' )
        );
    }
    /**
     * Enqueues.
     * @since 1.0.0
     * 
     * @hook socialfeeder_enqueue
     * 
     * @param \SocialFeeder\Models\SocialFeeder $social_feeder
     */
    public function enqueue( $social_feeder )
    {
        if ( $social_feeder->enqueue_styles ) {
            wp_enqueue_style( 'social-feeder' );
        }
    }
    /**
     * Returns available themes.
     * @since 1.0.0
     * 
     * @hook socialfeeder_themes
     * 
     * @return array
     */
    public function themes()
    {
        $themes = [
            [
                'id' => 'default',
                'name' => __( 'Default' ),
                'preview' => assets_url( 'img/theme-default.jpg', __DIR__ ),
            ],
            [
                'id' => 'invert',
                'name' => __( 'Invert', 'social-feeder' ),
                'preview' => assets_url( 'img/theme-invert.jpg', __DIR__ ),
            ],
            [
                'id' => 'legacy',
                'name' => __( 'Legacy', 'social-feeder' ),
                'preview' => assets_url( 'img/theme-legacy.jpg', __DIR__ ),
            ],
        ];
        if ( apply_filters( 'socialfeeder_show_pro_features', true ) ) {
            $themes = array_merge( $themes, [
                [
                    'id' => 'pro',
                    'name' => 'Twitter',
                    'preview' => assets_url( 'img/theme-twitter.jpg', __DIR__ ),
                    'disabled' => true,
                ],
                [
                    'id' => 'pro',
                    'name' => 'Instagram',
                    'preview' => assets_url( 'img/theme-instagram.jpg', __DIR__ ),
                    'disabled' => true,
                ],
                [
                    'id' => 'pro',
                    'name' => 'Facebook',
                    'preview' => assets_url( 'img/theme-facebook.jpg', __DIR__ ),
                    'disabled' => true,
                ],
            ] );
        }
        return $themes;
    }
    /**
     * Returns the classes to add to wrapper.
     * @since 1.0.0
     *
     * @param \SocialFeeder\Models\SocialFeeder $social_feeder
     * @param int                               $count         Feed count.
     * @param string                            $reference     Reference caller
     * 
     * @return string
     */
    public function classes( $social_feeder, $count = 0, $reference = null )
    {
        $classes = [ 'social-feeder' ];
        if ( $count === 0 ) {
            $classes[] = 'no-data';
        }
        if ( $reference ) {
            $classes[] = trim( $reference );
        }
        $classes[] = 'theme-' . ( $social_feeder->theme ? $social_feeder->theme : 'default' );
        if ( $social_feeder->direction ) {
            $classes[] = 'direction-' . $social_feeder->direction;
        }
        $classes = apply_filters( 'socialfeeder_wrapper_classes', $classes, $social_feeder );
        return implode( ' ', $classes );
    }
    /**
     * Returns the styles to add to wrapper.
     * @since 1.0.0
     *
     * @param \SocialFeeder\Models\SocialFeeder $social_feeder
     * 
     * @return string
     */
    public function styles( $social_feeder )
    {
        $styles = [];
        if ( $social_feeder->width ) {
            $styles[] = 'max-width:' . $social_feeder->width . ';';
        }
        if ( $social_feeder->height ) {
            $styles[] = 'max-height:' . $social_feeder->height . ';';
        }
        $styles = apply_filters( 'socialfeeder_wrapper_styles', $styles, $social_feeder );
        return implode( ' ', $styles );
    }
    /**
     * Displays theme default.
     * @since 1.0.0
     * 
     * @hook socialfeeder_theme_legacy
     *
     * @param array                             $feeds
     * @param \SocialFeeder\Models\SocialFeeder $social_feeder
     * @param string                            $styles        Styles per feed.
     */
    public function theme_legacy( $feeds, $social_feeder, $styles )
    {
        $this->view->show( 'feed.legacy', [
            'feeds' => is_array( $feeds ) ? $feeds : [ $feeds ],
            'social_feeder' => $social_feeder,
            'styles' => $styles,
        ] );
    }
}