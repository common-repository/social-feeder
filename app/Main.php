<?php

namespace SocialFeeder;

use WPMVC\Bridge;
/**
 * Main class.
 * Bridge between Wordpress and App.
 * Class contains declaration of hooks and filters.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
class Main extends Bridge
{
    /**
     * Declaration of public wordpress hooks.
     */
    public function init()
    {
        // Theme & styles
        $this->add_action( 'wp_enqueue_scripts', 'ThemeController@register_assets' );
        $this->add_action( 'socialfeeder_enqueue', 'ThemeController@enqueue', 1, 2 );
        $this->add_filter( 'socialfeeder_themes', 'ThemeController@themes', 1 );
        $this->add_action( 'socialfeeder_theme_default', 'ThemeController@theme_legacy', 10, 3 );
        $this->add_action( 'socialfeeder_theme_invert', 'ThemeController@theme_legacy', 10, 3 );
        $this->add_action( 'socialfeeder_theme_legacy', 'ThemeController@theme_legacy', 10, 3 );
        // Utility
        $this->add_filter( 'socialfeeder_feed_embed', 'UtilityController@feed_embed', 1, 3 );
        $this->add_filter( 'socialfeeder_clear_cache', 'UtilityController@clear_cache', 1 );
        // Wordpress
        $this->add_widget( 'SocialFeederWidget' );
        $this->add_shortcode( 'socialfeeder', 'UtilityController@shortcode' );
    }
    /**
     * Declaration of admin only wordpress hooks.
     * For Wordpress admin dashboard.
     */
    public function on_admin()
    {
        // Config
        $this->add_filter( 'plugin_action_links_social-feeder/plugin.php', 'ConfigController@plugin_links' );
        $this->add_filter( 'plugin_row_meta', 'ConfigController@row_meta', 10, 2 );
        $this->add_action( 'admin_init', 'AuthController@start' );
        $this->add_action( 'admin_menu', 'AdminController@menu', [ $this->config ], 10 );
    }
}