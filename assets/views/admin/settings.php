<?php
/**
 * Admin settings view template.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.0
 */
?>
<div class="wrap">

    <h2><?php _e( 'Social Feeder Settings', 'social-feeder' ) ?></h2>

    <?php if ( $notice ) : ?>
        <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
            <p><strong><?php echo $notice ?></strong></p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text"><?php _e( 'Dismiss this notice.', 'social-feeder' ) ?></span>
            </button>
        </div>
    <?php endif ?>

    <?php if ( $error ) : ?>
        <div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"> 
            <p><strong><?php echo $error ?></strong></p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text"><?php _e( 'Dismiss this notice.', 'social-feeder' ) ?></span>
            </button>
        </div>
    <?php endif ?>

    <form method="POST">

        <h3 class="nav-tab-wrapper">
            <?php foreach ( $tabs as $key => $name ) : ?>
                <a class="nav-tab <?php if ( $tab == $key ) :?>nav-tab-active<?php endif ?>"
                    href="<?php echo admin_url( 'options-general.php?page=social-feeder-settings&tab=' . $key ) ?>"
                >
                    <?= $name ?>
                </a>
            <?php endforeach ?>
        </h3>

        <?php $view->show( 'admin.settings-general', [ 'tab' => &$tab, 'social_feeder' => &$social_feeder ] ) ?>

        <?php $view->show( 'admin.settings-facebook', [ 'tab' => &$tab, 'social_feeder' => &$social_feeder, 'config' => &$config ] ) ?>

        <?php $view->show( 'admin.settings-twitter', [ 'tab' => &$tab, 'social_feeder' => &$social_feeder ] ) ?>

        <?php $view->show( 'admin.settings-instagram', [ 'tab' => &$tab, 'social_feeder' => &$social_feeder ] ) ?>

        <?php $view->show( 'admin.settings-themes', [ 'tab' => &$tab, 'social_feeder' => &$social_feeder, 'themes' => &$themes ] ) ?>

        <?php do_action( 'socialfeeder_admin_settings_tab', $tab, $social_feeder ) ?>

        <?php submit_button() ?>

    </form>

</div>