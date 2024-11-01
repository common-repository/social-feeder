<?php
/**
 * Admin settings, "Instagram" tab.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.7
 */
?>
<section id="instagram"
    <?php if ( $tab != 'instagram' ) : ?>style="display: none;"<?php endif ?>
>
    <h3>
        <?php _e( 'Instagram Settings', 'social-feeder' ) ?>
    </h3>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Enabled', 'social-feeder' ) ?></th>
            <td>
                <input type="checkbox"
                    name="instagram_enabled"
                    value="1"
                    <?php if ( $social_feeder->is_instagram_setup && $social_feeder->instagram['enabled'] ) : ?>checked<?php endif ?>
                />
            </td>
        </tr>

    </table>

    <h4>
        <?php _e( 'Application Settings', 'social-feeder' ) ?>
    </h4>

    <p class="description">
        <?php _e( 'Configure you Instagram\'s application settings, if you don\'t have one, get one here:', 'social-feeder' ) ?>
        <a href="https://www.instagram.com/developer/">
            <?php _e( 'Instagram for Developers', 'social-feeder' ) ?>
        </a>
        <br>
        <?php _e( 'The following additional permissions are required. (Start a permission submission at the <i>Permissions</i> tab when mananging you client)' ) ?>
        <br>
        <ol>
            <li>
                <strong>relationships</strong> - <?php _e( 'Needed to read the account feed.' ) ?>
            </li>
            <li>
                <strong>public_content</strong> - <?php _e( 'Needed to read the account feed.' ) ?>
            </li>
        </ol>
    </p>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Client ID', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="instagram_client_id"
                    value="<?php echo $social_feeder->is_instagram_setup ? $social_feeder->instagram['client_id'] : '' ?>"
                    class="regular-text"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Client Secret', 'social-feeder' ) ?></th>
            <td>
                <input type="text"
                    name="instagram_client_secret"
                    value="<?php echo $social_feeder->is_instagram_setup ? $social_feeder->instagram['client_secret'] : '' ?>"
                    class="regular-text"
                />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Redirect URL', 'social-feeder' ) ?></th>
            <td>
                <p style="color: #FA3D00;"><?php echo admin_url( 'index.php?trigger=instagram-callback' ) ?></p>
                <br>
                <span class="description">
                    <?php _e( 'This should be your redirect url. Setup this setting at your Instagram Developer Dashboard.' ) ?>
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
        <a href="<?php echo admin_url( 'index.php?trigger=social-feeder-settings&trigger=social-feeder&action=auth-instagram' ) ?>"
            class="button button-auth"
        >
            <?php _e( 'Authenticate', 'social-feeder' ) ?>
        </a>
    </div>

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
                    name="instagram_follow_url"
                    value="<?php echo $social_feeder->is_instagram_setup ? $social_feeder->instagram['follow_url'] : '' ?>"
                    class="regular-text"
                />
                <br>
                <span class="description">
                    <?php _e( 'URL to redirect the user to when follow us link is clicked.', 'social-feeder' ) ?>
                </span>
            </td>
        </tr>

    </table>

    <?php do_action( 'socialfeeder_admin_instagram_settings_footer', $social_feeder ) ?>

</section>