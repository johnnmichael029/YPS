<?php
/**
 * YPS Gaming - Role Based Access Control (RBAC)
 */

if (!defined('ABSPATH')) exit;

class YPS_RBAC {

    public static function init() {
        add_action('after_setup_theme', array(__CLASS__, 'register_roles'));
    }

    /**
     * Register Custom Roles & Capabilities
     * Roles: administrator, yps_admin, yps_staff, yps_pilot, yps_customer
     */
    public static function register_roles() {
        // 1. Customer Role
        add_role('yps_customer', __('YPS Customer', 'yps-gaming'), array(
            'read'              => true,
            'place_yps_orders'  => true,
            'track_yps_orders'  => true,
        ));

        // 2. Pilot Role
        add_role('yps_pilot', __('YPS Pilot', 'yps-gaming'), array(
            'read'                    => true,
            'view_assigned_orders'    => true,
            'update_assigned_orders'  => true,
            'upload_service_proof'    => true,
        ));

        // 3. Staff / Booking Manager Role (Read/Create/Update, NO Delete, NO User Mgmt)
        add_role('yps_staff', __('YPS Staff', 'yps-gaming'), array(
            'read'                   => true,
            'access_admin_dashboard' => true,
            'manage_yps_orders'      => true,
            'create_yps_orders'      => true,
            'update_yps_orders'      => true,
            'assign_yps_pilots'      => true,
            'delete_yps_orders'      => false,
            'manage_yps_users'       => false,
        ));

        // 4. Admin Role (Add full custom YPS capabilities to Administrator)
        $admin = get_role('administrator');
        if ($admin) {
            $admin->add_cap('access_admin_dashboard');
            $admin->add_cap('manage_yps_orders');
            $admin->add_cap('create_yps_orders');
            $admin->add_cap('update_yps_orders');
            $admin->add_cap('delete_yps_orders');
            $admin->add_cap('assign_yps_pilots');
            $admin->add_cap('manage_yps_pilots');
            $admin->add_cap('manage_yps_services');
            $admin->add_cap('view_yps_analytics');
            $admin->add_cap('manage_yps_users');
        }
    }

    /**
     * Check if user has a specific YPS role
     */
    public static function has_role($user_id, $role) {
        $user = get_userdata($user_id);
        return $user && in_array($role, (array) $user->roles);
    }

    /**
     * Is Super Admin (Administrator)
     */
    public static function is_super_admin($user_id = null) {
        if (!$user_id) $user_id = get_current_user_id();
        return current_user_can('manage_options') || self::has_role($user_id, 'administrator') || self::has_role($user_id, 'yps_admin');
    }

    /**
     * Can user manage orders (Staff or Admin)
     */
    public static function can_manage_orders($user_id = null) {
        if (!$user_id) $user_id = get_current_user_id();
        return self::is_super_admin($user_id) || self::has_role($user_id, 'yps_staff') || user_can($user_id, 'manage_yps_orders');
    }

    /**
     * Can user delete orders (Super Admin ONLY)
     */
    public static function can_delete_orders($user_id = null) {
        if (!$user_id) $user_id = get_current_user_id();
        return self::is_super_admin($user_id) || user_can($user_id, 'delete_yps_orders');
    }

    /**
     * Can user manage staff & pilot user accounts (Super Admin ONLY)
     */
    public static function can_manage_users($user_id = null) {
        if (!$user_id) $user_id = get_current_user_id();
        return self::is_super_admin($user_id) || user_can($user_id, 'manage_yps_users');
    }

    /**
     * Enforce page access control based on roles
     */
    public static function enforce_access($allowed_roles = array()) {
        if (!is_user_logged_in()) {
            wp_safe_redirect(YPS_Login_Routing::login_url_for_current());
            exit;
        }

        $current_user = wp_get_current_user();
        $user_roles   = (array) $current_user->roles;

        // Admins can access everything
        if (in_array('administrator', $user_roles) || in_array('yps_admin', $user_roles)) {
            return true;
        }

        // Check if user has any allowed role
        $has_access = false;
        foreach ($allowed_roles as $role) {
            if (in_array($role, $user_roles)) {
                $has_access = true;
                break;
            }
        }

        if (!$has_access) {
            wp_die(__('Access Denied: You do not have permission to view this page.', 'yps-gaming'), 'Forbidden', array('response' => 403));
        }

        return true;
    }
}

YPS_RBAC::init();
