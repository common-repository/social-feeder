<?php
/**
 * Admin settings, "Theme" tab.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
?>
<style type="text/css">
.themes {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}
.theme {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px;
}
.theme img {
    max-width: 175px;
    max-height: 315px;
}
.theme:hover img {
    opacity: 0.7;
}
.theme  input[type="radio"] {
    margin: 5px 0 0 !important;
}
</style>
<section id="themes"
    <?php if ( $tab != 'themes' ) : ?>style="display: none;"<?php endif ?>
>
    <h3>
        <?php _e( 'Theme Settings', 'social-feeder' ) ?>
    </h3>
    
    <?php do_action( 'socialfeeder_admin_themes_settings_header', [ 'social_feeder' => $social_feeder ] ) ?>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Enqueue styles', 'social-feeder' ) ?></th>
            <td>
                <input type="checkbox"
                    name="enqueue_styles"
                    value="1"
                    <?php if ( $social_feeder->enqueue_styles ) : ?>checked<?php endif ?>
                />
                <br>
                <span class="description">
                    <?php _e( 'Whether or not to enqueue / include the styles that come with the plugin. (IDs "social-feeder" and "font-awesome").', 'social-feeder' ) ?>
                </span>
                <?php do_action( 'socialfeeder_admin_themes_settings_enqueue_td', [ 'social_feeder' => $social_feeder ] ) ?>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Theme' ) ?></th>
            <td>
                <div class="themes">
                    <?php foreach ( $themes as $theme ) : ?>
                        <label class="theme">
                            <?php if ( isset( $theme[ 'preview' ] ) ) : ?>
                                <img src="<?php echo $theme[ 'preview' ] ?>"
                                    alt="<?php echo $theme['name'] ?>"
                                />
                            <?php endif ?>
                            <span class="name"><?php echo $theme['name'] ?></span>
                            <input type="radio"
                                name="theme"
                                value="<?php echo $theme['id'] ?>"
                                <?php if ( $social_feeder->theme === $theme['id'] ) : ?>checked<?php endif ?>
                                <?php if ( isset( $theme['disabled'] ) && $theme['disabled'] ) : ?>disabled<?php endif ?>
                            />
                        </label>
                    <?php endforeach ?>
                </div>
                <br>
                <span class="description">
                    <?php _e( 'Select the default theme of your choice. A theme defines how the feed will look like. Preview image may vary with the selected theme.', 'social-feeder' ) ?>
                </span>
                <?php if ( apply_filters( 'socialfeeder_show_pro_features', true ) ) : ?>
                        <?php socialfeeder()->view( 'pro.themes' ) ?>
                <?php endif ?>
                <?php do_action( 'socialfeeder_admin_themes_settings_theme_td', $social_feeder ) ?>
            </td>
        </tr>
    
        <?php do_action( 'socialfeeder_admin_themes_settings_tr', $social_feeder ) ?>

    </table>
    
    <?php do_action( 'socialfeeder_admin_themes_settings_footer', $social_feeder ) ?>
</section>