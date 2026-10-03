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

        if (in_array('administrator', $user_roles) || in_array('yps_admin', $user_roles)) {
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
}

YPS_Auth_Controller::init();
