<?php
/**
 * YPS Gaming - Login Routing
 *
 * - Role-based "home" URLs after login
 * - Points WordPress login / lost-password / register URLs to our /login page
 * - Redirects wp-login.php to /login (with a hidden admin fallback)
 * - Sends logout to /login?loggedout=1
 * - Keeps pilots & customers out of /wp-admin
 * - Auto-creates the /login page
 */

if (!defined('ABSPATH')) exit;

class YPS_Login_Routing {

    const LOGIN_SLUG = 'login';

    public static function init() {
        add_action('init', array(__CLASS__, 'ensure_pages'));
        add_action('after_switch_theme', array(__CLASS__, 'ensure_pages'));

        add_filter('login_url', array(__CLASS__, 'filter_login_url'), 10, 3);
        add_filter('lostpassword_url', array(__CLASS__, 'filter_lostpassword_url'), 10, 2);
        add_filter('register_url', array(__CLASS__, 'filter_register_url'));
        add_filter('logout_redirect', array(__CLASS__, 'filter_logout_redirect'), 10, 3);

        add_action('login_init', array(__CLASS__, 'redirect_wp_login'), 1);
        add_action('admin_init', array(__CLASS__, 'restrict_wp_admin'), 1);
    }

    /* -------------------------------------------------
     * URL helpers
     * ------------------------------------------------- */

    /** Base URL of our custom login page. */
    public static function login_page_url($args = array()) {
        $url = home_url('/' . self::LOGIN_SLUG . '/');
        return $args ? add_query_arg(array_map('rawurlencode', $args), $url) : $url;
    }

    /** Full URL of the current request (host is re-validated by safe_redirect_target later). */
    public static function current_url() {
        $host = isset($_SERVER['HTTP_HOST']) ? wp_unslash($_SERVER['HTTP_HOST']) : wp_parse_url(home_url(), PHP_URL_HOST);
        $uri  = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
        return set_url_scheme('http://' . $host . $uri);
    }

    /** Login page URL that returns the user to the current page afterwards. */
    public static function login_url_for_current() {
        return self::login_page_url(array('redirect_to' => self::current_url()));
    }

    /** Where a user should land after logging in, based on their role. */
    public static function role_home_url($user = null) {
        if (!$user) $user = wp_get_current_user();
        if (!$user || !$user->exists()) return home_url('/');

        $roles = (array) $user->roles;

        if (array_intersect(array('administrator', 'yps_admin', 'yps_staff'), $roles) || user_can($user, 'access_admin_dashboard')) {
            return home_url('/admin-dashboard/');
        }
        if (in_array('yps_pilot', $roles, true)) {
            return home_url('/pilot-dashboard/');
        }
        // Customers (Phase 2 will switch this to /my-orders/)
        return home_url('/track-order/');
    }

    /**
     * Validate a requested redirect: same-site only, and never back to a login page
     * (prevents open redirects and redirect loops). Returns '' when unusable.
     */
    public static function safe_redirect_target($requested) {
        $requested = is_string($requested) ? trim(wp_unslash($requested)) : '';
        if ($requested === '') return '';

        $target = wp_validate_redirect(esc_url_raw($requested), '');
        if ($target === '') return '';

        $path = (string) wp_parse_url($target, PHP_URL_PATH);
        if (strpos($path, 'wp-login.php') !== false || preg_match('#/' . self::LOGIN_SLUG . '/?$#', $path)) {
            return '';
        }
        return $target;
    }

    /* -------------------------------------------------
     * Page setup
     * ------------------------------------------------- */

    /** Create the /login page once if it doesn't exist. Template is auto-mapped by slug. */
    public static function ensure_pages() {
        if (get_option('yps_login_page_created')) return;

        if (!get_page_by_path(self::LOGIN_SLUG)) {
            wp_insert_post(array(
                'post_type'   => 'page',
                'post_title'  => 'Login',
                'post_name'   => self::LOGIN_SLUG,
                'post_status' => 'publish',
            ));
        }
        update_option('yps_login_page_created', 1);
    }

    /* -------------------------------------------------
     * Core URL filters
     * ------------------------------------------------- */

    public static function filter_login_url($login_url, $redirect, $force_reauth) {
        $args = array();
        if (!empty($redirect)) $args['redirect_to'] = $redirect;
        return self::login_page_url($args);
    }

    public static function filter_lostpassword_url($url, $redirect) {
        return self::login_page_url(array('action' => 'forgot'));
    }

    public static function filter_register_url($url) {
        return self::login_page_url(array('action' => 'register'));
    }

    public static function filter_logout_redirect($redirect_to, $requested, $user) {
        return self::login_page_url(array('loggedout' => '1'));
    }

    /* -------------------------------------------------
     * wp-login.php replacement
     * ------------------------------------------------- */

    public static function redirect_wp_login() {
        // Native form posts (from the hidden fallback) must go through.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') return;

        $action = isset($_GET['action']) ? sanitize_key($_GET['action']) : 'login';

        // Hidden admin fallback: wp-login.php?yps_admin=1
        if (!empty($_GET['yps_admin'])) return;

        // Flows WordPress must handle itself.
        if (in_array($action, array('logout', 'postpass', 'confirmaction', 'confirm_admin_email'), true)) return;
        if (isset($_GET['interim-login'])) return; // wp-admin "session expired" modal

        // Password reset link from email → our reset screen.
        if (in_array($action, array('rp', 'resetpass'), true)) {
            $args = array('action' => 'reset');
            if (!empty($_GET['key']))   $args['key']   = sanitize_text_field(wp_unslash($_GET['key']));
            if (!empty($_GET['login'])) $args['login'] = sanitize_user(wp_unslash($_GET['login']));
            wp_safe_redirect(self::login_page_url($args));
            exit;
        }

        $args = array();
        if ($action === 'lostpassword' || $action === 'retrievepassword') $args['action'] = 'forgot';
        if ($action === 'register') $args['action'] = 'register';
        if (!empty($_GET['redirect_to'])) $args['redirect_to'] = wp_unslash($_GET['redirect_to']);

        wp_safe_redirect(self::login_page_url($args));
        exit;
    }

    /* -------------------------------------------------
     * Keep pilots & customers out of wp-admin
     * (Staff still need wp-admin for Orders / Pilots / Services screens.)
     * ------------------------------------------------- */

    public static function restrict_wp_admin() {
        if (wp_doing_ajax() || (defined('DOING_CRON') && DOING_CRON)) return;
        if (isset($GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'admin-post.php') return;
        if (!is_user_logged_in()) return;

        if (current_user_can('manage_options') || current_user_can('access_admin_dashboard') || current_user_can('edit_posts')) {
            return;
        }

        wp_safe_redirect(self::role_home_url());
        exit;
    }
}

YPS_Login_Routing::init();
