jQuery(document).ready(function($){
    "use strict";

    $('.wsnfw_select2').select2({
        theme: "classic",
        "language": {
            "noResults": function(){
                return wsnfw_settings_info.no_results; 
            }
        }
    });

    $("#wsnfw_custom_phone_meta_keys").select2({
        tags: true
    });

    $.validator.addMethod("time", function(value, element) {
        return this.optional(element) || /^(?:[01][0-9]|2[0-3]):[0-5][0-9](?::[0-5][0-9])?$/.test(value);
    }, wsnfw_settings_info.invalid_time_format);

    var save_button = $('#wsnfw_save_button');
    var response_message = $('#wsnfw-response-message');
    $('#wsnfw_settings_form').validate({
        rules: {
            wsnfw_uname: "required",
            wsnfw_send_time: "required time",
        },
        messages: {
            wsnfw_uname: wsnfw_settings_info.api_key_required, 
            wsnfw_send_time: wsnfw_settings_info.invalid_time_format,
        },
        submitHandler: function(form) {
            var data = {
                'action': 'wsnfw_save_credentials',
                'username': $('#wsnfw_uname').val(),
                'password': $('#wsnfw_pass').val(),
                'sender': $('#wsnfw_sender').val(),
                'send_time': $('#wsnfw_send_time').val(),
            };
            response_message.empty().removeClass().hide();
            save_button.addClass("wsnfw_button--loading");
            $.post(ajaxurl, data, function (response) {
                save_button.removeClass("wsnfw_button--loading");
                if(!response.success){
                    $('<span>'+response.data+'</span>').appendTo(response_message);
                    response_message.addClass("wsnfw-error-message").show();
                }else {
                    $('<span>'+ wsnfw_settings_info.save_success +'</span>').appendTo(response_message); // استفاده از ترجمه‌ها
                    response_message.addClass("wsnfw-success-message").show();
                    setTimeout(function(){ location.reload(); }, 500);
                }
            });
        }
    });

    var clickedTab = $(".tabs > .active");
    var tabWrapper = $(".tab__content");
    var activeTab = tabWrapper.find(".active");
    var activeTabHeight = activeTab.outerHeight();
    activeTab.show();
    tabWrapper.height(activeTabHeight);

    $(".tabs > li").on("click", function() {
        $(".tabs > li").removeClass("active");
        $(this).addClass("active");
        clickedTab = $(".tabs .active");
        activeTab.fadeOut(150, function() {
            $(".tab__content > li").removeClass("active");
            var clickedTabIndex = clickedTab.index();
            $(".tab__content > li").eq(clickedTabIndex).addClass("active");
            activeTab = $(".tab__content > .active");
            activeTabHeight = activeTab.outerHeight();
            tabWrapper.stop().delay(10).animate({
                height: activeTabHeight
            }, 200, function() {
                activeTab.delay(10).fadeIn(150);
            });
        });
    });

    var save_users_settings_button = $('#wsnfw_save_users_settings_button');
    var users_settings_response_message = $('#wsnfw-users-settings-response-message');
    $('#wsnfw_users_settings_form').validate({
        rules: {
        },
        messages: {
        },
        submitHandler: function(form) {
            var data = {
                'action': 'wsnfw_save_users_settings',
                'wsnfw_active_digits': $('#wsnfw_active_digits').is(":checked"),
                'wsnfw_custom_phone_meta_keys': $('#wsnfw_custom_phone_meta_keys').val(),
            };
            users_settings_response_message.empty().removeClass().hide();
            save_users_settings_button.addClass("wsnfw_button--loading");
            $.post(ajaxurl, data, function (response) {
                save_users_settings_button.removeClass("wsnfw_button--loading");
                if(!response.success){
                    $('<span>'+response.data+'</span>').appendTo(users_settings_response_message);
                    users_settings_response_message.addClass("wsnfw-error-message").show();
                }else {
                    $('<span>'+ wsnfw_settings_info.save_success +'</span>').appendTo(users_settings_response_message); // استفاده از ترجمه‌ها
                    users_settings_response_message.addClass("wsnfw-success-message").show();
                    //setTimeout(function(){ location.reload(); }, 500);
                }
            });
        }
    });
});


jQuery(document).ready(function($) {
    "use strict";

    var save_wc_button = $('#wsnfw_save_wc_button');
    var wc_response_message = $('#wsnfw-wc-response-message');
    
    $('#wsnfw_wc_form').validate({
        rules: {},
        messages: {},
        submitHandler: function(form) {
            var sms_data = $("#wsnfw_wc_form").serializeArray();
            var data = {
                'action': 'wsnfw_save_wc_sms_data',
                'sms_data': sms_data,
            };
            wc_response_message.empty().removeClass().hide();
            save_wc_button.addClass("wsnfw_button--loading");
            $.post(ajaxurl, data, function(response) {
                save_wc_button.removeClass("wsnfw_button--loading");
                if (!response.success) {
                    $('<span>' + response.data + '</span>').appendTo(wc_response_message);
                    wc_response_message.addClass("wsnfw-error-message").show();
                } else {
                    $('<span>' + wsnfw_settings_info.save_success + '</span>').appendTo(wc_response_message); // استفاده از ترجمه‌ها
                    wc_response_message.addClass("wsnfw-success-message").show();
                }
            });
        }
    });

    var save_users_button = $('#wsnfw_save_users_button');
    var users_response_message = $('#wsnfw-users-response-message');
    
    $('#wsnfw_users_form').validate({
        rules: {},
        messages: {},
        submitHandler: function(form) {
            var sms_data = $("#wsnfw_users_form").serializeArray();
            var data = {
                'action': 'wsnfw_save_users_sms_data',
                'sms_data': sms_data,
            };
            users_response_message.empty().removeClass().hide();
            save_users_button.addClass("wsnfw_button--loading");
            $.post(ajaxurl, data, function(response) {
                save_users_button.removeClass("wsnfw_button--loading");
                if (!response.success) {
                    $('<span>' + response.data + '</span>').appendTo(users_response_message);
                    users_response_message.addClass("wsnfw-error-message").show();
                } else {
                    $('<span>' + wsnfw_settings_info.save_success + '</span>').appendTo(users_response_message); // استفاده از ترجمه‌ها
                    users_response_message.addClass("wsnfw-success-message").show();
                }
            });
        }
    });

    $('#wsnfw_users_form,#wsnfw_wc_form').on('click', '.wsnfw_active input:checkbox', function() {
        if ($(this).is(":checked")) {
            $(this).next('.wsnfw_active_hidden').val('on')
        } else {
            $(this).next('.wsnfw_active_hidden').val('off')
        }
    });

    var order_statuses = wsnfw_settings_info.order_statuses;
    var order_statuses_option = '';
    for (var key in order_statuses) {
        if (order_statuses.hasOwnProperty(key)) {
            order_statuses_option += '<option value="' + key + '">' + order_statuses[key] + '</option>';
        }
    }

    var sms_container_wc = $('#sms_container_wc');
    var sms_container_form_submit_wc = $('.wsnfw_save_button_container_wc');
    var add_sms_wc = $('#wsnfw_add_sms_wc');
    var next_index_wc = $('#wsnfw_next_index_wc').val();
    
    add_sms_wc.click(function() {
        var row = '<div class="sms">';
        row += '<div class="delete"><div id="delete_row_' + next_index_wc + '"><img src="' + wsnfw_settings_info.delete_button + '"></div></div>';
        row += '<div class="wsnfw_active"><label for="wsnfw_sms_active_' + next_index_wc + '" class="toggle-control"><input type="checkbox" id="wsnfw_sms_active_' + next_index_wc + '" name="wsnfw_sms_meta[' + next_index_wc + '][active]"><input type="hidden" class="wsnfw_active_hidden" name="wsnfw_sms_meta[' + next_index_wc + '][active_or_not]" value="off"><span class="control"></span></label></div>';
        row += '<div class="time"><label for="wsnfw_sms_time_' + next_index_wc + '">' + wsnfw_settings_info.time_label + '</label><input type="number" required min="0" class="wsnfw_time_input" name="wsnfw_sms_meta[' + next_index_wc + '][time]" id="wsnfw_sms_time_' + next_index_wc + '"><span>' + wsnfw_settings_info.days_after + '</span></div>';
        row += '<div class="order_status"><label for="wsnfw_sms_order_status_' + next_index_wc + '">' + wsnfw_settings_info.order_status + '</label><select name="wsnfw_sms_meta[' + next_index_wc + '][order_status]" id="wsnfw_sms_order_status_' + next_index_wc + '">' + order_statuses_option + '</select></div>';
        row += '<div class="hour"><label for="wsnfw_sms_hour_' + next_index_wc + '">' + wsnfw_settings_info.hour_label + '</label><input type="text" required placeholder="16:59" name="wsnfw_sms_meta[' + next_index_wc + '][hour]" id="wsnfw_sms_hour_' + next_index_wc + '"></div>';
        row += '<div class="sms_content"><label for="wsnfw_sms_content_' + next_index_wc + '">' + wsnfw_settings_info.content_label + '</label><textarea required rows="5" cols="20" name="wsnfw_sms_meta[' + next_index_wc + '][content]" id="wsnfw_sms_order_content_' + next_index_wc + '"></textarea></div>';
        row += '</div>';
        sms_container_form_submit_wc.before(row);
        next_index_wc++;
    });

    var sms_container = $('#sms_container');
    var sms_container_form_submit = $('#wsnfw_users_form .wsnfw_save_button_container');
    var add_sms = $('#wsnfw_add_sms');
    var next_index = $('#wsnfw_next_index').val();
    
    add_sms.click(function() {
        var row = '<div class="sms">';
        row += '<div class="delete"><div id="delete_row_' + next_index + '"><img src="' + wsnfw_settings_info.delete_button + '"></div></div>';
        row += '<div class="wsnfw_active"><label for="wsnfw_sms_active_' + next_index + '" class="toggle-control"><input type="checkbox" id="wsnfw_sms_active_' + next_index + '" name="wsnfw_sms_meta[' + next_index + '][active]"><input type="hidden" class="wsnfw_active_hidden" name="wsnfw_sms_meta[' + next_index + '][active_or_not]" value="off"><span class="control"></span></label></div>';
        row += '<div class="time"><label for="wsnfw_sms_time_' + next_index + '">' + wsnfw_settings_info.time_label + '</label><input type="number" required min="0" class="wsnfw_time_input" name="wsnfw_sms_meta[' + next_index + '][time]" id="wsnfw_sms_time_' + next_index + '"><span>' + wsnfw_settings_info.days + '</span></div>';
        row += '<div class="hour"><label for="wsnfw_sms_hour_' + next_index + '">' + wsnfw_settings_info.hour_label + '</label><input type="text" required placeholder="16:59" name="wsnfw_sms_meta[' + next_index + '][hour]" id="wsnfw_sms_hour_' + next_index + '"></div>';
        row += '<div class="sms_content"><label for="wsnfw_sms_content_' + next_index + '">' + wsnfw_settings_info.content_label + '</label><textarea required rows="5" cols="20" name="wsnfw_sms_meta[' + next_index + '][content]" id="wsnfw_sms_order_content_' + next_index + '"></textarea></div>';
        row += '</div>';
        sms_container_form_submit.before(row);
        next_index++;
    });

    $('#sms_container,#sms_container_wc,#gf_form_and_fields').on('click', '.sms .delete > div', function() {
        if (confirm(wsnfw_settings_info.confirm_delete)) {
            $(this).parents(".sms").remove();
        } else {
            return;
        }
    });
});

$(document).ready(function () {
    var gf_id;
    
    $('#wsnfw-gravity-forms').on('select2:select', function (e) {
        gf_id = e.params.data.id;
        var fields_select = $("#wsnfw-gravity-field");

        if (gf_id == -1) {
            fields_select.prop("disabled", true);
        } else {
            fields_select.prop("disabled", false);
        }

        fields_select.select2({
            templateResult: formatState
        });
    });

    function formatState(state, container) {
        if (state.id) {
            if (state.id.startsWith(gf_id.toString())) {
                $(container).addClass("gf_show");
            } else {
                $(container).addClass("gf_hide");
            }
        }
        return state.text;
    }

    $('#wsnfw-gravity-field').on('select2:select', function (e) {
        var selected_field = e.params.data.id;
        $(".wsnfw_gf_field_registered_sms .wsnfw_show_hide_field").each(function () {
            if ($(this).attr('id') == 'frmid-fldid_' + selected_field) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $("#wsnfw-gravity-field").prop("disabled", true);

    var wsnfw_save_gf_sms_button = $('#wsnfw_save_gf_sms_button');
    var wsnfw_gf_sms_response_message = $('#wsnfw-gf-sms-response-message');

    $('#wsnfw_gf_sms_form').validate({
        rules: {
            // Add rules here if needed
        },
        messages: {
            // Add custom messages here if needed
        },
        submitHandler: function (form) {
            var sms_data = $("#wsnfw_gf_sms_form").serializeArray();
            var data = {
                'action': 'wsnfw_save_gf_sms_data',
                'sms_data': sms_data,
            };

            wsnfw_gf_sms_response_message.empty().removeClass().hide();
            wsnfw_save_gf_sms_button.addClass("wsnfw_button--loading");

            $.post(ajaxurl, data, function (response) {
                wsnfw_save_gf_sms_button.removeClass("wsnfw_button--loading");
                if (!response.success) {
                    $('<span>' + response.data + '</span>').appendTo(wsnfw_gf_sms_response_message);
                    wsnfw_gf_sms_response_message.addClass("wsnfw-error-message").show();
                } else {
                    $('<span>' + wsnfw_settings_info.success_message + '</span>').appendTo(wsnfw_gf_sms_response_message);
                    wsnfw_gf_sms_response_message.addClass("wsnfw-success-message").show();
                }
            });
        }
    });

    $('#wsnfw_gf_sms_form').on('click', '.wsnfw_active input:checkbox', function () {
        if ($(this).is(":checked")) {
            $(this).next('.wsnfw_active_hidden').val('on')
        } else {
            $(this).next('.wsnfw_active_hidden').val('off')
        }
    });

    var add_gf_sms = $('.wsnfw_gf_add_sms');
    var next_gf_index = $('#wsnfw_gf_next_index').val();

    add_gf_sms.click(function () {
        var gf_id = $(this).parent().prop('id').replace('frmid-fldid_', '');
        var opt = '';

        $("#wsnfw-gravity-field option").each(function () {
            var res = $(this).val().split("-");
            var id = gf_id.split("-");
            if (res[0] == id[0]) {
                opt += '<option value="' + res[1] + '">' + $(this).text() + '</option>'
            }
        });

        var row = '<div class="sms">';
        row += '<input type="hidden" name="wsnfw_gf_sms_meta[' + next_gf_index + '][gf_formatted_id]" value="' + gf_id + '">';
        row += '<div class="delete"><div id="delete_gf_row_' + next_gf_index + '"><img src="' + wsnfw_settings_info.delete_button + '"></div></div>';
        row += '<div class="wsnfw_active"><label for="wsnfw_gf_sms_active_' + next_gf_index + '" class="toggle-control"><input type="checkbox" id="wsnfw_gf_sms_active_' + next_gf_index + '" name="wsnfw_gf_sms_meta[' + next_gf_index + '][active]"><input type="hidden" class="wsnfw_active_hidden"  name="wsnfw_gf_sms_meta[' + next_gf_index + '][active_or_not]" value="off"><span class="control"></span></label></div>';
        row += '<div class="time"><label for="wsnfw_gf_sms_time_' + next_gf_index + '">' + wsnfw_settings_info.time_label + '</label><input type="number" required min="0" class="wsnfw_time_input" name="wsnfw_gf_sms_meta[' + next_gf_index + '][time]" id="wsnfw_gf_sms_time_' + next_gf_index + '"><span>' + wsnfw_settings_info.days_after + '</span></div>';
        row += '<div class="hour"><label for="wsnfw_gf_sms_hour_' + next_gf_index + '">' + wsnfw_settings_info.hour_label + '</label><input type="text" minlength="5" maxlength="5" required placeholder="16:59" name="wsnfw_gf_sms_meta[' + next_gf_index + '][hour]" id="wsnfw_gf_sms_hour_' + next_gf_index + '"></div>';
        row += '<div class="condition"><label for="wsnfw_gf_condition_active_' + next_gf_index + '" class="toggle-control">' + wsnfw_settings_info.conditional_logic_label + '<input class="wsnfw_inputs wsnfw_condition_toggle" type="checkbox" id="wsnfw_gf_condition_active_' + next_gf_index + '" name="wsnfw_gf_sms_meta[' + next_gf_index + '][condition_active]"><span class="control"></span></label></div>';
        row += '<div class="sms_content"><label for="wsnfw_gf_sms_content_' + next_gf_index + '">' + wsnfw_settings_info.content_label + '</label><textarea required rows="5" cols="20" name="wsnfw_gf_sms_meta[' + next_gf_index + '][content]" id="wsnfw_gf_sms_order_content_' + next_gf_index + '"></textarea></div>';
        row += '</div><div style="display: none" class="wsnfw_condition_container" id="wsnfw_condition_container_' + next_gf_index + '"><div class="wsnfw_if_all_condition"><span>' + wsnfw_settings_info.if_all_condition_label + '</span><select name="wsnfw_gf_sms_meta[' + next_gf_index + '][all_or_one]"><option value="all" selected="">' + wsnfw_settings_info.all_option + '</option><option value="any">' + wsnfw_settings_info.any_option + '</option></select><span>' + wsnfw_settings_info.conditions_met_label + '</span><div class="plus-button plus-button--small"></div></div>';
        row += '<span>' + wsnfw_settings_info.if_label + '</span><div class="wsnfw_conditions"><select class="wsnfw_gf_conditional_field" name="wsnfw_gf_condition_field_[' + next_gf_index + '][0][field]" id="wsnfw_gf_condition_field_' + next_gf_index + '_0">' + opt + '</select>';
        row += '<select class="wsnfw_gf_conditional_operator" id="wsnfw_gf_condition_operator_' + next_gf_index + '_0" name="wsnfw_gf_condition_operator_[' + next_gf_index + '][0][operator]"><option value="is" selected="">' + wsnfw_settings_info.is_option + '</option><option value="isnot">' + wsnfw_settings_info.isnot_option + '</option><option value=">">' + wsnfw_settings_info.greater_than_option + '</option><option value="<">' + wsnfw_settings_info.less_than_option + '</option><option value="contains">' + wsnfw_settings_info.contains_option + '</option><option value="starts_with">' + wsnfw_settings_info.starts_with_option + '</option><option value="ends_with">' + wsnfw_settings_info.ends_with_option + '</option></select>';
        row += '<div id="wsnfw_gf_condition_value_' + next_gf_index + '_0" style="display:inline;"><input type="text" class="condition_field_value" style="padding:3px" placeholder="' + wsnfw_settings_info.enter_value_placeholder + '" id="wsnfw_gf_condition_value_10_10" name="wsnfw_gf_condition_value_[' + next_gf_index + '][0][value]" value=""></div><div class="minus-button plus-button--small"></div></div></div>';

        $(this).parent().append(row);
        next_gf_index++;
    });

    var condition_toggle = $('#wsnfw_gf_sms_form');
    condition_toggle.on('click', '.wsnfw_condition_toggle', function () {
        var id = $(this).attr('id').replace('wsnfw_gf_condition_active_', '');
        var condition_container = $("#wsnfw_condition_container_" + id);

        if ($(this).is(':checked')) {
            condition_container.show();
        } else {
            condition_container.hide();
        }
    });

    condition_toggle.find('.wsnfw_condition_toggle').each(function () {
        if ($(this).is(":checked")) {
            var id = $(this).attr('id').replace('wsnfw_gf_condition_active_', '');
            var condition_container = $("#wsnfw_condition_container_" + id);
            condition_container.show();
        }
    });

    var ind = 1;
    $("#wsnfw_gf_sms_form").on('click', '.plus-button', function () {
        var id = $(this).parents(".wsnfw_condition_container").attr('id').replace('wsnfw_condition_container_', '');
        ind = $(this).parents('.wsnfw_condition_container').children(".wsnfw_conditions").length;
        var opt2 = '';

        $(this).parents(".wsnfw_condition_container").find(".wsnfw_conditions .wsnfw_gf_conditional_field option").each(function () {
            opt2 += '<option value="' + $(this).val() + '">' + $(this).text() + '</option>'
        });

        var con = '<div class="wsnfw_conditions"><span>' + wsnfw_settings_info.if_label + '</span><select class="wsnfw_gf_conditional_field" name="wsnfw_gf_condition_field_[' + id + '][' + ind + '][field]" id="wsnfw_gf_condition_field_' + id + '_' + ind + '">' + opt2 + '</select>';
        con += '<select class="wsnfw_gf_conditional_operator valid" id="wsnfw_gf_condition_operator_' + id + '_' + ind + '" name="wsnfw_gf_condition_operator_[' + id + '][' + ind + '][operator]" aria-invalid="false"><option value="is">' + wsnfw_settings_info.is_option + '</option><option value="isnot">' + wsnfw_settings_info.isnot_option + '</option><option value=">">' + wsnfw_settings_info.greater_than_option + '</option><option value="<">' + wsnfw_settings_info.less_than_option + '</option><option value="contains">' + wsnfw_settings_info.contains_option + '</option><option value="starts_with">' + wsnfw_settings_info.starts_with_option + '</option><option value="ends_with">' + wsnfw_settings_info.ends_with_option + '</option></select>';
        con += '<div id="wsnfw_gf_condition_value_' + id + '_' + ind + '" style="display:inline;"><input type="text" class="condition_field_value" style="padding:3px" placeholder="' + wsnfw_settings_info.enter_value_placeholder + '" id="wsnfw_gf_condition_value_' + id + '_' + ind + '" name="wsnfw_gf_condition_value_[' + id + '][' + ind + '][value]" value=""></div><div class="minus-button plus-button--small"></div></div>';

        $(this).parents('.wsnfw_condition_container').append(con);
        ind++;
    });

    $("#wsnfw_gf_sms_form").on("click", '.minus-button', function () {
        $(this).parent().remove();
    });
});

