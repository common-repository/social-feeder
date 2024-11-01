<?php

/**
 * Plugin global functions file.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.0
 */
if ( !function_exists( 'socialfeeder' ) ) {
    /**
     * Returns main bridge class.
     * @since 1.0.0
     * 
     * @return \SocialFeeder\Main
     */
    function socialfeeder()
    {
        return get_bridge( 'SocialFeeder' );
    }
}
if ( !function_exists( 'get_tweet_url' ) ) {
    /**
     * Returns twitter URL based on ID.
     * @since 1.0.0
     *
     * @param string $ID Tweet ID.
     *
     * @return string
     */
    function get_tweet_url( $ID )
    {
        return socialfeeder()->{'_c_return_UtilityController@get_tweet_url'}( $ID );
    }
}
if ( !function_exists( 'get_social_feeder' ) ) {
    /**
     * Returns cached SocialFeeder model.
     * @since 1.0.0
     *
     * @return mixed
     */
    function get_social_feeder()
    {
        return socialfeeder()->{'_c_return_UtilityController@get_model'}();
    }
}
if ( !function_exists( 'get_facebook_url' ) ) {
    /**
     * Returns Facebook URL based on a Facebook data ID.
     * @since 1.0.0
     *
     * @param string $ID Facebook data ID.
     *
     * @return string
     */
    function get_facebook_url( $ID )
    {
        return socialfeeder()->{'_c_return_UtilityController@get_facebook_url'}( $ID );
    }
}
if ( !function_exists( 'sf_get_feed_classes' ) ) {
    /**
     * Returns feed HTML element classes.
     * @since 1.0.2
     *
     * @param \SocialFeeder\Models\Feed         $feed
     * @param \SocialFeeder\Models\SocialFeeder $social_feeder
     *
     * @return string
     */
    function sf_get_feed_classes( $feed, $social_feeder = null )
    {
        if ( $social_feeder === null ) {
            $social_feeder = get_social_feeder();
        }
        return socialfeeder()->{'_c_return_UtilityController@get_feed_classes'}( $feed, $social_feeder );
    }
}