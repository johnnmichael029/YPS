<?php
/**
 * YPS Gaming - Order Controller
 */

if (!defined('ABSPATH')) exit;

class YPS_Order_Controller {

    public static function init() {
        // AJAX Hooks for Booking & Tracking
        add_action('wp_ajax_yps_submit_booking', array(__CLASS__, 'handle_submit_booking'));
        add_action('wp_ajax_nopriv_yps_submit_booking', array(__CLASS__, 'handle_submit_booking'));

        add_action('wp_ajax_yps_track_order', array(__CLASS__, 'handle_track_order'));
        add_action('wp_ajax_nopriv_yps_track_order', array(__CLASS__, 'handle_track_order'));

        add_action('wp_ajax_yps_update_order_status', array(__CLASS__, 'handle_update_status'));

        add_action('wp_ajax_yps_assign_pilot', array(__CLASS__, 'handle_assign_pilot'));
    }

    /**
     * Submit Booking Handler
     */
    public static function handle_submit_booking() {
        check_ajax_referer('yps_nonce', 'nonce');

        $result = YPS_Order_Model::create_order($_POST);

        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        } else {
            wp_send_json_success(array(
                'message'  => 'Booking submitted successfully!',
                'order_id' => $result['order_number'],
            ));
        }
    }

    /**
     * Track Order Handler
     */
    public static function handle_track_order() {
        $order_id = sanitize_text_field($_POST['order_id'] ?? '');
        $email    = sanitize_email($_POST['email'] ?? '');

        if (empty($order_id)) {
            wp_send_json_error(array('message' => 'Please enter an Order ID.'));
        }

        $order = YPS_Order_Model::get_order_by_number($order_id);

        if ($order) {
            $post_id     = $order->ID;
            $needs_quote = get_post_meta($post_id, 'yps_needs_quote', true);
            $amount      = get_post_meta($post_id, 'yps_amount', true);
            $progress    = get_post_meta($post_id, 'yps_current_progress', true);

            wp_send_json_success(array(
                'order_id'         => get_post_meta($post_id, 'yps_order_id', true),
                'game'             => get_post_meta($post_id, 'yps_game', true),
                'service'          => get_post_meta($post_id, 'yps_service', true),
                'pilot'            => get_post_meta($post_id, 'yps_pilot', true),
                'status'           => get_post_meta($post_id, 'yps_status', true),
                'start_date'       => get_post_meta($post_id, 'yps_start_date', true),
                'est_completion'   => get_post_meta($post_id, 'yps_est_completion', true),
                'needs_quote'      => $needs_quote,
                'amount'           => $amount,
                'current_progress' => $progress,
            ));
        } else {
            wp_send_json_error(array('message' => 'Order not found. Please check your Order ID.'));
        }
    }

    /**
     * Update Status Handler (Admin, Staff & Pilot RBAC restricted)
     */
    public static function handle_update_status() {
        check_ajax_referer('yps_nonce', 'nonce');

        if (!YPS_RBAC::can_manage_orders() && !current_user_can('update_assigned_orders')) {
            wp_send_json_error(array('message' => 'Unauthorized user.'));
        }

        $post_id    = intval($_POST['post_id'] ?? 0);
        $new_status = sanitize_text_field($_POST['status'] ?? '');

        if ($post_id > 0 && !empty($new_status)) {
            $updated = YPS_Order_Model::update_status($post_id, $new_status);
            if ($updated !== false) {
                wp_send_json_success(array('message' => 'Status updated successfully!'));
            } else {
                wp_send_json_error(array('message' => 'Failed to update status.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Invalid parameters.'));
        }
    }

    /**
     * Assign Pilot Handler (Admin & Staff Managers)
     */
    public static function handle_assign_pilot() {
        check_ajax_referer('yps_nonce', 'nonce');

        if (!YPS_RBAC::can_manage_orders() && !current_user_can('assign_yps_pilots')) {
            wp_send_json_error(array('message' => 'Unauthorized user.'));
        }

        $post_id = intval($_POST['post_id'] ?? 0);
        $pilot   = sanitize_text_field($_POST['pilot'] ?? '');

        if ($post_id <= 0 || get_post_type($post_id) !== 'yps_order') {
            wp_send_json_error(array('message' => 'Invalid order.'));
        }

        $valid = array_merge(array('Unassigned'), yps_get_pilot_names());
        if (!in_array($pilot, $valid, true)) {
            wp_send_json_error(array('message' => 'Unknown pilot.'));
        }

        YPS_Order_Model::assign_pilot($post_id, $pilot);

        // Assigning a pilot to a pending order confirms it
        $status = get_post_meta($post_id, 'yps_status', true) ?: 'pending';
        if ($pilot !== 'Unassigned' && $status === 'pending') {
            YPS_Order_Model::update_status($post_id, 'confirmed');
            $status = 'confirmed';
        }

        wp_send_json_success(array(
            'message' => 'Pilot assigned.',
            'pilot'   => $pilot,
            'status'  => $status,
        ));
    }
}

YPS_Order_Controller::init();
