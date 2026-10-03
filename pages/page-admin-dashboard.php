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

        <?php
        // =========================================================
        // REAL DATA: aggregate every order in the database
        // =========================================================
        $now_ts   = current_time('timestamp');
        $today    = date('Y-m-d', $now_ts);
        $period   = isset($_GET['period']) ? intval($_GET['period']) : 7;
        if (!in_array($period, array(7, 30, 90), true)) $period = 7;

        $all_orders = get_posts(array(
            'post_type'      => 'yps_order',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));

        $total_sales      = 0.0;
        $total_orders     = count($all_orders);
        $count_by_status  = array('pending'=>0,'confirmed'=>0,'in_progress'=>0,'quality_check'=>0,'completed'=>0,'cancelled'=>0);
        $sales_by_game    = array();
        $sales_by_day     = array();   // 'Y-m-d' => amount
        $this_week_sales  = 0.0; $last_week_sales  = 0.0;
        $this_week_orders = 0;   $last_week_orders = 0;

        $week_start      = date('Y-m-d', strtotime('-6 days', $now_ts));
        $prev_week_start = date('Y-m-d', strtotime('-13 days', $now_ts));

        foreach ($all_orders as $o) {
            $status = get_post_meta($o->ID, 'yps_status', true) ?: 'pending';
            $amount = yps_get_order_amount($o->ID);
            $game   = get_post_meta($o->ID, 'yps_game', true) ?: 'other';
            $day    = get_the_date('Y-m-d', $o->ID);

            if (isset($count_by_status[$status])) $count_by_status[$status]++;

            // Weekly order counts (all orders)
            if ($day >= $week_start)                                  $this_week_orders++;
            elseif ($day >= $prev_week_start && $day < $week_start)   $last_week_orders++;

            // Cancelled orders don't count toward sales
            if ($status === 'cancelled') continue;

            $total_sales += $amount;
            $sales_by_game[$game] = ($sales_by_game[$game] ?? 0) + $amount;
            $sales_by_day[$day]   = ($sales_by_day[$day] ?? 0) + $amount;

            if ($day >= $week_start)                                  $this_week_sales += $amount;
            elseif ($day >= $prev_week_start && $day < $week_start)   $last_week_sales += $amount;
        }

        // Week-over-week % change (null when there's nothing to compare against)
        $pct_change = function ($current, $previous) {
            if ($previous <= 0) return null;
            return round((($current - $previous) / $previous) * 100, 1);
        };
        $sales_change  = $pct_change($this_week_sales, $last_week_sales);
        $orders_change = $pct_change($this_week_orders, $last_week_orders);

        // Chart buckets: daily for 7/30 days, weekly for 90 days
        $chart = array();
        if ($period === 90) {
            for ($w = 12; $w >= 0; $w--) {
                $end   = strtotime('-' . ($w * 7) . ' days', $now_ts);
                $start = strtotime('-6 days', $end);
                $sum   = 0.0;
                for ($d = $start; $d <= $end; $d += DAY_IN_SECONDS) {
                    $sum += $sales_by_day[date('Y-m-d', $d)] ?? 0;
                }
                $chart[] = array('label' => date('M j', $start), 'value' => $sum);
            }
        } else {
            for ($i = $period - 1; $i >= 0; $i--) {
                $d = strtotime('-' . $i . ' days', $now_ts);
                $chart[] = array(
                    'label' => $period === 7 ? date('D', $d) : date('j', $d),
                    'value' => $sales_by_day[date('Y-m-d', $d)] ?? 0,
                );
            }
        }
        $chart_max = max(array_merge(array(0), array_column($chart, 'value')));

        arsort($sales_by_game);
        $range_start = date('M j, Y', strtotime('-' . ($period - 1) . ' days', $now_ts));
        ?>

        <!-- Top Bar -->
        <div class="admin-topbar" id="admin-topbar">
            <div>
                <h1>Sales Tracking</h1>
                <div class="admin-date">
                    📅 <?php echo esc_html($range_start); ?> — <?php echo esc_html(date('M j, Y', $now_ts)); ?>
                </div>
            </div>
            <div style="display:flex;gap:10px;align-items:center;">
                <button class="yps-btn yps-btn-outline yps-btn-sm" id="admin-export-btn" type="button">
                    ↓ Export
                </button>
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#FF6B9D,#9B59B6);display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;font-weight:800;">
                    <?php echo esc_html(strtoupper(substr(wp_get_current_user()->display_name, 0, 1))); ?>
                </div>
            </div>
        </div>

        <!-- KPI Stats -->
        <div class="admin-stats-grid" id="admin-stats">
            <?php
            $stats = array(
                array('label'=>'Total Sales',  'value'=>yps_format_money($total_sales), 'change'=>$sales_change,  'icon'=>'💰', 'note'=>''),
                array('label'=>'Total Orders', 'value'=>$total_orders,                  'change'=>$orders_change, 'icon'=>'📦', 'note'=>''),
                array('label'=>'Completed',    'value'=>$count_by_status['completed'],  'change'=>null,           'icon'=>'✅', 'note'=>''),
                array('label'=>'In Progress',  'value'=>$count_by_status['in_progress'] + $count_by_status['quality_check'] + $count_by_status['confirmed'],
                      'change'=>null, 'icon'=>'⏳', 'note'=>$count_by_status['pending'] . ' pending'),
            );
            foreach ($stats as $idx => $stat) : ?>
            <div class="stat-card" id="stat-card-<?php echo $idx+1; ?>">
                <div class="stat-label"><?php echo $stat['icon']; ?> <?php echo esc_html($stat['label']); ?></div>
                <div class="stat-value<?php echo $idx===0?' pink':''; ?>"><?php echo esc_html($stat['value']); ?></div>
                <?php if ($stat['change'] !== null) : $up = $stat['change'] >= 0; ?>
                <div class="stat-change <?php echo $up ? '' : 'down'; ?>">
                    <?php echo $up ? '↑' : '↓'; ?> <?php echo esc_html(abs($stat['change'])); ?>% vs last week
                </div>
                <?php elseif ($stat['note']) : ?>
                <div class="stat-change" style="color:#aaa;"><?php echo esc_html($stat['note']); ?></div>
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
                    <select class="checkout-select" style="padding:6px 12px;font-size:0.8rem;width:auto;" id="chart-period"
                            onchange="window.location.search='?period='+this.value">
                        <option value="7"  <?php selected($period, 7); ?>>Last 7 Days</option>
                        <option value="30" <?php selected($period, 30); ?>>Last 30 Days</option>
                        <option value="90" <?php selected($period, 90); ?>>Last 90 Days</option>
                    </select>
                </div>
                <?php if ($chart_max > 0) : ?>
                <div class="mini-chart" id="sales-chart" style="height:100px;">
                    <?php foreach ($chart as $bar) :
                        $pct = $chart_max > 0 ? max(2, round(($bar['value'] / $chart_max) * 100)) : 2; ?>
                    <div class="chart-bar" style="height:<?php echo $pct; ?>%;" title="<?php echo esc_attr($bar['label'] . ': ' . yps_format_money($bar['value'])); ?>"></div>
                    <?php endforeach; ?>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.7rem;color:#aaa;margin-top:6px;">
                    <?php
                    // Avoid label clutter on long ranges
                    $step = count($chart) > 14 ? (int) ceil(count($chart) / 7) : 1;
                    foreach ($chart as $i => $bar) {
                        echo '<span>' . ($i % $step === 0 ? esc_html($bar['label']) : '') . '</span>';
                    }
                    ?>
                </div>
                <?php else : ?>
                <div style="height:120px;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:0.85rem;">
                    No sales in this period yet.
                </div>
                <?php endif; ?>
            </div>

            <!-- Top Games by Sales -->
            <div class="admin-card" id="top-games-card">
                <div class="admin-card-header">
                    <div class="admin-card-title">🎮 Top Games by Sales</div>
                </div>
                <?php if (!empty($sales_by_game) && $total_sales > 0) :
                    foreach ($sales_by_game as $game_id => $amount) :
                        $info = yps_get_game_info($game_id);
                        $pct  = round(($amount / $total_sales) * 100); ?>
                <div style="margin-bottom:14px;" id="top-game-<?php echo esc_attr($game_id); ?>">
                    <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:5px;">
                        <span style="font-weight:600;"><?php echo $info['icon']; ?> <?php echo esc_html($info['name']); ?></span>
                        <span style="color:var(--pink);font-weight:700;"><?php echo esc_html(yps_format_money($amount)); ?></span>
                    </div>
                    <div style="height:6px;background:#f0f0f0;border-radius:999px;overflow:hidden;">
                        <div style="height:100%;width:<?php echo $pct; ?>%;background:linear-gradient(90deg,var(--pink),var(--purple));border-radius:999px;"></div>
                    </div>
                </div>
                <?php endforeach;
                else : ?>
                <div style="height:120px;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:0.85rem;">
                    No sales yet.
                </div>
                <?php endif; ?>
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
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Assigned Pilot</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $recent_orders  = array_slice($all_orders, 0, 20);
                        $pilot_names    = yps_get_pilot_names();
                        $status_options = array(
                            'pending'       => 'Pending',
                            'confirmed'     => 'Confirmed',
                            'in_progress'   => 'In Progress',
                            'quality_check' => 'Quality Check',
                            'completed'     => 'Completed',
                            'cancelled'     => 'Cancelled',
                        );

                        if (empty($recent_orders)) : ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:32px;color:#aaa;">
                                No orders yet. New bookings will appear here automatically.
                            </td>
                        </tr>
                        <?php else :
                            foreach ($recent_orders as $order) :
                                $order_num   = get_post_meta($order->ID, 'yps_order_id', true) ?: $order->post_title;
                                $game_id     = get_post_meta($order->ID, 'yps_game', true);
                                $service     = get_post_meta($order->ID, 'yps_service', true);
                                $status      = get_post_meta($order->ID, 'yps_status', true) ?: 'pending';
                                $customer    = get_post_meta($order->ID, 'yps_customer_name', true) ?: '—';
                                $pilot       = get_post_meta($order->ID, 'yps_pilot', true) ?: 'Unassigned';
                                $game_info   = yps_get_game_info($game_id);
                                $needs_quote = get_post_meta($order->ID, 'yps_needs_quote', true);
                                $progress    = get_post_meta($order->ID, 'yps_current_progress', true);
                                $amount      = yps_get_order_amount($order->ID);
                            ?>
                        <tr id="order-row-<?php echo $order->ID; ?>">
                            <td style="font-weight:700;color:var(--pink);">
                                <a href="<?php echo esc_url(admin_url('post.php?post=' . $order->ID . '&action=edit')); ?>" title="Edit in WP Admin" style="color:inherit;text-decoration:underline;">
                                    <?php echo esc_html($order_num); ?>
                                </a>
                            </td>
                            <td><?php echo $game_info['icon']; ?> <?php echo esc_html($game_info['name']); ?></td>
                            <td>
                                <div><?php echo esc_html(yps_get_service_name($game_id, $service)); ?></div>
                                <?php if (!empty($progress)) : ?>
                                <div style="font-size:0.75rem;color:#9333ea;font-weight:600;margin-top:2px;">
                                    🎯 <?php echo esc_html($progress); ?>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight:600;color:#888;"><?php echo esc_html($customer); ?></td>
                            <td style="font-weight:700;">
                                <?php if ($needs_quote && $amount <= 0) : ?>
                                    <span style="color:#d946ef;font-weight:800;font-size:0.75rem;background:#fdf4ff;padding:2px 8px;border-radius:6px;border:1px solid #f5d0fe;display:inline-block;">📋 Quote Needed</span>
                                <?php else : ?>
                                    <?php echo esc_html(yps_format_money($amount)); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <select class="yps-pilot-select" data-order-id="<?php echo $order->ID; ?>" style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:0.85rem;font-weight:600;background:#fff;cursor:pointer;">
                                    <option value="Unassigned" <?php selected($pilot, 'Unassigned'); ?>>— Unassigned —</option>
                                    <?php foreach ($pilot_names as $p_name) : ?>
                                        <option value="<?php echo esc_attr($p_name); ?>" <?php selected($pilot, $p_name); ?>><?php echo esc_html($p_name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select class="yps-status-select" data-order-id="<?php echo $order->ID; ?>" style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:0.85rem;font-weight:600;background:#fff;cursor:pointer;">
                                    <?php foreach ($status_options as $opt_val => $opt_label) : ?>
                                        <option value="<?php echo esc_attr($opt_val); ?>" <?php selected($status, $opt_val); ?>><?php echo esc_html($opt_label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td style="color:#aaa;font-size:0.82rem;"><?php echo get_the_date('M j, Y', $order->ID); ?></td>
                        </tr>
                            <?php endforeach;
                        endif; ?>
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

    // Assign pilot
    document.querySelectorAll('.yps-pilot-select').forEach(function(select) {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            this.disabled = true;
            this.style.backgroundColor = '#fff9c4';

            const formData = new FormData();
            formData.append('action', 'yps_assign_pilot');
            formData.append('nonce', yps_ajax.nonce);
            formData.append('post_id', orderId);
            formData.append('pilot', this.value);

            fetch(yps_ajax.ajax_url, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                this.disabled = false;
                if (data.success) {
                    this.style.backgroundColor = '#d4edda';
                    setTimeout(() => { this.style.backgroundColor = '#fff'; }, 1500);
                    // Reflect auto-confirmed status
                    const statusSel = document.querySelector('.yps-status-select[data-order-id="' + orderId + '"]');
                    if (statusSel && data.data.status) statusSel.value = data.data.status;
                } else {
                    alert((data.data && data.data.message) || 'Error assigning pilot.');
                    this.style.backgroundColor = '#f8d7da';
                }
            })
            .catch(() => {
                this.disabled = false;
                alert('Connection error.');
                this.style.backgroundColor = '#f8d7da';
            });
        });
    });

    // Export Recent Orders to CSV
    const exportBtn = document.getElementById('admin-export-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            const rows = document.querySelectorAll('#orders-table tr');
            const csv = [];
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('th, td');
                if (cells.length < 2) return; // skip "no orders" row
                const vals = [];
                cells.forEach(function(cell) {
                    const sel = cell.querySelector('select');
                    let text = sel ? sel.options[sel.selectedIndex].text : cell.innerText;
                    text = text.trim().replace(/"/g, '""');
                    vals.push('"' + text + '"');
                });
                csv.push(vals.join(','));
            });
            const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'yps-orders-' + new Date().toISOString().slice(0, 10) + '.csv';
            a.click();
            URL.revokeObjectURL(a.href);
        });
    }
});
</script>

<?php get_footer(); ?>
