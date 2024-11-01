<?php
/*
*
*	***** Whatsiplus Scheduled Notification *****
*
*	This file initializes all WSNFW Core components
*	
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Define WSNFW Constants
define( 'WSNFW_CORE_INC', dirname( __FILE__ ) . '/inc/' );
define( 'WSNFW_CORE_IMG', plugins_url( 'assets/img/', __FILE__ ) );
define( 'WSNFW_CORE_CSS', plugins_url( 'assets/css/', __FILE__ ) );
define( 'WSNFW_CORE_JS', plugins_url( 'assets/js/', __FILE__ ) );
/*
*
*  Register CSS
*
*/
function wsnfw_register_core_css( $page ) {
	if ( $page === 'toplevel_page_whatsiplus_schedule' ) {
		wp_enqueue_style( 'wsnfw-settings', WSNFW_CORE_CSS . 'wsnfw-settings.css', null, '0.0.1', 'all' );
		wp_enqueue_style( 'select2css', WSNFW_CORE_CSS . 'select2.min.css', false, '1.0', 'all' );
	}
	if ( get_post_type() === 'product' || get_post_type() === 'lp_course' ) {
		wp_enqueue_style( 'wsnfw-core', WSNFW_CORE_CSS . 'wsnfw-core.css', null, '0.0.1', 'all' );
	}
}

;
add_action( 'admin_enqueue_scripts', 'wsnfw_register_core_css' );
/*
*
*  Register JS/Jquery Ready
*
*/
function wsnfw_register_core_js( $page ) {
		if ( $page === 'toplevel_page_whatsiplus_schedule' ) {
			wp_enqueue_script( 'jquery-validate', WSNFW_CORE_JS . 'jquery.validate.min.js', [ 'jquery' ], '0.0.1', true );
			wp_enqueue_script( 'select2', WSNFW_CORE_JS . 'select2.min.js', array( 'jquery-validate' ), '1.0', true );
			wp_enqueue_script( 'wsnfw-settings', WSNFW_CORE_JS . 'wsnfw-settings.js', [ 'jquery' ], '0.0.1', true );
			
			if ( function_exists( 'wc_get_order_statuses' ) ) {
				$wsnfw_data = [
					'delete_button'      => WSNFW_CORE_IMG . 'macos-close.png',
					'order_statuses' =>     wc_get_order_statuses(),
					'save_success'    => __( 'Information saved successfully', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'time_label'         => __( 'Time', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'days_after'         => __( 'days after', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'order_status'       => __( 'Order Status', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'hour_label'         => __( 'Hour', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'content_label'      => __( 'Message Content', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'conditional_logic'  => __( 'Conditional Logic', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'all_option'         => __( 'All', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'any_option'         => __( 'At least one', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'send_whatsapp_message_if' => __( 'Send WhatsApp message if', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'if'                => __( 'If', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'enter_value'       => __( 'Enter a value', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'is'                => __( 'is', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'isnot'             => __( 'is not', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'greater_than'      => __( 'greater than', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'less_than'         => __( 'less than', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'contains'          => __( 'contains', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'starts_with'       => __( 'starts with', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'ends_with'         => __( 'ends with', 'whatsiplus-scheduled-notification-for-woocommerce' ),
				];
			 }
			 else
			 {
				$wsnfw_data = [
					'delete_button'      => WSNFW_CORE_IMG . 'macos-close.png',
					'save_success'    => __( 'Information saved successfully', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'time_label'         => __( 'Time', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'days_after'         => __( 'days after', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'order_status'       => __( 'Order Status', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'hour_label'         => __( 'Hour', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'content_label'      => __( 'Message Content', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'conditional_logic'  => __( 'Conditional Logic', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'all_option'         => __( 'All', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'any_option'         => __( 'At least one', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'send_whatsapp_message_if' => __( 'Send WhatsApp message if', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'if'                => __( 'If', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'enter_value'       => __( 'Enter a value', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'is'                => __( 'is', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'isnot'             => __( 'is not', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'greater_than'      => __( 'greater than', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'less_than'         => __( 'less than', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'contains'          => __( 'contains', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'starts_with'       => __( 'starts with', 'whatsiplus-scheduled-notification-for-woocommerce' ),
					'ends_with'         => __( 'ends with', 'whatsiplus-scheduled-notification-for-woocommerce' ),
				];
			 }
			wp_localize_script( 'wsnfw-settings', 'wsnfw_settings_info', $wsnfw_data );
		}
	
	
	if ( get_post_type() === 'product' || get_post_type() === 'lp_course' ) {
		wp_register_script( 'wsnfw-core', WSNFW_CORE_JS . 'wsnfw-core.js', array('jquery'), time(), true );
		
		$translated_texts = array(
			'delete_confirm' => __( 'Are you sure?', 'whatsiplus-scheduled-notification-for-woocommerce' ),
			'time_label'     => __( 'Time', 'whatsiplus-scheduled-notification-for-woocommerce' ),
			'days_after'     => __( 'days after', 'whatsiplus-scheduled-notification-for-woocommerce' ),
			'order_status'   => __( 'Order Status', 'whatsiplus-scheduled-notification-for-woocommerce' ),
			'hour_label'     => __( 'Hour', 'whatsiplus-scheduled-notification-for-woocommerce' ),
			'content_label'  => __( 'Message Content', 'whatsiplus-scheduled-notification-for-woocommerce' ),
		);

		
		
		wp_localize_script( 'wsnfw-settings', 'wsnfw_settings_info', $wsnfw_settings_info );

		$wsnfw_data = [
			'delete_button'  => WSNFW_CORE_IMG . 'macos-close.png',
		];
		if (get_post_type() === 'product'){
			$wsnfw_data['order_statuses'] = wc_get_order_statuses();
		}elseif (get_post_type() === 'lp_course'){
			$wsnfw_data['order_statuses'] = learn_press_get_order_statuses();
		}
		
		// Combine translated texts with other data
		$wsnfw_data = array_merge( $wsnfw_data, $translated_texts );
		
		// Localize the script with combined data
		wp_localize_script( 'wsnfw-core', 'wsnfw_data', $wsnfw_data );
		
		// Enqueue the script
		wp_enqueue_script( 'wsnfw-core' );
	}
}

function learn_press_get_order_statuses( $prefix = true, $status_only = false ) {
	_deprecated_function( __FUNCTION__, '4.2.0' );
	$register_statues = learn_press_get_register_order_statuses();

	if ( ! $prefix ) {
		$order_statuses = array();
		foreach ( $register_statues as $k => $v ) {
			$k                    = preg_replace( '~^lp-~', '', $k );
			$order_statuses[ $k ] = $v;
		}
	} else {
		$order_statuses = $register_statues;
	}

	$order_statuses = wp_list_pluck( $order_statuses, 'label' );

	if ( $status_only ) {
		$order_statuses = array_keys( $order_statuses );
	}

	$order_statuses = apply_filters( 'learn_press_order_statuses', $order_statuses );

	return apply_filters( 'learn-press/order-statues', $order_statuses );
}

add_action( 'admin_enqueue_scripts', 'wsnfw_register_core_js' );

/*
*
*  Includes
*
*/
// Load the sms api
require_once WSNFW_CORE_INC . 'wsnfw-sms-api.php';
// Load the admin settings
require_once WSNFW_CORE_INC . 'wsnfw-settings.php';
// Load the Functions
require_once WSNFW_CORE_INC . 'wsnfw-core-functions.php';
// Load the ajax Request
require_once WSNFW_CORE_INC . 'wsnfw-ajax-request.php';