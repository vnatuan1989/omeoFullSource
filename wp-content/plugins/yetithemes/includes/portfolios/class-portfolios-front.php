<?php
/**
 * @package yeti-portfolios
 */

if (!class_exists('Yetithemes_Portfolio_Front')) {

    class Yetithemes_Portfolio_Front extends Yetithemes_Portfolio
    {

        function __construct()
        {
            parent::__construct();
            $this->init_shortcode();
        }

        public function getCats($atts)
        {
            $args = array(
                'hide_empty' => true,
                'orderby' => 'title',
                'order' => 'ASC',
                'post_type' => $this->post_type,
            );
            if ($atts['style'] == 'cats' && strlen($atts['cats']) !== 0) {
                $args['slug'] = array_map('trim', explode(',', $atts['cats']));
            }

            $terms = get_terms($this->tax_cat, $args);
            return $terms;
        }

        private function init_shortcode()
        {
            add_shortcode('yesshop_portfolio', array($this, 'portfolio_shortcode'));

            add_shortcode('yetithemes_portfolio_single', array($this, 'add_sinle_info'));

        }

        private function paging_nav()
        {
            global $wp_query;
            if (function_exists('wp_pagenavi')) {
                wp_pagenavi();
                return;
            }
            echo '<div class="wp-pagenavi">';
            $links = paginate_links(array(
                'total' => $wp_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'mid_size' => 3,
                'type' => 'list',
            ));
            echo $links;
            echo '</div>';
        }

        public function portfolio_shortcode($atts = array())
        {
            $atts = shortcode_atts(array(
                'style' => '',
                'cats' => '',
                'filter_alight' => '',
                'filter_style' => '',
                'tab_cont_style' => '',
                'columns' => 4,
                'filter_s' => 1,
                'title_s' => 1,
                'cats_s' => 1,
                'desc_s' => 1,
                's_nav' => 0,
                'limit' => '-1',
            ), $atts);

            ob_start();

            $content_style = empty($atts['tab_cont_style']) ? '' : 'style_' . $atts['tab_cont_style'];
            ?>

            <div class="yeti-portfolios-wrapper">
                <div class="yeti-portfolio-container">
                    <?php if (absint($atts["filter_s"])): ?>
                        <div class="yeti-portfolio-filters-wrap">
                            <?php $this->get_filters($atts); ?>
                        </div><!-- .yeti-portfolio-filters -->
                    <?php endif; ?>
                    <div class="yeti-portfolio-content yeti-images-gallery row <?php echo esc_attr($content_style) ?>">
                        <?php
                        if ($atts['style'] == 'cats') {
                            $this->get_tab_content($atts);
                        } else {
                            $this->get_content($atts);
                        }
                        ?>
                    </div><!-- .yeti-portfolio-content -->
                </div><!-- .yeti-portfolio-container -->

                <?php
                if (function_exists('yesshop_paging_nav') && absint($atts['s_nav'])) {
                    yesshop_paging_nav();
                }

                ?>

            </div>
            <?php
            $content = ob_get_clean();
            wp_reset_query();
            return $content;

        }

        public function get_filters($atts)
        {
            $cats = $this->getCats($atts);
            $first = true;

            $_class = array('yeti-tabs');
            if ($atts['style'] == 'cats') {
                $_class[] = 'tab-style';
            } else {
                $_class[] = 'isotope-style';
            }

            if (strlen($atts['filter_alight']) > 0) $_class[] = $atts['filter_alight'];
            if (strlen($atts['filter_style']) > 0) $_class[] = $atts['filter_style'];

            ?>
            <div class="<?php echo esc_attr(implode(' ', $_class)) ?>">
                <ul class="yeti-portfolio-filters tabs">
                    <?php if (strlen($atts['style']) == 0): $first = false; ?>
                        <li id="all" class="active"><a href="javascript:void(0)" id="all_a"
                                                       data-filter=".yeti-portfolio-item"
                                                       class="filter active"><?php _e('ALL', 'yetithemes'); ?></a></li>
                    <?php endif; ?>

                    <?php foreach ($cats as $cat) {
                        $class = '';
                        if ($first) {
                            $class = 'active';
                            $first = false;
                        }
                        ?>
                        <li id="<?php echo esc_html($cat->slug); ?>" class="<?php echo esc_attr($class); ?>"><a
                                    href="javascript:void(0)" data-filter=".<?php echo esc_html($cat->slug); ?>"
                                    id="<?php echo esc_html($cat->slug); ?>_a"
                                    class="filter-portfoio"><?php echo esc_html($cat->name); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php
        }

        public function get_content($atts = array())
        {
            $def = array(
                'style' => '',
                'cats' => '',
                'columns' => 4,
                'filter_s' => 1,
                'title_s' => 1,
                'cats_s' => 1,
                'desc_s' => 1,
                'limit' => '-1',
            );

            $atts = wp_parse_args($atts, $def);

            query_posts("post_type={$this->post_type}&posts_per_page=" . $atts["limit"] . "&paged=" . get_query_var('paged'));

            $_dec = array_map('trim', explode(',', $atts['columns']));
            $i = 0;
            $_max_columns = max($_dec);

            if (have_posts()) :
                while (have_posts()): the_post();
                    global $post;
                    $class = array();

                    if(!empty($_dec)) {
                        $_i = $i%count($_dec);
                        $_column = $_dec[$_i];
                    } else {
                        $_column = 3;
                    }

                    $class[] = 'col-lg-' . round(24 / absint($_column));
                    $class[] = 'col-md-' . round(24 / absint($_column));
                    $class[] = 'col-sm-' . round(24 / (round(absint($_column) * 0.5)));
                    $class[] = 'col-xs-' . round(24 / (round(absint($_column) * 0.5)));

                    if( absint($_max_columns) === absint($_column)) {
                        $class[] = 'item-width-cal';
                    }

                    $cats = wp_get_post_terms($post->ID, $this->tax_cat, array("fields" => "slugs"));

                    //thumbnail
                    $thumb = get_post_thumbnail_id($post->ID);
                    $thumb_url = wp_get_attachment_image_src($thumb, 'full');

                    ?>
                    <div class="yeti-portfolio-item <?php echo esc_attr(implode(' ', $class)); ?> <?php echo esc_attr(implode(' ', $cats)); ?>"
                         data-filter="<?php echo esc_attr(implode(',', $cats)); ?>">
                        <div class="yeti-portfolio-thumb">
                            <div class="thumnail">
                                <a href="<?php echo get_permalink(); ?>"
                                   title="<?php echo get_the_title(); ?>"><?php if (has_post_thumbnail()) the_post_thumbnail('portfolio_thumb'); ?></a>
                                <div class="icons thumb-holder">
                                    <a href="<?php echo esc_url($thumb_url[0]); ?>" class="btn_zoom"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="summary">
                                <?php if (absint($atts["title_s"])): ?>
                                    <h3><a href="<?php echo get_permalink(); ?>"
                                           title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a></h3>
                                <?php endif; ?>
                                <div class="yeti-meta">
                                    <?php if (absint($atts['cats_s'])) echo get_the_term_list($post->ID, $this->tax_cat, '<div class="meta-cats">', ', ', '</div>'); ?>
                                    <?php if (absint($atts['desc_s'])): ?>
                                        <?php the_excerpt(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php

                    $i++;
                endwhile;
            endif;

        }

        public function get_tab_content($atts)
        {
            if (strlen($atts['cats']) == 0) return;
            foreach (array_map('trim', explode(',', $atts['cats'])) as $slug) {
                $atts['cat_slug'] = $slug;
                echo '<div class="yeti-portfolio-tab-content">';
                $this->get_tab_item($atts);
                echo '</div>';
            }
        }

        protected function get_tab_item($atts)
        {
            $args = array(
                'port_type' => $this->post_type,
                'posts_per_page' => $atts['limit'],
                'tax_query' => array(
                    array(
                        'taxonomy' => $this->tax_cat,
                        'field' => 'slug',
                        'terms' => $atts['cat_slug']
                    )
                )
            );

            $portfolio = new WP_Query($args);

            //tab_cont_style
            $item_image_size = 'portfolio_thumb';
            if ($atts['tab_cont_style'] == 'big_item') {
                $item_image_size = 'portfolio_thumb_big';
            }
            $i = 0;

            if ($portfolio->have_posts()) :
                while ($portfolio->have_posts()):
                    $portfolio->the_post();
                    global $post;
                    $class = array();

                    if ($atts['tab_cont_style'] == 'big_item') {
                        if ($i == 0) {
                            $item_image_size = 'portfolio_thumb_big';
                            $class[] = 'col-sm-12';
                        } else {
                            $item_image_size = 'portfolio_thumb';
                            $class[] = 'col-sm-6 col-xs-12 item-width-cal';
                        }
                    } else {
                        $item_image_size = 'portfolio_thumb';
                        $class[] = 'col-lg-' . round(24 / absint($atts["columns"]));
                        $class[] = 'col-md-' . round(24 / (1 + round(absint($atts["columns"]) * 992 / 1200)));
                        $class[] = 'col-sm-' . round(24 / (round(absint($atts["columns"]) * 768 / 1200)));
                        $class[] = 'col-xs-' . round(24 / (round(absint($atts["columns"]) * 480 / 1200)));
                        $class[] = 'col-mb-24';
                        $class[] = 'item-width-cal';
                    }

                    //thumbnail
                    $thumb = get_post_thumbnail_id($post->ID);
                    $thumb_url = wp_get_attachment_image_src($thumb, 'full');

                    ?>
                    <div class="yeti-portfolio-item <?php echo esc_attr(implode(' ', $class)); ?> <?php echo $atts['cat_slug']; ?>"
                         data-filter="<?php echo $atts['cat_slug']; ?>">
                        <div class="yeti-portfolio-thumb">
                            <div class="thumnail">
                                <a href="<?php echo get_permalink(); ?>"
                                   title="<?php echo get_the_title(); ?>"><?php if (has_post_thumbnail()) the_post_thumbnail($item_image_size); ?></a>
                                <div class="icons thumb-holder">
                                    <a href="<?php echo esc_url($thumb_url[0]); ?>" class="yeti-pretty-photo btn_zoom"><i class="fa icon-yeti-search"></i></a>
                                </div>
                            </div>
                            <div class="summary">
                                <?php if (absint($atts["title_s"])): ?>
                                    <h3><a href="<?php echo get_permalink(); ?>"
                                           title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a></h3>
                                <?php endif; ?>
                                <div class="yeti-meta">
                                    <?php //echo get_the_term_list( $post->ID, $this->tax_cat, "<div class=\"meta-cats\"><strong>Cats: </strong>", ', ', "</div><!--.meta-cats-->" );
                                    ?>
                                    <?php if (absint($atts["desc_s"])): ?>
                                        <?php
                                        $excerpt = get_the_excerpt();

                                        $words = explode(' ', $excerpt, (15));
                                        if (count($words) > 14) array_pop($words);

                                        echo implode(' ', $words);
                                        ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;

        }

        public function add_sinle_info($atts){
            $atts = shortcode_atts(array(
                'customer' => 'Yetithemes'
            ), $atts);
            global $post;

            ob_start();
            ?>
            <table class="portfolio-info">
                <tbody>
                <tr>
                    <th><?php echo esc_html_e('Customer', 'yetithemes')?></th>
                    <td><?php echo esc_html($atts['customer'])?></td>
                </tr>

                <tr>
                    <th><?php echo esc_html_e('Date post', 'yetithemes')?></th>
                    <td><?php echo get_the_date();?></td>
                </tr>

                <tr>
                    <th><?php echo esc_html_e('Categories', 'yetithemes')?></th>
                    <td><?php echo get_the_term_list($post->ID, $this->tax_cat, '', ', ', '');  ?></td>
                </tr>

                <?php if(function_exists('yesshop_single_post_meta_bottom_sharing')): ?>
                    <tr>
                        <th><?php echo esc_html_e('Share', 'yetithemes')?></th>
                        <td><?php echo yesshop_single_post_meta_bottom_sharing();  ?></td>
                    </tr>
                <?php endif;?>

                </tbody>
            </table>
            <?php

            return ob_get_clean();
        }
    }

    new Yetithemes_Portfolio_Front();
}
