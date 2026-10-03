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
     * Roles: yps_admin, yps_pilot, yps_customer
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

        // 3. Admin Role (Add custom YPS capabilities to Administrator)
        $admin = get_role('administrator');
        if ($admin) {
            $admin->add_cap('manage_yps_orders');
            $admin->add_cap('assign_yps_pilots');
            $admin->add_cap('manage_yps_pilots');
            $admin->add_cap('manage_yps_services');
            $admin->add_cap('view_yps_analytics');
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
     * Enforce page access control based on roles
     */
    public static function enforce_access($allowed_roles = array()) {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/login?redirect=' . urlencode($_SERVER['REQUEST_URI'])));
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
