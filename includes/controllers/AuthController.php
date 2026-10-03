<?php
/**
 * YPS Gaming - Auth Controller
 */

if (!defined('ABSPATH')) exit;

class YPS_Auth_Controller {

    public static function init() {
        add_action('wp_ajax_yps_login', array(__CLASS__, 'handle_login'));
        add_action('wp_ajax_nopriv_yps_login', array(__CLASS__, 'handle_login'));

        add_action('wp_ajax_yps_register', array(__CLASS__, 'handle_register'));
        add_action('wp_ajax_nopriv_yps_register', array(__CLASS__, 'handle_register'));

        add_action('wp_ajax_yps_create_user_account', array(__CLASS__, 'handle_create_user_account'));
    }

    /**
     * Handle Login AJAX
     */
    public static function handle_login() {
        check_ajax_referer('yps_nonce', 'nonce');

        $username = sanitize_text_field($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            wp_send_json_error(array('message' => 'Please fill in both username and password.'));
        }

        $user = YPS_User_Model::login_user($username, $password);

        if (is_wp_error($user)) {
            wp_send_json_error(array('message' => 'Invalid username or password.'));
        }

        // Determine redirect URL based on Role
        $user_roles = (array) $user->roles;
        $redirect = home_url('/');

        if (in_array('administrator', $user_roles) || in_array('yps_admin', $user_roles) || in_array('yps_staff', $user_roles)) {
            $redirect = home_url('/admin-dashboard');
        } elseif (in_array('yps_pilot', $user_roles)) {
            $redirect = home_url('/pilot-dashboard');
        } elseif (in_array('yps_customer', $user_roles)) {
            $redirect = home_url('/track-order');
        }

        wp_send_json_success(array(
            'message'  => 'Login successful!',
            'redirect' => $redirect,
        ));
    }

    /**
     * Handle Customer Registration AJAX
     */
    public static function handle_register() {
        check_ajax_referer('yps_nonce', 'nonce');

        $username = sanitize_text_field($_POST['username'] ?? '');
        $email    = sanitize_email($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        }

        $result = YPS_User_Model::register_user($username, $email, $password, 'yps_customer');

        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }

        // Auto login after registration
        YPS_User_Model::login_user($username, $password);

        wp_send_json_success(array(
            'message'  => 'Account registered successfully!',
            'redirect' => home_url('/track-order'),
        ));
    }

    /**
     * Create Staff / Pilot / Admin Account Handler (Super Admin ONLY)
     */
    public static function handle_create_user_account() {
        check_ajax_referer('yps_nonce', 'nonce');

        if (!YPS_RBAC::can_manage_users()) {
            wp_send_json_error(array('message' => 'Unauthorized: Only Super Admins can manage user accounts.'));
        }

        $display_name = sanitize_text_field($_POST['display_name'] ?? '');
        $username     = sanitize_user($_POST['username'] ?? '');
        $email        = sanitize_email($_POST['email'] ?? '');
        $password     = $_POST['password'] ?? '';
        $role         = sanitize_text_field($_POST['role'] ?? 'yps_staff');

        $allowed_roles = array('yps_staff', 'yps_pilot', 'administrator');
        if (!in_array($role, $allowed_roles, true)) {
            wp_send_json_error(array('message' => 'Invalid role selected.'));
        }

        if (empty($username) || empty($email) || empty($password) || empty($display_name)) {
            wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        }

        if (username_exists($username)) {
            wp_send_json_error(array('message' => 'Username already exists.'));
        }

        if (email_exists($email)) {
            wp_send_json_error(array('message' => 'Email address is already in use.'));
        }

        $user_id = wp_insert_user(array(
            'user_login'   => $username,
            'user_email'   => $email,
            'user_pass'    => $password,
            'display_name' => $display_name,
            'first_name'   => $display_name,
            'role'         => $role,
        ));

        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        }

        // If pilot role, create a YPS Pilot CPT post if needed
        if ($role === 'yps_pilot') {
            wp_insert_post(array(
                'post_type'   => 'yps_pilot',
                'post_title'  => $display_name,
                'post_status' => 'publish',
                'meta_input'  => array(
                    'yps_pilot_user_id' => $user_id,
                    'yps_pilot_email'   => $email,
                    'yps_pilot_status'  => 'active',
                ),
            ));
        }

        wp_send_json_success(array(
            'message'      => 'Account created successfully!',
            'user_id'      => $user_id,
            'display_name' => $display_name,
            'role'         => $role,
        ));
    }
}

YPS_Auth_Controller::init();
