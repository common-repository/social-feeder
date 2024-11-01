<?php

namespace SocialFeeder\Traits;

use Exception;
use Instagram\Core\ApiException;
use Instagram\Instagram;
use SocialFeeder\Models\Feed;
use WPMVC\Log;
/**
 * Instagram trait.
 * Uses Instagram's API to get media and transform them into feed.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
trait InstagramTrait
{
    /**
     * Adds feeds from instagram to current feed list.
     * @since 1.0.0
     *
     * @param array $feeds Current feeds (by reference).
     */
    protected function feed_from_instagram( &$feeds )
    {
        if ( $this->is_instagram_ready ) {
            try {
                $instagram = new Instagram();
                $instagram->setAccessToken( $this->instagram['access_token'] );
                $user = $instagram->getCurrentUser();
                foreach ( $user->getMedia() as $media ) {
                    $feed = apply_filters( 'socialfeeder_feed_model', new Feed() );
                    $feed->from_instagram( $media, $this->date_format );
                    $feeds[] = apply_filters( 'socialfeeder_filled_feed', $feed, $this );
                }
            } catch ( ApiException $e ) {
                Log::error( $e );
            } catch ( Exception $e ) {
                Log::error( $e );
            }
        }
    }
    /**
     * Returns flag indicating if instagram settings are in place.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_instagram_setup()
    {
        return $this->instagram && is_array( $this->instagram );
    }
    /**
     * Returns flag indicating if instagram is ready for usage.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_instagram_ready()
    {
        return $this->instagram && is_array( $this->instagram ) && array_key_exists( 'enabled', $this->instagram ) && $this->instagram['enabled'] && array_key_exists( 'access_token', $this->instagram ) && !empty( $this->instagram['access_token'] );
    }
    /**
     * Returns flag indicating if instagram has the follow us url setup.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_instagram_legible()
    {
        return $this->is_instagram_setup && array_key_exists( 'enabled', $this->instagram ) && $this->instagram['enabled'] && array_key_exists( 'follow_url', $this->instagram ) && !empty( $this->instagram['follow_url'] );
    }
}