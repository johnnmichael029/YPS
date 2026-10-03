<?php
/**
 * Template Name: Pilot Dashboard
 * YPS Gaming - Pilot Dashboard Page Template
 */

// Enforce Pilot Access Control (must run before any output so redirects work)
YPS_RBAC::enforce_access(array('yps_pilot', 'administrator'));

get_header();

$current_user = wp_get_current_user();
$pilot_name = $current_user->display_name;

// Get orders assigned to this pilot
$all_assigned = YPS_Order_Model::get_orders(array(
    'posts_per_page' => -1,
    'meta_query' => array(
        array('key' => 'yps_pilot', 'value' => $pilot_name, 'compare' => '='),
    ),
));

// Stats counters
$total_assigned = count($all_assigned);
$in_progress = 0;
$completed = 0;

foreach ($all_assigned as $o) {
    $st = get_post_meta($o->ID, 'yps_status', true);
    if ($st === 'in_progress')
        $in_progress++;
    if ($st === 'completed')
        $completed++;
}
?>

<div class="yps-container" style="padding: 40px 0;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;margin-top:60px;">
        <div>
            <div style="font-size:0.8rem;color:#FF6B9D;font-weight:700;text-transform:uppercase;letter-spacing:1px;">
                👨‍✈️ Pilot Portal</div>
            <h1 style="font-size:1.8rem;font-weight:900;color:#1a1a2e;margin-top:4px;">Welcome back,
                <?php echo esc_html($pilot_name); ?>! 👋</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px;">
        <div style="background:white;border-radius:16px;padding:20px;box-shadow:0 4px 16px rgba(0,0,0,0.05);">
            <div style="font-size:0.8rem;color:#888;font-weight:600;">📋 Assigned Orders</div>
            <div style="font-size:1.8rem;font-weight:800;color:#1a1a2e;margin-top:4px;"><?php echo $total_assigned; ?>
            </div>
        </div>
        <div style="background:white;border-radius:16px;padding:20px;box-shadow:0 4px 16px rgba(0,0,0,0.05);">
            <div style="font-size:0.8rem;color:#888;font-weight:600;">⏳ In Progress</div>
            <div style="font-size:1.8rem;font-weight:800;color:#FF9800;margin-top:4px;"><?php echo $in_progress; ?>
            </div>
        </div>
        <div style="background:white;border-radius:16px;padding:20px;box-shadow:0 4px 16px rgba(0,0,0,0.05);">
            <div style="font-size:0.8rem;color:#888;font-weight:600;">✅ Completed Tasks</div>
            <div style="font-size:1.8rem;font-weight:800;color:#4CAF50;margin-top:4px;"><?php echo $completed; ?></div>
        </div>
    </div>

    <!-- Assigned Orders List -->
    <div style="background:white;border-radius:20px;padding:28px;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
        <h3 style="font-size:1.1rem;font-weight:800;color:#1a1a2e;margin-bottom:20px;">Your Active Tasks</h3>

        <?php if (empty($all_assigned)): ?>
            <div style="text-align:center;padding:40px;color:#aaa;">
                <div style="font-size:2rem;margin-bottom:8px;">🎯</div>
                <div>No orders assigned to you yet.</div>
            </div>
        <?php else: ?>
            <div style="overflow-x:auto;">
                <table class="admin-table" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Game</th>
                            <th>Service</th>
                            <th>Customer</th>
                            <th>Update Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_assigned as $order):
                            $order_num = get_post_meta($order->ID, 'yps_order_id', true) ?: $order->post_title;
                            $game = get_post_meta($order->ID, 'yps_game', true) ?: 'N/A';
                            $service = get_post_meta($order->ID, 'yps_service', true) ?: 'N/A';
                            $status = get_post_meta($order->ID, 'yps_status', true) ?: 'pending';
                            $customer = get_post_meta($order->ID, 'yps_customer_name', true) ?: 'Customer';

                            $status_options = array(
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'in_progress' => 'In Progress',
                                'quality_check' => 'Quality Check',
                                'completed' => 'Completed'
                            );
                            ?>
                            <tr>
                                <td style="font-weight:700;color:#FF6B9D;"><?php echo esc_html($order_num); ?></td>
                                <td><?php echo esc_html($game); ?></td>
                                <td><?php echo esc_html($service); ?></td>
                                <td style="color:#666;"><?php echo esc_html($customer); ?></td>
                                <td>
                                    <select class="yps-status-select" data-order-id="<?php echo $order->ID; ?>"
                                        style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:0.85rem;font-weight:600;background:#fff;cursor:pointer;">
                                        <?php foreach ($status_options as $opt_val => $opt_label): ?>
                                            <option value="<?php echo esc_attr($opt_val); ?>" <?php selected($status, $opt_val); ?>>
                                                <?php echo esc_html($opt_label); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="color:#aaa;font-size:0.82rem;"><?php echo get_the_date('M j, Y', $order->ID); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelects = document.querySelectorAll('.yps-status-select');
        statusSelects.forEach(function (select) {
            select.addEventListener('change', function () {
                const orderId = this.dataset.orderId;
                const newStatus = this.value;
                this.disabled = true;

                const formData = new FormData();
                formData.append('action', 'yps_update_order_status');
                formData.append('nonce', yps_ajax.nonce);
                formData.append('post_id', orderId);
                formData.append('status', newStatus);

                fetch(yps_ajax.ajax_url, { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        this.disabled = false;
                        if (data.success) {
                            this.style.backgroundColor = '#d4edda';
                            setTimeout(() => { this.style.backgroundColor = '#fff'; }, 1500);
                        } else {
                            alert(data.data.message || 'Error updating status.');
                        }
                    });
            });
        });
    });
</script>

<?php get_footer(); ?>