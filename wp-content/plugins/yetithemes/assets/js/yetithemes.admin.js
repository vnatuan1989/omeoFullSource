/**
 * Created by kinhdon on 10/13/2015.
 */


(function ($) {
    "use strict";
    var text_add_button;
    var text_cancel_button;

    function nth_resUnload() {
        return "Dummy database is importing..."
    }

    $(document).ready(function () {

        $('#videos_product_data #button_add_video').on('click', function (event) {
            event.preventDefault();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'yeti_product_data_action',
                    act: 'add_product_video',
                    url: $('#yeti_embcode').val(),
                    post_id: woocommerce_admin_meta_boxes.post_id,
                },
                beforeSend: function (e) {
                    $('#videos_product_data').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                },
                success: function (data) {
                    $('#table_videos_html tbody').html(data);
                    $('#yeti_embcode').val('');
                    $('#videos_product_data').unblock();

                }
            });
        })

        $('#videos_product_data').on('click', 'table#table_videos_html .remove', function (event) {
            event.preventDefault();
            var conf = confirm("Do you want to remove this video?");

            if (!conf) return false;

            var _index = $(this).parents('tr').data('index');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'yeti_product_data_action',
                    act: 'remove_product_video',
                    post_id: woocommerce_admin_meta_boxes.post_id,
                    index: _index
                },
                beforeSend: function (e) {
                    $('#videos_product_data').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                },
                success: function (data) {
                    $('#table_videos_html tbody').html(data);
                    $('#videos_product_data').unblock();
                }
            });
        });

        var $tab_panel = $('#custom_tab_product_data');
        $tab_panel.on('click', '#button_add_customtab', function (event) {
            event.preventDefault();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'yeti_product_data_action',
                    act: 'add_product_tab',
                    title: $('#yeti_prod_tab_title_adding').val(),
                    content: $('#yeti_prod_tab_content_adding').val(),
                    classes: $('#yeti_prod_tab_classes').val(),
                    post_id: woocommerce_admin_meta_boxes.post_id,
                    priority: $('#yeti_prod_tab_priority').val()
                },
                beforeSend: function (e) {
                    $('#custom_tab_product_data').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                },
                success: function (data) {
                    $('#table_customtabs_html tbody').html(data);
                    $('#yeti_prod_tab_title_adding').val('');
                    $('#yeti_prod_tab_content_adding').val('');
                    $('#yeti_prod_tab_classes').val('');
                    $('#custom_tab_product_data').unblock();

                }
            });
        });

        $tab_panel.on('click', 'table#table_customtabs_html .remove', function (event) {
            event.preventDefault();
            var conf = confirm("Do you want to remove this row?");
            if (conf) {
                var _index = $(this).parents('tr').data('index');
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'yeti_product_data_action',
                        act: 'remove_product_tab',
                        post_id: woocommerce_admin_meta_boxes.post_id,
                        index: _index
                    },
                    beforeSend: function (e) {
                        $('#custom_tab_product_data').block({
                            message: null,
                            overlayCSS: {
                                background: '#fff',
                                opacity: 0.6
                            }
                        });
                    },
                    success: function (data) {
                        $('#table_customtabs_html tbody').html(data);
                        $('#custom_tab_product_data').unblock();
                    }
                });
            }
        });


        var gallery_frame;
        var $image_gallery_ids = $('#nth_gallery_image_id');
        var $gallery_images = $('#yeti_galleries_container').find('ul.gallery-images');

        $('.add_gallery_images').on('click', 'a', function (event) {
            var $el = $(this);
            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (gallery_frame) {
                gallery_frame.open();
                return;
            }

            // Create the media frame.
            gallery_frame = wp.media.frames.nth_gallery = wp.media({
                // Set the title of the modal.
                title: $el.data('choose'),
                button: {
                    text: $el.data('update')
                },
                states: [
                    new wp.media.controller.Library({
                        title: $el.data('choose'),
                        filterable: 'all',
                        multiple: true
                    })
                ]
            });

            gallery_frame.on('select', function () {
                var selection = gallery_frame.state().get('selection');
                var attachment_ids = $image_gallery_ids.val();

                selection.map(function (attachment) {
                    attachment = attachment.toJSON();

                    if (attachment.id) {
                        attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                        var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                        $gallery_images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>');
                    }
                });

                $image_gallery_ids.val(attachment_ids);
            });

            // Finally, open the modal.
            gallery_frame.open();

        });

        // Remove images
        $('#yeti_galleries_container').on('click', 'a.delete', function () {
            $(this).closest('li.image').remove();

            var attachment_ids = '';

            $('#yeti_galleries_container').find('ul li.image').each(function () {
                var attachment_id = $(this).data('attachment_id');
                attachment_ids = attachment_ids + attachment_id + ',';
            });

            $image_gallery_ids.val(attachment_ids);

            // remove any lingering tooltips
            $('#tiptip_holder').removeAttr('style');
            $('#tiptip_arrow').removeAttr('style');

            return false;
        });

        if(typeof $.fn.sortable === 'function') {
            $('#yeti_galleries_container ul.gallery-images').sortable({
                placeholder: 'yeti-sortable-placeholder',
                revert: true,
                cursor: "move",
                distance: 5
            });
            $('#yeti_galleries_container ul.gallery-images').disableSelection();
        }

        $(document).on('sortupdate', '#yeti_galleries_container ul.gallery-images', function (e, ui) {
            var _val = '';
            $(this).find('li.image').each(function (i) {
                _val += $(this).data('attachment_id') + ',';
            });
            $image_gallery_ids.val(_val);
        });

        var dialog, form,
            link = $("#yeti-dialog-form #link"),
            pos = $("#yeti-dialog-form #pos"),
            thumb = $("#yeti-dialog-form #thumbnail_id"),
            allFields = $([]).add(link).add(pos),
            btn_text = $('#yeti-add-gallery-video').data('btn');


        $('#yeti_galleries_container').on('click', '.gallery-videos .remove', function (event) {
            event.preventDefault();
            if ($(this).parents('tbody').find('tr').length <= 2) {
                $(this).parents('tbody').find('tr.no_item').removeClass('hidden');
            }
            $(this).parents('tr').remove();
        });


        $('body').on('click', '#yeti-add-gallery-video', function (event) {
            event.preventDefault();
            var link = $("#yeti-dialog-form #link"),
                pos = $("#yeti-dialog-form #pos"),
                thumb = $("#yeti-dialog-form #thumbnail_id");
            if (link.val().length > 0 && thumb.val().length > 0) {
                var _val = link.val() + '|' + thumb.val();
                if (pos.val().length > 0) _val += '|' + pos.val();
                var hidden = '<input type="hidden" name="nth_gallery_video[]" value="' + _val + '" />'
                $('#yeti_galleries_container table.gallery-videos tbody').append(
                    '<tr>' +
                    '<td>' + thumb.parents('.nth_upload_image').find('.nth_thumbnail').html() + '</td>' +
                    '<td>' + link.val() + hidden + '</td>' +
                    '<td>' + pos.val() + '</td>' +
                    '<td><a href="#" class="dashicons-before dashicons-trash remove"></a></td>' +
                    '</tr>'
                );
                $('#yeti_galleries_container table.gallery-videos .no_item').addClass('hidden');
            }
        });

        var tiptip_args = {
            'attribute': 'data-tip',
            'fadeIn': 50,
            'fadeOut': 50,
            'delay': 200
        };

        if (typeof $({}).tipTip === 'function') {
            $('.yeti-help-tip').tipTip(tiptip_args);
        }

        /****    AJAX BUTTON     ****/

        $(document).on('click', '.yeti-ajax-call', function (e) {
            e.preventDefault();
            var param = $(this).data('param');
            var json = $(this).data('json') || 0;
            var $this = $(this);
            if (typeof param == 'undefined') return false;
            var args = {
                type: 'POST',
                url: ajaxurl,
                data: param,
                beforeSend: function (XMLHttpRequest) {
                    $this.trigger('_beforeSend');
                },
                error: function (o) {
                    $this.trigger('_error', [o]);
                    console.log(o);
                },
                success: function (o) {
                    $this.trigger('_success', [o]);
                }
            }
            if (json && json !== 0) args.dataType = 'json';
            $.ajax(args);
        });

        var button_html = '';

        $(document).on('_beforeSend', '.theme-importer-wrapper .main-dummydata .yeti-ajax-call', function () {
            button_html = $(this).html();
            $(this).html('<i class="fa fa-refresh fa-spin fa-2x" aria-hidden="true"></i> ' + $(this).data('progress_text'));
            window.onbeforeunload = function (e) {
                return 'Dummy database is being imported, please wait a moment!';
            };
            $(this).prop('disabled', true);
        });
        $(document).on('_success', '.theme-importer-wrapper .main-dummydata .yeti-ajax-call', function (e, o) {
            if (o == 'connect_error') {
                alert("Couldn't connect to server, please check your connection or contact with us");
            } else if (o == 'wp_import_exist') {
                alert('Please deactivate "WordPress Importer" plugin before doing this step');
            }
            window.onbeforeunload = null;
            window.location.reload(true);
        });

        var __home_item = '.theme-importer-wrapper .homepage-import .homepage-item-wrapper .yeti-ajax-call';

        $(document).on('_beforeSend', __home_item, function () {
            $(this).text('Importing...').removeClass('button-primary');
            $(this).parents('.homepage-item-inner').addClass('loading');
            $('.homepage-import .homepage-item-wrapper .homepage-item-inner').addClass('disabled');
            $(this).prop('disabled', true);
            window.onbeforeunload = function (e) {
                return "Homepage is being setting, please wait a moment!";
            }
        });

        $(document).on('_error', __home_item, function (e, o) {
            alert('[Error]');
            window.onbeforeunload = null;
            window.location.reload(true);
        })

        $(document).on('_success', __home_item, function (e, o) {
            window.onbeforeunload = null;

            if (o.status == 'connect_error') {
                alert("Couldn't connect to server, please check your connection or contact with us");
                window.location.reload(true);
                return false;
            } else if (o.status == 'wp_import_exist') {
                alert("Please deactivate \"WordPress Importer\" plugin before doing this step");
                window.location.reload(true);
                return false;
            } else if (o.status == 'rev_error') {
                alert("Couldn't download main slideshow for this home! please try again or contact with our support team.");
                window.location.reload(true);
                return false;
            } else if (o.status == 'res_plugin_error') {
                alert("Please make sure you were fully installed required Plugins, then come back here and try it again!");
                window.location.reload(true);
                return false;
            } else if (typeof $(this).data('ref') !== 'undefined' && $(this).data('ref').length > 0) {
                window.location.href = $(this).data('ref');
            } else {
                window.location.reload(true);
            }
        });

        $(document).on('click', 'body .yeti-validate-api .yeti-validate-submit', function (e) {
            e.preventDefault();
            var $_root = $(this).parents('.yeti-validate-api'),
                $_this = $(this),
                action = $_root.data('action'),
                ajax_action = $_root.data('ajax_action'),
                token = $_root.find('.yeti-validate-data').val(),
                section = $_root.data('section');

            if (token.length == 0) return false;
            $.ajax({
                url: ajaxurl,
                dataType: 'json',
                type: 'POST',
                data: {
                    action: ajax_action,
                    token: token
                },
                beforeSend: function () {
                    $_this.attr('disabled', 'disabled');
                },
                success: function (o) {
                    $_this.removeAttr('disabled');
                    if (typeof o.meta !== 'undefined' && o.meta.code == '200') {
                        $_root.find('.yeti-validate-userid').val(o.data.id);
                        $_root.find('.yeti-validate-username').val(o.data.full_name);
                        $_root.find('.yeti-validate-useravata').val(o.data.profile_picture);
                        $_root.find('.yeti-validate-usercount').val(o.data.counts.media);
                        $_root.find('.user-meta img').attr('src', o.data.profile_picture);
                        $_root.find('.user-meta .instagram-name').html(o.data.full_name);
                        $_root.find('.user-meta .instagram-userid').html('<strong>User ID:</strong> ' + o.data.id);
                        $_root.find('.user-meta .instagram-count').html('<strong>Media:</strong> ' + o.data.counts.media);
                    }
                }
            });
        });

        $(document).on('click', '.purchase-popup-action', function (e) {
            e.preventDefault();
            var _id = $(this).data('id');
            $(_id).toggleClass('active');
        });

        $(document).on('hover', '.yeti-item-inner', function () {
        }, function () {
            $(this).find('.action-buttons .purchase-popup.active').removeClass('active');
        });

        $('.yeti-ajax-get-content').each(function (e, i) {
            var param = $(this).data('param');
            var json = $(this).data('json') || 0;
            var $this = $(this);
            var $_pro_text = $(this).data('progress_text') || 'Loading data...';
            if (typeof param == 'undefined') return false;
            var args = {
                type: 'POST',
                url: ajaxurl,
                data: param,
                beforeSend: function (XMLHttpRequest) {
                    $this.append('<h2 class="progress-text"><i class="fa fa-refresh fa-spin" aria-hidden="true"></i> ' + $_pro_text + '</h2>');
                },
                error: function (o) {
                    $this.find('h2.progress-text').addClass('error').text(o);
                },
                success: function (o) {
                    $this.html(o);
                }
            }
            if (json && json !== 0) args.dataType = 'json';
            $.ajax(args);
        });

        $(document).on('click', '.description-toggle-action', function () {
            $(this).parents('.description-toggle-content').addClass('open');
        });

        $('form#yeti_features_enable_form input').on('change', function (e) {
            $(this).parents('form').trigger('submit', [$(this)]);
        });

        $('form#yeti_features_enable_form').on('submit', function (e, $this) {
            e.preventDefault();

            var fromData = JSON.parse(JSON.stringify($(this).serializeArray()));
            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: fromData,
                dataType: 'json',
                beforeSend: function () {
                    $this.addClass('loading');
                    $this.prop('disabled', true);
                    $this.parents('.featured-enable-wrap').addClass('loading');
                },
                success: function (o) {
                    $this.prop('disabled', false);
                    $this.removeClass('loading');
                    $this.parents('.featured-enable-wrap').toggleClass('enabled').removeClass('loading');
                }
            });
        });

    });

})(jQuery);