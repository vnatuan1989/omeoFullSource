/*!
 * YetiThemes Plugin v1.0.0
 * Copyright 2015 Nexthemes
 */

(function ($) {
    "use strict";

    YetiThemes._events = {

    }

    YetiThemes.objs = {
        portfolio: {
            elements: $('.yeti-portfolios-wrapper'),
            init: function () {
                this.elements.each(function () {
                    var $this = $(this);
                    var $grid = $this.find('.yeti-portfolio-content').isotope({
                        itemSelector: '.yeti-portfolio-item',
                        masonry: {columnWidth: $this.find('.item-width-cal:visible')[0]}
                    });

                    $this.find('img').load(function () {
                        $grid.isotope({
                            itemSelector: '.yeti-portfolio-item',
                            masonry: {columnWidth: $this.find('.item-width-cal:visible')[0]}
                        });
                    });
                    var _current_filter = $this.find('.yeti-portfolio-filters li.active a').data('filter');
                    setTimeout(function () {
                        $grid.isotope({
                            filter: _current_filter,
                            masonry: {columnWidth: $grid.find('.item-width-cal:visible')[0]}
                        });
                    }, 150);

                    $this.find('ul.yeti-portfolio-filters li').on('click', function () {
                        $(this).parent().find('li.active').removeClass('active');
                        $(this).addClass('active');
                        var filter_class = $(this).find('a').data('filter');
                        $grid.isotope({
                            filter: filter_class,
                            masonry: {columnWidth: $grid.find('.item-width-cal:visible')[0]}
                        });
                    });

                });


            }
        },
        ajaxseach: {
            elements: $('#header form.yeti-searchform [name=s]'),
            init: function () {
                var _limit = yesshop_data.search.param.limit || 5,
                    _min = yesshop_data.search.min || 3;

                var _s_cat = this.elements.parents('.searchform').find('[name=product_cat]').val();
                var _param = yesshop_data.search.param || {
                        limit: _limit,
                        product_cat: _s_cat,
                        action: 'yeti_ajax_search_products'
                    };

                if (typeof _param.product_cat == 'undefined' || _param.product_cat.length == 0) _param.product_cat = _s_cat;

                //icon-yeti-loading
                var $s = this.elements,
                    _width = $s.parents('form').width() || 'auto';

                this.elements.autocomplete({
                    minChars: _min,
                    triggerSelectOnValidInput: false,
                    maxHeight: 'auto',
                    width: _width,
                    params: _param,
                    type: 'POST',
                    zIndex: 999,
                    appendTo: $s.parents('form'),
                    serviceUrl: yesshop_data.ajax_url,
                    onSearchStart: function () {
                        $s.parent().find('[type=submit] .fa').removeClass('fa-search').addClass('fa-spinner fa-spin');
                    },
                    onSearchComplete: function (query, suggestion) {
                        $('.autocomplete-suggestions .autocomplete-suggestion').each(function (i, e) {
                            var i = $(this).data('index');
                            if (suggestion[i]['id'] == -1) return false;
                            var title = $(this).html();

                            if ($(this).find('img.suggestion-thumbnail').length <= 0)
                                $(this).prepend(suggestion[i]['img']);

                            if ($(this).find('.suggestion-prices').length <= 0 && typeof suggestion[i]['price'] != "undefined") {
                                $(this).append(suggestion[i]['price']);
                            }
                        });

                        $s.parent().find('[type=submit] .fa').removeClass('fa-spinner fa-spin').addClass('fa-search');
                    },
                    onSelect: function (suggestion) {
                        if (suggestion.id != -1) {
                            window.location.href = suggestion.url;
                        }
                    }
                });
            }
        },
        galleries: {
            elements: $('.yeti-galleries-wrap'),
            init: function () {
                this.elements.each(function () {
                    var $this = $(this),
                        $grid = $this.find('.galleries-content');

                    $this.find('ul.gallery-filters.ajax_filter li').on('click', function (event) {
                        event.preventDefault();
                        var el = $(this);
                        el.parent().find('li.active').removeClass('active');
                        el.addClass('active');

                        el.trigger('yeti_ajax_galleries_content', [$this, $grid]);
                    });

                    $this.find('form.order-form').on('change', 'select', function () {
                        var el = $(this);
                        el.trigger('yeti_ajax_galleries_content', [$this, $grid]);
                    });
                });
            }
        },
        gallery: {
            elements: $('.gallery-content'),
            init: function () {
                this.elements.each(function () {
                    var $this = $(this);

                    if ($this.hasClass('gallery-style-2')) {

                        var wrap = $this.find('.galleries-wrapper'),
                            def = {
                                fullscreen: {
                                    enabled: true,
                                    nativeFS: true
                                },
                                controlNavigation: 'thumbnails',
                                autoScaleSlider: true,
                                autoScaleSliderWidth: 1170,
                                autoScaleSliderHeight: 670,
                                loop: false,
                                imageScaleMode: 'fit-if-smaller',
                                navigateByClick: true,
                                numImagesToPreload: 2,
                                arrowsNav: true,
                                arrowsNavAutoHide: true,
                                arrowsNavHideOnTouch: true,
                                keyboardNavEnabled: true,
                                fadeinLoadedSlide: true,
                                globalCaption: false,
                                globalCaptionInside: false,
                                autoPlay: {
                                    enabled: true,
                                    pauseOnHover: true,
                                    delay: 5000
                                },
                                thumbs: {
                                    appendSpan: true,
                                    firstMargin: true,
                                    paddingBottom: 4
                                }
                            },
                            ops = wrap.data('options'),
                            conf = $.extend(def, ops);

                        $('#yeti_galleries').royalSlider(conf);
                    }
                });

            }
        },
        masonry_gallery: {
            elements: $('.gallery-content'),
            gallery_grid: null,
            k: 0,
            init: function () {
                this.elements.each(function () {
                    var $this = $(this);

                    YetiThemes.objs.masonry_gallery.gallery_grid = $this.find('.yeti-isotope').isotope({
                        percentPosition: true,
                        itemSelector: '.gallery-image-item',
                        masonry: {}
                    });

                    YetiThemes.objs.masonry_gallery.gallery_grid.imagesLoaded().progress(function () {
                        YetiThemes.objs.masonry_gallery.gallery_grid.isotope('layout');
                    });

                    YetiThemes.objs.masonry_gallery.k = parseInt($this.attr('data-k'));

                    $this.on('click', '.nth_gallery_load_more', function (e) {
                        e.preventDefault();
                        var btn_el = $(this);

                        if (YetiThemes.objs.masonry_gallery.k >= $this.data('max')) return false;

                        $.ajax({
                            type: 'POST',
                            url: YetiThemes.ajax_url,
                            dataType: 'json',
                            data: {
                                k: YetiThemes.objs.masonry_gallery.k,
                                l: $this.attr('data-number'),
                                post_id: $this.attr('data-post_id'),
                                action: 'yeti_gallery_items'
                            },
                            beforeSend: function () {
                                $.data(btn_el, 'txt_html', btn_el.html());
                                btn_el.prop('disabled', true);
                                btn_el.find('i.fa').addClass('fa-spin');
                                var _txt = btn_el.data('loading_text') || 'Loading...';
                                btn_el.find('span').html(_txt);
                            },
                            success: function (data) {
                                var $item = $(data.element);
                                YetiThemes.objs.masonry_gallery.k = parseInt(data.k);
                                YetiThemes.objs.masonry_gallery.gallery_grid.append($item).isotope('appended', $item);

                                YetiThemes.objs.masonry_gallery.gallery_grid.imagesLoaded().progress(function () {
                                    YetiThemes.objs.masonry_gallery.gallery_grid.isotope('layout');
                                });

                                btn_el.prop('disabled', false);
                                btn_el.find('i.fa').removeClass('fa-spin');
                                btn_el.html($.data(btn_el, 'txt_html'));

                                if (data.k >= $this.data('max')) btn_el.remove();
                            }
                        });
                    });

                });
            }
        },
        advanced_reviews: {
            elements: $('.yeti-rating.input'),
            init: function () {
                $(document).on('click', '.yeti-rating .yeti-stars a', function (e) {
                    e.preventDefault();
                    var val = $(this).data('val'),
                        $star = $(this).closest('li'),
                        $container = $(this).closest('.yeti-stars');
                    $(this).parents('.yeti-rating').find('select').val(val);
                    $star.siblings('li').removeClass('active');
                    $star.addClass('active');
                    $container.addClass('selected');
                    var adv_rate = 0,
                        _total = 0;
                    $(this).parents('.comment-form-rating').find('select').each(function () {
                        var val = $(this).val();
                        if (val.length > 0) {
                            adv_rate += parseInt(val);
                            _total++;
                        }
                    });

                    var rating = Math.round(adv_rate / _total * 10) / 10,
                        rating_txt = rating;
                    if (rating % 1 === 0) {
                        rating_txt = rating + '.0';
                    }
                    $(this).parents('.comment-form-rating').find('.advanced-rating-wrap .rating-text').text(rating_txt);
                    $(this).parents('.comment-form-rating').find(".advanced-rating-wrap [name='rating']").val(rating);

                });
            }
        },
        woo_load_more: {
            elements: $('.yeti-woo-load-more'),
            init: function () {
                $('body').on('click', '.yeti-woo-load-more', function (e) {
                    e.preventDefault();
                    var _atts = $(this).data('atts'),
                        _btn = $(this);
                    $.ajax({
                        type: 'POST',
                        url: YetiThemes.ajax_url,
                        data: _atts,
                        beforeSend: function () {
                            _btn.prop('disabled', true).addClass('loading');
                        },
                        success: function (res) {
                            if(_btn.parent().parent().find('.products').length > 0){
                                _btn.parent().parent().find('.products').append($(res).find('.products').html());
                                var _rs_count = $(res).find('.products .product').length;
                            } else {
                                _btn.parent().parent().find('.product_list_widget').append($(res).find('.product_list_widget').html());
                                var _rs_count = $(res).find('.product_list_widget .col-sm-24').length;
                            }
                            _atts.offset += _rs_count;
                            _btn.data('atts', _atts);
                            _btn.prop('disabled', false).removeClass('loading');
                            if(parseInt(_rs_count) < parseInt(_atts.per_page)) _btn.remove();
                        }
                    });
                });
            }
        }
    }

    $(document).ready(function () {

        $.each(YetiThemes.objs, function (key, value) {
            if (value.elements.length > 0) {
                value.init();
            }
        });

        $(document).trigger('yeti_gridlist_cook');
    });


    $(document).on('click', '.gridlist-toggle #grid', function (e) {
        e.preventDefault();
        if(typeof $.cookie !== "function") return false;

        $(this).addClass('active');
        $('#list').removeClass('active');
        $('#table').removeClass('active');
        $.cookie('gridcookie', 'grid', {path: '/'});
        var products = $(this).parents(".yeti-shop-meta-controls").nextAll(".row").find(".products");
        products.fadeOut(300, function () {
            $(this).addClass('grid').removeClass('list').fadeIn(300);
        });

        return false;
    })

    $(document).on('click', '.gridlist-toggle #list', function (e) {
        e.preventDefault();
        if(typeof $.cookie !== "function") return false;

        $('#grid, #table').removeClass('active');
        $(this).addClass('active');
        $.cookie('gridcookie', 'list', {path: '/'});
        var products = $(this).parents(".yeti-shop-meta-controls").nextAll(".row").find(".products");
        products.fadeOut(300, function () {
            $(this).removeClass('grid').addClass('list').fadeIn(300);
        });

        return false;
    });

    $(document).on('yeti_gridlist_cook', function () {

        if(typeof $.cookie !== "function") return false;
        if ($.cookie('gridcookie')) {
            var products = $(".yeti-shop-meta-controls").nextAll(".row").find(".products");
            products.removeClass('list').removeClass('grid').addClass($.cookie('gridcookie'));
        }

        if ($.cookie('gridcookie') == 'grid') {
            $('.gridlist-toggle #grid').addClass('active');
            $('.gridlist-toggle #list').removeClass('active');
        }

        if ($.cookie('gridcookie') == 'list') {
            $('.gridlist-toggle #list').addClass('active');
            $('.gridlist-toggle #grid').removeClass('active');
        }
    });

    $(document).on('yeti_ajax_galleries_content', function (event, container, grid) {
        console.log(container);

        var termid = container.find('.gallery-filters li.active a').data('termid');
        var orderby = container.find('form.order-form select[name=orderby]').val();
        var order = container.find('form.order-form select[name=order]').val();
        var paged = container.find('ul.gallery-filters').data('paged');
        var data = {
            action: 'yeti_gallery_content',
            term_id: termid,
            orderby: orderby,
            order: order,
            paged: paged
        };

        var appent = container.find('.galleries-content');

        $.ajax({
            type: 'POST',
            url: YetiThemes.ajax_url,
            data: data,
            beforeSend: function () {
                appent.yesshop_loading();
            },
            success: function (res) {
                appent.html(res);
                appent.yesshop_unlock();
            }
        });
    });

})(jQuery);