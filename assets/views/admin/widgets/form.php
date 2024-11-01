<?php
/**
 * Widget form.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.0
 */
?>
<div class="social-feeder">
    <p>
        <label for="<?php echo $widget->get_field_id( 'title' ) ?>">
            <?php _e( 'Title' ) ?>
        </label>
        <input id="<?php echo $widget->get_field_id( 'title' ) ?>"
            name="<?php echo $widget->get_field_name( 'title' ) ?>"
            class="widefat"
            type="text"
            value="<?php echo $instance['title'] ?>"
        >
    </p>
    <p>
        <label for="<?php echo $widget->get_field_id( 'limit' ) ?>">
            <?php _e( 'Feed limit:', 'social-feeder' ) ?>
        </label>
        <input id="<?php echo $widget->get_field_id( 'limit' ) ?>"
            name="<?php echo $widget->get_field_name( 'limit' ) ?>"
            class="widefat"
            type="number"
            value="<?php echo $instance['limit'] ?>"
        >
        <br>
        <span class="description">
            <?php _e( 'Amount of feed items to display.', 'social-feeder' ) ?>
        </span>
    </p>
    <p>
        <label for="<?php echo $widget->get_field_id( 'direction' ) ?>">
            <?php _e( 'Display:', 'social-feeder' ) ?>
        </label>
        <select id="<?php echo $widget->get_field_id( 'direction' ) ?>"
            name="<?php echo $widget->get_field_name( 'direction' ) ?>"
            class="widefat"
        >
            <?php foreach ( $directions as $value => $label ) : ?>
                <option value="<?php esc_html_e( $value ) ?>"
                    <?php if ( $value === $instance['direction'] ) : ?>selected<?php endif ?>
                ><?php esc_html_e( $label ) ?></option>
            <?php endforeach ?>
        </select>
    </p>
    <p>
        <label for="<?php echo $widget->get_field_id( 'width' ) ?>">
            <?php _e( 'Width:', 'social-feeder' ) ?>
        </label>
        <input id="<?php echo $widget->get_field_id( 'width' ) ?>"
            name="<?php echo $widget->get_field_name( 'width' ) ?>"
            class="widefat"
            type="text"
            value="<?php echo $instance['width'] ?>"
        >
        <br>
        <span class="description">
            <?php _e( 'Max width (px|%) per feed.', 'social-feeder' ) ?>
        </span>
    </p>
    <p>
        <label for="<?php echo $widget->get_field_id( 'height' ) ?>">
            <?php _e( 'Height:', 'social-feeder' ) ?>
        </label>
        <input id="<?php echo $widget->get_field_id( 'height' ) ?>"
            name="<?php echo $widget->get_field_name( 'height' ) ?>"
            class="widefat"
            type="text"
            value="<?php echo $instance['height'] ?>"
        >
        <br>
        <span class="description">
            <?php _e( 'Max height (px|%) per feed.', 'social-feeder' ) ?>
        </span>
    </p>
    <?php if ( apply_filters( 'socialfeeder_show_pro_features', true ) ) : ?>
        <p>
            <label style="color:#777">
                <?php _e( 'Theme:', 'social-feeder' ) ?>
            </label>
            <select class="widefat" disabled>
                <option value=""><?php _e( '--> Selected on settings', 'social-feeder' ) ?></option>
            </select>
            <?php socialfeeder()->view( 'pro.feature' ) ?>
        </p>
    <?php endif ?>
    <?php do_action( 'socialfeeder_widget_form', $widget, $instance, $social_feeder ) ?>
</div>