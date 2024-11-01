<?php
/*
*
*    ***** Whatsiplus Scheduled Notification *****
*
*    Ajax Requests
*    
*/
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Handle the saving of credentials via AJAX.
 */
add_action( 'wp_ajax_wsnfw_save_credentials', 'wsnfw_ajax_save_credentials' );
add_action( 'wp_ajax_nopriv_wsnfw_save_credentials', 'wsnfw_ajax_save_credentials' );
function wsnfw_ajax_save_credentials() {
    $api_key     = isset( $_POST['username'] ) ? sanitize_text_field( wp_unslash( $_POST['username'] ) ) : '';
    $country_code = isset( $_POST['password'] ) ? sanitize_text_field( wp_unslash( $_POST['password'] ) ) : '';
    $sender      = isset( $_POST['sender'] ) ? sanitize_text_field( wp_unslash( $_POST['sender'] ) ) : '';
    $send_time   = isset( $_POST['send_time'] ) ? sanitize_text_field( wp_unslash( $_POST['send_time'] ) ) : '';    

    if ( empty( $api_key ) || empty( $send_time ) ) {
        wp_send_json_error( __( 'Please complete all fields.', 'whatsiplus-scheduled-notification-for-woocommerce' ) );
    }

    $credentials_is_valid = wsnfw_check_if_credentials_is_valid( $api_key, $country_code );
    if ( ! $credentials_is_valid ) {
        wp_send_json_error( __( 'The API key is invalid.', 'whatsiplus-scheduled-notification-for-woocommerce' ) );
    }

    update_option( 'wsnfw_uname', $api_key );
    update_option( 'wsnfw_pass', $country_code );
    update_option( 'wsnfw_sender', $sender );
    update_option( 'wsnfw_send_time', $send_time );

    wp_send_json_success();
}

/**
 * Handle the saving of WooCommerce SMS data via AJAX.
 */
add_action( 'wp_ajax_wsnfw_save_wc_sms_data', 'wsnfw_save_wc_sms_data' );
add_action( 'wp_ajax_nopriv_wsnfw_save_wc_sms_data', 'wsnfw_save_wc_sms_data' );
function wsnfw_save_wc_sms_data() {
    $sms_data = isset( $_POST['sms_data'] ) ? sanitize_text_field( wp_unslash( $_POST['sms_data'] ) ) : '';

    $so_tmp = [];

    foreach ( $sms_data as $i => $data ) {
        preg_match_all( '!\d+!', $data['name'], $match_id );
        preg_match_all( "/\[([^\]]*)\]/", $data['name'], $match_name );
        $so_tmp[ $match_id[0][0] ][ $match_name[1][1] ] = $data['value'];
    }

    update_option( 'wsnfw_wc_sms_data', $so_tmp );
    wp_send_json_success();
}

/**
 * Handle the saving of users SMS data via AJAX.
 */
add_action( 'wp_ajax_wsnfw_save_users_sms_data', 'wsnfw_save_users_sms_data' );
add_action( 'wp_ajax_nopriv_wsnfw_save_users_sms_data', 'wsnfw_save_users_sms_data' );
function wsnfw_save_users_sms_data() {
    $sms_data = isset( $_POST['sms_data'] ) ? sanitize_text_field( wp_unslash($_POST['sms_data']) ) : '';
    $so_tmp = [];

    foreach ( $sms_data as $i => $data ) {
        preg_match_all( '!\d+!', $data['name'], $match_id );
        preg_match_all( "/\[([^\]]*)\]/", $data['name'], $match_name );
        $so_tmp[ $match_id[0][0] ][ $match_name[1][1] ] = $data['value'];
    }

    update_option( 'wsnfw_users_sms_data', $so_tmp );
    wp_send_json_success();
}

/**
 * Handle the saving of user settings via AJAX.
 */
add_action( 'wp_ajax_wsnfw_save_users_settings', 'wsnfw_save_users_settings' );
add_action( 'wp_ajax_nopriv_wsnfw_save_users_settings', 'wsnfw_save_users_settings' );
function wsnfw_save_users_settings() {
    update_option( 'wsnfw_active_digits', isset( $_POST['wsnfw_active_digits'] ) ? sanitize_text_field( wp_unslash($_POST['wsnfw_active_digits']) ) : '' );
    update_option( 'wsnfw_custom_phone_meta_keys', isset( $_POST['wsnfw_custom_phone_meta_keys'] ) ? sanitize_text_field( wp_unslash($_POST['wsnfw_custom_phone_meta_keys']) ) : '' );
    wp_send_json_success();
}

/**
 * Handle the saving of Gravity Forms SMS data via AJAX.
 */
add_action( 'wp_ajax_wsnfw_save_gf_sms_data', 'wsnfw_save_gf_sms_data' );
add_action( 'wp_ajax_nopriv_wsnfw_save_gf_sms_data', 'wsnfw_save_gf_sms_data' );
function wsnfw_save_gf_sms_data() {
    $sms_data = isset( $_POST['sms_data'] ) ? sanitize_text_field( wp_unslash($_POST['sms_data'] )) : '';

    $so_tmp = [];

    foreach ( $sms_data as $i => $data ) {
        preg_match_all( '!\d+!', $data['name'], $match_id );
        preg_match_all( "/\[([^\]]*)\]/", $data['name'], $match_name );
        if ( ! empty( $data['value'] ) ) {
            if ( isset( $match_id[0][1] ) ) {
                $so_tmp[ $match_id[0][0] ]['condition'][ $match_id[0][1] ][ $match_name[1][2] ] = $data['value'];
            } else {
                $so_tmp[ $match_id[0][0] ][ $match_name[1][1] ] = $data['value'];
            }
        }
    }

    update_option( 'wsnfw_gf_sms_data', $so_tmp );
    wp_send_json_success();
}