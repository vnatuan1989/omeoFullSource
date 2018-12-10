<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 1/29/2016
 * Vertion: 1.0
 */

add_action('init', 'yesshop_template_redirect_preview');

if (!function_exists('yesshop_template_redirect_preview')) {
    function yesshop_template_redirect_preview()
    {
        global $yesshop_datas;
        if (isset($_REQUEST['preview'])) {
            $_preview = absint($_REQUEST['preview']);
            $yesshop_datas['footer-stblock'] = 'footer-layout-'.$_preview;

            switch ($_preview) {
                case 1:
                    $yesshop_datas['header-style'] = '1';
                    $yesshop_datas['fullwidth-header']  = '1';
                    $yesshop_datas['footer-stblock'] = 'yeti-omeo-footer-layout-1';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-1.png',
                        'width' => 114,
                        'height' => 116
                    );
                    break;
                case 2:
                    $yesshop_datas['header-style']  = '2';
                    $yesshop_datas['fullwidth-header']  = '0';
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-2';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-1.png',
                        'width' => 96,
                        'height' => 96
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-2';
                    $yesshop_datas['header-shipping-text'] = '<div class="yt-time"><strong class="yt-color-primary">WORK TIME</strong>&nbsp; &nbsp;<span>  Mon - Fri:    7:00 AM to 8:00 PM  |  Sunday:    7:00 AM to 5:00 PM</span></div>';
                    break;
                case 3:
                    $yesshop_datas['header-style']  = '3';
                    $yesshop_datas['fullwidth-header']  = '1';
                    $yesshop_datas['absolute-header'] = 1;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-3';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-3.png',
                        'width' => 135,
                        'height' => 90
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-3';
                    break;
                case 4:
                    $yesshop_datas['header-style']  = '4';
                    $yesshop_datas['fullwidth-header']  = '1';
                    $yesshop_datas['absolute-header'] = 1;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-4';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-3.png',
                        'width' => 324,
                        'height' => 54
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-4';
                    break;
                case 5:
                    $yesshop_datas['header-style']  = '5';
                    $yesshop_datas['fullwidth-header']  = '1';
                    $yesshop_datas['absolute-header'] = 0;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-4';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-5.png',
                        'width' => 86,
                        'height' => 69
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-5';
                    $yesshop_datas['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                    break;
                case 6:
                    $yesshop_datas['header-style']  = '6';
                    $yesshop_datas['fullwidth-header']  = '0';
                    $yesshop_datas['absolute-header'] = 0;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-6';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-5.png',
                        'width' => 86,
                        'height' => 69
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-6';
                    $yesshop_datas['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                    break;
                case 7:
                    $yesshop_datas['header-style']  = '5';
                    $yesshop_datas['fullwidth-header']  = '1';
                    $yesshop_datas['absolute-header'] = 0;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-3';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-5.png',
                        'width' => 86,
                        'height' => 69
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-7';
                    $yesshop_datas['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                    break;
                case 8:
                    $yesshop_datas['header-style']  = '5';
                    $yesshop_datas['fullwidth-header']  = '1';
                    $yesshop_datas['absolute-header'] = 1;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-4';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-5.png',
                        'width' => 86,
                        'height' => 69
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-8';
                    $yesshop_datas['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                    break;
                case 9:
                    $yesshop_datas['header-style']  = '7';
                    $yesshop_datas['fullwidth-header']  = '0';
                    $yesshop_datas['absolute-header'] = 0;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-9';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-1.png',
                        'width' => 96,
                        'height' => 99
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-9';
                    $yesshop_datas['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><div><span>CALL US NOW</span></br><span class="yt-color-primary">034 2333 3444</span></div></div>';
                    break;
                case 10:
                    $yesshop_datas['header-style']  = '5';
                    $yesshop_datas['fullwidth-header']  = '1';
                    $yesshop_datas['absolute-header'] = 0;
                    $yesshop_datas['footer-stblock'] = 'omeo-footer-layout-4';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'omeo-logo-5.png',
                        'width' => 86,
                        'height' => 69
                    );
                    $yesshop_datas['color-stylesheet']      = 'home-10';
                    $yesshop_datas['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                    $yesshop_datas['product-item-style']     = 'classic-2';
                    break;

                case 14:
                    $yesshop_datas['header-style'] = '10';
                    $yesshop_datas['logo']                 = array(
                        'url'   => THEME_IMG_URI . 'logo-14.png',
                        'width' => 162,
                        'height' => 26
                    );
                    $yesshop_datas['color-stylesheet']      = 'cappuccino';
					$yesshop_datas['header-shipping-text'] = '<h3 class="primaryColor">free shipping</h3>
					<p><span>For orders over $100 </span><a class="primaryColor" href="#">Learn more</a></p>';
                    break;

                case 16:
                    $yesshop_datas['header-style'] = '8';
                    $yesshop_datas['logo']                 = array(
                        'url'   => THEME_IMG_URI . 'logo-16.png',
                        'width' => 162,
                        'height' => 26
                    );
                    $yesshop_datas['color-stylesheet']      = 'orange2';
                    $yesshop_datas['product-item-style']     = 'classic-border';
                    $yesshop_datas['vertical-menu-limit-enable']    = 1;
                    $yesshop_datas['vertical-menu-limit']           = 5;
                    $yesshop_datas['header-vertical-style']         = 'big-icon-desc';
                    break;


                case 19:
                    $yesshop_datas['header-style']  = '5';
                    $yesshop_datas['logo']          = array(
                        'url'   => THEME_IMG_URI . 'logo-19.png',
                        'width' => 378,
                        'height' => 62
                    );
                    $yesshop_datas['header-shipping-text'] = '[yesshop_social items="fa fa-twitter|Twitter|#, fa fa-linkedin|linkedin|#,fa fa-behance|behance|#,fa fa-dribbble|dribbble|#"]';
                    $yesshop_datas['color-stylesheet']      = 'cornblue';
                    break;

                default:
                    $yesshop_datas['header-style'] = '1';
            }
        }

        if (isset($_REQUEST['cat_mode'])) {
            switch ($_REQUEST['cat_mode']) {
                case '1':
                    $yesshop_datas['shop-layout'] = '0-1';
                    $yesshop_datas['shop-right-sidebar'] = 'shop-widget-area-right';
                    break;
                case '2':
                    $yesshop_datas['shop-layout'] = '1-1';
                    $yesshop_datas['shop_columns'] = 2;
                    break;
                case '3':
                    $yesshop_datas['shop-layout'] = '0-0';
                    $yesshop_datas['shop-top-filters'] = 1;
                    $yesshop_datas['shop-top-sidebar'] = 'shop-widget-area-top';
                    $yesshop_datas['shop_columns'] = 4;
                    break;
            }
        }

        if(is_home() && isset($_REQUEST['preset'])) {
            switch (absint($_REQUEST['preset'])) {
                case 1:
                    $yesshop_datas['blog-type'] = 'masonry';
                    $yesshop_datas['blog-layout'] = '0-0';
                    $yesshop_datas['blog-columns'] = '3';
                    break;
                case 2:
                    $yesshop_datas['blog-type'] = 'sticky-columns';
                    $yesshop_datas['blog-layout'] = '0-1';
                    $yesshop_datas['blog-columns'] = '2';
                    break;
                case 3:
                    $yesshop_datas['blog-type'] = 'columns';
                    $yesshop_datas['blog-layout'] = '0-0';
                    $yesshop_datas['blog-columns'] = '2';
                    break;
                case 4:
                    $yesshop_datas['blog-type'] = 'list-mode';
                    $yesshop_datas['blog-layout'] = '0-0';
                    break;
                default:
                    $yesshop_datas['blog-type'] = 'default';
                    $yesshop_datas['blog-layout'] = '0-1';

            }
        }

    }
}

add_filter('theme_mod_nav_menu_locations', 'yesshop_thememode_menu_location_preview_change', 50);

if (!function_exists('yesshop_thememode_menu_location_preview_change')) {

    function yesshop_thememode_menu_location_preview_change($default)
    {
        if (isset($_REQUEST['preview'])) {
            switch (absint($_REQUEST['preview'])) {
                case 5:
                    $default['primary-menu'] = 334;
                    break;
                case 7:
                    $default['primary-menu'] = 334;
                    break;
                case 8:
                    $default['primary-menu'] = 334;
                    break;
                case 10:
                    $default['primary-menu'] = 334;
                    break;
            }
        }
        return $default;
    }

}

add_action( 'wp_head', 'yesshop_preview_header_style', 200 );

function yesshop_preview_header_style(){
    if (isset($_REQUEST['preview'])){
        $css = '';
        switch ($_REQUEST['preview']) {
            case 8:
                $css .= 'body.boxed{padding-top:0px; padding-bottom: 0px;}';
                break;
            case 9:
                $css .= 'body.custom-background{ background: url('.THEME_IMG_URI.'home9-background.jpg) top center no-repeat; background-size: contain; background-color: #ff9a6e; }';
                break;
            case 14:
                $css .= 'body.custom-background{ background: url('.THEME_IMG_URI.'bkg_home14.jpg) top left repeat;}';
                break;
        }

        echo '<style type="text/css">' . $css . '</style>';
    }
}

add_filter('yesshop_header_top_html', 'yesshop_headertop_sidebar_html_preview', 10);

function yesshop_headertop_sidebar_html_preview()
{
    global $yesshop_datas;

    if(isset($_REQUEST['preview'])) {
        $_preview = $_REQUEST['preview'];
    } elseif(isset($yesshop_datas['header-style'])) {
        $_preview = $yesshop_datas['header-style'];
		switch(absint($yesshop_datas['header-style'])) {
			case 3:
				$_preview = 4;
				break;
            case 8:
                $_preview = 11;
                break;
            case 12:
                $_preview = 21;
                break;
		}
    } else {
        $_preview = 1;
    }

    ob_start();

    switch ($_preview) {
        case 3:
        case 11:
        case 15:
        case 16:
        case 24:
            ?>
            <ul class="widgets-sidebar">
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><i class="fa fa-envelope-o" aria-hidden="true"></i> themeyeti@gmail.com</div>
                </li>
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><i class="fa fa-phone" aria-hidden="true"></i> +08 864 123 89</div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_login popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_currency_switcher popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_multi_language popup="right"]'); ?></div>
                </li>
            </ul>
            <?php
            break;
        case 18:
        case 26:
            ?>
            <ul class="widgets-sidebar">
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><i class="fa fa-envelope-o" aria-hidden="true"></i> themeyeti@gmail.com</div>
                </li>
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><i class="fa fa-phone" aria-hidden="true"></i> +08 864 123 89</div>
                </li>
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_login popup="left"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_search]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_currency_switcher popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_multi_language popup="right"]'); ?></div>
                </li>
            </ul>
            <?php
            break;
        case 4:
        case 5:
        case 6:
        case 8:
        case 10:
		case 13:
		case 17:
		case 19:
            ?>
            <ul class="widgets-sidebar">
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_login popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_currency_switcher popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_multi_language popup="right"]'); ?></div>
                </li>
            </ul>
            <?php
            break;
        case 12:
            ?>
            <ul class="widgets-sidebar">
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><i class="fa fa-envelope-o" aria-hidden="true"></i> themeyeti@gmail.com</div>
                </li>
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><i class="fa fa-phone" aria-hidden="true"></i> +08 864 123 89</div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_cart popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_login popup="right"]'); ?></div>
                </li>
            </ul>
            <?php
            break;
        case 21:
            $_sidebar = array(
                'before_widget' => '<li class="widget %s pull-left">',
                'after_widget'  => '</li>',
            );
            ?>
            <ul class="widgets-sidebar">
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_currency_switcher popup="left"]'); ?></div>
                </li>
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_multi_language popup="left"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget">Call toll free 900 1234 5678 8am - 6pm pts mon-sun</div>
                </li>
            </ul>
            <?php
            break;
        case 22:
            ?>
            <ul class="widgets-sidebar">
                <li class="pull-left widget widget_text">
                    <div class="textwidget">Default welcome msg!</div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_currency_switcher popup="left"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_multi_language popup="left"]'); ?></div>
                </li>
            </ul>
            <?php
            break;
        case 23:
            ?>
			 <ul class="widgets-sidebar">
                <li class="col-sm-8 widget widget_text pull-left">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_social items="fa-twitter|Follow us on Twitter|#, fa-linkedin|Linkedin|#, fa-behance|Behance|#, fa-dribbble|Dribbble|#" tt_location="bottom"]'); ?></div>
                </li>
				<li class="col-sm-8 text-center">
					Order online or call us (+1800) 000 8808
				</li>	
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_login popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_currency_switcher popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_multi_language popup="right"]'); ?></div>
                </li>
            </ul>
            <?php
			break;
        default:
            ?>
            <ul class="widgets-sidebar">
                <li class="pull-left widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_social items="fa-twitter|Follow us on Twitter|#, fa-linkedin|Linkedin|#, fa-behance|Behance|#, fa-dribbble|Dribbble|#" tt_location="bottom"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_head_top_login popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_currency_switcher popup="right"]'); ?></div>
                </li>
                <li class="pull-right widget widget_text">
                    <div class="textwidget"><?php echo do_shortcode('[yesshop_multi_language popup="right"]'); ?></div>
                </li>
            </ul>
            <?php

    }

    return ob_get_clean();

}