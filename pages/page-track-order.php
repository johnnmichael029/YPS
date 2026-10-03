<?php
/**
 * Template Name: Track Order Page
 * YPS Gaming - Track Order Page Template
 */
get_header();
?>

<section class="track-order-section" id="track-order-section">
    <div class="yps-container">
        <div class="track-order-card" id="track-order-card">

            <!-- Card Header -->
            <div class="track-card-header">
                <div style="font-size:2.5rem;margin-bottom:12px;position:relative;">📦</div>
                <h1>Track Your Order</h1>
                <p>Enter your order number or email to check the status of your service.</p>
            </div>

            <!-- Card Body -->
            <div class="track-card-body">

                <!-- Search Form -->
                <form class="track-form" id="track-order-form" novalidate>
                    <div class="track-form-row">
                        <div class="form-group">
                            <label class="form-label" for="order-id-input">Order Number</label>
                            <input type="text" 
                                   class="form-input" 
                                   id="order-id-input" 
                                   name="order_id" 
                                   placeholder="e.g. YPS123ABC"
                                   autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="order-email-input">Email (Optional)</label>
                            <input type="email" 
                                   class="form-input" 
                                   id="order-email-input" 
                                   name="email" 
                                   placeholder="your@email.com"
                                   autocomplete="email">
                        </div>
                    </div>
                    <button type="submit" class="track-btn" id="track-submit-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Track Order
                    </button>
                    <div id="track-error-msg" style="display:none;color:#ef4444;font-size:0.85rem;text-align:center;padding:8px;background:rgba(239,68,68,0.06);border-radius:8px;"></div>
                </form>

                <!-- ORDER RESULT (hidden by default, shown via JS) -->
                <div class="order-result" id="order-result">

                    <div style="border:1px solid rgba(255,107,157,0.15);border-radius:16px;padding:20px;margin-bottom:24px;background:#fff9fb;">
                        <div style="font-size:0.75rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Order ID</div>
                        <div id="result-order-id" style="font-size:1.4rem;font-weight:900;color:#FF6B9D;letter-spacing:2px;"></div>
                    </div>

                    <!-- Status Tracker -->
                    <div class="order-status-bar" id="order-status-bar">
                        <div class="status-step done" id="sstep-placed">
                            <div class="step-circle">✓</div>
                            <div class="step-label">Order Placed</div>
                        </div>
                        <div class="status-step" id="sstep-assigned">
                            <div class="step-circle">2</div>
                            <div class="step-label">Pilot Assigned</div>
                        </div>
                        <div class="status-step" id="sstep-progress">
                            <div class="step-circle">3</div>
                            <div class="step-label">In Progress</div>
                        </div>
                        <div class="status-step" id="sstep-completed">
                            <div class="step-circle">4</div>
                            <div class="step-label">Completed</div>
                        </div>
                    </div>

                    <!-- Order Detail Grid -->
                    <div class="order-details-grid" id="order-details-grid">
                        <div class="order-detail-item">
                            <div class="order-detail-label">Game</div>
                            <div class="order-detail-value" id="result-game">—</div>
                        </div>
                        <div class="order-detail-item">
                            <div class="order-detail-label">Service</div>
                            <div class="order-detail-value" id="result-service">—</div>
                        </div>
                        <div class="order-detail-item">
                            <div class="order-detail-label">Assigned Pilot</div>
                            <div class="order-detail-value" id="result-pilot">—</div>
                        </div>
                        <div class="order-detail-item">
                            <div class="order-detail-label">Est. Completion</div>
                            <div class="order-detail-value" id="result-est">—</div>
                        </div>
                        <div class="order-detail-item" style="grid-column:1/-1;">
                            <div class="order-detail-label">Current Status</div>
                            <div id="result-status-badge" style="margin-top:4px;"></div>
                        </div>
                    </div>

                    <div style="text-align:center;margin-top:20px;color:#aaa;font-size:0.82rem;">
                        Need help? <a href="<?php echo esc_url(home_url('/contact-us')); ?>" style="color:#FF6B9D;font-weight:600;">Contact our support →</a>
                    </div>
                </div>

                <!-- Demo hint -->
                <div style="margin-top:20px;padding:12px 16px;background:#f0f9ff;border-radius:10px;border:1px solid #bae6fd;font-size:0.8rem;color:#0284c7;display:flex;gap:8px;align-items:center;">
                    <span>💡</span>
                    <span>Demo: Enter any order number (e.g. <strong>YPS12345</strong>) to see a sample tracking result.</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form      = document.getElementById('track-order-form');
    const result    = document.getElementById('order-result');
    const errDiv    = document.getElementById('track-error-msg');
    const submitBtn = document.getElementById('track-submit-btn');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const orderId = document.getElementById('order-id-input').value.trim();
        const email   = document.getElementById('order-email-input').value.trim();

        errDiv.style.display = 'none';
        if (!orderId) {
            errDiv.textContent = 'Please enter your order number.';
            errDiv.style.display = 'block';
            return;
        }

        submitBtn.innerHTML = '<div class="yps-spinner"></div> Searching...';
        submitBtn.disabled = true;

        // AJAX track via WordPress
        const fd = new FormData();
        fd.append('action',   'yps_track_order');
        fd.append('nonce',    yps_ajax.nonce);
        fd.append('order_id', orderId);
        fd.append('email',    email);

        fetch(yps_ajax.ajax_url, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(function(data) {
                submitBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg> Track Order';
                submitBtn.disabled = false;

                if (data.success && data.data.found) {
                    const d = data.data;
                    document.getElementById('result-order-id').textContent  = d.order_id;
                    document.getElementById('result-game').textContent      = d.game;
                    document.getElementById('result-service').textContent   = d.service;
                    document.getElementById('result-pilot').textContent     = d.pilot;
                    document.getElementById('result-est').textContent       = d.est_completion;

                    // Status badge
                    const statusMap = {
                        'pending'     : { label: 'Pending Pilot',  cls: 'pending' },
                        'in_progress' : { label: 'In Progress',    cls: 'in-progress' },
                        'completed'   : { label: 'Completed',      cls: 'completed' },
                    };
                    const st = statusMap[d.status] || { label: d.status, cls: 'pending' };
                    document.getElementById('result-status-badge').innerHTML =
                        '<span class="status-pill ' + st.cls + '">' + st.label + '</span>';

                    // Update status steps
                    const steps = ['sstep-placed','sstep-assigned','sstep-progress','sstep-completed'];
                    const stagesMap = {
                        'pending'     : 1,
                        'in_progress' : 3,
                        'completed'   : 4,
                    };
                    const activeStage = stagesMap[d.status] || 1;
                    steps.forEach(function(id, i) {
                        const el = document.getElementById(id);
                        el.classList.remove('done','active');
                        if (i < activeStage - 1)  { el.classList.add('done'); el.querySelector('.step-circle').textContent = '✓'; }
                        else if (i === activeStage - 1) { el.classList.add('active'); el.querySelector('.step-circle').textContent = (i+1); }
                    });

                    result.classList.add('visible');
                    result.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    errDiv.textContent = 'Order not found. Please check your order number.';
                    errDiv.style.display = 'block';
                    result.classList.remove('visible');
                }
            })
            .catch(function() {
                submitBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg> Track Order';
                submitBtn.disabled = false;
                errDiv.textContent = 'Something went wrong. Please try again.';
                errDiv.style.display = 'block';
            });
    });
});
</script>

<?php get_footer(); ?>
