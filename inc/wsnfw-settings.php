<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'admin_menu', 'wsnfw_add_credentials_menu' );
function wsnfw_add_credentials_menu() {
	add_menu_page(
		'Whatsiplus Schedule',
		'Whatsi Schedule',
		'manage_options',
		'whatsiplus_schedule',
		'wsnfw_admin_settings_page2',
		WSNFW_CORE_IMG . 'logo.png'
	);
}

function wsnfw_admin_settings_page2() {
	$api_key                = get_option( 'wsnfw_uname', '' );
	$country_code           = get_option( 'wsnfw_pass', '' );
	$sender                 = get_option( 'wsnfw_sender', '' );
	$wsnfw_send_time         = get_option( 'wsnfw_send_time', '16:59' );
	$digits_installed       = function_exists( 'digit_ready' );
	$gravityForms_installed = class_exists( 'GFForms' );
	$ticket = '<p>' . esc_html__( 'If you want to use the plugin, you need to have an API key.', 'whatsiplus-scheduled-notification-for-woocommerce') . '</p>
    <p>' . esc_html__( 'You can do this by creating a user account.', 'whatsiplus-scheduled-notification-for-woocommerce') . '</p>
    <p>' . esc_html__( 'Creating an account is free and you can use all services for unlimited use for 5 days.', 'whatsiplus-scheduled-notification-for-woocommerce') . '</p>';
	?>
    <section class="wrapper">
        <div id="wsnfw_header">
            <div>
            <a href="<?php echo esc_url( 'https://whatsiplus.ir' ); ?>" target="_blank">
            <img src="<?php echo esc_url( WSNFW_CORE_IMG . 'logo-1.png' ); ?>" 
                alt="<?php echo esc_attr( 'وب سرویس واتساپ برای ارسال پیام' ); ?>">
            </a>

            </div>
	        <?php
	        if ( wsnfw_check_if_credentials_is_valid( $api_key, $country_code ) ) {
		        if ( ! empty( $api_key ) ) {
			        ?>
		        <?php }
	        }
	        ?>
        </div>
            <?php
            ?>
            <?php if ( ! get_option( 'wsnfw_ticket_send' ) ) { ?>
            <div class="wsnfw_notice">
            <p>
            <?php
                $whatsiplus_url = esc_url( __( 'https://whatsiplus.com/', 'whatsiplus-scheduled-notification-for-woocommerce' ) );

                if ( get_locale() === 'fa_IR' ) {
                    $whatsiplus_url = esc_url( __( 'https://whatsiplus.ir/', 'whatsiplus-scheduled-notification-for-woocommerce' ) );
                }
            ?>
            <a href="<?php echo $whatsiplus_url; ?>" target="_blank">
                <?php esc_html_e( 'To activate the plugin, please enter your API key first.', 'whatsiplus-scheduled-notification-for-woocommerce' ); ?>
            </a>
            </p>

            </div>
            <?php } ?>
        <ul class="tabs">
        <li class="active"><?php esc_html_e('Settings', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></li>
        <li><?php esc_html_e('User Registration Settings', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></li>
        <li><?php esc_html_e('Gravity Form Settings', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></li>
        <li><?php esc_html_e('Wordpress Settings', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></li>
        </ul>
        <ul class="tab__content">
            <li class="active">
                <div class="content__wrapper">
	                <?php if ( wsnfw_check_if_credentials_is_valid( $api_key, $country_code ) ) {
		                if ( ! get_option( 'wsnfw_ticket_send' ) ) {
			                ?>
                            <form method="post" action="" class="activate_plugin">
                                <div class="wsnfw-info-message digits_pattern_info">
					                <?php echo wp_kses_post( $ticket ); ?>
                                    <?php
                                    $panel_url = esc_url( __( 'https://panel.whatsiplus.com/', 'whatsiplus-scheduled-notification-for-woocommerce' ) );

                                    if ( get_locale() === 'fa_IR' ) {
                                        $panel_url = esc_url( __( 'https://panel.whatsiplus.ir/', 'whatsiplus-scheduled-notification-for-woocommerce' ) );
                                    }
                                    ?>

                                    <h3>
                                        <a href="<?php echo $panel_url; ?>" target="_blank">
                                            <?php esc_html_e( 'Sign up and get your API key', 'whatsiplus-scheduled-notification-for-woocommerce' ); ?>
                                        </a>
                                    </h3>
                                </div>
                            </form>
			                <?php
		                }
	                } ?>
                    <form id="wsnfw_settings_form" class="wsnfw_form form-style-2">
                    <label for="wsnfw_uname">
                        <span class="label">
                            <?php esc_html_e('Whatsiplus API Key', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                            <span class="required">*</span>
                        </span>
                        <input type="text" class="input-field" id="wsnfw_uname" name="wsnfw_uname"
                            value="<?php echo esc_attr($api_key); ?>">
                    </label>
                    <br><br>
                    <label for="wsnfw_pass">
                        <span class="label">
                            <?php esc_html_e('Default Country Code', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                            <span></span>
                        </span>
                        <input type="text" class="input-field" id="wsnfw_pass" name="wsnfw_pass"
                            value="<?php echo esc_attr($country_code); ?>">
                    </label>
                    <br><br>
                    <label for="wsnfw_send_time">
                        <span class="label">
                            <?php esc_html_e('Default WhatsApp Send Time', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                            <span class="required">*</span>
                        </span>
                        <input type="text" class="input-field" id="wsnfw_send_time" name="wsnfw_send_time"
                            value="<?php echo esc_attr($wsnfw_send_time); ?>">
                    </label>
                    <br><br>
                    <div class="wsnfw-info-message digits_pattern_info">
                        <?php esc_html_e('The scheduled WhatsApp message plugin is also compatible with the LearnPress plugin. To view settings, please visit the edit page of each course.', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                    </div>
                    <br><br>
                    <div class="wsnfw_save_button_container">
                        <button type="submit" class="wsnfw_button" id="wsnfw_save_button">
                            <span class="button__text">
                                <?php esc_html_e('Save', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                            </span>
                        </button>
                        <div id="wsnfw-response-message" style="display: none;"></div>
                    </div>
                </form>

                </div>
            </li>
            <li>
            <div class="content__wrapper">
            <div id="wsnfw_users_plugin_settings">
                <?php
                $wsnfw_active_digits = get_option('wsnfw_active_digits', 'false');
                ?>
                <form id="wsnfw_users_settings_form" class="wsnfw_form wsnfw_form form-style-2">
                    <label for="wsnfw_active_digits" class="toggle-control">
                        <span class="label" style="padding-top: 0;">
                            <?php esc_html_e('Send WhatsApp message for Digits registration?', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                        </span>
                        <input type="checkbox" id="wsnfw_active_digits"
                            name="wsnfw_active_digits" <?php echo ($wsnfw_active_digits === 'true' && $digits_installed ? 'checked' : '');
                        echo (!$digits_installed ? ' disabled' : ''); ?>>
                        <span class="control <?php echo (!$digits_installed ? 'not-allowed' : ''); ?>"></span>
                        <?php if (!$digits_installed) { ?>
                            <div class="fsms-warning-message enter-credentials warning_phonebook">
                                <?php esc_html_e('Digits plugin is not installed', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                            </div>
                        <?php } ?>
                    </label>
                    <br><br>
                    <div class="wsnfw_form_element">
                        <label for="wsnfw_custom_phone_meta_keys">
                            <?php esc_html_e('Select Custom Mobile Number Field', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                        </label>
                        <select name="wsnfw_custom_phone_meta_keys[]" id="wsnfw_custom_phone_meta_keys" style="width: 100%;">
                            <?php
                            global $wpdb;
                            $user_meta_keys = $wpdb->get_results("SELECT DISTINCT meta_key FROM `" . $wpdb->prefix . "usermeta`");

                            $wsnfw_custom_phone_meta_keys = get_option('wsnfw_custom_phone_meta_keys', '');
                            foreach ($user_meta_keys as $user_meta_key) { ?>
                                <option value="<?php echo esc_attr($user_meta_key->meta_key); ?>" <?php echo ($wsnfw_custom_phone_meta_keys === $user_meta_key->meta_key) ? 'selected' : ''; ?>><?php echo esc_html($user_meta_key->meta_key); ?></option>
                            <?php }
                            if (!in_array($wsnfw_custom_phone_meta_keys, array_column($user_meta_keys, 'meta_key'))) { ?>
                                <option value="<?php echo esc_attr($wsnfw_custom_phone_meta_keys); ?>" selected><?php echo esc_html($wsnfw_custom_phone_meta_keys); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br><br>
                    <div class="wsnfw_save_button_container">
                        <button type="submit" class="wsnfw_button" id="wsnfw_save_users_settings_button">
                            <span class="button__text">
                                <?php esc_html_e('Save', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                            </span>
                        </button>
                        <div id="wsnfw-users-settings-response-message" style="display: none;"></div>
                    </div>
                </form>
            </div>
            <div class="wsnfw-info-message digits_pattern_info">
            <?php 
            printf(
                esc_html__('The usable variables are %1$s and %2$s', 'whatsiplus-scheduled-notification-for-woocommerce'), 
                '%display_name%', 
                '%username%' 
            ); 
            ?>
            </div>
            <div id="wsnfw_top">
                <div id="wsnfw_add_sms">
                    <?php esc_html_e('Add', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                </div>
                <div id="wsnfw_help">
                    <span class="woocommerce-help-tip" data-tip="a"></span>
                </div>
            </div>
            <div id="sms_container">
                <?php
                $users_sms_data = get_option('wsnfw_users_sms_data', []);
                $index = !empty($users_sms_data) ? (max(array_keys($users_sms_data)) + 1) : 0;
                ?>
                <input type="hidden" id="wsnfw_next_index" name="wsnfw_next_index" value="<?php echo esc_attr($index); ?>">
                <form id="wsnfw_users_form" class="wsnfw_form">
                    <?php
                    if ($users_sms_data) {
                        foreach ($users_sms_data as $i => $wsnfw_meta) { ?>
                            <div class="sms">
                                <div class="delete">
                                    <div id="delete_row_<?php echo esc_attr($i); ?>">
                                        <img src="<?php echo esc_url(WSNFW_CORE_IMG . 'macos-close.png'); ?>" alt="<?php esc_attr_e('Delete', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>" />
                                    </div>
                                </div>
                                <div class="wsnfw_active">
                                    <label for="wsnfw_sms_active_<?php echo esc_attr($i); ?>" class="toggle-control">
                                        <input class="wsnfw_inputs" type="checkbox"
                                            id="wsnfw_sms_active_<?php echo esc_attr($i); ?>"
                                            name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][active]" <?php echo ($wsnfw_meta['active_or_not'] == "on") ? "checked" : ''; ?>>
                                        <input class="wsnfw_active_hidden" type="hidden"
                                            name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][active_or_not]"
                                            value="<?php echo esc_attr($wsnfw_meta['active_or_not']); ?>">
                                        <span class="control"></span>
                                    </label>
                                </div>
                                <div class="time">
                                    <label for="wsnfw_sms_time_<?php echo esc_attr($i); ?>">
                                        <?php esc_html_e('Time', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                    </label>
                                    <input class="wsnfw_inputs" type="number" min="0" class="wsnfw_time_input"
                                        name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][time]"
                                        id="wsnfw_sms_time_<?php echo esc_attr($i); ?>"
                                        value="<?php echo esc_attr($wsnfw_meta['time']); ?>" required>
                                    <span><?php esc_html_e('days', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                                </div>
                                <div class="hour">
                                    <label for="wsnfw_sms_hour_<?php echo esc_attr($i); ?>">
                                        <?php esc_html_e('Hour', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                    </label>
                                    <input class="wsnfw_inputs" type="text" placeholder="<?php esc_attr_e('16:59', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>"
                                        name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][hour]"
                                        id="wsnfw_sms_hour_<?php echo esc_attr($i); ?>"
                                        value="<?php echo isset($wsnfw_meta['hour']) ? esc_attr($wsnfw_meta['hour']) : ''; ?>"
                                        required>
                                </div>
                                <div class="sms_content">
                                    <label for="wsnfw_sms_content_<?php echo esc_attr($i); ?>">
                                        <?php esc_html_e('Message Content', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                    </label>
                                    <textarea class="wsnfw_inputs" rows="5" cols="20"
                                            name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][content]"
                                            id="wsnfw_sms_order_content_<?php echo esc_attr($i); ?>"
                                            required><?php echo esc_html($wsnfw_meta['content']); ?></textarea>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                    <div class="wsnfw_save_button_container">
                        <button type="submit" class="wsnfw_button" id="wsnfw_save_users_button">
                            <span class="button__text">
                                <?php esc_html_e('Save', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                            </span>
                        </button>
                        <div id="wsnfw-users-response-message" style="display: none;"></div>
                    </div>
                </form>
            </div>
            </div>

            </li>
            <li>
            <div class="content__wrapper">
    <?php if ( ! $gravityForms_installed ) { ?>
        <div class="fsms-warning-message gravity_not_installed">
            <?php esc_html_e('Gravity Forms plugin is not installed. Please install the plugin to view the settings.', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
        </div>
    <?php } else { ?>
        <div id="gf_form_and_fields">
            <div id="wsnfw_gravity_forms">
                <div id="wsnfw_forms">
                    <label for="wsnfw-gravity-forms">
                        <?php esc_html_e('Select Form', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                    </label>
                    <select class="wsnfw_select2" name="wsnfw-gravity-forms" id="wsnfw-gravity-forms" style="width: 60%">
                        <?php
                        $forms = GFAPI::get_forms();
                        $forms_array = array();
                        echo "<option value='-1'></option>";
                        foreach ( $forms as $form ) {
                            echo "<option value='" . esc_attr($form['id']) . "'>" . esc_html($form['title']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div id="form_fields">
                    <label for="wsnfw-gravity-field">
                        <?php esc_html_e('Select Desired Field', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                    </label>
                    <select class="wsnfw_select2" name="wsnfw-gravity-field" id="wsnfw-gravity-field" style="width: 60%">
                        <?php
                        echo "<option value='-1'></option>";
                        foreach ( $forms as $form ) {
                            $form = GFAPI::get_form( $form['id'] );
                            if ( gettype( $form ) == "array" ) {
                                foreach ( $form['fields'] as $field ) {
                                    echo "<option value='" . esc_attr($form['id'] . '-' . $field['id']) . "'>" . esc_html($field['label']) . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="wsnfw_gf_field_registered_sms">
                <?php
                $gf_sms_data = get_option('wsnfw_gf_sms_data', []);
                $index = !empty($gf_sms_data) ? (max(array_keys($gf_sms_data)) + 1) : 0;
                ?>
                <input type="hidden" id="wsnfw_gf_next_index" name="wsnfw_next_index" value="<?php echo esc_attr($index); ?>">
                <form id="wsnfw_gf_sms_form" class="wsnfw_form">
                    <?php
                    foreach ( $forms as $form ) {
                        $form = GFAPI::get_form($form['id']);
                        if (gettype($form) == "array") {
                            foreach ($form['fields'] as $field) { ?>
                                <div class="wsnfw_show_hide_field" id="frmid-fldid_<?php echo esc_attr($form['id'] . '-' . $field['id']); ?>" style="display: none;">
                                    <div class="wsnfw_gf_add_sms wsnfw_button">
                                        <?php esc_html_e('Add', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                    </div>
                                    <?php foreach ($gf_sms_data as $i => $wsnfw_meta) {
                                        if ($wsnfw_meta['gf_formatted_id'] == $form['id'] . '-' . $field['id']) { ?>
                                            <div class="sms">
                                                <input type="hidden" name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][gf_formatted_id]" value="<?php echo esc_attr($wsnfw_meta['gf_formatted_id']); ?>">
                                                <div class="delete">
                                                    <div id="delete_row_<?php echo esc_attr($i); ?>">
                                                        <img src="<?php echo esc_url(WSNFW_CORE_IMG . 'macos-close.png'); ?>" alt="<?php esc_attr_e('Delete', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>"/>
                                                    </div>
                                                </div>
                                                <div class="wsnfw_active">
                                                    <label for="wsnfw_gf_sms_active_<?php echo esc_attr($i); ?>" class="toggle-control">
                                                        <input class="wsnfw_inputs" type="checkbox" id="wsnfw_gf_sms_active_<?php echo esc_attr($i); ?>" name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][active]" <?php checked($wsnfw_meta['active_or_not'], 'on'); ?>>
                                                        <input class="wsnfw_active_hidden" type="hidden" name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][active_or_not]" value="<?php echo esc_attr($wsnfw_meta['active_or_not']); ?>">
                                                        <span class="control"></span>
                                                    </label>
                                                </div>
                                                <div class="time">
                                                    <label for="wsnfw_gf_sms_time_<?php echo esc_attr($i); ?>">
                                                        <?php esc_html_e('Time', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                                    </label>
                                                    <input class="wsnfw_inputs wsnfw_time_input" type="number" min="0" name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][time]" id="wsnfw_gf_sms_time_<?php echo esc_attr($i); ?>" value="<?php echo esc_attr($wsnfw_meta['time']); ?>" required>
                                                    <span><?php esc_html_e('days', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                                                </div>
                                                <div class="hour">
                                                    <label for="wsnfw_gf_sms_hour_<?php echo esc_attr($i); ?>">
                                                        <?php esc_html_e('Hour', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                                    </label>
                                                    <input class="wsnfw_inputs" type="text" minlength="5" maxlength="5" placeholder="<?php esc_attr_e('16:59', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>" name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][hour]" id="wsnfw_gf_sms_hour_<?php echo esc_attr($i); ?>" value="<?php echo esc_attr($wsnfw_meta['hour'] ?? ''); ?>" required>
                                                </div>
                                                <div class="condition">
                                                    <label for="wsnfw_gf_condition_active_<?php echo esc_attr($i); ?>" class="toggle-control">
                                                        <?php esc_html_e('Conditional Logic', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                                        <input class="wsnfw_inputs wsnfw_condition_toggle" type="checkbox" id="wsnfw_gf_condition_active_<?php echo esc_attr($i); ?>" name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][condition_active]" <?php checked($wsnfw_meta['condition_active'], 'on'); ?>>
                                                        <span class="control"></span>
                                                    </label>
                                                </div>
                                                <div class="sms_content">
                                                    <label for="wsnfw_gf_sms_content_<?php echo esc_attr($i); ?>">
                                                        <?php esc_html_e('Message Content', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                                    </label>
                                                    <textarea class="wsnfw_inputs" rows="5" cols="20" name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][content]" id="wsnfw_gf_sms_order_content_<?php echo esc_attr($i); ?>" required><?php echo esc_textarea($wsnfw_meta['content']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="wsnfw_condition_container" id="wsnfw_condition_container_<?php echo esc_attr($i); ?>" style="display: none;">
                                                <div class="wsnfw_if_all_condition">
                                                    <span><?php esc_html_e('Send WhatsApp message if', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                                                    <select name="wsnfw_gf_sms_meta[<?php echo esc_attr($i); ?>][all_or_one]">
                                                        <option value="all" <?php selected($wsnfw_meta['all_or_one'], 'all'); ?>>
                                                            <?php esc_html_e('All', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                                        </option>
                                                        <option value="any" <?php selected($wsnfw_meta['all_or_one'], 'any'); ?>>
                                                            <?php esc_html_e('Any', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>
                                                        </option>
                                                    </select>
                                                    <span><?php esc_html_e('of the following conditions are met:', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                                                    <div class="plus-button plus-button--small"></div>
                                                </div>
                                                <?php foreach ($wsnfw_meta['condition'] as $j => $condition) { ?>
                                                    <div class="wsnfw_conditions">
                                                        <span><?php esc_html_e('If', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                                                        <select class="wsnfw_gf_conditional_field" name="wsnfw_gf_condition_field_[<?php echo esc_attr($i); ?>][<?php echo esc_attr($j); ?>][field]" id="wsnfw_gf_condition_field_<?php echo esc_attr($i . '_' . $j); ?>">
                                                            <?php
                                                            if (gettype($form) == "array") {
                                                                foreach ($form['fields'] as $fieldc) {
                                                                    $selected = selected($fieldc['id'], $condition['field'], false);
                                                                    echo "<option value='" . esc_attr($fieldc['id']) . "' " . esc_attr($selected) . ">" . esc_html($fieldc['label']) . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <select class="wsnfw_gf_conditional_operator" id="wsnfw_gf_condition_operator_<?php echo esc_attr($i . '_' . $j); ?>" name="wsnfw_gf_condition_operator_[<?php echo esc_attr($i); ?>][<?php echo esc_attr($j); ?>][operator]">
                                                            <option value="is" <?php selected($condition['operator'], 'is'); ?>><?php esc_html_e('Is', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></option>
                                                            <option value="isnot" <?php selected($condition['operator'], 'isnot'); ?>><?php esc_html_e('Is Not', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></option>
                                                            <option value=">" <?php selected($condition['operator'], '>'); ?>><?php esc_html_e('Greater Than', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></option>
                                                            <option value="<" <?php selected($condition['operator'], '<'); ?>><?php esc_html_e('Less Than', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></option>
                                                            <option value="contains" <?php selected($condition['operator'], 'contains'); ?>><?php esc_html_e('Contains', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></option>
                                                            <option value="starts_with" <?php selected($condition['operator'], 'starts_with'); ?>><?php esc_html_e('Starts With', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></option>
                                                            <option value="ends_with" <?php selected($condition['operator'], 'ends_with'); ?>><?php esc_html_e('Ends With', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></option>
                                                        </select>
                                                        <div id="wsnfw_gf_condition_value_<?php echo esc_attr($i . '_' . $j); ?>" style="display:inline;">
                                                            <input type="text" class="condition_field_value" style="padding:3px" placeholder="<?php esc_attr_e('Enter a value', 'whatsiplus-scheduled-notification-for-woocommerce'); ?>" id="wsnfw_gf_condition_value_<?php echo esc_attr($i . '_' . $j); ?>" name="wsnfw_gf_condition_value_[<?php echo esc_attr($i); ?>][<?php echo esc_attr($j); ?>][value]" value="<?php echo esc_attr($condition['value']); ?>">
                                                        </div>
                                                        <div class="plus-button plus-button--small minus"></div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                            <?php }
                        }
                    } ?>
                    <div class="wsnfw_save_button_container" style="margin-top: 15px;">
                        <button type="submit" class="wsnfw_button" id="wsnfw_save_gf_sms_button"><span class="button__text"><?php esc_html_e('Save', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span></button>
                        <div id="wsnfw-gf-sms-response-message" style="display: none;"></div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

            </li>
            <li>
            <div class="content__wrapper">
    <div class="wsnfw-info-message digits_pattern_info"><?php esc_html_e('To set up scheduled WooCommerce message, go to the product edit page.', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></div>
    <br><br>
    <?php if (function_exists('is_woocommerce')): ?>
        <div id="wsnfw_top_wc">
            <div id="wsnfw_add_sms_wc" class="wsnfw_btn_add"><?php esc_html_e('Add', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></div>
        </div>
        <div id="sms_container_wc">
            <?php
            $wc_sms_data = get_option('wsnfw_wc_sms_data', []);
            $index       = !empty($wc_sms_data) ? (max(array_keys($wc_sms_data)) + 1) : 0;
            $statuses    = wc_get_order_statuses();
            ?>
            <input type="hidden" id="wsnfw_next_index_wc" name="wsnfw_next_index_wc" value="<?php echo esc_attr($index); ?>">
            <div class="wsnfw-info-message digits_pattern_info"><?php esc_html_e('Available variables: %order_id%', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></div>
            <form id="wsnfw_wc_form" class="wsnfw_form">
                <?php
                if ($wc_sms_data) {
                    foreach ($wc_sms_data as $i => $wsnfw_meta) { ?>
                        <div class="sms">
                            <div class="delete">
                                <div id="delete_row_<?php echo esc_attr($i); ?>">
                                    <img src="<?php echo esc_url(WSNFW_CORE_IMG . 'macos-close.png'); ?>" />
                                </div>
                            </div>
                            <div class="wsnfw_active">
                                <label for="wsnfw_wc_sms_active_<?php echo esc_attr($i); ?>" class="toggle-control">
                                    <input class="wsnfw_inputs" type="checkbox"
                                           id="wsnfw_wc_sms_active_<?php echo esc_attr($i); ?>"
                                           name="wsnfw_wc_sms_meta[<?php echo esc_attr($i); ?>][active]"
                                           <?php checked($wsnfw_meta['active_or_not'], 'on'); ?>>
                                    <input class="wsnfw_wc_active_hidden" type="hidden"
                                           name="wsnfw_wc_sms_meta[<?php echo esc_attr($i); ?>][active_or_not]"
                                           value="<?php echo esc_attr($wsnfw_meta['active_or_not']); ?>">
                                    <span class="control"></span>
                                </label>
                            </div>
                            <div class="time">
                                <label for="wsnfw_wc_sms_time_<?php echo esc_attr($i); ?>"><?php esc_html_e('Time', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                                <input class="wsnfw_inputs" type="number" min="0" class="wsnfw_time_input"
                                       name="wsnfw_wc_sms_meta[<?php echo esc_attr($i); ?>][time]"
                                       id="wsnfw_wc_sms_time_<?php echo esc_attr($i); ?>"
                                       value="<?php echo esc_attr($wsnfw_meta['time']); ?>" required>
                                <span><?php esc_html_e('days', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                            </div>
                            <div class="order_status">
                                <label for="wsnfw_sms_order_status_<?php echo esc_attr($i); ?>"><?php esc_html_e('Order Status', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                                <select name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][order_status]"
                                        id="wsnfw_sms_order_status_<?php echo esc_attr($i); ?>">
                                    <?php
                                    foreach ($statuses as $status => $status_name) {
                                        $selected = $wsnfw_meta['order_status'] === $status ? 'selected' : '';
                                        echo '<option value="' . esc_attr($status) . '"' . $selected . '>' . esc_html($status_name) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="hour">
                                <label for="wsnfw_wc_sms_hour_<?php echo esc_attr($i); ?>"><?php esc_html_e('Hour', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                                <input class="wsnfw_inputs" type="text" placeholder="16:59"
                                       name="wsnfw_wc_sms_meta[<?php echo esc_attr($i); ?>][hour]"
                                       id="wsnfw_wc_sms_hour_<?php echo esc_attr($i); ?>"
                                       value="<?php echo esc_attr(isset($wsnfw_meta['hour']) ? $wsnfw_meta['hour'] : ''); ?>"
                                       required>
                            </div>
                            <div class="sms_content">
                                <label for="wsnfw_wc_sms_content_<?php echo esc_attr($i); ?>"><?php esc_html_e('Message Content', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                                <textarea class="wsnfw_inputs" rows="5" cols="20"
                                          name="wsnfw_wc_sms_meta[<?php echo esc_attr($i); ?>][content]"
                                          id="wsnfw_wc_sms_order_content_<?php echo esc_attr($i); ?>"
                                          required><?php echo esc_textarea($wsnfw_meta['content']); ?></textarea>
                            </div>
                        </div>
                    <?php }
                }
                ?>
                <div class="wsnfw_save_button_container_wc">
                    <button type="submit" class="wsnfw_button" id="wsnfw_save_wc_button">
                        <span class="button__text"><?php esc_html_e('Save', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                    </button>
                    <div id="wsnfw-wc-response-message" style="display: none;"></div>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="fsms-warning-message gravity_not_installed"><?php esc_html_e('WooCommerce plugin is not installed. Please install this plugin to view settings.', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></div>
    <?php endif; ?>
</div>
            </li>
        </ul>
    </section>
	<?php
}

