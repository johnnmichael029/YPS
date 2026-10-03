<?php
/**
 * Template Name: My Orders
 * YPS Gaming - Customer My Orders Page Template
 */

if (!is_user_logged_in()) {
    wp_safe_redirect(YPS_Login_Routing::login_url_for_current());
    exit;
}

get_header();

$current_user = wp_get_current_user();
$customer_id = $current_user->ID;
$customer_email = $current_user->user_email;

// Query orders belonging to this customer (by user ID or email)
$orders = get_posts(array(
    'post_type' => 'yps_order',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_query' => array(
        'relation' => 'OR',
        array('key' => 'yps_customer_id', 'value' => $customer_id, 'compare' => '='),
        array('key' => 'yps_customer_email', 'value' => $customer_email, 'compare' => '='),
    ),
));

$status_labels = array(
    'pending' => array('label' => 'Pending', 'bg' => '#fff7ed', 'color' => '#c2410c', 'border' => '#ffedd5'),
    'confirmed' => array('label' => 'Confirmed', 'bg' => '#eff6ff', 'color' => '#1d4ed8', 'border' => '#dbeafe'),
    'in_progress' => array('label' => 'In Progress', 'bg' => '#fdf4ff', 'color' => '#a21caf', 'border' => '#fae8ff'),
    'quality_check' => array('label' => 'Quality Check', 'bg' => '#fefce8', 'color' => '#a16207', 'border' => '#fef9c3'),
    'completed' => array('label' => 'Completed', 'bg' => '#f0fff4', 'color' => '#15803d', 'border' => '#bbf7d0'),
    'cancelled' => array('label' => 'Cancelled', 'bg' => '#fef2f2', 'color' => '#b91c1c', 'border' => '#fee2e2'),
);
?>

<div class="yps-container" style="padding: 40px 0; min-height: 70vh;">

    <!-- Page Header -->
    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-top: 32px; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: #1a1a2e; margin-top: 4px;">My Boosting Orders</h1>
            <p style="color: #666; font-size: 0.9rem; margin-top: 4px;">Welcome,
                <?php echo esc_html($current_user->display_name ?: $current_user->user_login); ?>! Here is your active
                order history.
            </p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="yps-btn yps-btn-primary">
                + New Order
            </a>
        </div>
    </div>

    <?php if (empty($orders)): ?>
        <div
            style="background: white; border-radius: 20px; padding: 48px 24px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
            <div style="font-size: 3rem; margin-bottom: 12px;">📦</div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #1a1a2e; margin-bottom: 8px;">No orders found yet</h3>
            <p style="color: #777; font-size: 0.92rem; max-width: 420px; margin: 0 auto 24px;">You haven't placed any boost
                orders under this account email (<?php echo esc_html($customer_email); ?>).</p>
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="yps-btn yps-btn-primary">Browse Services
                &rarr;</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
            <?php foreach ($orders as $order):
                $order_num = get_post_meta($order->ID, 'yps_order_id', true) ?: $order->post_title;
                $game_id = get_post_meta($order->ID, 'yps_game', true);
                $service = get_post_meta($order->ID, 'yps_service', true);
                $status_slug = get_post_meta($order->ID, 'yps_status', true) ?: 'pending';
                $pilot = get_post_meta($order->ID, 'yps_pilot', true) ?: 'Unassigned';
                $game_info = yps_get_game_info($game_id);
                $needs_quote = get_post_meta($order->ID, 'yps_needs_quote', true);
                $progress = get_post_meta($order->ID, 'yps_current_progress', true);
                $amount = yps_get_order_amount($order->ID);
                $st_info = $status_labels[$status_slug] ?? array('label' => ucfirst($status_slug), 'bg' => '#f3f4f6', 'color' => '#4b5563', 'border' => '#e5e7eb');
                $track_link = home_url('/track-order/?order_id=' . esc_attr($order_num));
                ?>
                <div
                    style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f0e6ff; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <!-- Order Header -->
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                            <div>
                                <span style="font-size: 0.75rem; color: #888; font-weight: 600;">Order ID</span>
                                <div style="font-size: 1.1rem; font-weight: 800; color: var(--pink); letter-spacing: 0.5px;">
                                    <?php echo esc_html($order_num); ?>
                                </div>
                            </div>
                            <span
                                style="font-size: 0.78rem; font-weight: 700; background: <?php echo $st_info['bg']; ?>; color: <?php echo $st_info['color']; ?>; border: 1px solid <?php echo $st_info['border']; ?>; padding: 4px 12px; border-radius: 999px;">
                                <?php echo esc_html($st_info['label']); ?>
                            </span>
                        </div>

                        <!-- Game & Service -->
                        <div
                            style="margin-bottom: 16px; padding: 12px; background: #faf8ff; border-radius: 12px; border: 1px solid #f3e8ff;">
                            <div
                                style="font-size: 0.85rem; font-weight: 700; color: #1a1a2e; display: flex; align-items: center; gap: 6px;">
                                <span><?php echo $game_info['icon']; ?></span> <?php echo esc_html($game_info['name']); ?>
                            </div>
                            <div style="font-size: 0.92rem; font-weight: 800; color: #6b21a8; margin-top: 4px;">
                                <?php echo esc_html(yps_get_service_name($game_id, $service)); ?>
                            </div>
                            <?php if (!empty($progress)): ?>
                                <div
                                    style="font-size: 0.78rem; color: #9333ea; font-weight: 700; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                    <span>🎯</span> <?php echo esc_html($progress); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Meta Details -->
                        <div
                            style="display: flex; justify-content: space-between; font-size: 0.82rem; color: #666; margin-bottom: 8px;">
                            <span>Assigned Pilot:</span>
                            <span style="font-weight: 700; color: #333;"><?php echo esc_html($pilot); ?></span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 0.82rem; color: #666; margin-bottom: 16px;">
                            <span>Price / Quote:</span>
                            <span style="font-weight: 800; color: #1a1a2e;">
                                <?php if ($needs_quote && $amount <= 0): ?>
                                    <span
                                        style="color: #d946ef; font-weight: 800; background: #fdf4ff; padding: 2px 8px; border-radius: 6px; border: 1px solid #f5d0fe; font-size: 0.75rem;">📋
                                        Final Quote Pending</span>
                                <?php else: ?>
                                    <?php echo esc_html(yps_format_money($amount)); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div
                        style="border-top: 1px solid #f0f0f0; padding-top: 14px; margin-top: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.78rem; color: #aaa;"><?php echo get_the_date('M j, Y', $order->ID); ?></span>
                        <a href="<?php echo esc_url($track_link); ?>" class="yps-btn yps-btn-outline yps-btn-sm"
                            style="padding: 6px 14px; font-size: 0.82rem;">
                            Track Order &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>