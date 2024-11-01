<?php
/**
 * Feeds display on theme: "legacy" | "default" | "invert"
 * 
 * COPY THIS FILE IN YOUR THEME FOR CUSTOMIZATIONS. LOCATION:
 * [theme-folder]/socialfeeder/feed/legacy.php
 *
 * @author Cami Mostajo
 * @copyright 10Quality <https://www.10quality.com>
 * @license GPLv3
 * @package social-feeder
 * @version 1.0.4
 */
?>
<!-- FEEDS SECTION -->
<!-- BEGIN ....... -->
<?php if ( count( $feeds ) > 0 ) : ?>
    <?php do_action( 'socialfeeder_before_feeds', $social_feeder ) ?>
    <div class="feeds">
        <?php foreach ( $feeds as $feed ) : ?>
            <div class="<?php echo sf_get_feed_classes( $feed, $social_feeder ) ?>" style="<?php echo $styles ?>">
                <div class="network">
                    <?php if ( $feed->feeder == 'twitter' ) : ?>
                        <i class="fa fa-twitter"></i>
                    <?php elseif ( $feed->feeder == 'instagram' ) : ?>
                        <i class="fa fa-instagram"></i>
                    <?php elseif ( $feed->feeder == 'facebook' ) : ?>
                        <i class="fa fa-facebook"></i>
                    <?php endif ?>
                </div>
                <div class="item">
                    <?php do_action( 'socialfeeder_top_feed', $feed, $social_feeder ) ?>
                    <a href="<?php echo $feed->link ? $feed->link : $feed->url ?>" class="link">
                        <?php if ( $feed->media_embed ) : ?>
                            <?php echo $feed->media_embed ?>
                        <?php elseif ( $feed->media_url ) : ?>
                            <img src="<?php echo $feed->media_url ?>"
                                alt="feed <?php echo $feed->feeder ?> <?php echo $feed->date ?>"
                            />
                        <?php endif ?>
                        <span class="date"><?php echo $feed->date ?></span>
                        <div class="content"><?php echo $feed->content ?></div>
                    </a>
                    <?php do_action( 'socialfeeder_bottom_feed', $feed, $social_feeder ) ?>
                </div>
            </div><!--.feed-->
        <?php endforeach ?>
    </div><!--.feeds-->
    <?php do_action( 'socialfeeder_after_feeds', $social_feeder ) ?>
<?php endif ?>
<!-- END ......... -->
<!-- FEEDS SECTION -->

<!-- FOLLOW US SECTION -->
<!-- BEGIN ....... -->
<?php if ( $social_feeder->follow_us ) : ?>
    <?php do_action( 'socialfeeder_before_follow_us', $social_feeder ) ?>
    <div class="follow-us">
        <?php do_action( 'socialfeeder_top_follow_us', $social_feeder ) ?>
        <?php if ( $social_feeder->is_twitter_legible ) : ?>
            <a href="<?php echo $social_feeder->twitter['follow_url'] ?>"
                title="<?php printf( __( 'Follow us on %s', 'social-feeder' ), 'Twitter' ) ?>"
            >
                <i class="fa fa-twitter"></i>
            </a>
        <?php endif ?>
        <?php if ( $social_feeder->is_instagram_legible ) : ?>
            <a href="<?php echo $social_feeder->instagram['follow_url'] ?>"
                title="<?php printf( __( 'Follow us on %s', 'social-feeder' ), 'Instagram' ) ?>"
            >
                <i class="fa fa-instagram"></i>
            </a>
        <?php endif ?>
        <?php if ( $social_feeder->is_facebook_legible ) : ?>
            <a href="<?php echo $social_feeder->facebook['follow_url'] ?>"
                title="<?php printf( __( 'Follow us on %s', 'social-feeder' ), 'Facebook' ) ?>"
            >
                <i class="fa fa-facebook"></i>
            </a>
        <?php endif ?>
        <?php do_action( 'socialfeeder_bottom_follow_us', $social_feeder ) ?>
    </div>
    <?php do_action( 'socialfeeder_after_follow_us', $social_feeder ) ?>
<?php endif ?>
<!-- END ......... -->
<!-- FOLLOW US SECTION -->