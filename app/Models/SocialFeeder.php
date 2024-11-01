<?php

namespace SocialFeeder\Models;

use SocialFeeder\Traits\TwitterTrait;
use SocialFeeder\Traits\InstagramTrait;
use SocialFeeder\Traits\MergeTrait;
use SocialFeeder\Traits\FacebookTrait;
use WPMVC\Cache;
use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\OptionModel as Model;
/**
 * Social Feeder option based model.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.7
 */
class SocialFeeder extends Model
{
    use FindTrait, TwitterTrait, InstagramTrait, MergeTrait, FacebookTrait;
    /**
     * Model id.
     * @since 1.0.0
     * @var string
     */
    protected $id = 'socialFeeder';
    /**
     * Field aliases and definitions.
     * @since 1.0.0
     *
     * @var array
     */
    protected $aliases = [
        'follow_us' => 'field_follow_us',
        'merge' => 'field_merge',
        'limit' => 'field_limit',
        'date_format' => 'field_date_format',
        'frequency' => 'field_frequency',
        'enqueue_styles' => 'field_enqueue_styles',
        'theme' => 'field_theme',
        'direction' => 'field_direction',
        'width' => 'field_width',
        'height' => 'field_height',
        'security_key' => 'field_e_key',
        'feeds' => 'func_get_feeds',
        'twitter' => 'field_twitter',
        'is_twitter_setup' => 'func_is_twitter_setup',
        'is_twitter_legible' => 'func_is_twitter_legible',
        'instagram' => 'field_instagam',
        'is_instagram_setup' => 'func_is_instagram_setup',
        'is_instagram_ready' => 'func_is_instagram_ready',
        'is_instagram_legible' => 'func_is_instagram_legible',
        'facebook' => 'field_facebook',
        'is_facebook_setup' => 'func_is_facebook_setup',
        'is_facebook_ready' => 'func_is_facebook_ready',
        'is_facebook_legible' => 'func_is_facebook_legible',
        'facebook_accounts' => 'func_get_facebook_accounts',
        'has_facebook_pages' => 'func_has_facebook_pages',
        'is_facebook_me' => 'func_is_facebook_me',
        'facebook_page' => 'func_get_facebook_page',
        'facebook_id' => 'func_get_facebook_id',
    ];
    /**
     * Returns encrypted value.
     * @since 1.0.0
     *
     * @param mixed $value Value to encrypt.
     *
     * @return string
     */
    protected function encrypt( $value )
    {
        return base64_encode( mcrypt_encrypt( MCRYPT_RC2, $this->security_key, $value, MCRYPT_MODE_ECB ) );
    }
    /**
     * Returns decrypted value.
     * @since 1.0.0
     *
     * @param string $value Value to decrypt.
     *
     * @return mixed
     */
    protected function decrypt( $value )
    {
        return trim( mcrypt_decrypt( 
            MCRYPT_RC2,
            $this->security_key,
            base64_decode( $value ),
            MCRYPT_MODE_ECB
        ) );
    }
    /**
     * Returns feeds.
     * @since 1.0.0
     *
     * @return array
     */
    protected function get_feeds()
    {
        $feeds = Cache::remember( 
            socialfeeder()->{'_c_return_UtilityController@get_feed_cache_key'}( $this ),
            $this->frequency,
            function () {
                $feeds = [];
                $this->feed_from_facebook( $feeds );
                $this->feed_from_instagram( $feeds );
                if ( is_ssl() ) {
                    $this->feed_from_twitter( $feeds );
                }
                if ( $this->merge ) {
                    $this->feed_merge( $feeds );
                }
                return $feeds;
            }
        );
        return apply_filters( 'socialfeeder_feeds', $feeds );
    }
    /**
     * Returns model attributes.
     * @since 1.0.2
     * 
     * @return array
     */
    public function get_data()
    {
        return $this->attributes;
    }
}