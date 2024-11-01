<?php

namespace SocialFeeder\Traits;

use TwitterAPIExchange;
use SocialFeeder\Models\Feed;
use Amostajo\WPPluginCore\Log;
/**
 * Twitter trait.
 * Uses Twitter's API to get tweets and transform them into feed.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
trait TwitterTrait
{
    /**
     * Adds feeds from twitter to current feed list.
     * @since 1.0.0
     *
     * @param array $feeds Current feeds (by reference).
     */
    protected function feed_from_twitter( &$feeds )
    {
        // Twitter
        if ( $this->is_twitter_setup
            && isset( $this->twitter['enabled'] )
            && $this->twitter['enabled']
            && isset( $this->twitter['api_key'] )
            && isset( $this->twitter['api_secret'] )
            && isset( $this->twitter['token'] )
            && isset( $this->twitter['token_secret'] )
            && isset( $this->twitter['screen_name'] )
        ) {
            try {
                $api = new TwitterAPIExchange( [
                    'oauth_access_token' => $this->twitter['token'],
                    'oauth_access_token_secret' => $this->twitter['token_secret'],
                    'consumer_key' => $this->twitter['api_key'],
                    'consumer_secret' => $this->twitter['api_secret'],
                ] );
                // Request
                $request = json_decode( $api->setGetfield( sprintf( 
                    '?screen_name=%s&count=%s&tweet_mode=extended',
                    $this->twitter['screen_name'],
                    $this->limit
                ) )->buildOauth( 'https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET' )->performRequest() );
                // Processes request.
                if ( is_array( $request ) ) {
                    foreach ( $request as $data ) {
                        $feed = apply_filters( 'socialfeeder_feed_model', new Feed() );
                        $feed->from_twitter( $data, $this->date_format );
                        $feeds[] = apply_filters( 'socialfeeder_filled_feed', $feed, $this );
                    }
                }
            } catch ( Exception $e ) {
                Log::error( $e );
            }
        }
    }
    /**
     * Returns flag indicating if twitter settings are in place.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_twitter_setup()
    {
        return $this->twitter && is_array( $this->twitter );
    }
    /**
     * Returns flag indicating if twitter has the follow us url setup.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_twitter_legible()
    {
        return $this->is_twitter_setup && array_key_exists( 'enabled', $this->twitter ) && $this->twitter['enabled'] && array_key_exists( 'follow_url', $this->twitter ) && !empty( $this->twitter['follow_url'] );
    }
}