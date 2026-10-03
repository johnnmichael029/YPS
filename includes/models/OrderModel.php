<?php
/**
 * YPS Gaming - Order Model
 */

if (!defined('ABSPATH')) exit;

class YPS_Order_Model {

    /**
     * Create a new order post & post meta
     */
    public static function create_order($data) {
        $game     = sanitize_text_field($data['game'] ?? '');
        $service  = sanitize_text_field($data['service'] ?? '');
        $name     = sanitize_text_field($data['name'] ?? '');
        $email    = sanitize_email($data['email'] ?? '');
        $customer_id = get_current_user_id();

        if (empty($game) || empty($service) || empty($name) || empty($email)) {
            return new WP_Error('missing_fields', 'Please fill all required fields.');
        }

        $order_num = 'YPS' . strtoupper(substr(md5(time() . $email), 0, 8));

        $order_id = wp_insert_post(array(
            'post_type'   => 'yps_order',
            'post_title'  => $order_num,
            'post_status' => 'publish',
            'meta_input'  => array(
                'yps_order_id'       => $order_num,
                'yps_game'           => $game,
                'yps_service'        => $service,
                'yps_customer_name'  => $name,
                'yps_customer_email' => $email,
                'yps_customer_id'    => $customer_id,
                'yps_status'         => 'pending',
                'yps_pilot'          => 'Unassigned',
                'yps_start_date'     => date('Y-m-d'),
                'yps_est_completion' => date('Y-m-d', strtotime('+3 days')),
                'yps_notes'          => '',
            ),
        ));

        if (is_wp_error($order_id)) {
            return $order_id;
        }

        return array('order_id' => $order_id, 'order_number' => $order_num);
    }

    /**
     * Get orders filtered by query args
     */
    public static function get_orders($args = array()) {
        $default_args = array(
            'post_type'      => 'yps_order',
            'post_status'    => 'publish',
            'posts_per_page' => 20,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        $merged_args = wp_parse_args($args, $default_args);
        return get_posts($merged_args);
    }

    /**
     * Get single order by order number or post ID
     */
    public static function get_order_by_number($order_number) {
        $orders = get_posts(array(
            'post_type'  => 'yps_order',
            'meta_query' => array(
                array('key' => 'yps_order_id', 'value' => $order_number, 'compare' => '='),
            ),
            'posts_per_page' => 1,
        ));

        return !empty($orders) ? $orders[0] : null;
    }

    /**
     * Update order status
     */
    public static function update_status($order_id, $status) {
        $valid_statuses = array('pending', 'confirmed', 'in_progress', 'quality_check', 'completed', 'cancelled');
        if (!in_array($status, $valid_statuses)) {
            return false;
        }

        return update_post_meta($order_id, 'yps_status', $status);
    }

    /**
     * Assign pilot to order
     */
    public static function assign_pilot($order_id, $pilot_name) {
        return update_post_meta($order_id, 'yps_pilot', sanitize_text_field($pilot_name));
    }
}
