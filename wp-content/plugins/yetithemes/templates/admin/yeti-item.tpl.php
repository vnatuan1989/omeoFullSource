<div class="yeti-item col-2">
    <div class="yeti-item-inner">
        <img src="<?php echo esc_url($live_preview_url); ?>" alt="<?php echo esc_attr($item) ?>">

        <div class="price-label"><sup>$</sup><?php echo esc_html(absint($cost)) ?></div>
        <div class="meta-wrapper">
            <h3 class="home-title"><a href="<?php echo esc_url($url) ?>"
                                      title="<?php echo esc_attr($item); ?>"><?php echo esc_html($item); ?></a></h3>
            <p>
                <label><?php echo esc_html($category) ?></label>
            </p>
            <p>
                <label class="color1"><strong>Sales:</strong> <?php echo esc_html($sales) ?></label>
                <label class="color2"><strong>Rating:</strong> <?php echo esc_html($rating_decimal) . '/' . esc_html($rating) ?>
                </label>
                <label class="color3"><strong>Last
                        Update:</strong> <?php echo gmdate('d M Y', strtotime($last_update)); ?></label>
            </p>
        </div>
        <div class="action-buttons">
            <a class="button" target="_blank" href="<?php echo esc_url($url) ?>"
               title="<?php esc_html_e('View Detail in Themeforest', 'yetithemes'); ?>">
                <i class="fa fa-external-link"
                   aria-hidden="true"></i></i> <?php esc_html_e('View Detail', 'yetithemes'); ?>
            </a>
            <a class="button right color3 purchase-popup-action" data-id="#purchase_popup_<?php echo esc_attr($id); ?>"
               href="#" title="<?php echo esc_attr($item); ?>"><i class="fa fa-cart-plus" aria-hidden="true"></i>
                Purchase now</a>
            <div class="purchase-popup" id="purchase_popup_<?php echo esc_attr($id); ?>">
                <?php foreach ($item_prices as $k => $price) :
                    if ($k == 0) {
                        $class = 'popup-top';
                        $class2 = 'button right color3';
                        $_purchase_url = add_query_arg(array(
                            'license' => urlencode('regular'),
                            'open_purchase_for_item_id' => urlencode($id),
                            'purchasable' => urlencode('source'),
                            'ref' => urlencode('themeyeti')
                        ), esc_url($url));
                        $_desc = "Use, by you or one client, in a single end product which end users <strong>are not</strong> charged for. The total price includes the item price and a buyer fee.";
                    } else {
                        $class = 'popup-bottom';
                        $class2 = 'button right color2';
                        $_purchase_url = add_query_arg(array(
                            'license' => urlencode('extended'),
                            'size' => urlencode('source'),
                            'ref' => urlencode('themeyeti')
                        ), esc_url(Yetithemes_Envato_Api()->getUrl('before_cart') . $id));
                        ///cart/configure_before_adding/17298866?license=extended&size=source
                        $_desc = "Use, by you or one client, in a single end product which end users <strong>can be</strong> charged for. The total price includes the item price and a buyer fee.";
                    }
                    ?>
                    <div class="<?php echo esc_attr($class); ?>">
                        <h3><?php echo esc_html($price['licence']); ?></h3>
                        <a class="<?php echo esc_attr($class2); ?>" target="_blank"
                           href="<?php echo esc_url($_purchase_url); ?>" title="<?php echo esc_attr($item); ?>">Purchase
                            for &mdash; $<?php echo esc_html($price['price']) ?></a>
                        <p><?php echo wp_kses_post($_desc); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
