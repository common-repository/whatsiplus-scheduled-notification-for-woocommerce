<?php
/*
Plugin Name: Whatsiplus Scheduled Notification for Woocommerce
Plugin URI: https://whatsiplus.com/
Description: With this plugin, you can send scheduled WhatsApp messages to WooCommerce products or gravity form fields.
Version: 1.0.0
Author: Whatsiplus
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: whatsiplus-scheduled-notification-for-woocommerce
Domain Path: /languages
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

function wsnfw_load_textdomain() {
    load_plugin_textdomain(
        'whatsiplus-scheduled-notification-for-woocommerce', // Text Domain
        null, // Use the default location for the language files
        basename( dirname( __FILE__ ) ) . '/languages' // Path to the language files
    );
}
add_action( 'plugins_loaded', 'wsnfw_load_textdomain' );


// بارگذاری فایل‌های اصلی افزونه
require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
