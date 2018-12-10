(function ($) {
    "use strict";

    $.fn.extend({
        yesshop_block: function (options) {
            var defaults = {
                message: null,
                overlayCSS: {
                    background: "#fff url(" + yesshop_data.loading_icon + ") no-repeat center"
                }
            }
            var opts = $.extend({}, defaults, options);
            return this.each(function () {
                var elem = $(this);
                elem.block(opts);
            });
        },
        yesshop_loading: function (options) {
            var el = $(this);
            var defaults = {
                type: 'light'
            }
            var opts = $.extend({}, defaults, options);

            el.addClass('yeti-loading ' + opts.type);
            el.append(
                '<div class="yeti-spinner">' +
                '<div class="folding-cube">' +
                '<div class="cube1 cube"></div>' +
                '<div class="cube2 cube"></div>' +
                '<div class="cube3 cube"></div>' +
                '<div class="cube4 cube"></div>' +
                '</div>' +
                '</div>'
            );
        },
        yesshop_unlock: function () {
            var el = $(this),
                spin = el.find('.yeti-spinner');
            if (spin.length > 0) {
                spin.remove();
            }
            el.removeClass('yeti-loading dark light');
        },
        updateMegaMenuPosition: function () {
            if($(this).hasClass('initialized')) return false;

            if($(this).parents('.container').length > 0) {
                var cont_left = Math.round($(this).parents('.container').offset().left) + 15;
                var cont_right = Math.round(cont_left + $(this).parents('.container').outerWidth() - 30);
            } else {
                var cont_left = 29;
                var cont_right = $('body').width() - 29;
            }

            if ($(this).parent('li').hasClass('menu-item-level-0')) {
                if ($(this).parent().offset().left + i - cont_left < 3) {
                    var i;
                    i = 15 - $(this).parent().offset().left + cont_left;
                } else if ($(this).parent().offset().left + $(this).outerWidth() > cont_right) {
                    console.log(cont_right);
                    var over_right = Math.round(cont_right - ($(this).parent().offset().left + $(this).outerWidth()));
                    $(this).css('left', over_right + 'px');
                }

            } else {
                if ($(this).parent().offset().left + $(this).parent().outerWidth() + $(this).outerWidth() > cont_right) {
                    $(this).addClass('yeti-pos-left');
                    $(this).find('ul.sub-menu:not(.yeti-pos-left)').addClass('yeti-pos-left');
                }

                if ($(this).parent('li').offset().left - $(this).outerWidth() - cont_left < 10 && $(this).hasClass('yeti-pos-left')) {
                    $(this).removeClass('yeti-pos-left');
                }
            }

            $(this).addClass('initialized');
        }
    });

    var MASS = {
        initialized: false,
        prodInfo: {
            timeout: {
                obj: false,
                time: 2000,
                fIn: 'zoomInRight',
                fOut: 'zoomOutRight'
            }
        },
        eventListenner: function () {
            $('body').on('click', '.yeti-mini-popup .mini-popup-hover.tini-offcanvas > a', function (e) {
                e.preventDefault();
                $('body').toggleClass('offcanvas-right');
            });

            $('body').on('click', '.mobile-menu-btn', function (e) {
                e.preventDefault();
                $('body').toggleClass('offcanvas-left');
            });

            $(document).on('click', '.offcanvas-close', function (e) {
                e.preventDefault();
                $('body').removeClass('offcanvas-right').removeClass('offcanvas-left');
            })

            $('.yeti-compare-popup').on('click', '.products-list .remove', function (e) {
                e.preventDefault();
                var _link = $(this),
                    data = {
                        action: yith_woocompare.actionremove,
                        id: $(this).data('product_id'),
                        context: 'frontend',
                        responseType: 'product_list'
                    };
                $.ajax({
                    type: 'post',
                    url: yith_woocompare.ajaxurl.toString().replace('%%endpoint%%', yith_woocompare.actionremove),
                    data: data,
                    dataType: 'html',
                    beforeSend: function () {
                        $('.yeti-compare-popup').yesshop_loading();
                    },
                    success: function (response) {
                        $('.yeti-compare-popup ul.products-list').html(response);
                        $('.yeti-compare-popup').yesshop_unlock();
                    }
                });

            });

            $('body').on('click', '.yeti-close', function (e) {
                e.preventDefault()
                $(this).parent().hide(100);
            });

            $('.vertical-menu-inner').on('click', '.menu-more-action > a', function (e) {
                e.preventDefault();
                $(this).parent('li').nextAll().removeClass('hide');
                $(this).parent('li').remove();
            });
        },
        beforeReady: function () {
            $('body').on('adding_to_cart', function (e, $thisbutton, data) {
                $thisbutton.parents('section.product').yesshop_loading({type: 'light'});
            });

            $('body').on('added_to_cart', function (e, fragments, cart_hash, $thisbutton) {
                if (typeof $thisbutton === 'undefined') return false;
                $thisbutton.parents('section.product').yesshop_unlock();
                $('body').toggleClass('offcanvas-right');
            });

            $('body').on('click', '.back-previous-page', function (e) {
                e.preventDefault();
                window.history.back();
            });

            this.eventListenner();
            this.quantityAction();
        },
        quantityAction: function () {
            $(document).on('click', '.quantity .plus, .quantity .minus', function (e) {

                //get value
                var $qty = $(this).closest('.quantity').find('.qty'),
                    currentVal = parseFloat($qty.val() || 0),
                    max = parseFloat($qty.attr('max') || 0),
                    min = parseFloat($qty.attr('min') || 0),
                    step = parseFloat($qty.attr('step') || 1);

                // Format values
                if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                if (max === '' || max === 'NaN') max = '';
                if (min === '' || min === 'NaN') min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

                // Change the value
                if ($(this).is('.plus')) {
                    if (max && ( max == currentVal || currentVal > max )) {
                        $qty.val(max);
                    } else {
                        $qty.val(currentVal + parseFloat(step));
                    }
                } else {
                    if (min && ( min == currentVal || currentVal < min )) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        $qty.val(currentVal - parseFloat(step));
                    }
                }

                // Trigger change event
                $qty.trigger('change');
            });

            $(document).on('change', '.shop_table .quantity .qty', function (e) {
                var _val = $(this).val(),
                    _prod_id = $(this).parents('.product-quantity').data('product_id'),
                    gift_items = $('.shop_table [data-gift_for=' + _prod_id + ']');

                gift_items.each(function (e, i) {
                    $(this).find('span').text(_val);
                    $(this).find('[type=hidden]').val(_val);
                })
            });
        },
        initialize: function () {
            if (this.initialized) return;
            this.initialized = true;
            this.build();
            this.events();
        },
        data: {
            shortcode: {
                product_tab: []
            },
            touchDevice: $.support.touch ? 1 : 0,
        },
        build: function () {
            this.headerSticky(0);
            this.megaMenu();
        },
        events: function () {
            this.eventsGeneral();
            this.ajax_response();
            this.shortcodeEvents();
            this.windowResize();
            this.quickShop();
            this.countdowns();
            this.prodSingleThumbEvent();
            this.owlCarousel2();
            this.compareLink();
            this.isotope();
            this.formPopup();
            this.toggleWidgetCategories();
            this.ajaxLogin();
            this.paceLoader();
            this.magnific_event();
            this.prodSingleImageEvent();
        },
        headerSticky: function (update) {
            if ($.support.touch) return false;

            if (update == 1) {
                $('#header .yeti-sticky').sticky('unstick');
            }

            var wpbar_top = $('#wpadminbar').length > 0 ? $('#wpadminbar').height() : 0;

            $('#header .yeti-sticky').sticky({topSpacing: wpbar_top})
                .on('sticky-start', function () {
                    $(this).addClass('fadeInDown');
                })
                .on('sticky-end', function () {
                    $(this).removeClass('fadeInDown');
                });
        },

        megaMenu: function () {
            $('.main-menu ul.menu li').on('hover', function () {
                if ($(this).find('> ul.sub-menu').length > 0)
                    $(this).find('> ul.sub-menu').updateMegaMenuPosition();
            })
        },

        eventsGeneral: function () {

            $('[data-toggle="tooltip"]').tooltip();
            $('.widget_categories ul > li.cat-item ul').each(function (index) {
                $(this).parent().addClass('cat-parent');
            });
            $('.shortcode-woo-tabs li.tab-item').on('click', function (e) {
                if ($(this).hasClass('active')) return false;
                var _id = $(this).find('a').data('id');
                $(this).parent().find('.active').removeClass('active');
                $(this).addClass('active');
                $('#' + _id).parent().find('.show').removeClass('show').addClass('hidden');
                $('#' + _id).removeClass('hidden').addClass('show');
            });

            $('.nth-phone-menu-icon').on('click', function () {
                $('.nth-menu-wrapper .main-menu.pc-menu').removeClass('pc-menu').addClass('mb-menu');
                $('.nth-menu-wrapper .main-menu.mb-menu').toggleClass('fadeInDown');
                $('.nth-menu-wrapper').toggleClass('hidden-xs');
                $(this).toggleClass('active');
            });

            $('.vertical-menu-inner.submenu_height_fixed > ul.menu > li').on('hover', function () {
                var verti_height = $(this).parents('.vertical-menu-inner').height();
                $(this).children('ul.sub-menu').css({'min-height': verti_height});
            });

            $('.yith-wcwl-add-button.show').on('click', function () {
                $(this).addClass('loading');
            });

            $(document).on('change', '.woocommerce-ordering input, .woocommerce-ordering select', function () {
                $(this).closest('form').submit();
            });

            $('#header .nth_header_bottom').on("click", '.vertical-menu-wrapper .vertical-menu-dropdown', function () {
                $(this).parents('.vertical-menu-wrapper').toggleClass("active");
            });

            $('.nth-social-share-link li a').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var title = $(this).attr('title');
                window.open(url, title, "width=700, height=520");
            });

            $('body.pace-loading').removeClass('pace-loading');

            $('.widget-heading').on('click', function () {
                if ($(window).width() < 768) {
                    $(this).next().slideToggle(200);
                }
            });

            //search box
            $(document).on('click', '.dropdown ul.dropdown-menu li', function (e) {
                e.preventDefault();

                var slug = $(this).data('val'),
                    txt = $(this).text();
                $(this).parents('.dropdown').find('.dropdown-toggle .dropdown-text').text(txt);
                $(this).parents('.dropdown').find('.dropdown-value').val(slug).trigger('change');

            })

            $(document).on('change', '.searchform .dropdown-toggle .dropdown-value', function () {
                var slug = $(this).val();
                if (typeof yesshop_data.search.param !== 'undefined') {
                    yesshop_data.search.param.product_cat = slug;

                }
            });

            $(document).on('click', '.menu-drop-icon', function (e) {
                $(this).nextAll('.sub-menu').slideToggle(200);
                $(this).toggleClass('fa-minus').toggleClass('fa-plus');
            });

            if(parseInt(yesshop_data.pace) === 1) {
                window.onbeforeunload = function (e) {
                    $('body').addClass('pace-loading');
                    return null;
                }
            }

            $('body').on('click', '.trainding-products-section .product-image ul.thumbs-gallery li a', function (e) {
                e.preventDefault();
                if($(this).parent('li').hasClass('active')) return false;
                var src = $(this).data('src'),
                    img_wrap = $(this).parents('.product-image'),
                    main_img = img_wrap.find('ul + img');

                $(this).parents('ul').find('.active').removeClass('active');
                $(this).parent('li').addClass('active');
                img_wrap.yesshop_loading();
                main_img.attr('src', src).removeAttr('srcset');
                main_img.on('load', function () {
                    img_wrap.yesshop_unlock();
                });
            });


            $('body').on('click', '.widget_product_categories.yeti-widgets .product-categories li > .go-sub', function () {
                $(this).parent().toggleClass('show-sub');
                $(this).parents('.widget_product_categories').addClass('init');
            });

            if($('.onepage-container .entry-content').length > 0 && typeof $.fullpage !== 'undefined') {
                $('.onepage-container .entry-content').fullpage({
                    verticalCentered: false,
                    css3: true,
                    navigation: true,
                    navigationPosition: 'right',
                    onLeave: function(index, nextIndex, direction){
                        //do something
                    },
                });
            }

            if($(window).width() < 768) {
                $('footer').on('click', 'div.widget .widgettitle', function (e) {
                    $(this).next().slideToggle(200);
                })
            }
        },
        owlCarousel2_callback: function ($this) {
            var sl_root = $this;

            var configs = {
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 5000,
                dots: false,
                lazyLoad: true,
                onInitialized: function (event) {
                    sl_root.addClass('initialized').yesshop_unlock();
                }
            };
            $.extend(configs, yesshop_data.owl);

            if (typeof yesshop_data !== 'undefined' && yesshop_data.rtl == '1') {
                defaults.rtl = true;
            }

            var slider = sl_root.data('slider');
            var base = sl_root.data('base'),
                delay = sl_root.data('delay');;

            $.extend(configs, sl_root.data("options"));

            if (typeof base !== "undefined" && base == 1) {
                configs.responsiveBaseElement = sl_root;
            }

            if(typeof delay === "undefined") delay = 0;

            if (typeof slider !== "undefined" && slider !== 'this') {
                var owl = sl_root.find(slider);
            } else {
                var owl = sl_root.find('.yeti-owl-slider');
            }

            setTimeout(function () {
                owl.addClass('owl-carousel').owlCarousel(configs);
            }, parseInt(delay));

        },
        owlCarousel2: function () {
            $('.yeti-owlCarousel:not(.initialized)').each(function () {
                var root = $(this);
                MASS.owlCarousel2_callback(root);
            });
        },
        scrollbar_Swiper: function () {
            var swiper_scroll = new Swiper('.swiper-container', {
                scrollbar: '.swiper-scrollbar',
                direction: 'vertical',
                slidesPerView: 'auto',
                mousewheelControl: true,
                freeMode: true
            });
        },
        ajax_response: function () {
            this.removeCartItem();
            MASS.removeWishList();
            $('body').on('click', '.vc_tta-tabs-list li.vc_tta-tab a', function (e) {
                e.preventDefault();
            });

            $('body').on('click', '.vc_tta-tabs-list li.vc_tta-tab', function () {

                var __id = $(this).find('a').attr('href'),
                    __container = $(this).parents('.vc_tta-tabs').find('.vc_tta-panels-container .vc_tta-panel' + __id + ' .vc_tta-panel-body'),
                    __content_el = __container.find('.tab-ajax-content');
                if (__content_el.length > 0) {
                    var content = __content_el.html();
                    var data = {
                        action: 'yesshop_tta_tabs_content',
                        content: content,
                        context: 'frontend'
                    }
                    $.ajax({
                        url: yesshop_data.ajax_url,
                        data: data,
                        type: "POST",
                        timeout: 30000,
                        beforeSend: function () {

                        },
                        success: function (data) {
                            __content_el.remove();
                            __container.html(data);
                        }
                    });
                }

            });

            this.ajax_woo_filters();
        },
        ajaxSuccess_Callback: function () {
            MASS.owlCarousel2();
            MASS.quickShop();
            MASS.countdowns();
            $('[data-toggle="tooltip"]').tooltip();
            MASS.toggleWidgetCategories();
        },
        wooPriceReSetup: function () {
            if (typeof woocommerce_price_slider_params === 'undefined') {
                return false;
            }

            // Get markup ready for slider
            $('input#min_price, input#max_price').hide();
            $('.price_slider, .price_label').show();

            // Price slider uses jquery ui
            var min_price = $('.price_slider_amount #min_price').data('min'),
                max_price = $('.price_slider_amount #max_price').data('max'),
                current_min_price = parseInt(min_price, 10),
                current_max_price = parseInt(max_price, 10);

            if ($('.price_slider_amount #min_price').val().length > 0) {
                current_min_price = $('.price_slider_amount #min_price').val();
            }
            if ($('.price_slider_amount #max_price').val().length > 0) {
                current_max_price = $('.price_slider_amount #max_price').val();
            }

            $('.price_slider').slider({
                range: true,
                animate: true,
                min: min_price,
                max: max_price,
                values: [current_min_price, current_max_price],
                create: function () {

                    $('.price_slider_amount #min_price').val(current_min_price);
                    $('.price_slider_amount #max_price').val(current_max_price);

                    $(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
                },
                slide: function (event, ui) {

                    $('input#min_price').val(ui.values[0]);
                    $('input#max_price').val(ui.values[1]);

                    $(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
                },
                change: function (event, ui) {

                    $(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
                }
            });
        },
        ajax_woo_filters: function () {

            var
                History = window.History, // Note: We are using a capital H instead of a lower h
                State = History.getState(),
                $this = this;
            History.Adapter.bind(window, 'statechange', function () {
                var State = History.getState();
                $.ajax({
                    url: State.url,
                    beforeSend: function () {
                        $('.woocommerce-page #content').yesshop_loading({type: 'light woop_top'});
                    },
                    success: function (response) {
                        $('.woocommerce-page #body-wrapper .body-wrapper').html($(response).find('.body-wrapper').html());
                        console.log($(response).find('.woocommerce-page .body-wrapper').html());

                        MASS.wooPriceReSetup();

                        $('.woocommerce-page #content').yesshop_unlock();

                        $(document).trigger('yeti_gridlist_cook');

                        var newTitle = $(response).filter('title').text();
                        $('title').text(newTitle);

                        MASS.ajaxSuccess_Callback();
                    }
                });
            });

            $(document).on('click', '.woocommerce-page .widgets-sidebar .widget_product_categories ul li a,' +
                '.woocommerce-page .widgets-sidebar .product-filters-widget ul li a,' +
                '.woocommerce-page .woocommerce-pagination ul li a', function (e) {
                if ($this.msie) e.which = 1;
                if (e.which != 1) return;
                e.preventDefault();
                var $clink = $(this);
                History.pushState(null, null, $clink.attr('href'));
                $('html, body').animate({scrollTop: $('.main-content').offset().top}, 500);
            });

            $(document).on('submit', '.woocommerce-ordering, .widget_price_filter form', function (e) {
                e.preventDefault();
                var url = $(this).serialize();
                History.pushState(null, null, '?' + url);
            });
        },
        shortcodeEvents: function () {
            $('ul.shortcode-woo-tabs li.tab-item-ajax:not(.active)').live('click', function (e) {
                var cat_slug = $(this).find('> a').data('slug');
                var tab_id = $(this).find('> a').data('id');
                var element = $(this).parents('.yeti-shortcode-content').find('.products');
                var tab_ajax_content = $(this).parents('.yeti-shortcode-content').find('.tab-content-item.ajax-content')
                var data = {
                    action: 'yeti_woo_get_product_by_cat',
                    atts: $(this).parents('.yeti_products_categories_shortcode').data('atts'),
                    cat_slug: cat_slug,
                    context: 'frontend'
                }

                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                if (MASS.data.shortcode.product_tab[tab_id]) {
                    tab_ajax_content.html(MASS.data.shortcode.product_tab[tab_id]);
                    MASS.owlCarousel2();
                    return;
                }

                $.ajax({
                    type: "POST",
                    timeout: 30000,
                    url: yesshop_data.ajax_url,
                    data: data,
                    error: function (xhr, err) {
                        element.yesshop_unlock();
                    },
                    beforeSend: function () {
                        element.yesshop_loading();
                    },
                    success: function (response) {
                        element.yesshop_unlock();
                        tab_ajax_content.html(response);
                        MASS.data.shortcode.product_tab[tab_id] = response;
                    }
                });

            });
        },
        windowResize: function () {
            $(window).resize(function () {
                MASS.headerSticky(1);
            });
        },
        quickShop: function () {
            if (typeof $({}).magnificPopup !== 'function') return false;

            $('body').on('click', '.yeti-quickshop-wrapper .woocommerce-product-gallery__image > a', function (e) {
                e.preventDefault();
            });

            $('.yeti_quickshop_link').magnificPopup({
                type: 'ajax',
                callbacks: {
                    open: function () {
                        $('.mfp-bg').yesshop_loading({type: 'dark'});
                    },
                    ajaxContentAdded: function () {
                        $('.yeti-quickshop-wrapper').css({'width': 870, 'max-width': '100%'});
                        $('.mfp-content').find('form.variations_form').wc_variation_form();
                        $('.mfp-content').find('form.variations_form .variations select').change();
                        $('body').trigger('wc_fragments_loaded');
                        MASS.owlCarousel2();
                        MASS.scrollbar_Swiper();

                        MASS.prodSingleImageEvent();
                        $('.mfp-bg').yesshop_unlock();
                    }
                }
            });
        },
        countdowns: function () {
            $('.yeti-countdown').each(function (e, i) {
                var cd = $(this).data('atts');
                $(this).countdown(cd.dateTo, function (e) {
                    $(this).html(e.strftime(cd.format));
                });
            });
        },
        prodSingleThumbEvent: function () {
            $('body').on("click", ".variations_form .yeti-variable-attr-swapper .select-option", function (e) {
                var val = $(this).attr('data-value');
                var _this = $(this);

                var color_select = $(this).parents('tr').find('select');
                color_select.trigger('focusin');
                if (color_select.find('option[value=' + val + ']').length !== 0) {
                    color_select.val(val).change();
                    $(this).parent(".yeti-variable-attr-swapper").find('.selected').removeClass('selected');
                    _this.addClass('selected');
                }

            });

            $('body').on('click', '.variations_form .reset_variations', function (e) {
                $(this).parents('.variations').find('.yeti-variable-attr-swapper .select-option.selected').removeClass('selected');
            });

            /* Quantity sync */
            $(document).on('change', 'form.cart input.qty', function () {
                $(this.form).find('button[data-quantity]').data('quantity', this.value);
            });

        },
        prodSingleImageEvent: function () {

            if(typeof $.fn.wc_product_gallery !== 'function' || $( '.woocommerce-product-gallery .woocommerce-product-gallery__image' ).length == 0) return false;

            if ($('#yeti_prod_thumbnail').lenght <= 0) return false;
            var _conf = $('#yeti_prod_thumbnail').data('params') || {};
            _conf.onInit = function (swiper) {
                $('#yeti_prod_thumbnail').removeClass('loading');
            }
            var swiper = new Swiper('#yeti_prod_thumbnail', _conf);
            var _zoom = true;
            if ($(".product .images .yeti-owlCarousel").length) {

                if(_zoom) {
                    var element = $(".product .images .p_image.yeti-owlCarousel").find('.owl-item:nth-of-type(1) a.zoom1');
                    if(!element.find('.zoomImg').length && $(window).width() > 768) {
                        element.zoom({
                            url: element.find('img').attr('data-src')
                        });
                    }
                }

                if(typeof swiper !== 'undefined' && $('#yeti_prod_thumbnail').length > 0) {
                    $(".product .images .p_image.yeti-owlCarousel").on('changed.owl.carousel', function (event) {

                        var thumb = $(".product .images .thumbnails .swiper-slide:nth-of-type(" + (event.item.index + 1) + ")");
                        $(".product .images .thumbnails .swiper-slide.open").removeClass('open');

                        if(typeof swiper != 'undefined') {
							swiper.slideTo(event.item.index, 300, false);
                            swiper.update();
						}

                        thumb.addClass('open');

                        if(_zoom) {
                            var element = $(".product .images .p_image.yeti-owlCarousel").find('.owl-item:nth-of-type(' + (event.item.index + 1) + ') a.zoom1');
                            if(!element.find('.zoomImg').length && $(window).width() > 768) {
                                element.zoom({
                                    url: element.find('img').attr('data-src')
                                });
                            }
                        }

                    });
                }

                $(document).on('click', "#yeti_prod_thumbnail .swiper-wrapper .swiper-slide", function (event) {
                    event.preventDefault();
                    var pos = $(this).data('pos');
                    $(".product .images .yeti-owlCarousel .yeti-owl-slider").trigger('to.owl.carousel', [pos, 300, true]);
                });


            }

            $('body').on('found_variation', function (e, variation) {
                var $form = $('form.variations_form');
                $form.wc_variations_image_update(false);
                if (typeof variation !== 'undefined' && typeof variation.image.src !== 'undefined') {
                    console.log(1000);
                    $('.product .p_image .woocommerce-product-gallery__image a.product-image').each(function (i) {
                        if ($(this).find('img:eq(0)').attr('src') === variation.image.src) {
                            $(".product .images .yeti-owlCarousel .yeti-owl-slider").trigger('to.owl.carousel', [i, 300, true]);
                        }
                    });
                }
            });
        },
        magnific_event: function () {
            $('.mass-ajax-magnific').magnificPopup({
                type: 'ajax',
                closeOnBgClick: true,
            });
            $('.mass-video-gallery').magnificPopup({
                type: 'iframe',
                delegate: 'a',
                gallery: {
                    enabled: true
                }
            });
            $('.yeti-images-gallery').magnificPopup({
                type: 'image',
                delegate: 'a.btn_zoom',
                gallery: {
                    enabled: true
                }
            });
            $('.mass-inline-magnific').magnificPopup({
                type: 'inline',
                midClick: true
            });
        },
        update_cart: function () {
            $.ajax({
                type: 'GET',
                url: yesshop_data.ajax_url + '?action=nth_update_cart',
                success: function (response) {
                    var fragments = response.fragments;
                    // Replace fragments
                    if (fragments) {
                        $.each(fragments, function (key, value) {
                            $(key).replaceWith(value);
                        });
                    }
                }
            });
        },
        removeCartItem: function () {
            $('body').on('click', 'li.mini_cart_item .yeti_remove_cart', function (e) {
                e.preventDefault();
                var $thisbutton = $(this),
                    $_container = $thisbutton.parents('.main-sidebar.sidebar-right');
                var data = {
                    action: "yesshop_woo_remove_cart_item"
                };

                $.each($thisbutton.data(), function (key, value) {
                    data[key] = value;
                });

                $.ajax({
                    url: yesshop_data.ajax_url,
                    data: data,
                    type: "POST",
                    beforeSend: function () {
                        $_container.yesshop_loading();
                    },
                    success: function (response) {
                        if (!response) return;

                        var this_page = window.location.toString();

                        var fragments = response.fragments;
                        if (fragments) {
                            $.each(fragments, function (key, value) {
                                $(key).addClass('updating');
                            });
                        }

                        // Block widgets and fragments
                        $('.shop_table.cart, .updating, .cart_totals').yesshop_loading();

                        // Replace fragments
                        if (fragments) {
                            $.each(fragments, function (key, value) {
                                $(key).replaceWith(value);
                            });
                        }

                        // Unblock
                        $('.widget_shopping_cart, .updating').stop(true).css('opacity', '1').yesshop_unlock();

                        // Cart page elements
                        $('.shop_table.cart').load(this_page + ' .shop_table.cart:eq(0) > *', function () {
                            $('.shop_table.cart').stop(true).css('opacity', '1').yesshop_unlock();
                            $('body').trigger('cart_page_refreshed');
                        });

                        $('.cart_totals').load(this_page + ' .cart_totals:eq(0) > *', function () {
                            $('.cart_totals').stop(true).css('opacity', '1').yesshop_unlock();
                        });

                        $_container.yesshop_unlock();
                    }
                });
            });
        },
        removeWishList: function () {
            $('body').on('click', '.nth_remove_from_wishlist', function () {
                var remove_btn = $(this),
                    pagination = remove_btn.data('pagination'),
                    wishlist_id = remove_btn.data('id'),
                    wishlist_token = remove_btn.data('token'),
                    prod_id = remove_btn.data('prod_id'),
                    par_box = remove_btn.parents('.nth-toolbar-popup-cotent');
                var data = {
                    action: 'remove_from_wishlist',
                    remove_from_wishlist: prod_id,
                    wishlist_id: wishlist_id,
                    wishlist_token: wishlist_token
                }
                $.ajax({
                    url: yesshop_data.ajax_url,
                    data: data,
                    type: "POST",
                    beforeSend: function () {
                        par_box.yesshop_loading();
                    },
                    success: function (response) {
                        $('body').trigger('added_to_wishlist');
                    }
                });
            });
        },
        compareLink: function () {
            if (typeof yith_woocompare == 'undefined' || typeof woocommerce_params == 'undefined') return false;
            $(document).on('click', '.product a.yeti-compare:not(.added)', function (e) {
                e.preventDefault();
                var button = $(this),
                    data = {
                        //_yitnonce_ajax: yith_woocompare.nonceadd,
                        action: yith_woocompare.actionadd,
                        id: button.data('product_id'),
                        context: 'frontend'
                    };

                $.ajax({
                    type: 'post',
                    url: yith_woocompare.ajaxurl.toString().replace('%%endpoint%%', yith_woocompare.actionadd),
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        button.addClass('loading');
                    },
                    success: function (response) {

                        button.removeClass("loading");
                        button.addClass('added')
                            .attr('href', response.table_url)
                            .text(yith_woocompare.added_label);

                        // add the product in the widget
                        $('.yeti-compare-popup ul.products-list').html(response.widget_table);
                        $('.yeti-compare-popup').show();

                        $('body').trigger('compare_product_added');
                    }
                });
            });

            $(document).on('click', '.yeti-compare-remove', function (e) {
                e.preventDefault();
                var _link = $(this),
                    data = {
                        action: yith_woocompare.actionremove,
                        id: $(this).data('product_id'),
                        context: 'frontend'
                    };
                $.ajax({
                    type: 'post',
                    url: yith_woocompare.ajaxurl.toString().replace('%%endpoint%%', yith_woocompare.actionremove),
                    data: data,
                    dataType: 'html',
                    beforeSend: function () {
                        _link.parents('.yeti-compare-wrapper').yesshop_block();
                    },
                    success: function (response) {
                        $('.yeti-compare-wrapper').replaceWith(response);
                    }
                });
            });

        },
        isotope: function () {
            $(".yeti-isotope-act").each(function (i, e) {
                var data = $(this).data('params');
                if (typeof data == "undefined") return false;
                var $this = $(this)
                setTimeout(function () {
                    $this.isotope(data);
                }, 750);
                $(this).find("img").load(function () {
                    $(this).parents('.yeti-isotope-act').isotope(data);
                });
            })
        },
        formPopup: function () {
            if (typeof $({}).magnificPopup !== 'function') return false;

            var mgf_width = $("#yeti_newsletter_popup_open").data('mgf_width') || 800;

            $('#yeti_newsletter_popup_open').magnificPopup({
                type: 'ajax',
                callbacks: {
                    open: function () {
                        $('.mfp-bg').yesshop_loading({type: 'dark'});
                    },
                    ajaxContentAdded: function () {
                        $('#yeti_newsletter_popup').css({'width': mgf_width, 'max-width': '100%'});
                    }
                }
            });

            if (!$.cookie('yeti_newsletter_popup_open') || $.cookie('yeti_newsletter_popup_open') == '0') {
                setTimeout(function () {
                    $("#yeti_newsletter_popup_open").trigger('click');
                }, 8000);
            }

            if (!$.cookie('yeti_newsletter_footer_open') || $.cookie('yeti_newsletter_footer_open') == '0') {
                $(".footer-newsletter-wrap").removeClass('hidden');
            }

            $(document).on('click', '.footer-newsletter-wrap .close-btn', function (e) {
                e.preventDefault();
                $.cookie('yeti_newsletter_footer_open', '1', {expires: 1, path: '/'});
                $(this).parents('.footer-newsletter-wrap').slideUp(300);
            });

            $(document).on('click', '.popup-cookie-close', function (e) {
                e.preventDefault();
                $.magnificPopup.close()
                var __ex = $(this).data('time') || 1;
                if (parseInt(__ex) > 0)
                    $.cookie('yeti_newsletter_popup_open', '1', {expires: __ex, path: '/'});
            });

        },
        toggleWidgetCategories: function () {
            $('.widget_product_categories.yeti-widgets .product-categories li').each(function () {
                if($(this).find('> .go-sub').length > 0) return false;
                if ($(this).hasClass('cat-parent')) {
                    $(this).prepend("<span class='go-sub'><i class='fa fa-angle-down' aria-hidden='true'></i></span>");
                }
            });
        },
        ajaxLogin: function () {
            $(document).on('submit', '.yeti-ajax-login-wrapper form', function (e) {
                e.preventDefault();
                var $this = $(this);
                var data = $this.serializeArray();
                data.push({name: 'action', value: 'yesshop_ajax_login'});
                $.ajax({
                    type: "POST",
                    url: yesshop_data.ajax_url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        $this.find('[type=submit]').prop('disabled', true);
                        $this.parents('.yeti-mini-popup-cotent').yesshop_loading();
                    },
                    success: function (o) {
                        if (o.code == false) window.location.reload(true);
                        else {
                            $this.find('.login-username').removeClass('form-group has-error has-feedback');
                            $this.find('.login-username label').removeClass('control-label');
                            $this.find('.login-username input').removeClass('form-control');

                            $this.find('.login-password').addClass('form-group has-error has-feedback');
                            $this.find('.login-password label').addClass('control-label');
                            $this.find('.login-password input').addClass('form-control').val('');
                            if (o.code == 'invalid_username') {
                                $this.find('.login-username').addClass('form-group has-error has-feedback');
                                $this.find('.login-username label').addClass('control-label');
                                $this.find('.login-username input').addClass('form-control');
                            }
                            var _append = '<div class="clear"></div><div class="alert alert-danger alert-dismissible" role="alert">' + o.mess + '</div>';
                            if ($this.parents('.yeti-ajax-login-wrapper').find('div.alert').length > 0)
                                $this.parents('.yeti-ajax-login-wrapper').find('div.alert').remove();
                            $this.parents('.yeti-ajax-login-wrapper').append(_append);
                            $this.unblock();
                            $this.find('[type=submit]').prop('disabled', false);
                            $this.parents('.yeti-mini-popup-cotent').yesshop_unlock();
                        }
                    }
                });
            })
        },

        paceLoader: function () {
            if (typeof Pace !== 'undefined') {
                Pace.options = {
                    ajax: false
                };
            }

        },
        fix_VC_FullWidth: function () {
            if (typeof yesshop_data !== 'undefined' && yesshop_data.rtl == '1') {
                var _screen_w = $(window).width();
                $('body .vc_row[data-vc-full-width=true]').each(function (e, i) {
                    var _margin = ($(this).width() - _screen_w) / 2;
                    $(this).css('right', _margin);
                });
            }
        },
        select2: function () {
            if (typeof $({}).select2 !== 'function') return false;
            $('.nth-searchform .search_product_cat').select2();
        }
    };

    MASS.beforeReady();

    $(document).ready(function () {

        MASS.initialize();

    });

    /*Product page*/

    $(document).on('click', '#back_to_top', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 300);
    });

    $(window).on('scroll', function (e) {
        var _top = $(window).scrollTop();
        if (_top > 500) {
            $('#back_to_top').show();
        } else {
            $('#back_to_top').hide();
        }
    });

    $(".shipping-calculator-button").on('click', function () {
        $(this).toggleClass('open');
    });

    $(document).on('click', '.yeti-sidebar ul.widgets-sidebar > li.widget_product_categories ul.product-categories  li  a', function (event) {
        if ($('body').hasClass('touch_device')) {
            if ($(this).find("+ ul.children").length) {
                if (!$(this).attr('click-counter')) {
                    event.preventDefault();
                    $(this).find("ul.children").css("max-height", "100%");
                    $(this).attr('click-counter', 1);
                }
                else {
                    return;
                }
            }
        }
    });

})(jQuery);