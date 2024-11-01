<?php

namespace SocialFeeder\Controllers;

use Exception;
use WPMVC\Log;
use WPMVC\Cache;
use WPMVC\MVC\Controller;
use SocialFeeder\Models\SocialFeeder;
/**
 * Utility hooks and methods.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
class UtilityController extends Controller
{
    /**
     * Returns twitter URL based on ID.
     * @since 1.0.0
     *
     * @param string $ID Tweet ID.
     *
     * @return string
     */
    public function get_tweet_url( $ID )
    {
        return apply_filters( 
            'socialfeeder_tweet_url',
            sprintf( socialfeeder()->config->get( 'twitter.link' ), $ID ),
            $ID
        );
    }
    /**
     * Returns facebook post URL based on ID.
     * @since 1.0.0
     *
     * @param string $ID Post ID.
     *
     * @return string
     */
    public function get_facebook_url( $ID )
    {
        return apply_filters( 
            'socialfeeder_facebook_url',
            sprintf( socialfeeder()->config->get( 'facebook.link' ), $ID ),
            $ID
        );
    }
    /**
     * Returns cached SocialFeeder model.
     * @since 1.0.0
     *
     * @return \SocialFeeder\Models\SocialFeeder
     */
    public function get_model()
    {
        return apply_filters( 'socialfeeder_model', SocialFeeder::find() );
    }
    /**
     * Returns html embed snippet.
     * @since 1.0.0
     * 
     * @hook socialfeeder_feed_embed
     * 
     * @param string $html
     * @param string $source
     * @param string $url
     *
     * @return string
     */
    public function feed_embed( $html, $source, $url )
    {
        if ( $source === 'youtube' ) {
            return $this->view->get( 'embed.youtube', [ 'url' => $url ] );
        }
        return $html;
    }
    /**
     * Returns the feed cache key, based on social feeder setup.
     * @since 1.0.0
     * 
     * @param \SocialFeeder\Models\SocialFeeder $social_feeder
     * 
     * @return string
     */
    public function get_feed_cache_key( $social_feeder )
    {
        try {
            // Key
            $key = apply_filters( 
                'socialfeeder_feed_cache_key',
                sprintf( 
                    'feed_l%d_m%d',
                    $social_feeder->limit,
                    $social_feeder->merge ? 1 : 0
                ),
                $social_feeder
            );
            $keys = Cache::has( 'socialfeeder_feed_keys' ) ? Cache::get( 'socialfeeder_feed_keys' ) : [];
            if ( !in_array( $key, $keys ) ) {
                $keys[] = $key;
            }
            Cache::add( 
                'socialfeeder_feed_keys',
                $keys,
                apply_filters( 'socialfeeder_feed_keys_cache_time', 1440 )
            );
            return $key;
        } catch ( Exception $e ) {
            Log::error( $e );
        }
        return 'socialfeeder_feeds';
    }
    /**
     * Handles shortcode display.
     * @since 1.0.0
     * 
     * @shortcode socialfeeder
     * 
     * @param array $atts Shortcode attributes.
     *
     * @return string
     */
    public function shortcode( $atts )
    {
        // Prepare
        $social_feeder = get_social_feeder();
        $atts = shortcode_atts( apply_filters( 
            'socialfeeder_shortcode_default_atts',
            [
                'limit' => $social_feeder->limit ? $social_feeder->limit : 4,
                'direction' => 'column',
                'width' => null,
                'height' => null,
            ],
            $social_feeder
        ), $atts );
        $social_feeder->direction = $atts['direction'];
        if ( !empty( $atts['limit'] ) ) {
            $social_feeder->limit = intval( $atts['limit'] );
        }
        if ( !empty( $atts['width'] ) ) {
            $social_feeder->width = $atts['width'];
        }
        if ( !empty( $atts['height'] ) ) {
            $social_feeder->height = $atts['height'];
        }
        $social_feeder = apply_filters( 'socialfeeder_model_shortcode', $social_feeder, $atts );
        // Retreive
        $feeds = $social_feeder->feeds;
        // Render
        do_action( 'socialfeeder_enqueue', $social_feeder );
        return $this->view->get( 'wrapper', apply_filters( 'socialfeeder_wrapper_params', [
            'feeds' => $feeds,
            'social_feeder' => &$social_feeder,
            'atts' => &$atts,
            'theme' => $social_feeder->theme ? $social_feeder->theme : 'default',
            'classes' => socialfeeder()->{'_c_return_ThemeController@classes'}( $social_feeder, count( $feeds ), 'type-shortcode' ),
            'styles' => socialfeeder()->{'_c_return_ThemeController@styles'}( $social_feeder ),
        ] ) );
    }
    /**
     * Clears cache.
     * @since 1.0.1
     * 
     * @hook socialfeeder_clear_cache
     */
    public function clear_cache()
    {
        Cache::forget( 'socialfeeder' );
        Cache::forget( 'socialfeeder_feeds' );
        if ( Cache::has( 'socialfeeder_feed_keys' ) ) {
            foreach ( Cache::get( 'socialfeeder_feed_keys' ) as $key ) {
                Cache::forget( $key );
            }
            Cache::forget( 'socialfeeder_feed_keys' );
        }
        do_action( 'socialfeeder_cache_cleared' );
    }
    /**
     * Returns feed HTML element classes.
     * @since 1.0.2
     *
     * @param \SocialFeeder\Models\Feed         $feed
     * @param \SocialFeeder\Models\SocialFeeder $social_feeder
     *
     * @return string
     */
    public function get_feed_classes( $feed, $social_feeder )
    {
        $classes = array_map( function ( $class ) {
            return strip_tags( $class );
        }, apply_filters( 
            'socialfeeder_feed_wrapper_classes',
            [ 'feed', $feed->feeder ],
            $feed,
            $social_feeder
        ) );
        return implode( ' ', $classes );
    }
}