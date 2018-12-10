<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 1/31/2016
 * Vertion: 1.0
 */

?>

<div class="wrap about-wrap yetithemes-wrap">

    <?php do_action('yetithemes_plugin_panel_header'); ?>

    <div class="nav-tab-conent">

        <div class="white-bg two-col">
            <div class="col">
                <h3>Documentation</h3>
                <p>Fully functional mega menu supports displaying category links, image, video and product showcase.</p>
            </div>
            <div class="col">
                <h3>Support center</h3>
                <p>If you need some help for everything about Elextron, that can' be found in documentation, please create a ticket in here: <a href="https://themeyeti.atlassian.net/servicedesk/customer/portal/2/group/3">https://themeyeti.atlassian.net/servicedesk/customer/portal/2/group/3</a> and give us:</p>
                <ol>
                    <li>Your issues (and screenshots)</li>
                    <li>Your purchase code (request)</li>
                    <li>Your site info</li>
                </>
            </div>
        </div>

        <h2 class="clear">Video tutorial</h2>
        <?php
        $video_list = Yetithemes_YoutubeApi()->get_playList();
        if(is_array($video_list) && isset($video_list['items']) && !empty($video_list['items'])): ?>


            <div class="yeti-items">

            <?php foreach ($video_list['items'] as $video):
                $_snippet = $video['snippet'];
                $_resourceId = $_snippet['resourceId'];
                $_image = $_snippet['thumbnails']['high'];
                ?>

                <div class="yeti-item col-3">

                        <div class="yeti-item-inner youtube-video">

                            <img src="<?php echo esc_url($_image['url'])?>">

                            <div class="meta-abs-wrapper">
                                <a target="_blank" href="https://youtu.be/<?php echo esc_attr($_resourceId['videoId'])?>">
                                    <strong class="home-title"><?php echo esc_html($_snippet['title'])?></strong>
                                </a>

                            </div>

                        </div>

                </div>

            <?php endforeach;?>

            </div>

        <?php endif; ?>
    </div>

</div>
