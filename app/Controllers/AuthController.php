<?php

namespace SocialFeeder\Controllers;

use Exception;
use WPMVC\Log;
use WPMVC\Cache;
use WPMVC\Request;
use WPMVC\MVC\Controller;
use Instagram\Core\ApiException;
use Instagram\Auth;
use SocialFeeder\Models\SocialFeeder;
use Facebook\Exceptions\FacebookAuthenticationException;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
/**
 * Handles authentication and callbacks functionality.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.0
 */
class AuthController extends Controller
{
    /**
     * Starts authentication.
     * Checks on triggers process authenticaton.
     * @since 1.0.0
     * 
     * @hook admin_init
     */
    public function start()
    {
        if ( session_status() === PHP_SESSION_NONE ) {
            session_start();
        }
        if ( Request::input( 'trigger' ) === 'social-feeder' ) {
            switch ( Request::input( 'action' ) ) {
                case 'auth-instagram':
                    $this->auth_instagram();
                    break;
                case 'auth-facebook':
                    $this->auth_facebook();
                    break;
            }
        }
        switch ( Request::input( 'trigger' ) ) {
            case 'instagram-callback':
                $this->callback_instagram();
                break;
            case 'facebook-callback':
                $this->callback_facebook();
                break;
        }
    }
    /**
     * Authenticates instagram application.
     * @since 1.0.0
     */
    public function auth_instagram()
    {
        try {
            $social_feeder = get_social_feeder();
            if ( $social_feeder->is_instagram_setup
                && isset( $social_feeder->instagram['enabled'] )
                && $social_feeder->instagram['enabled']
                && isset( $social_feeder->instagram['client_id'] )
                && isset( $social_feeder->instagram['client_secret'] )
            ) {
                $auth = new Auth( [
                    'client_id' => $social_feeder->instagram['client_id'],
                    'client_secret' => $social_feeder->instagram['client_secret'],
                    'redirect_uri' => $social_feeder->instagram['redirect_url'],
                    'scope' => [ 'basic', 'relationships', 'public_content' ],
                ] );
                $auth->authorize();
                exit;
            }
        } catch ( ApiException $e ) {
            Log::error( $e );
        }
    }
    /**
     * Performs Instragram's callback and sets access token.
     * @since 1.0.0
     */
    public function callback_instagram()
    {
        $social_feeder = get_social_feeder();
        try {
            if ( $social_feeder->is_instagram_setup
                && isset( $social_feeder->instagram['enabled'] )
                && $social_feeder->instagram['enabled']
                && isset( $social_feeder->instagram['client_id'] )
                && isset( $social_feeder->instagram['client_secret'] )
            ) {
                $auth = new Auth( [
                    'client_id' => $social_feeder->instagram['client_id'],
                    'client_secret' => $social_feeder->instagram['client_secret'],
                    'redirect_uri' => $social_feeder->instagram['redirect_url'],
                    'scope' => [ 'basic', 'relationships', 'public_content' ],
                ] );
                $code = Request::input( 'code' );
                if ( $code ) {
                    $social_feeder->instagram['access_token'] = $auth->getAccessToken( $code );
                    $social_feeder->save();
                    Cache::forget( 'socialfeeder' );
                    Cache::forget( 'socialfeeder_feeds' );
                    wp_redirect( admin_url( 'options-general.php?page=social-feeder-settings&tab=instagram&notice=' . urlencode( __( 'Settings saved and Instagram authenticated.', 'SocialFeeder' ) ) ) );
                    exit;
                }
            }
        } catch ( ApiException $e ) {
            Log::error( $e );
        }
        try {
            $social_feeder->instagram['access_token'] = null;
            $social_feeder->save();
            Cache::forget( 'socialfeeder' );
        } catch ( Exception $e ) {
            Log::error( $e );
        }
        wp_redirect( admin_url( 'options-general.php?page=social-feeder-settings&tab=instagram&error=' . urlencode( __( 'Settings saved, but could not authenticate with Instragram. Review your configuration and try again.', 'SocialFeeder' ) ) ) );
        exit;
    }
    /**
     * Authenticates facebook application.
     * @since 1.0.0
     */
    public function auth_facebook()
    {
        try {
            $social_feeder = get_social_feeder();
            if ( $social_feeder->is_facebook_setup
                && isset( $social_feeder->facebook['enabled'] )
                && $social_feeder->facebook['enabled']
                && isset( $social_feeder->facebook['app_id'] )
                && isset( $social_feeder->facebook['app_secret'] )
                && isset( $social_feeder->facebook['api_version'] )
            ) {
                $fb = new Facebook( [
                    'app_id' => $social_feeder->facebook['app_id'],
                    'app_secret' => $social_feeder->facebook['app_secret'],
                    'default_graph_version' => $social_feeder->facebook['api_version'],
                ] );
                $helper = $fb->getRedirectLoginHelper();
                wp_redirect( $helper->getLoginUrl( $social_feeder->facebook['redirect_url'], [ 'email', 'public_profile', 'user_posts', 'manage_pages' ] ) );
                exit;
            }
        } catch ( FacebookAuthenticationException $e ) {
            Log::error( $e );
        }
    }
    /**
     * Performs Facebook's callback and sets access token.
     * @since 1.0.0
     */
    public function callback_facebook()
    {
        $social_feeder = get_social_feeder();
        try {
            if ( $social_feeder->is_facebook_setup
                && isset( $social_feeder->facebook['enabled'] )
                && $social_feeder->facebook['enabled']
                && isset( $social_feeder->facebook['app_id'] )
                && isset( $social_feeder->facebook['app_secret'] )
                && isset( $social_feeder->facebook['api_version'] )
            ) {
                $fb = new Facebook( [
                    'app_id' => $social_feeder->facebook['app_id'],
                    'app_secret' => $social_feeder->facebook['app_secret'],
                    'default_graph_version' => $social_feeder->facebook['api_version'],
                ] );
                $token = $fb->getRedirectLoginHelper()->getAccessToken();
                $token = $fb->getOAuth2Client()->getLongLivedAccessToken( $token );
                if ( $token ) {
                    $social_feeder->facebook['access_token'] = ( string ) $token;
                    $social_feeder->save();
                    Cache::forget( 'socialfeeder' );
                    Cache::forget( 'socialfeeder_feeds' );
                    wp_redirect( admin_url( 'options-general.php?page=social-feeder-settings&tab=facebook&notice=' . urlencode( __( 'Settings saved and Facebook authenticated.', 'SocialFeeder' ) ) ) );
                    exit;
                }
                die;
            }
        } catch ( FacebookResponseException $e ) {
            Log::error( $e );
        } catch ( FacebookAuthenticationException $e ) {
            Log::error( $e );
        } catch ( FacebookSDKException $e ) {
            Log::error( $e );
        }
        try {
            $social_feeder->facebook['access_token'] = null;
            $social_feeder->save();
            Cache::forget( 'socialfeeder' );
            Cache::forget( 'facebook_accounts' );
        } catch ( Exception $e ) {
            Log::error( $e );
        }
        wp_redirect( admin_url( 'options-general.php?page=social-feeder-settings&tab=facebook&error=' . urlencode( __( 'Settings saved, but could not authenticate with Facebook. Review your configuration and try again.', 'SocialFeeder' ) ) ) );
        exit;
    }
}