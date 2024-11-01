jQuery(document).ready(function($){
    "use strict";

    var order_stauses = wsnfw_data.order_statuses;
    var order_statuses_option = '';
    for (var key in order_stauses) {
        if (order_stauses.hasOwnProperty(key)) {
            order_statuses_option += '<option value="' + key + '">' + order_stauses[key] + '</option>';
        }
    }

    var sms_container = $('#sms_container');
    var add_sms = $('#wsnfw_add_sms');
    var next_index = $('#wsnfw_next_index').val();
    add_sms.click(function (){
        var row = '<div class="sms">';
        row += '<div class="delete"><div id="delete_row_' + next_index + '"><img src="' + wsnfw_data.delete_button +'"></div></div>';
        row += '<div class="active"><label for="wsnfw_sms_active_' + next_index + '" class="toggle-control"><input type="checkbox" id="wsnfw_sms_active_' + next_index + '" name="wsnfw_sms_meta[' + next_index + '][active]"><span class="control"></span></label></div>';
        row += '<div class="time"><label for="wsnfw_sms_time_' + next_index + '">' + wsnfw_data.time_label + '</label><input type="number" min="0" class="wsnfw_time_input" name="wsnfw_sms_meta[' + next_index + '][time]" id="wsnfw_sms_time_' + next_index + '"><span>' + wsnfw_data.days_after + '</span></div>';
        row += '<div class="order_status">\n' +
            '                   <label for="wsnfw_sms_order_status_' + next_index + '">' + wsnfw_data.order_status + '</label>\n' +
            '                   <select name="wsnfw_sms_meta[' + next_index + '][order_status]" id="wsnfw_sms_order_status_' + next_index + '">' + order_statuses_option + '</select></div>';
        row += '<div class="hour"><label for="wsnfw_sms_hour_' + next_index + '">' + wsnfw_data.hour_label + '</label><input type="text" placeholder="16:59" name="wsnfw_sms_meta[' + next_index + '][hour]" id="wsnfw_sms_hour_' + next_index + '"></div>';
        row += '<div class="sms_content"><label for="wsnfw_sms_content_' + next_index + '">' + wsnfw_data.content_label + '</label><textarea rows="5" cols="20" name="wsnfw_sms_meta[' + next_index + '][content]" id="wsnfw_sms_order_content_' + next_index + '"></textarea></div>';
        row += '</div>';
        sms_container.append(row);
        next_index++;
    });

    $('#sms_container').on('click', '.sms .delete > div', function () {
        if (confirm(wsnfw_data.delete_confirm)) {
            $(this).parents(".sms").remove();
        } else {
            return;
        }
    });
});
