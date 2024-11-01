<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

function wsnfw_check_if_credentials_is_valid( $api_key1, $country_code1 ) {
	$url = "https://api.whatsiplus.com/serviceSettings/{$api_key1}?countryCode={$country_code1}";
    
    $response = wp_remote_get( $url );

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( isset($data['status']) && $data['status'] === 'true' ) {
        return true;
    }

    return false;
}

function wsnfw_send_scheduled_sms( $mobile, $date_to_send, $message ) {
    
    $timezone = wp_timezone_string();

    if (!$timezone || !preg_match('/^[+-](?:2[0-3]|[01][0-9]):[0-5][0-9]$/', $timezone)) {
        $timezone = 'UTC'; 
    }

    try {
        $date = new DateTime($date_to_send, new DateTimeZone($timezone));
    } catch (Exception $e) {
        die('Invalid date format: ' . $e->getMessage());
    }

    $date->setTimezone(new DateTimeZone('UTC'));
    $timestamp = $date->getTimestamp();

    $api_key = get_option( 'wsnfw_uname', '' );
    if ( empty( $api_key ) || empty( $message ) ) {
        return false;
    }

    $url = "https://api.whatsiplus.com/sendMsg/{$api_key}";

    $body = array(
        'phonenumber' => $mobile,
        'message'     => $message,
        'schedule'    => $timestamp
    );

    $response = wp_remote_post( $url, array(
        'body'    => $body,
        'headers' => array(
            'User-Agent' => 'Apidog/1.0.0 (https://apidog.com)',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
        'timeout' => 10,
        'sslverify' => false,
    ));

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $response_body = wp_remote_retrieve_body( $response );
    $data = json_decode( $response_body, true );

    if ( isset($data['success']) && $data['success'] === 'true' ) {
        return true;
    }

    return false;
}
