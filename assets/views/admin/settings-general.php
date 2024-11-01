<?php
/**
 * Admin settings, "General" tab.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
?>
<section id="general"
    <?php if ( $tab != 'general' ) : ?>style="display: none;"<?php endif ?>
>
    <h3>
        <?php _e( 'General Settings', 'social-feeder' ) ?>
    </h3>
    
    <?php do_action( 'socialfeeder_admin_general_settings_header', $social_feeder ) ?>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Refresh Frequency', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="frequency"
                    value="<?php echo $social_feeder->frequency ?>"
                    class="regular-text"
                    placeholder="<?php _e( 'in minutes', 'social-feeder' ) ?>"
                />
                <br>
                <span class="description">
                    <?php _e( 'How frequently will the feed refresh. Value in minutes (default 60).', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Date Format', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="date_format"
                    value="<?php echo $social_feeder->date_format ?>"
                    class="regular-text"
                    placeholder="<?php _e( 'i.e. Y-m-d', 'social-feeder' ) ?>"
                />
                <br>
                <span class="description">
                    <?php _e( 'Use php formatting:', 'social-feeder' ) ?> 
                    <a href="http://php.net/manual/en/function.date.php">
                        <?php _e( 'PHP dates', 'social-feeder' ) ?>
                    </a>
                </span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Merge', 'social-feeder' ) ?></th>
            <td>
                <input type="checkbox"
                    name="merge"
                    value="1"
                    <?php if ( $social_feeder->merge ) : ?>checked<?php endif ?>
                />
                <br>
                <span class="description">
                    <?php _e( 'Merges all social networks and display the most recent posts in one feed.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Limit', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="limit"
                    value="<?php echo $social_feeder->limit ?>"
                    class="regular-text"
                    placeholder="<?php _e( 'i.e. 4, 5, 6', 'social-feeder' ) ?>"
                />
                <br>
                <span class="description">
                    <?php _e( 'Limits the amount of items to display in feed.', 'social-feeder' ) ?>
                    <br>
                    <?php _e( 'When <strong>merge</strong> is un-selected, the limit will be applied per social network.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Show follow us', 'social-feeder' ) ?></th>
            <td>
                <input type="checkbox"
                    name="follow_us"
                    value="1"
                    <?php if ( $social_feeder->follow_us ) : ?>checked<?php endif ?>
                />
                <br>
                <span class="description">
                    <?php _e( 'Whether or not to display the "follow us" links below the feed.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

        <?php if ( apply_filters( 'socialfeeder_show_pro_features', true ) ) : ?>
            <tr valign="top">
                <th scope="row"><?php _e( 'Highlight', 'social-feeder' ) ?></th>
                <td>
                    <input type="checkbox"
                        name="demo_highlight"
                        value="0"
                        disabled
                    />
                    <br>
                    <span class="description" style="color:#777">
                        <?php _e( 'Highlight links and hashtags (#) in the feed\'s content.', 'social-feeder' ) ?>
                    </span>
                    <br>
                    <?php socialfeeder()->view( 'pro.feature' ) ?>
                </td>
            </tr>
        <?php endif ?>
    
        <?php do_action( 'socialfeeder_admin_general_settings_tr', $social_feeder ) ?>

    </table>

    <input type="hidden"
        name="security_key"
        value="<?php echo $social_feeder->security_key ? $social_feeder->security_key : uniqid( '', true ) ?>"
    />
    
    <?php do_action( 'socialfeeder_admin_general_settings_footer', $social_feeder ) ?>
</section>