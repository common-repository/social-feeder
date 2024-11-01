<?php

namespace SocialFeeder\Traits;

use Exception;
use Facebook\Facebook;
use SocialFeeder\Models\Feed;
use WPMVC\Log;
use WPMVC\Cache;
use Facebook\Exceptions\FacebookSDKException;
/**
 * Facebook trait.
 * Uses Facebook's SDK to get posts and transform them into feed.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
trait FacebookTrait
{
    /**
     * Adds feeds from facebook to current feed list.
     * @since 1.0.0
     *
     * @param array $feeds Current feeds (by reference).
     */
    protected function feed_from_facebook( &$feeds )
    {
        // Facebook
        if ( $this->is_facebook_ready && $this->facebook_id ) {
            try {
                $fb = new Facebook( [
                    'app_id' => $this->facebook['app_id'],
                    'app_secret' => $this->facebook['app_secret'],
                    'default_graph_version' => $this->facebook['api_version'],
                    'default_access_token' => $this->facebook['access_token'],
                ] );
                // Get posts from entity
                $response = $fb->get( '/' . $this->facebook_id . '/posts?fields=id,message,story,created_time,link,picture,type,source,properties,caption,object_id' );
                // Parse posts
                if ( !$response->isError() ) {
                    $response = $response->getDecodedBody();
                    foreach ( $response['data'] as $data ) {
                        $feed = apply_filters( 'socialfeeder_feed_model', new Feed() );
                        $feed->from_facebook( $data, $this->date_format );
                        $feeds[] = apply_filters( 'socialfeeder_filled_feed', $feed, $this );
                    }
                }
            } catch ( FacebookSDKException $e ) {
                Log::error( $e );
            } catch ( Exception $e ) {
                Log::error( $e );
            }
        }
    }
    /**
     * Returns list of facebook accounts.
     * @since 1.0.0
     *
     * @return array
     */
    protected function get_facebook_accounts()
    {
        if ( !$this->is_facebook_ready ) {
            return;
        }
        $credentials = [
            'app_id' => $this->facebook['app_id'],
            'app_secret' => $this->facebook['app_secret'],
            'default_graph_version' => $this->facebook['api_version'],
            'default_access_token' => $this->facebook['access_token'],
        ];
        return Cache::remember( 
            'facebook_accounts',
            43200,
            function () use( &$credentials ) {
                try {
                    $fb = new Facebook( $credentials );
                    $response = $fb->get( '/me' );
                    $accounts = [ 'me' => $response->isError() ? null : $response->getDecodedBody(), 'pages' => [] ];
                    $response = $fb->get( '/' . $accounts['me']['id'] . '/accounts' );
                    if ( !$response->isError() ) {
                        $response = $response->getDecodedBody();
                        foreach ( $response['data'] as $account ) {
                            $accounts['pages'][] = [ 'id' => $account['id'], 'name' => $account['name'] ];
                        }
                    }
                    return $accounts;
                } catch ( FacebookSDKException $e ) {
                    Log::error( $e );
                } catch ( Exception $e ) {
                    Log::error( $e );
                }
                return;
            }
         );
    }
    /**
     * Returns flag indicating if account has facebook pages.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function has_facebook_pages()
    {
        return $this->facebook_accounts && isset( $this->facebook_accounts['pages'] ) && count( $this->facebook_accounts['pages'] ) > 0;
    }
    /**
     * Returns flag indicating if selected account is "me".
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_facebook_me()
    {
        return !$this->facebook_accounts || !isset( $this->facebook['profile'] ) || $this->facebook['profile'] != 'page';
    }
    /**
     * Returns selected facebook page.
     * @since 1.0.0
     *
     * @return string
     */
    protected function get_facebook_page()
    {
        return isset( $this->facebook['page'] ) ? $this->facebook['page'] : null;
    }
    /**
     * Returns selected facebook profile id.
     * @since 1.0.0
     *
     * @return string
     */
    protected function get_facebook_id()
    {
        return $this->is_facebook_me ? $this->facebook_accounts['me']['id'] : $this->facebook['page'];
    }
    /**
     * Returns flag indicating if facebook settings are in place.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_facebook_setup()
    {
        return $this->facebook && is_array( $this->facebook );
    }
    /**
     * Returns flag indicating if facebook is ready for usage.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_facebook_ready()
    {
        return $this->is_facebook_setup && array_key_exists( 'enabled', $this->facebook ) && $this->facebook['enabled'] && array_key_exists( 'access_token', $this->facebook ) && !empty( $this->facebook['access_token'] );
    }
    /**
     * Returns flag indicating if facebook has the follow us url setup.
     * @since 1.0.0
     *
     * @return bool
     */
    protected function is_facebook_legible()
    {
        return $this->is_facebook_setup && array_key_exists( 'enabled', $this->facebook ) && $this->facebook['enabled'] && array_key_exists( 'follow_url', $this->facebook ) && !empty( $this->facebook['follow_url'] );
    }
}