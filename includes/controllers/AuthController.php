<?php
/**
 * YPS Gaming - Auth Controller
 */

if (!defined('ABSPATH')) exit;

class YPS_Auth_Controller {

    const MAX_LOGIN_ATTEMPTS = 5;
    const LOCKOUT_SECONDS    = 900; // 15 minutes
    const MIN_PASSWORD_LEN   = 8;

    public static function init() {
        add_action('wp_ajax_yps_login', array(__CLASS__, 'handle_login'));
        add_action('wp_ajax_nopriv_yps_login', array(__CLASS__, 'handle_login'));

        add_action('wp_ajax_yps_register', array(__CLASS__, 'handle_register'));
        add_action('wp_ajax_nopriv_yps_register', array(__CLASS__, 'handle_register'));

        add_action('wp_ajax_nopriv_yps_forgot_password', array(__CLASS__, 'handle_forgot_password'));
        add_action('wp_ajax_yps_forgot_password', array(__CLASS__, 'handle_forgot_password'));

        add_action('wp_ajax_nopriv_yps_reset_password', array(__CLASS__, 'handle_reset_password'));
        add_action('wp_ajax_yps_reset_password', array(__CLASS__, 'handle_reset_password'));

        add_action('wp_ajax_yps_create_user_account', array(__CLASS__, 'handle_create_user_account'));
    }

    /* -------------------------------------------------
     * Rate limiting helpers (per IP + username)
     * ------------------------------------------------- */

    private static function client_ip() {
        return isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '0.0.0.0';
    }

    private static function attempts_key($username) {
        return 'yps_login_fail_' . md5(self::client_ip() . '|' . strtolower($username));
    }

    /**
     * Where to send a user after authenticating: requested page if safe, else role home.
     */
    private static function resolve_redirect($user) {
        $requested = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : '';
        $target    = YPS_Login_Routing::safe_redirect_target($requested);
        return $target !== '' ? $target : YPS_Login_Routing::role_home_url($user);
    }

    /**
     * Handle Login AJAX
     */
    public static function handle_login() {
        check_ajax_referer('yps_nonce', 'nonce');

        $username = sanitize_text_field(wp_unslash($_POST['username'] ?? ''));
        $password = (string) wp_unslash($_POST['password'] ?? '');
        $remember = !empty($_POST['remember']);

        if ($username === '' || $password === '') {
            wp_send_json_error(array('message' => 'Please fill in both username and password.'));
        }

        $key      = self::attempts_key($username);
        $attempts = (int) get_transient($key);

        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            wp_send_json_error(array(
                'message' => 'Too many failed attempts. Please try again in 15 minutes or reset your password.',
                'locked'  => true,
            ));
        }

        $user = YPS_User_Model::login_user($username, $password, $remember);

        if (is_wp_error($user)) {
            $attempts++;
            set_transient($key, $attempts, self::LOCKOUT_SECONDS);
            $left = self::MAX_LOGIN_ATTEMPTS - $attempts;

            $message = 'Invalid username or password.';
            if ($left > 0 && $left <= 2) {
                $message .= sprintf(' %d attempt%s left before a 15-minute lockout.', $left, $left === 1 ? '' : 's');
            } elseif ($left <= 0) {
                $message = 'Too many failed attempts. Please try again in 15 minutes or reset your password.';
            }
            wp_send_json_error(array('message' => $message, 'locked' => $left <= 0));
        }

        delete_transient($key);

        wp_send_json_success(array(
            'message'  => 'Welcome back, ' . $user->display_name . '!',
            'redirect' => self::resolve_redirect($user),
        ));
    }

    /**
     * Handle Customer Registration AJAX (customers only — staff/pilots are created by admins)
     */
    public static function handle_register() {
        check_ajax_referer('yps_nonce', 'nonce');

        $display_name = sanitize_text_field(wp_unslash($_POST['display_name'] ?? ''));
        $username     = sanitize_user(wp_unslash($_POST['username'] ?? ''), true);
        $email        = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $password     = (string) wp_unslash($_POST['password'] ?? '');

        if ($username === '' || $email === '' || $password === '') {
            wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        }
        if (!is_email($email)) {
            wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        }
        if (strlen($password) < self::MIN_PASSWORD_LEN) {
            wp_send_json_error(array('message' => 'Password must be at least ' . self::MIN_PASSWORD_LEN . ' characters.'));
        }

        $result = YPS_User_Model::register_user($username, $email, $password, 'yps_customer');

        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }

        if ($display_name !== '') {
            wp_update_user(array('ID' => $result, 'display_name' => $display_name, 'first_name' => $display_name));
        }

        // Auto login after registration
        $user = YPS_User_Model::login_user($username, $password, true);

        wp_send_json_success(array(
            'message'  => 'Account created! Redirecting…',
            'redirect' => is_wp_error($user) ? YPS_Login_Routing::login_page_url() : self::resolve_redirect($user),
        ));
    }

    /**
     * Forgot Password AJAX — always returns the same message so it can't be used to probe accounts.
     */
    public static function handle_forgot_password() {
        check_ajax_referer('yps_nonce', 'nonce');

        $login = sanitize_text_field(wp_unslash($_POST['user_login'] ?? ''));
        if ($login === '') {
            wp_send_json_error(array('message' => 'Please enter your username or email.'));
        }

        // Light throttle: max 3 reset emails per IP+login per 15 minutes.
        $key  = 'yps_reset_req_' . md5(self::client_ip() . '|' . strtolower($login));
        $sent = (int) get_transient($key);
        if ($sent < 3) {
            set_transient($key, $sent + 1, self::LOCKOUT_SECONDS);
            if (function_exists('retrieve_password')) {
                retrieve_password($login); // Result intentionally ignored.
            }
        }

        wp_send_json_success(array(
            'message' => 'If an account matches that username or email, a password reset link has been sent. Please check your inbox (and spam folder).',
        ));
    }

    /**
     * Reset Password AJAX (from the emailed link)
     */
    public static function handle_reset_password() {
        check_ajax_referer('yps_nonce', 'nonce');

        $key       = sanitize_text_field(wp_unslash($_POST['key'] ?? ''));
        $login     = sanitize_user(wp_unslash($_POST['login'] ?? ''));
        $password  = (string) wp_unslash($_POST['password'] ?? '');
        $password2 = (string) wp_unslash($_POST['password2'] ?? '');

        $user = check_password_reset_key($key, $login);
        if (is_wp_error($user)) {
            wp_send_json_error(array('message' => 'This reset link is invalid or has expired. Please request a new one.', 'expired' => true));
        }
        if (strlen($password) < self::MIN_PASSWORD_LEN) {
            wp_send_json_error(array('message' => 'Password must be at least ' . self::MIN_PASSWORD_LEN . ' characters.'));
        }
        if ($password !== $password2) {
            wp_send_json_error(array('message' => 'Passwords do not match.'));
        }

        reset_password($user, $password);
        delete_transient(self::attempts_key($login));

        wp_send_json_success(array(
            'message'  => 'Your password has been updated. You can now sign in.',
            'redirect' => YPS_Login_Routing::login_page_url(array('reset' => 'done')),
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
