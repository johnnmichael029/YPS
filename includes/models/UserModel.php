<?php
/**
 * YPS Gaming - User Model
 */

if (!defined('ABSPATH')) exit;

class YPS_User_Model {

    /**
     * Register a new YPS user with specific role
     */
    public static function register_user($username, $email, $password, $role = 'yps_customer') {
        if (username_exists($username) || email_exists($email)) {
            return new WP_Error('user_exists', 'Username or Email already registered.');
        }

        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            return $user_id;
        }

        // Set specified role
        $user = new WP_User($user_id);
        $user->set_role($role);

        return $user_id;
    }

    /**
     * Authenticate user credentials
     */
    public static function login_user($username_or_email, $password, $remember = true) {
        $creds = array(
            'user_login'    => $username_or_email,
            'user_password' => $password,
            'remember'      => (bool) $remember,
        );

        return wp_signon($creds, is_ssl());
    }

    /**
     * Get all registered pilots
     */
    public static function get_all_pilots() {
        return get_users(array(
            'role__in' => array('yps_pilot', 'administrator'),
            'orderby'  => 'display_name',
        ));
    }
}
