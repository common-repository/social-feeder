<?php
/**
 * Admin settings, "Facebook" tab.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
?>
<section id="facebook"
    <?php if ( $tab != 'facebook' ) : ?>style="display: none;"<?php endif ?>
>
    <h3>
        <?php _e( 'Facebook Settings', 'social-feeder' ) ?>
    </h3>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Enabled', 'social-feeder' ) ?></th>
            <td>
                <input type="checkbox"
                    name="facebook_enabled"
                    value="1"
                    <?php if ( $social_feeder->is_facebook_setup && $social_feeder->facebook['enabled'] ) : ?>checked<?php endif ?>
                />
            </td>
        </tr>

    </table>

    <h4>
        <?php _e( 'Application Settings', 'social-feeder' ) ?>
    </h4>

    <p class="description">
        <?php _e( 'Configure you facebook\'s application settings, if you don\'t have one, get one here:', 'social-feeder' ) ?>
        <a href="https://developers.facebook.com/apps">
            <?php _e( 'Facebook Developer Apps', 'social-feeder' ) ?>
        </a>
        <br>
        <?php _e( 'The following additional Facebook permissions are required. (Set them at <i>Status and Review</i> in Facebook Developer Apps Dashboard)' ) ?>
        <br>
        <ol>
            <li>
                <strong>user_posts</strong> - <?php _e( 'Needed to display your primary account\'s feed.' ) ?>
            </li>
            <li>
                <strong>manage_pages</strong> - <?php _e( 'Needed to display feed from pages you manage.' ) ?>
            </li>
        </ol>
    </p>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'App ID', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="facebook_app_id"
                    value="<?php echo $social_feeder->is_facebook_setup ? $social_feeder->facebook['app_id'] : '' ?>"
                    class="regular-text"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'App secret', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="facebook_app_secret"
                    value="<?php echo $social_feeder->is_facebook_setup ? $social_feeder->facebook['app_secret'] : '' ?>"
                    class="regular-text"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Api Version', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="facebook_api_version"
                    value="<?php echo $social_feeder->is_facebook_setup ? $social_feeder->facebook['api_version'] : '' ?>"
                    class="regular-text"
                    placeholder="i.e. v2.10"
                />
                <br>
                <span class="description">
                    <?php _e( 'If non set, plugin will default it to v2.10.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'OAuth redirect URL', 'social-feeder' ) ?></th>
            <td>
                <p style="color: #FA3D00;"><?php echo admin_url( 'index.php?trigger=facebook-callback' ) ?></p>
                <br>
                <span class="description">
                    <?php _e( 'This should be your <strong>Valid OAuth redirect url</strong>. Setup this setting at your Facebook Developer Apps Dashboard, section:' ) ?>
                    <br>
                    <i><?php _e( 'Login with Facebook Settings-> Advanced-> Client OAuth Settings' ) ?></i>
                </span>
            </td>
        </tr>

    </table>

    <h4>
        <?php _e( 'Authentication', 'social-feeder' ) ?>
    </h4>

    <p class="description">
        <?php _e( 'The plugin will perform authentication if needed. You can force and reset authentication by clicking the following button:', 'social-feeder' ) ?>
    </p>

    <div class="authorization">
        <a href="<?php echo admin_url( 'index.php?trigger=social-feeder-settings&trigger=social-feeder&action=auth-facebook' ) ?>"
            class="button button-auth"
        >
            <?php _e( 'Authenticate', 'social-feeder' ) ?>
        </a>
    </div>

    <?php if ( $social_feeder->has_facebook_pages ) : ?>

        <h4>
            <?php _e( 'Profile', 'social-feeder' ) ?>
        </h4>

        <p class="description">
            <?php _e( 'Select the profile you want to display feeds from:', 'social-feeder' ) ?>
        </p>

        <table class="form-table">

            <tr valign="top">
                <th scope="row"><?php _e( 'Options', 'social-feeder' ) ?></th>
                <td>
                    <input type="radio"
                        name="facebook_profile"
                        value="<?php echo $social_feeder->facebook_accounts['me']['id'] ?>"
                        <?php if ( $social_feeder->is_facebook_me ) : ?>checked<?php endif ?>
                    /> <?php echo $social_feeder->facebook_accounts['me']['name'] ?>
                    <br>
                    <br>
                    <input type="radio"
                        name="facebook_profile"
                        value="page"
                        <?php if ( ! $social_feeder->is_facebook_me ) : ?>checked<?php endif ?>
                    /> <?php _e( 'Page', 'social-feeder' ) ?>:
                    <select name="facebook_page">
                        <?php foreach ( $social_feeder->facebook_accounts['pages'] as $page ) : ?>
                            <option value="<?php echo $page['id'] ?>"
                                <?php if ( $social_feeder->facebook_page == $page['id'] ) : ?>selected<?php endif ?>
                            >
                                <?php echo $page['name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>

        </table>

    <?php endif ?>

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
                    name="facebook_follow_url"
                    value="<?php echo $social_feeder->is_facebook_setup ? $social_feeder->facebook['follow_url'] : '' ?>"
                    class="regular-text"
                />
                <br>
                <span class="description">
                    <?php _e( 'URL to redirect the user to when follow us link is clicked.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

    </table>

    <?php do_action( 'socialfeeder_admin_facebook_settings_footer', $social_feeder ) ?>

</section>