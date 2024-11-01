<?php
/**
 * Admin settings, "Twitter" tab.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.3
 */
?>
<section id="twitter"
    <?php if ( $tab != 'twitter' ) : ?>style="display: none;"<?php endif ?>
>
    <h3>
        <?php _e( 'Twitter Settings', 'social-feeder' ) ?>
    </h3>

    <p class="description">
        <i style="color: #F44336;"><?php _e( 'NOTE: Upon recent Twitter policy updates, your site will require SSL to show this feed.', 'social-feeder' ) ?></i>
    </p>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Enabled', 'social-feeder' ) ?></th>
            <td>
                <input type="checkbox"
                    name="twitter_enabled"
                    value="1"
                    <?php if ( $social_feeder->is_twitter_setup && $social_feeder->twitter['enabled'] ) : ?>checked<?php endif ?>
                />
            </td>
        </tr>

    </table>

    <h4>
        <?php _e( 'Application Settings', 'social-feeder' ) ?>
    </h4>

    <p class="description">
        <?php _e( 'Configure you Twitter\'s application settings, if you don\'t have one, get one here:', 'social-feeder' ) ?>
        <a href="https://apps.twitter.com">
            <?php _e( 'Twitter Apps', 'social-feeder' ) ?>
        </a>
    </p>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Consumer Key', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="twitter_api_key"
                    value="<?php echo $social_feeder->is_twitter_setup ? $social_feeder->twitter['api_key'] : '' ?>"
                    class="regular-text"
                />
                <br>
                <span class="description">
                    <?php _e( 'API Key.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Consumer Secret', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="twitter_api_secret"
                    value="<?php echo $social_feeder->is_twitter_setup ? $social_feeder->twitter['api_secret'] : '' ?>"
                    class="regular-text"
                />
                <br>
                <span class="description">
                    <?php _e( 'API Secret.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Access Token', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="twitter_token"
                    value="<?php echo $social_feeder->is_twitter_setup ? $social_feeder->twitter['token'] : '' ?>"
                    class="regular-text"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Access Token Secret', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="twitter_token_secret"
                    value="<?php echo $social_feeder->is_twitter_setup ? $social_feeder->twitter['token_secret'] : '' ?>"
                    class="regular-text"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Screen name', 'social-feeder' ) ?></th>
            <td>
                @<input type="text"
                    name="twitter_screen_name"
                    value="<?php echo $social_feeder->is_twitter_setup ? $social_feeder->twitter['screen_name'] : '' ?>"
                    class="regular-text"
                />
                <br>
                <span class="description">
                    <?php _e( 'Twitter\'s username (screen name) without @', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

    </table>

    <h4>
        <?php _e( 'Follow Us', 'social-feeder' ) ?>
    </h4>

    <p class="description">
        <?php _e( 'In the default template, follow us icons appear at the bottom of the feeder.', 'social-feeder' ) ?>
    </p>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'URL Link', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="twitter_follow_url"
                    value="<?php echo $social_feeder->is_twitter_setup ? $social_feeder->twitter['follow_url'] : '' ?>"
                    class="regular-text"
                />
                <br>
                <span class="description">
                    <?php _e( 'URL to redirect the user to when follow us link is clicked.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

    </table>

    <?php do_action( 'socialfeeder_admin_twitter_settings_footer', $social_feeder ) ?>

</section>