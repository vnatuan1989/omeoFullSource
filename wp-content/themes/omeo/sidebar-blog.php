<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Yesshop
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

extract(Yesshop_Functions()->pages_sidebar_act('blog'));
?>

<?php if (strlen($_left_class) > 0): ?>
    <div id="sidebar_left" class="sidebar-blog yeti-sidebar <?php echo esc_attr($_left_class); ?>" role="complementary">
        <?php if (is_active_sidebar($_left_sidebar)): ?>
            <ul class="widgets-sidebar">
                <?php dynamic_sidebar($_left_sidebar); ?>
            </ul>
        <?php endif; ?>
    </div><!-- .nth-content-left -->
<?php endif; ?>

<?php if (strlen($_right_class)): ?>

    <?php if(! is_active_sidebar($_right_sidebar)) $_right_sidebar = 'main-widget-area';?>

    <div id="sidebar_right" class="sidebar-blog yeti-sidebar <?php echo esc_attr($_right_class); ?>">
        <?php if (is_active_sidebar($_right_sidebar)): ?>
            <ul class="widgets-sidebar">
                <?php dynamic_sidebar($_right_sidebar); ?>
            </ul>
        <?php endif; ?>
    </div><!-- .nth-content-right -->
<?php endif; ?>
