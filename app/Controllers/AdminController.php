<?php

namespace SocialFeeder\Controllers;

use WPMVC\Log;
use WPMVC\Cache;
use WPMVC\Request;
use WPMVC\MVC\Controller;
use SocialFeeder\Models\SocialFeeder;
use SocialFeeder\Main as Plugin;
/**
 * Admin configuration functionality.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.0
 */
class AdminController extends Controller
{
    /**
     * Admin menu ID.
     * @since 1.0.0
     * @var string
     */
    const ADMIN_MENU_SETTINGS = 'social-feeder-settings';
    /**
     * Plugins configuration.
     * @since 1.0.0
     * @var object
     */
    protected $config;
    /**
     * Registers admin menus.
     * @since 1.0.0
     * 
     * @hook admin_menu
     *
     * @param object $config Plugin's configuration.
     */
    public function menu( $config )
    {
        $this->config = $config;
        add_submenu_page( 
            'options-general.php',
            __( 'Social Feeder Settings', 'social-feeder' ),
            __( 'Social Feeder', 'social-feeder' ),
            'manage_options',
            self::ADMIN_MENU_SETTINGS,
            [ &$this, 'view_settings' ]
        );
    }
    /**
     * Displays admin settings.
     * @since 1.0.0
     */
    public function view_settings()
    {
        $social_feeder = apply_filters( 'socialfeeder_model', SocialFeeder::find() );
        do_action( 'socialfeeder_admin_enqueue' );
        $this->view->show( 'admin.settings', [
            'notice' => $this->save( $social_feeder ),
            'error' => Request::input( 'error' ),
            'tab' => Request::input( 'tab', 'general' ),
            'tabs' => apply_filters( 'socialfeeder_admin_tabs', [
                'general' => __( 'General', 'social-feeder' ),
                'themes' => __( 'Themes' ),
                'facebook' => __( 'Facebook' ),
                'twitter' => __( 'Twitter' ),
                'instagram' => __( 'Instagram' ),
            ] ),
            'view' => &$this->view,
            'social_feeder' => &$social_feeder,
            'config' => &$this->config,
            'themes' => apply_filters( 'socialfeeder_themes', [] ),
        ] );
    }
    /**
     * Saves settings.
     * Returns flag indicating success operation
     * @since 1.0.0
     *
     * @param object $socialFeeder Social Feeder model
     */
    protected function save( &$model )
    {
        $notice = Request::input( 'notice' );
        // Check action
        if ( !empty( $notice ) ) {
            return $notice;
        }
        // Save form
        if ( $_POST ) {
            try {
                $redirect_url = null;
                $model->frequency = Request::input( 'frequency', 60 );
                $model->date_format = Request::input( 'date_format', 'F j, Y' );
                $model->merge = Request::input( 'merge', 0 );
                $model->limit = Request::input( 'limit', 4 );
                $model->enqueue_styles = Request::input( 'enqueue_styles', 0 );
                $model->theme = Request::input( 'theme', 'default' );
                $model->follow_us = Request::input( 'follow_us', 0 );
                $model->security_key = Request::input( 'security_key', uniqid( '', true ) );
                if ( !$model->is_facebook_setup ) {
                    $model->facebook = [];
                }
                $check = $model->facebook;
                $model->facebook['enabled'] = Request::input( 'facebook_enabled', 0 );
                $model->facebook['app_id'] = Request::input( 'facebook_app_id' );
                $model->facebook['app_secret'] = Request::input( 'facebook_app_secret' );
                $model->facebook['api_version'] = Request::input( 'facebook_api_version', 'v2.10' );
                $model->facebook['redirect_url'] = admin_url( 'index.php?trigger=facebook-callback' );
                $model->facebook['follow_url'] = Request::input( 'facebook_follow_url' );
                $model->facebook['profile'] = Request::input( 'facebook_profile' );
                $model->facebook['page'] = Request::input( 'facebook_page' );
                // Check if modification where made to re-authenticate
                if ( $model->facebook['enabled']
                    && ( $check['enabled'] != $model->facebook['enabled']
                        || $check['app_id'] != $model->facebook['app_id']
                        || $check['app_secret'] != $model->facebook['app_secret']
                        || $check['api_version'] != $model->facebook['api_version']
                    )
                ) {
                    $redirect_url = admin_url( 'options-general.php?page=social-feeder-settings&trigger=social-feeder&action=auth-facebook' );
                }
                if ( !$model->is_twitter_setup ) {
                    $model->twitter = [];
                }
                $model->twitter['enabled'] = Request::input( 'twitter_enabled', 0 );
                $model->twitter['api_key'] = Request::input( 'twitter_api_key' );
                $model->twitter['api_secret'] = Request::input( 'twitter_api_secret' );
                $model->twitter['token'] = Request::input( 'twitter_token' );
                $model->twitter['token_secret'] = Request::input( 'twitter_token_secret' );
                $model->twitter['screen_name'] = Request::input( 'twitter_screen_name' );
                $model->twitter['follow_url'] = Request::input( 'twitter_follow_url' );
                if ( !$model->is_instagram_setup ) {
                    $model->instagram = [];
                }
                $check = $model->instagram;
                $model->instagram['enabled'] = Request::input( 'instagram_enabled', 0 );
                $model->instagram['client_id'] = Request::input( 'instagram_client_id' );
                $model->instagram['client_secret'] = Request::input( 'instagram_client_secret' );
                $model->instagram['redirect_url'] = admin_url( 'index.php?trigger=instagram-callback' );
                $model->instagram['follow_url'] = Request::input( 'instagram_follow_url' );
                // Check if modification where made to re-authenticate
                if ( $model->instagram['enabled']
                    && ( $check['enabled'] != $model->instagram['enabled']
                        || $check['client_id'] != $model->instagram['client_id']
                        || $check['client_secret'] != $model->instagram['client_secret']
                    )
                ) {
                    $redirect_url = admin_url( 'options-general.php?page=social-feeder-settings&trigger=social-feeder&action=auth-instagram' );
                }
                $model = apply_filters( 'socialfeeder_model_before_save', $model );
                $model->save();
                do_action( 'socialfeeder_saved', $model );
                // Clear cache
                do_action( 'socialfeeder_clear_cache' );
                // Check if redirection is needed
                $redirect_url = apply_filters( 'socialfeeder_admin_redirect_url', $redirect_url );
                if ( !empty( $redirect_url ) ) {
                    $this->view->show( 'admin.trigger', [ 'location' => $redirect_url ] );
                    die;
                }
                return __( 'Settings saved.', 'social-feeder' );
            } catch ( Exception $e ) {
                Log::error( $e );
            }
        }
        return;
    }
}