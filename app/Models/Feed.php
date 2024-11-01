<?php

namespace SocialFeeder\Models;

use SocialFeeder\Traits\FeedTrait;
use WPMVC\MVC\Traits\GenericModelTrait;
/**
 * Feed custom model.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.4
 */
class Feed
{
    use FeedTrait, GenericModelTrait;
    /**
     * Twitter key.
     * @since 1.0.0
     * @var string
     */
    const FEEDER_TWITTER = 'twitter';
    /**
     * Instagram key.
     * @since 1.0.0
     * @var string
     */
    const FEEDER_INSTAGRAM = 'instagram';
    /**
     * Facebook key.
     * @since 1.0.1
     * @var string
     */
    const FEEDER_FACEBOOK = 'facebook';
    /**
     * Attributes and aliases hidden from print.
     * @since 1.0.0
     * @var array
     */
    protected $hidden = array();
    /**
     * Feed aliasses to attributes.
     * @since 1.0.0
     * @var array
     */
    protected $aliases = [
        'profile_image_url' => 'field_feed_profile_image_url',
        'feeder' => 'field_feeder',
        'feed_id' => 'field_feed_id',
        'url' => 'field_feed_url',
        'time' => 'field_feed_time',
        'content' => 'field_feed_content',
        'media_url' => 'field_feed_media',
        'media_thumb' => 'field_feed_media_thumb',
        'media_type' => 'field_feed_media_type',
        'media_embed' => 'field_feed_media_embed',
        'date_format' => 'field_date_format',
        'date' => 'func_get_date',
        'link' => 'field_feed_link',
    ];
    /**
     * Creates feed from twitter feed.
     * @since 1.0.0
     *
     * @param object $data        Twitter data.
     * @param string $date_format Date format.
     *
     * @return this for chaining
     */
    public function from_twitter( &$data, $date_format = 'F m, J' )
    {
        $this->attributes['date_format'] = $date_format;
        $this->attributes['feeder'] = self::FEEDER_TWITTER;
        // Normalize data
        foreach ( $data as $key => $value ) {
            switch ( $key ) {
                case 'id':
                    $this->attributes['feed_id'] = $value;
                    break;
                case 'text':
                case 'full_text':
                    $this->attributes['feed_content'] = $value;
                    break;
                case 'id_str':
                    $this->attributes['feed_url'] = get_tweet_url( $value );
                    break;
                case 'created_at':
                    $this->attributes['feed_time'] = strtotime( $value );
                    break;
                case 'profile_image_url':
                    $this->attributes['feed_profile_image_url'] = $value;
                    break;
                case 'entities':
                    if ( isset( $value->media ) && isset( $value->media[0] ) ) {
                        $this->attributes['feed_media'] = $value->media[0]->media_url;
                    }
                    $this->attributes['feed_media_type'] = 'image';
                    break;
                default:
                    $this->attributes[$key] = $value;
                    break;
            }
            $this->attributes = apply_filters( 'socialfeeder_twitter_feed_loop', $this->attributes, $key, $value );
        }
        $this->attributes = apply_filters( 'socialfeeder_twitter_feed_data', $this->attributes, $data );
        return $this;
    }
    /**
     * Creates feed from instagram feed.
     * @since 1.0.0
     *
     * @param object $media        Instagram media data.
     * @param string $date_format Date format.
     *
     * @return this for chaining
     */
    public function from_instagram( &$media, $date_format = 'F m, J' )
    {
        $this->attributes['date_format'] = $date_format;
        $this->attributes['feeder'] = self::FEEDER_INSTAGRAM;
        // Normalize data
        foreach ( $media->getData() as $key => $value ) {
            switch ( $key ) {
                case 'id':
                    $this->attributes['feed_id'] = $value;
                    break;
                case 'link':
                    $this->attributes['feed_url'] = $value;
                    break;
                case 'created_time':
                    $this->attributes['feed_time'] = $value;
                    break;
                case 'profile_picture':
                    $this->attributes['feed_profile_image_url'] = $value;
                    break;
                case 'images':
                    $this->attributes['feed_media'] = $value->standard_resolution->url;
                    $this->attributes['feed_media_type'] = 'image';
                    break;
                case 'caption':
                    if ( !empty( $value ) && isset( $value->text ) ) {
                        $this->attributes['feed_content'] = $value->text;
                    }
                    break;
                default:
                    $this->attributes[$key] = $value;
                    break;
            }
            $this->attributes = apply_filters( 
                'socialfeeder_instagram_feed_loop',
                $this->attributes,
                $key,
                $value
            );
        }
        $this->attributes = apply_filters( 'socialfeeder_instagram_feed_data', $this->attributes, $media );
        return $this;
    }
    /**
     * Creates feed from facebook feed.
     * @since 1.0.1
     *
     * @param array  $data        Feed data.
     * @param string $date_format Date format.
     *
     * @return this for chaining
     */
    public function from_facebook( &$data, $date_format = 'F m, J' )
    {
        $this->attributes['date_format'] = $date_format;
        $this->attributes['feeder'] = self::FEEDER_FACEBOOK;
        // Normalize data
        foreach ( $data as $key => $value ) {
            switch ( $key ) {
                case 'message':
                    $this->attributes['feed_content'] = $value;
                    break;
                case 'created_time':
                    $this->attributes['feed_time'] = strtotime( $value );
                    break;
                case 'story':
                    if ( !isset( $this->attributes['feed_content'] ) ) {
                        $this->attributes['feed_content'] = '';
                    }
                    $this->attributes['feed_content'] .= '<span class="story">' . $value . '</span>';
                    break;
                case 'type':
                    switch ( $value ) {
                        case 'photo':
                            $this->attributes['feed_media'] = $data['picture'];
                            $this->attributes['feed_media_type'] = 'image';
                            break;
                        case 'video':
                            if ( isset( $data['source'] ) ) {
                                $this->attributes['feed_thumb'] = $data['picture'];
                                $this->attributes['feed_media'] = $data['source'];
                                $this->attributes['feed_media_type'] = 'video';
                            } else {
                                if ( isset( $data['picture'] ) ) {
                                    $this->attributes['feed_media'] = $data['picture'];
                                    $this->attributes['feed_media_type'] = 'image';
                                }
                            }
                            if ( isset( $data['caption'] )
                                && $data['caption'] === 'youtube.com'
                            ) {
                                $this->attributes['feed_media_embed'] = apply_filters( 'socialfeeder_feed_embed', null, 'youtube', $data['source'] );
                            }
                            break;
                    }
                    break;
                case 'id':
                    $this->attributes['feed_url'] = get_facebook_url( $value );
                    break;
                case 'link':
                    $this->attributes['feed_link'] = $value;
                    if ( isset( $data['picture'] ) ) {
                        $this->attributes['feed_media'] = $data['picture'];
                        $this->attributes['feed_media_type'] = 'image';
                    }
                    if ( isset( $data['caption'] ) ) {
                        $this->attributes['feed_content'] = $data['caption'];
                    }
                    break;
                default:
                    $this->attributes[$key] = $value;
                    break;
            }
            $this->attributes = apply_filters( 'socialfeeder_facebook_feed_loop', $this->attributes, $key, $value );
        }
        $this->attributes = apply_filters( 'socialfeeder_facebook_feed_data', $this->attributes, $data );
        return $this;
    }
    /**
     * Returns formatted date.
     * @since 1.0.0
     *
     * @return string
     */
    protected function get_date()
    {
        return date( $this->date_format, $this->time );
    }
}