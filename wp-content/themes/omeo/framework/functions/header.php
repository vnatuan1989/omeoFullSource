<?php
//Add custom body class
   add_filter( 'body_class', function( $classes ) {
       global $yesshop_datas;
       return array_merge( $classes,array('yt-product-archive-layout-'.$yesshop_datas['product_archive_layout'] ) );
       return array_merge( $classes, array($yesshop_datas['heading_align'] ) );

   } );
?>



<?php

function yesshop_header_wrap_start()
{
    global $yesshop_datas;
    $header_style = isset($yesshop_datas['header-style']) ? esc_attr($yesshop_datas['header-style']) : "1";

    $_head_pos = '';
    if(is_front_page() || (isset($yesshop_datas['page-datas']['page_show_breadcrumb']) && absint($yesshop_datas['page-datas']['page_show_breadcrumb']) === 0)) {
      if(!empty($yesshop_datas['absolute-header'])) $_head_pos = ' header-absolute';
    }
    if(!empty($yesshop_datas['fullwidth-header'])) $_head_pos .= ' yt-header-full-width';
    echo '<header id="header" class="header-' . esc_attr($header_style) . esc_attr($_head_pos) . '">';
}

function yesshop_header_wrap_end()
{
    echo '</header>';
}

function yesshop_header_body()
{
    if (!$style = Yesshop_Functions()->getThemeData('header-style')) {
        $style = 1;
    }
    if (strlen($style) == 0 || !file_exists(THEME_DIR . 'framework/header_tpl/header-' . $style . '.php')) $style = 1;
    get_template_part('framework/header_tpl/header', $style);
}
