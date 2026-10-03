<?php
/**
 * Template Name: Admin Dashboard
 * YPS Gaming - Sales & Admin Dashboard Page Template
 * Note: Restrict this page to admins only in production.
 */
get_header();
if (!current_user_can('manage_options')) {
    wp_redirect(home_url('/'));
    exit;
}
?>

<div class="admin-layout" id="admin-layout">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="admin-sidebar" role="navigation" aria-label="Admin Navigation">
        <div class="sidebar-section-title">Main</div>
        <a href="#" class="sidebar-link active" id="sidebar-dashboard">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=yps_order')); ?>" class="sidebar-link" id="sidebar-orders">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Orders
        </a>
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=yps_pilot')); ?>" class="sidebar-link" id="sidebar-pilots">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Pilots
        </a>
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=yps_service')); ?>" class="sidebar-link" id="sidebar-services">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Services
        </a>

        <div class="sidebar-section-title">Reports</div>
        <a href="#" class="sidebar-link" id="sidebar-analytics">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Analytics
        </a>

        <div class="sidebar-section-title" style="margin-top:auto;">Account</div>
        <a href="<?php echo esc_url(admin_url()); ?>" class="sidebar-link" id="sidebar-wp-admin">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
            WP Admin
        </a>
        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="sidebar-link" id="sidebar-logout">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Logout
        </a>
    </aside>

    <!-- Main Content -->
    <main class="admin-main" id="admin-main" role="main">

        <!-- Top Bar -->
        <div class="admin-topbar" id="admin-topbar">
            <div>
                <h1>Sales Tracking</h1>
                <div class="admin-date">
                    📅 <?php echo date('M j, Y'); ?> — <?php echo date('M j, Y', strtotime('+7 days')); ?>
                </div>
            </div>
            <div style="display:flex;gap:10px;align-items:center;">
                <button class="yps-btn yps-btn-outline yps-btn-sm" id="admin-export-btn">
                    ↓ Export
                </button>
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#FF6B9D,#9B59B6);display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;font-weight:800;">
                    <?php echo strtoupper(substr(wp_get_current_user()->display_name, 0, 1)); ?>
                </div>
            </div>
        </div>

        <!-- KPI Stats -->
        <div class="admin-stats-grid" id="admin-stats">
            <?php
            // Query real stats from CPT
            $total_orders    = wp_count_posts('yps_order')->publish ?? 0;
            $pending_orders  = 0;
            $completed_orders= 0;
            $in_prog_orders  = 0;

            $orders = get_posts(array('post_type'=>'yps_order','posts_per_page'=>-1,'post_status'=>'publish'));
            foreach ($orders as $o) {
                $s = get_post_meta($o->ID,'_status',true);
                if ($s==='pending')       $pending_orders++;
                if ($s==='in_progress')   $in_prog_orders++;
                if ($s==='completed')     $completed_orders++;
            }

            $stats = array(
                array('label'=>'Total Sales',      'value'=>'₱107,850', 'change'=>'+12.5%', 'up'=>true,  'icon'=>'💰'),
                array('label'=>'Total Orders',     'value'=>max($total_orders, 62), 'change'=>'+8.3%',  'up'=>true,  'icon'=>'📦'),
                array('label'=>'Completed',        'value'=>max($completed_orders,48), 'change'=>'+5.1%','up'=>true, 'icon'=>'✅'),
                array('label'=>'In Progress',      'value'=>max($in_prog_orders, 10),  'change'=>'',     'up'=>true,  'icon'=>'⏳'),
            );
            foreach ($stats as $idx => $stat) : ?>
            <div class="stat-card" id="stat-card-<?php echo $idx+1; ?>">
                <div class="stat-label"><?php echo $stat['icon']; ?> <?php echo esc_html($stat['label']); ?></div>
                <div class="stat-value<?php echo $idx===0?' pink':''; ?>"><?php echo esc_html($stat['value']); ?></div>
                <?php if ($stat['change']) : ?>
                <div class="stat-change <?php echo $stat['up']?'':'down'; ?>">
                    <?php echo $stat['up'] ? '↑' : '↓'; ?> <?php echo esc_html($stat['change']); ?> vs last week
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Charts Row -->
        <div class="admin-grid-2" id="admin-charts-row">
            <!-- Sales Overview -->
            <div class="admin-card" id="sales-overview-card">
                <div class="admin-card-header">
                    <div class="admin-card-title">📈 Sales Overview</div>
                    <select class="checkout-select" style="padding:6px 12px;font-size:0.8rem;width:auto;" id="chart-period">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                    </select>
                </div>
                <!-- CSS Bar Chart -->
                <div class="mini-chart" id="sales-chart" style="height:100px;">
                    <?php
                    $chart_data = array(45,60,35,80,55,90,72);
                    $max = max($chart_data);
                    foreach ($chart_data as $val) :
                        $pct = round(($val/$max)*100);
                    ?>
                    <div class="chart-bar" style="height:<?php echo $pct; ?>%;" title="₱<?php echo $val * 1000; ?>"></div>
                    <?php endforeach; ?>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.7rem;color:#aaa;margin-top:6px;">
                    <?php
                    $days = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
                    foreach ($days as $day) echo '<span>' . $day . '</span>';
                    ?>
                </div>
            </div>

            <!-- Top Games by Sales -->
            <div class="admin-card" id="top-games-card">
                <div class="admin-card-header">
                    <div class="admin-card-title">🎮 Top Games by Sales</div>
                </div>
                <?php
                $top_games = array(
                    array('name'=>'Genshin Impact',    'icon'=>'🌸', 'pct'=>68, 'amount'=>'₱73,338'),
                    array('name'=>'Honkai: Star Rail',  'icon'=>'⭐', 'pct'=>18, 'amount'=>'₱19,413'),
                    array('name'=>'Zenless Zone Zero',  'icon'=>'⚡', 'pct'=>9,  'amount'=>'₱9,707'),
                    array('name'=>'Wuthering Waves',    'icon'=>'🌊', 'pct'=>5,  'amount'=>'₱5,392'),
                );
                foreach ($top_games as $g) : ?>
                <div style="margin-bottom:14px;" id="top-game-<?php echo sanitize_title($g['name']); ?>">
                    <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:5px;">
                        <span style="font-weight:600;"><?php echo $g['icon']; ?> <?php echo esc_html($g['name']); ?></span>
                        <span style="color:var(--pink);font-weight:700;"><?php echo esc_html($g['amount']); ?></span>
                    </div>
                    <div style="height:6px;background:#f0f0f0;border-radius:999px;overflow:hidden;">
                        <div style="height:100%;width:<?php echo $g['pct']; ?>%;background:linear-gradient(90deg,var(--pink),var(--purple));border-radius:999px;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="admin-card" id="recent-orders-card">
            <div class="admin-card-header">
                <div class="admin-card-title">📋 Recent Orders</div>
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=yps_order')); ?>" style="font-size:0.82rem;color:var(--pink);font-weight:600;">View All →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="admin-table" id="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Game</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Show real orders from CPT, or demo data
                        $demo_orders = array(
                            array('id'=>'YPS#935120A','game'=>'Genshin Impact','service'=>'Daily Commission','amount'=>'₱50','status'=>'completed','date'=>date('M j, Y',strtotime('-1 day'))),
                            array('id'=>'YPS#935120B','game'=>'Honkai: Star Rail','service'=>'Weekly Bosses','amount'=>'₱80','status'=>'in_progress','date'=>date('M j, Y',strtotime('-2 days'))),
                            array('id'=>'YPS#935120C','game'=>'Zenless Zone Zero','service'=>'Daily Tasks','amount'=>'₱50','status'=>'completed','date'=>date('M j, Y',strtotime('-3 days'))),
                            array('id'=>'YPS#935120D','game'=>'Wuthering Waves','service'=>'Event Farming','amount'=>'₱120','status'=>'in_progress','date'=>date('M j, Y',strtotime('-3 days'))),
                            array('id'=>'YPS#935120E','game'=>'Genshin Impact','service'=>'Spiral Abyss','amount'=>'₱150','status'=>'pending','date'=>date('M j, Y')),
                            array('id'=>'YPS#935120F','game'=>'Honkai: Star Rail','service'=>'Simulated Universe','amount'=>'₱100','status'=>'completed','date'=>date('M j, Y',strtotime('-4 days'))),
                        );

                        // Fetch real orders from yps_order CPT
                        $real_orders = get_posts(array('post_type'=>'yps_order','posts_per_page'=>20,'post_status'=>'publish','orderby'=>'date','order'=>'DESC'));
                        if (!empty($real_orders)) {
                            foreach ($real_orders as $order) {
                                $order_num = get_post_meta($order->ID, 'yps_order_id', true) ?: get_post_meta($order->ID, '_order_number', true) ?: $order->post_title;
                                $game      = get_post_meta($order->ID, 'yps_game', true) ?: get_post_meta($order->ID, '_game', true) ?: 'N/A';
                                $service   = get_post_meta($order->ID, 'yps_service', true) ?: get_post_meta($order->ID, '_service_type', true) ?: 'N/A';
                                $status    = get_post_meta($order->ID, 'yps_status', true) ?: get_post_meta($order->ID, '_status', true) ?: 'pending';
                                $customer  = get_post_meta($order->ID, 'yps_customer_name', true) ?: 'Customer';
                                
                                $status_options = array(
                                    'pending'       => 'Pending',
                                    'confirmed'     => 'Confirmed',
                                    'in_progress'   => 'In Progress',
                                    'quality_check' => 'Quality Check',
                                    'completed'     => 'Completed',
                                    'cancelled'     => 'Cancelled'
                                );
                                ?>
                                <tr id="order-row-<?php echo $order->ID; ?>">
                                    <td style="font-weight:700;color:var(--pink);">
                                        <a href="<?php echo esc_url(admin_url('post.php?post=' . $order->ID . '&action=edit')); ?>" title="Edit in WP Admin" style="color:inherit;text-decoration:underline;">
                                            <?php echo esc_html($order_num); ?>
                                        </a>
                                    </td>
                                    <td><?php echo esc_html($game); ?></td>
                                    <td><?php echo esc_html($service); ?></td>
                                    <td style="font-weight:600;color:#888;"><?php echo esc_html($customer); ?></td>
                                    <td>
                                        <select class="yps-status-select" data-order-id="<?php echo $order->ID; ?>" style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:0.85rem;font-weight:600;background:#fff;cursor:pointer;">
                                            <?php foreach ($status_options as $opt_val => $opt_label) : ?>
                                                <option value="<?php echo esc_attr($opt_val); ?>" <?php selected($status, $opt_val); ?>>
                                                    <?php echo esc_html($opt_label); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td style="color:#aaa;font-size:0.82rem;"><?php echo get_the_date('M j, Y', $order->ID); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            foreach ($demo_orders as $o) :
                                $status_cls = array('pending'=>'pending','in_progress'=>'in-progress','completed'=>'completed')[$o['status']] ?? 'pending';
                            ?>
                            <tr>
                                <td style="font-weight:700;color:var(--pink);"><?php echo esc_html($o['id']); ?></td>
                                <td><?php echo esc_html($o['game']); ?></td>
                                <td><?php echo esc_html($o['service']); ?></td>
                                <td style="font-weight:700;"><?php echo esc_html($o['amount']); ?></td>
                                <td><span class="status-pill <?php echo esc_attr($status_cls); ?>"><?php echo esc_html(ucwords(str_replace('_',' ',$o['status']))); ?></span></td>
                                <td style="color:#aaa;"><?php echo esc_html($o['date']); ?></td>
                            </tr>
                            <?php endforeach;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.yps-status-select');
    statusSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            const originalBg = this.style.backgroundColor;
            
            this.disabled = true;
            this.style.backgroundColor = '#fff9c4';

            const formData = new FormData();
            formData.append('action', 'yps_update_order_status');
            formData.append('nonce', yps_ajax.nonce);
            formData.append('post_id', orderId);
            formData.append('status', newStatus);

            fetch(yps_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                this.disabled = false;
                if (data.success) {
                    this.style.backgroundColor = '#d4edda';
                    setTimeout(() => { this.style.backgroundColor = '#fff'; }, 1500);
                } else {
                    alert(data.data.message || 'Error updating status.');
                    this.style.backgroundColor = '#f8d7da';
                }
            })
            .catch(err => {
                this.disabled = false;
                alert('Connection error.');
                this.style.backgroundColor = '#f8d7da';
            });
        });
    });
});
</script>

<?php get_footer(); ?>
