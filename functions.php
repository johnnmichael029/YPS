<?php
/**
 * YPS Gaming Theme Functions
 */
// Load MVC & RBAC Modules
require_once get_template_directory() . '/includes/data/services.php';
require_once get_template_directory() . '/includes/rbac/Roles.php';
require_once get_template_directory() . '/includes/models/OrderModel.php';
require_once get_template_directory() . '/includes/models/UserModel.php';
require_once get_template_directory() . '/includes/controllers/OrderController.php';
require_once get_template_directory() . '/includes/controllers/AuthController.php';

// Automatically load page view templates from pages/ subfolder
function yps_template_include_pages($template) {
    if (is_page()) {
        $page_slug = get_post_field('post_name', get_queried_object_id());
        $custom_template = get_template_directory() . '/pages/page-' . $page_slug . '.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    return $template;
}
add_filter('template_include', 'yps_template_include_pages');

// Pilot roster used for order assignment (core team + users with the yps_pilot role)
function yps_get_pilot_names() {
    $names = array('Yuna', 'Yulia', 'Anastasya', 'Fruenah', 'April', 'Uno', 'Chanelia', 'Bonnie');
    $pilot_users = get_users(array('role' => 'yps_pilot', 'fields' => array('display_name')));
    foreach ($pilot_users as $u) {
        if (!empty($u->display_name) && !in_array($u->display_name, $names, true)) {
            $names[] = $u->display_name;
        }
    }
    return $names;
}

// Theme Setup
function yps_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo', array(
        'height'      => 50,
        'width'       => 150,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'yps-gaming'),
        'footer'  => __('Footer Navigation', 'yps-gaming'),
    ));
}
add_action('after_setup_theme', 'yps_theme_setup');

// Enqueue Scripts and Styles
function yps_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('yps-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Nunito:wght@400;600;700;800;900&display=swap', array(), null);

    // Main stylesheet
    wp_enqueue_style('yps-main', get_template_directory_uri() . '/assets/css/main.css', array(), '2.0.0');

    // Main JS
    wp_enqueue_script('yps-main', get_template_directory_uri() . '/assets/js/main.js', array(), '2.0.0', true);

    // Localize script with AJAX URL
    wp_localize_script('yps-main', 'yps_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('yps_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'yps_enqueue_assets');

// Custom Post Types
function yps_register_post_types() {
    // Services CPT
    register_post_type('yps_service', array(
        'labels' => array(
            'name'          => __('Services', 'yps-gaming'),
            'singular_name' => __('Service', 'yps-gaming'),
            'add_new_item'  => __('Add New Service', 'yps-gaming'),
            'edit_item'     => __('Edit Service', 'yps-gaming'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon'    => 'dashicons-games',
        'show_in_rest' => true,
    ));

    // Pilots CPT
    register_post_type('yps_pilot', array(
        'labels' => array(
            'name'          => __('Pilots', 'yps-gaming'),
            'singular_name' => __('Pilot', 'yps-gaming'),
            'add_new_item'  => __('Add New Pilot', 'yps-gaming'),
            'edit_item'     => __('Edit Pilot', 'yps-gaming'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon'    => 'dashicons-superhero',
        'show_in_rest' => true,
    ));

    // Games CPT
    register_post_type('yps_game', array(
        'labels' => array(
            'name'          => __('Games', 'yps-gaming'),
            'singular_name' => __('Game', 'yps-gaming'),
            'add_new_item'  => __('Add New Game', 'yps-gaming'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon'    => 'dashicons-controller',
        'show_in_rest' => true,
    ));

    // Orders CPT
    register_post_type('yps_order', array(
        'labels' => array(
            'name'          => __('Orders', 'yps-gaming'),
            'singular_name' => __('Order', 'yps-gaming'),
            'add_new_item'  => __('Add New Order', 'yps-gaming'),
        ),
        'public'            => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'supports'          => array('title', 'custom-fields'),
        'menu_icon'         => 'dashicons-cart',
        'capability_type'   => 'post',
        'show_in_rest'      => false,
    ));
}
add_action('init', 'yps_register_post_types');

// Custom Taxonomies
function yps_register_taxonomies() {
    // Game category for services
    register_taxonomy('yps_game_cat', array('yps_service', 'yps_pilot'), array(
        'labels' => array(
            'name'          => __('Game Categories', 'yps-gaming'),
            'singular_name' => __('Game Category', 'yps-gaming'),
        ),
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
    ));

    // Service type
    register_taxonomy('yps_service_type', 'yps_service', array(
        'labels' => array(
            'name'          => __('Service Types', 'yps-gaming'),
            'singular_name' => __('Service Type', 'yps-gaming'),
        ),
        'hierarchical'  => false,
        'public'        => true,
        'show_in_rest'  => true,
    ));
}
add_action('init', 'yps_register_taxonomies');

// Register Widget Areas
function yps_register_sidebars() {
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'yps-gaming'),
        'id'            => 'footer-1',
        'description'   => __('Footer widget area column 1', 'yps-gaming'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'yps_register_sidebars');

// AJAX: Track Order
function yps_track_order_ajax() {
    $order_id = sanitize_text_field($_POST['order_id'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');

    if (empty($order_id)) {
        wp_send_json_error(array('message' => 'Please enter an Order ID.'));
        return;
    }

    $args = array(
        'post_type'  => 'yps_order',
        'meta_query' => array(
            array('key' => 'yps_order_id', 'value' => $order_id, 'compare' => '='),
        ),
        'posts_per_page' => 1,
    );

    if (!empty($email)) {
        $args['meta_query'][] = array('key' => 'yps_customer_email', 'value' => $email, 'compare' => '=');
        $args['meta_query']['relation'] = 'AND';
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        wp_send_json_success(array(
            'order_id'       => get_post_meta($post_id, 'yps_order_id', true),
            'game'           => get_post_meta($post_id, 'yps_game', true),
            'service'        => get_post_meta($post_id, 'yps_service', true),
            'pilot'          => get_post_meta($post_id, 'yps_pilot', true),
            'status'         => get_post_meta($post_id, 'yps_status', true),
            'start_date'     => get_post_meta($post_id, 'yps_start_date', true),
            'est_completion' => get_post_meta($post_id, 'yps_est_completion', true),
        ));
        wp_reset_postdata();
    } else {
        wp_send_json_error(array('message' => 'Order not found. Please check your Order ID and try again.'));
    }
}
add_action('wp_ajax_yps_track_order', 'yps_track_order_ajax');
add_action('wp_ajax_nopriv_yps_track_order', 'yps_track_order_ajax');

// AJAX: Submit Booking
function yps_submit_booking() {
    check_ajax_referer('yps_nonce', 'nonce');

    $game    = sanitize_text_field($_POST['game'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');

    if (empty($game) || empty($service) || empty($name) || empty($email)) {
        wp_send_json_error(array('message' => 'Please fill all required fields.'));
    }

    // Generate order ID
    $order_num = 'YPS' . strtoupper(substr(md5(time() . $email), 0, 8));

    // Create order post
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
            'yps_status'         => 'pending',
            'yps_start_date'     => date('Y-m-d'),
            'yps_est_completion' => date('Y-m-d', strtotime('+3 days')),
            'yps_notes'          => '',
        ),
    ));

    wp_send_json_success(array(
        'message'  => 'Booking submitted successfully!',
        'order_id' => $order_num,
    ));
}
add_action('wp_ajax_yps_submit_booking', 'yps_submit_booking');
add_action('wp_ajax_nopriv_yps_submit_booking', 'yps_submit_booking');

// AJAX: Update Order Status from Admin Dashboard
function yps_update_order_status() {
    check_ajax_referer('yps_nonce', 'nonce');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'Unauthorized user.'));
    }

    $post_id    = intval($_POST['post_id'] ?? 0);
    $new_status = sanitize_text_field($_POST['status'] ?? '');

    if ($post_id > 0 && !empty($new_status)) {
        update_post_meta($post_id, 'yps_status', $new_status);
        wp_send_json_success(array('message' => 'Status updated successfully!'));
    } else {
        wp_send_json_error(array('message' => 'Invalid parameters.'));
    }
}
add_action('wp_ajax_yps_update_order_status', 'yps_update_order_status');

// Helper: Get page URL by slug
function yps_page_url($slug) {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page->ID) : home_url('/' . $slug);
}

// Add body classes
function yps_body_classes($classes) {
    if (is_front_page()) $classes[] = 'yps-home';
    return $classes;
}
add_filter('body_class', 'yps_body_classes');

// Excerpt length
function yps_excerpt_length() { return 20; }
add_filter('excerpt_length', 'yps_excerpt_length');

// Disable admin bar on frontend for non-admins
function yps_disable_admin_bar() {
    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'yps_disable_admin_bar');

// ===========================
// YPS ORDER META FIELDS
// ===========================
function yps_add_order_meta_boxes() {
    add_meta_box(
        'yps_order_details',
        'Order Details',
        'yps_order_meta_box_callback',
        'yps_order',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'yps_add_order_meta_boxes');

function yps_order_meta_box_callback($post) {
    wp_nonce_field('yps_order_meta_nonce', 'yps_order_meta_nonce');
    
    $status_options = array(
        'pending'       => 'Pending',
        'confirmed'     => 'Confirmed',
        'in_progress'   => 'In Progress',
        'quality_check' => 'Quality Check',
        'completed'     => 'Completed',
        'cancelled'     => 'Cancelled',
    );

    $fields = array(
        'yps_order_id'         => 'Order ID',
        'yps_customer_name'   => 'Customer Name',
        'yps_customer_email'   => 'Customer Email',
        'yps_game'             => 'Game',
        'yps_service'          => 'Service',
        'yps_pilot'            => 'Assigned Pilot',
        'yps_status'           => 'Status',
        'yps_start_date'       => 'Start Date (YYYY-MM-DD)',
        'yps_est_completion'   => 'Estimated Completion (YYYY-MM-DD)',
        'yps_notes'            => 'Internal Notes',
    );

    echo '<table style="width:100%;border-collapse:collapse;">';
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr><td style="padding:8px;font-weight:600;width:220px;">' . esc_html($label) . '</td>';
        echo '<td style="padding:8px;">';
        if ($key === 'yps_status') {
            echo '<select name="' . esc_attr($key) . '" style="width:100%;padding:6px 10px;border:1px solid #ddd;border-radius:4px;">';
            foreach ($status_options as $opt_val => $opt_label) {
                $selected = ($value === $opt_val) ? ' selected' : '';
                echo '<option value="' . esc_attr($opt_val) . '"' . $selected . '>' . esc_html($opt_label) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" style="width:100%;padding:6px 10px;border:1px solid #ddd;border-radius:4px;">';
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

function yps_save_order_meta($post_id) {
    if (!isset($_POST['yps_order_meta_nonce']) || !wp_verify_nonce($_POST['yps_order_meta_nonce'], 'yps_order_meta_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    $fields = array('yps_order_id','yps_customer_name','yps_customer_email','yps_game','yps_service','yps_pilot','yps_status','yps_start_date','yps_est_completion','yps_notes');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_yps_order', 'yps_save_order_meta');
