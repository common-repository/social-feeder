<?php

namespace SocialFeeder\Controllers;

use WPMVC\MVC\Controller;
/**
 * Configuration.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
class ConfigController extends Controller
{
    /**
     * Returns action links.
     * @since 1.0.2
     * 
     * @hook plugin_action_links_{basename}
     *
     * @param array $links Plugin action links.
     *
     * @return array
     */
    public function plugin_links( $links = [] )
    {
        return array_merge( [ '<a href="' . admin_url( 'options-general.php?page=social-feeder-settings' ) . '">' . __( 'Settings' ) . '</a>' ], $links );
    }
    /**
     * Returns row meta links.
     * @since 1.0.2
     * 
     * @hook plugin_row_meta
     * 
     * @param array  $meta
     * @param string $file
     * 
     * @return array
     */
    public function row_meta( $meta, $file )
    {
        if ( $file === 'social-feeder/plugin.php' ) {
            $meta['docs'] = '<a href="' .
                esc_url( 'https://www.10quality.com/docs/social-feeder/' ) .
                '" aria-label="' .
                esc_attr__( 'Documentation', 'social-feeder' ) .
                '" target="_blank">' .
                esc_html__( 'Documentation', 'social-feeder' ) .
                '</a>';
            $meta['news'] = '<a href="' .
                esc_url( 'https://www.10quality.com/tag/social-feeder/' ) .
                '" aria-label="' .
                esc_attr__( 'News', 'social-feeder' ) .
                '" target="_blank">' .
                esc_html__( 'News', 'social-feeder' ) .
                '</a>';
        }
        return $meta;
    }
}