<?php
/*
*
*	***** Whatsiplus Scheduled Notification *****
*
*	Core Functions
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

/*
*
* Custom Front End Ajax Scripts / Loads In WP Footer
*
*/

function wsnfw_frontend_enqueue_scripts() {
    wp_register_script(
		'wsnfw-inline-ajax-script',
		'', 
		array('jquery'),
		'1.0.0',
		true
	);
	

    wp_enqueue_script('wsnfw-inline-ajax-script');

    $inline_script = "
        jQuery(document).ready(function ($) {
            $('#wsnfw_custom_plugin_form').submit(function (event) {
                event.preventDefault();
                
                var myInputFieldValue = $('#myInputField').val();
                
                var data = {
                    'action': 'wsnfw_custom_plugin_frontend_ajax',
                    'myInputFieldValue': myInputFieldValue,
                };

                $.post(wsnfw_ajax.ajaxurl, data, function (response) {
                    if (response.Status == true) {
                        $('#wsnfw_custom_plugin_form_wrap').html(response);
                    } else {
                        $('#wsnfw_custom_plugin_form_wrap').html(response);
                    }
                });
            });
        });
    ";

    wp_add_inline_script('wsnfw-inline-ajax-script', $inline_script);
    
    wp_localize_script('wsnfw-inline-ajax-script', 'wsnfw_ajax', array(
        'ajaxurl' => esc_url(admin_url('admin-ajax.php'))
    ));
}
add_action('wp_enqueue_scripts', 'wsnfw_frontend_enqueue_scripts');


function wsnfw_add_scheduled_sms_postbox() {
	add_meta_box(
		'wsnfw-scheduled-sms',
		__('Scheduled WhatsApp Message', 'whatsiplus-scheduled-notification-for-woocommerce'),
		'wsnfw_add_scheduled_sms_box',
		array('product', 'lp_course'),
		'normal',
		'core'
	);
}
add_action( 'add_meta_boxes', 'wsnfw_add_scheduled_sms_postbox' );

function wsnfw_add_scheduled_sms_box() {
	$default_send_time = get_option( 'wsnfw_send_time', '16:59' );
	$p_id              = get_the_ID();
	$wsnfw_metas        = get_post_meta( $p_id, '_wsnfw_sms_metas', true ) ?? [];
	$index             = ! empty( $wsnfw_metas ) ? max( array_keys( $wsnfw_metas ) ) + 1 : 0;

	if ( get_post_type() === 'product' ) {
		$statuses = wc_get_order_statuses();
	} elseif ( get_post_type() === 'lp_course' ) {
		$statuses = learn_press_get_order_statuses();
	}

	?>
    <div id="wsnfw_scheduled_sms_container">
        <div id="wsnfw_top">
            <div id="wsnfw_add_sms"><?php esc_html_e('Add Message', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></div>
        </div>
        <div class="wsnfw-info-message">
		    <?php echo '<h4>' . esc_html__('Available Variables', 'whatsiplus-scheduled-notification-for-woocommerce') . '</h4>
                        <ul>
                          <li>' . esc_html__('Product Name: %p_name%', 'whatsiplus-scheduled-notification-for-woocommerce') . '</li>
                          <li>' . esc_html__('Product Price: %p_price%', 'whatsiplus-scheduled-notification-for-woocommerce') . '</li>
                          <li>' . esc_html__('Product Link: %p_link%', 'whatsiplus-scheduled-notification-for-woocommerce') . '</li>
                        </ul>' ?>
        </div>
        <input type="hidden" id="wsnfw_next_index" name="wsnfw_next_index" value="<?php echo esc_attr($index); ?>">
        <div id="sms_container">
			<?php if ( ! empty( $wsnfw_metas ) ) {
				foreach ( $wsnfw_metas as $i => $wsnfw_meta ) { ?>
                    <div class="sms">
                        <div class="delete">
                            <div id="delete_row_<?php echo esc_attr($i); ?>">
								<img src="<?php echo esc_url( WSNFW_CORE_IMG . 'macos-close.png' ); ?>" />	
							</div>
                        </div>
                        <div class="active">
                            <label for="wsnfw_sms_active_<?php echo esc_attr($i); ?>" class="toggle-control">
                                <input type="checkbox" id="wsnfw_sms_active_<?php echo esc_attr($i); ?>"
                                       name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][active]" <?php checked($wsnfw_meta['active'], "on"); ?>>
                                <span class="control"></span>
                            </label>
                        </div>
                        <div class="time">
                            <label for="wsnfw_sms_time_<?php echo esc_attr($i); ?>"><?php esc_html_e('Time', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                            <input type="number" min="0" class="wsnfw_time_input"
                                   name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][time]" id="wsnfw_sms_time_<?php echo esc_attr($i); ?>"
                                   value="<?php echo esc_attr($wsnfw_meta['time']); ?>">
                            <span><?php esc_html_e('days after', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></span>
                        </div>
                        <div class="order_status">
                            <label for="wsnfw_sms_order_status_<?php echo esc_attr($i); ?>"><?php esc_html_e('Order Status', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                            <select name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][order_status]"
                                    id="wsnfw_sms_order_status_<?php echo esc_attr($i); ?>">
								<?php
								foreach ( $statuses as $status => $status_name ) {
									$selected = $wsnfw_meta['order_status'] === $status ? "selected" : '';
									echo '<option value="' . esc_attr( $status ) . '"' . esc_attr($selected) . '>' . esc_html( $status_name ) . '</option>';
								}
								?>
                            </select>
                        </div>
                        <div class="hour">
                            <label for="wsnfw_sms_hour_<?php echo esc_attr($i); ?>"><?php esc_html_e('Hour', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                            <input type="text" placeholder="16:59" name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][hour]"
                                   id="wsnfw_sms_hour_<?php echo esc_attr($i); ?>"
                                   value="<?php echo esc_attr($wsnfw_meta['hour'] ?? $default_send_time); ?>">
                        </div>
                        <div class="sms_content">
                            <label for="wsnfw_sms_content_<?php echo esc_attr($i); ?>"><?php esc_html_e('Message Content', 'whatsiplus-scheduled-notification-for-woocommerce'); ?></label>
                            <textarea rows="5" cols="20" name="wsnfw_sms_meta[<?php echo esc_attr($i); ?>][content]"
                                      id="wsnfw_sms_order_content_<?php echo esc_attr($i); ?>"><?php echo esc_textarea($wsnfw_meta['content']); ?></textarea>
                        </div>
                    </div>
				<?php }
			} ?>
        </div>
    </div>
	<?php
}

add_action( 'save_post', 'wsnfw_product_sms_meta_save' );
function wsnfw_product_sms_meta_save( $post_id ) {
    if (!isset($_POST['wsnfw_sms_meta'])){
        return;
    }
	$sms_metas = isset( $_POST['wsnfw_sms_meta'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wsnfw_sms_meta'] ) ) : [];

	if ( ! empty( $sms_metas ) ) {
		update_post_meta( $post_id, '_wsnfw_sms_metas', $sms_metas );
	}
}

add_action( 'woocommerce_order_status_changed', 'wsnfw_order_status_change_happened', 10, 3 );
function wsnfw_order_status_change_happened( $order_id, $status_changed_from, $status_changed_to ) {
	$order  = wc_get_order( $order_id );
	$mobile = $order->get_billing_phone();
	if ( empty( $mobile ) ) {
		return;
	}
	foreach ( $order->get_items() as $item_id => $item ) {
		$product_id             = $item->get_product_id();
		$registered_sms_to_send = get_post_meta( $product_id, '_wsnfw_sms_metas', true );
		if ( empty( $registered_sms_to_send ) ) {
			continue;
		}
		foreach ( $registered_sms_to_send as $i => $sms_meta ) {
			if ( $sms_meta['order_status'] === 'wc-' . $status_changed_to && $sms_meta['active'] === "on" && ! empty( $sms_meta['time'] ) && ! empty( $sms_meta['content'] ) ) {
				$message              = str_replace( array(
					'%p_name%',
					'%p_price%',
					'%sitename%',
					'%p_link%',
				), array(
					$item->get_name(),
					$item->get_subtotal(),
					get_bloginfo( "name" ),
					get_permalink( $product_id )
				), $sms_meta['content'] );
				$default_hour_to_send = get_option( 'wsnfw_send_time', '16:59' );
				$hour_to_send         = $sms_meta['hour'] ?? $default_hour_to_send;
				$date_to_send = gmdate( 'Y-m-d ' . $hour_to_send, strtotime( gmdate( "Y-m-d H:i:s", strtotime( $order->get_date_modified( "Y-m-d H:i:s" ) ) ) . ' + ' . $sms_meta['time'] . ' days' ) );
				wsnfw_send_scheduled_sms( $mobile, $date_to_send, $message );
			}
		}
	}
}

add_action( 'user_register', 'wsnfw_after_user_registered', 99 );
function wsnfw_after_user_registered( $user_id ) {
	$already_sent_sms = get_user_meta( $user_id, 'wsnfw_sent_scheduled_sms_for_user', true );
	if ( ! empty( $already_sent_sms ) && $already_sent_sms === '1' ) {
		//return;
	}
	$wsnfw_active_digits          = get_option( 'wsnfw_active_digits', 'false' );
	$wsnfw_custom_phone_meta_keys = get_option( 'wsnfw_custom_phone_meta_keys', '' );
	if ( $wsnfw_active_digits === 'false' && empty( $wsnfw_custom_phone_meta_keys ) ) {
		return;
	}
	if ( $wsnfw_active_digits == 'true' ) {
		$digits_phone = get_user_meta( $user_id, 'digits_phone', true );
	} else if ( ! empty( $wsnfw_custom_phone_meta_keys ) ) {
		$digits_phone = get_user_meta( $user_id, $wsnfw_custom_phone_meta_keys, true );
	}
	if ( empty( $digits_phone ) ) {
		return;
	}
	$default_hour_to_send = get_option( 'wsnfw_send_time', '16:59' );
	$users_sms_data       = get_option( 'wsnfw_users_sms_data', [] );
	if ( empty( $users_sms_data ) ) {
		return;
	}
	$user         = get_userdata( $user_id );
	$display_name = $user->display_name;
	$user_name    = $user->user_login;
	foreach ( $users_sms_data as $user_sms_data ) {
		$message      = str_replace( array(
			'%display_name%',
			'%username%',
		), array(
			$display_name,
			$user_name,
		), $user_sms_data['content'] );
		$hour_to_send = $sms_meta['hour'] ?? $default_hour_to_send;
		$date_to_send = gmdate( 'Y-m-d ' . $hour_to_send, strtotime( gmdate( "Y-m-d H:i:s" ) . ' + ' . $user_sms_data['time'] . ' days' ) );
		wsnfw_send_scheduled_sms( $digits_phone, $date_to_send, $message );
	}
	update_user_meta( $user_id, 'wsnfw_sent_scheduled_sms_for_user', '1' );
}

add_action( 'gform_entry_created', 'wsnfw_gf_field_filled' );
function wsnfw_gf_field_filled( $entry ) {
	$gf_sms_data = get_option( 'wsnfw_gf_sms_data', [] );
	foreach ( $gf_sms_data as $sms_data ) {
		$exploded = explode( "-", $sms_data['gf_formatted_id'] );
		if ( $exploded[0] !== $entry['form_id'] ) {
			continue;
		}
		$mobile = $entry[ $exploded[1] ];
		if ( empty( $mobile ) ) {
			continue;
		}
		$result = true;
		if ( ! empty( $sms_data['condition_active'] ) && $sms_data['condition_active'] === "on" ) {
			$all_condition = $sms_data['all_or_one'];
			if ( $all_condition === 'all' ) {
				foreach ( $sms_data['condition'] as $condition ) {
					$result = wsnfw_matches_operation( $entry[ $condition['field'] ], $condition['value'], $condition['operator'] );
					if ( ! $result ) {
						break;
					}
				}
			} elseif ( $all_condition === 'any' ) {
				foreach ( $sms_data['condition'] as $condition ) {
					$result = wsnfw_matches_operation( $entry[ $condition['field'] ], $condition['value'], $condition['operator'] );
					if ( $result ) {
						break;
					}
				}
			}
		}
		if ( $result ) {
			$default_hour_to_send = get_option( 'wsnfw_send_time', '16:59' );
			$hour_to_send         = $sms_data['hour'] ?? $default_hour_to_send;
			$date_to_send = gmdate( 'Y-m-d ' . $hour_to_send, strtotime( gmdate( "Y-m-d H:i:s" ) . ' + ' . $sms_data['time'] . ' days' ) );
			wsnfw_send_scheduled_sms( $mobile, $date_to_send, $sms_data['content'] );
		}
	}
}

add_action( 'init', 'wsnfw_wc_order_actions_sms' );
function wsnfw_wc_order_actions_sms() {
	if (!function_exists('is_woocommerce')){
        return;
    }
	$wc_sms = get_option( 'wsnfw_wc_sms_data' );
	if ( $wc_sms && is_array( $wc_sms ) ) {
		foreach ( $wc_sms as $sms ) {
			if ( ! isset( $sms['active'] ) ) {
				continue;
			}
			$status = str_replace( 'wc-', '', $sms['order_status'] );
			add_action( 'woocommerce_order_status_' . $status, function ( $order_id ) use ( $sms, $status ) {
				$order  = wc_get_order( $order_id );
				$mobile = $order->get_billing_phone();
				if ( empty( $mobile ) || empty( $sms['content'] ) || empty( $sms['time'] ) ) {
					return;
				}
				$message              = str_replace( array(
					'%order_id%',
					'%sitename%',
				), array(
					$order_id,
					get_bloginfo( "name" ),
				), $sms['content'] );
				$default_hour_to_send = get_option( 'wsnfw_send_time', '16:59' );
				$hour_to_send         = $sms['hour'] ?? $default_hour_to_send;
				$date_to_send = gmdate('Y-m-d ' . $hour_to_send, strtotime($order->get_date_modified("Y-m-d H:i:s") . ' + ' . $sms['time'] . ' days'));

				wsnfw_send_scheduled_sms( $mobile, $date_to_send, $message );
			}, 10, 1 );
		}
	}
}

//add_filter('update_user_metadata', 'wsnfw_monitor_update_user_metadata',10 , 4);
function wsnfw_monitor_update_user_metadata( $check, $object_id, $meta_key, $meta_value ) {
	if ( strtolower( $meta_key !== 'digits_phone' ) ) {
		return $check;
	}
	$wsnfw_active_digits = get_option( 'wsnfw_active_digits', 'false' );
	if ( $wsnfw_active_digits === 'false' ) {
		return $check;
	}
	$default_hour_to_send = get_option( 'wsnfw_send_time', '16:59' );
	$mobile               = $meta_value;
	$users_sms_data       = get_option( 'wsnfw_users_sms_data', [] );
	$user                 = get_userdata( $object_id );
	$display_name         = $user->display_name;
	$user_name            = $user->user_login;
	foreach ( $users_sms_data as $user_sms_data ) {
		$message      = str_replace( array(
			'%display_name%',
			'%username%',
		), array(
			$display_name,
			$user_name,
		), $user_sms_data['content'] );
		$hour_to_send = $sms_meta['hour'] ?? $default_hour_to_send;
		$date_to_send = gmdate('Y-m-d ' . $hour_to_send, strtotime(gmdate("Y-m-d H:i:s") . ' + ' . $user_sms_data['time'] . ' days'));

		wsnfw_send_scheduled_sms( $mobile, $date_to_send, $message );
	}

	return $check;
}

add_action( 'learn-press/order/status-changed', 'wsnfw_order_lms_changed_status', 10, 3 );
function wsnfw_order_lms_changed_status( $order_id, $old_status, $new_status ) {
	$order = learn_press_get_order( $order_id );
    $user_id = $order->get_user_id();
	
	// Sanitize and retrieve custom phone meta keys
	$wsnfw_custom_phone_meta_keys = sanitize_text_field( get_option( 'wsnfw_custom_phone_meta_keys', '' ) );
	$mobile = sanitize_text_field( get_user_meta( $user_id, $wsnfw_custom_phone_meta_keys, true ) );
	
	if ( empty( $mobile ) ) {
		return;
	}
	
	foreach ( $order->get_items() as $item_id => $item ) {
		$product_id = absint( $item['course_id'] );
		
		// Get registered SMS to send, sanitize post meta data
		$registered_sms_to_send = get_post_meta( $product_id, '_wsnfw_sms_metas', true );
		$registered_sms_to_send = array_map( 'sanitize_text_field', $registered_sms_to_send );
		
		if ( empty( $registered_sms_to_send ) ) {
			continue;
		}
		
		foreach ( $registered_sms_to_send as $i => $sms_meta ) {
			// Check the new order status, SMS active status, and required fields
			if ( $sms_meta['order_status'] === 'lp-' . $new_status && $sms_meta['active'] === 'on' && !empty( $sms_meta['time'] ) && !empty( $sms_meta['content'] ) ) {
				
				// Replace placeholders with actual data
				$message = str_replace(
					array(
						'%p_name%',
						'%p_price%',
						'%sitename%',
						'%p_link%',
					),
					array(
						esc_html( $item['name'] ),
						esc_html( $item['subtotal'] ),
						esc_html( get_bloginfo( 'name' ) ),
						esc_url( get_permalink( $product_id ) ),
					),
					$sms_meta['content']
				);
				
				// Get the time to send the SMS
				$default_hour_to_send = sanitize_text_field( get_option( 'wsnfw_send_time', '16:59' ) );
				$hour_to_send = sanitize_text_field( $sms_meta['hour'] ?? $default_hour_to_send );
				$date_to_send = gmdate('Y-m-d ' . $hour_to_send, strtotime(gmdate('Y-m-d H:i:s', strtotime($order->get_date_modified('Y-m-d H:i:s'))) . ' + ' . intval($sms_meta['time']) . ' days'));				
				// Send the SMS
				wsnfw_send_scheduled_sms( $mobile, $date_to_send, esc_html( $message ) );
			}
		}
	}
}
