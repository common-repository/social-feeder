<?php
/**
 * Feeds wrapper view/template.
 * 
 * COPY THIS FILE IN YOUR THEME FOR CUSTOMIZATIONS. LOCATION:
 * [theme-folder]/socialfeeder/wrapper.php
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.2
 */
?>
<?php do_action( 'socialfeeder_before_wrapper', $social_feeder ) ?>
<div class="<?php echo esc_html( $classes ) ?>">
    <?php do_action( 'socialfeeder_before_theme', $social_feeder ) ?>
    <?php do_action( 'socialfeeder_theme_' . $theme, $feeds, $social_feeder, $styles ) ?>
    <?php do_action( 'socialfeeder_after_theme', $social_feeder ) ?>
</div><!-- WRAPPER -->
<?php do_action( 'socialfeeder_after_wrapper', $social_feeder ) ?>