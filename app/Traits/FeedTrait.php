<?php

namespace SocialFeeder\Traits;

/**
 * Feed model trait.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.1
 */
trait FeedTrait
{
    /**
     * Attributes in model.
     * @since 1.0.0
     * @var array
     */
    protected $attributes = array();
    /**
     * Returns property mapped to alias.
     * @since 1.0.1
     *
     * @param string $alias Alias.
     *
     * @return string
     */
    private function get_alias_property( $alias )
    {
        if ( array_key_exists( $alias, $this->aliases ) ) {
            return $this->aliases[$alias];
        }
        return $alias;
    }
    /**
     * Returns alias name mapped to property.
     * @since 1.0.1
     *
     * @param string $property Property.
     *
     * @return string
     */
    private function get_alias( $property )
    {
        if ( in_array( $property, $this->aliases ) ) {
            return array_search( $property, $this->aliases );
        }
        return $property;
    }
    /**
     * Returns json string.
     *
     * @param string
     */
    public function to_json()
    {
        return json_encode( $this->to_array() );
    }
    /**
     * Returns string.
     *
     * @param string
     */
    public function __toString()
    {
        return $this->to_json();
    }
}