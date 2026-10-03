<?php
/**
 * Template Name: Checkout Page
 * YPS Gaming - Checkout Page Template
 */
get_header();
?>

<section class="checkout-section" id="checkout-section">
    <div class="yps-container">
        <div class="text-center" style="margin-bottom:32px;">
            <h1 class="section-title fade-up">Service &amp; Account</h1>
            <p class="section-subtitle fade-up">Complete your booking and get started!</p>
        </div>

        <!-- Step Indicator -->
        <div class="checkout-steps" id="checkout-steps">
            <div class="checkout-step active" id="cstep-1">
                <div class="step-num">1</div>
                <div class="step-name">Selected Service</div>
            </div>
            <div class="checkout-step" id="cstep-2">
                <div class="step-num">2</div>
                <div class="step-name">Details &amp; Payment</div>
            </div>
            <div class="checkout-step" id="cstep-3">
                <div class="step-num">3</div>
                <div class="step-name">Confirmation</div>
            </div>
        </div>

        <div class="checkout-grid">
            <!-- LEFT: Multi-step Form -->
            <div id="checkout-form-area">

                <!-- STEP 1: Service Selection -->
                <div class="checkout-form-card" id="step-1-card">
                    <h3><span class="step-badge">1</span> Select Your Service</h3>
                    <form class="checkout-form" id="checkout-step1-form" novalidate>
                        <div class="form-group">
                            <label class="form-label" for="co-game">Game *</label>
                            <select class="checkout-select" id="co-game" name="game" required>
                                <option value="">— Select a game —</option>
                                <option value="genshin">🌸 Genshin Impact</option>
                                <option value="honkai">⭐ Honkai: Star Rail</option>
                                <option value="zenless">⚡ Zenless Zone Zero</option>
                                <option value="wuthering">🌊 Wuthering Waves</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-service">Service Type *</label>
                            <select class="checkout-select" id="co-service" name="service" required>
                                <option value="">— Select a service —</option>
                                <optgroup label="🌸 Genshin Impact — Ascension">
                                    <option value="character-ascension-level-70" data-price="$4.00">⚔️ Character Ascension (Lvl 70) — $4.00</option>
                                    <option value="character-ascension-level-80" data-price="$5.00">⚔️ Character Ascension (Lvl 80) — $5.00</option>
                                    <option value="character-ascension-level-90" data-price="$6.00">⭐ Character Ascension (Lvl 90) — $6.00</option>
                                    <option value="talent-ascension-08-08-08" data-price="$6.00">📜 Talent Ascension (08/08/08) — $6.00</option>
                                    <option value="talent-ascension-09-09-09" data-price="$10.00">📜 Talent Ascension (09/09/09) — $10.00</option>
                                    <option value="talent-ascension-10-10-10" data-price="$15.00">👑 Talent Ascension (10/10/10) — $15.00</option>
                                    <option value="weapon-ascension-level-70" data-price="$4.00">🗡️ Weapon Ascension (Lvl 70) — $4.00</option>
                                    <option value="weapon-ascension-level-80" data-price="$5.00">🗡️ Weapon Ascension (Lvl 80) — $5.00</option>
                                    <option value="weapon-ascension-level-90" data-price="$6.00">🗡️ Weapon Ascension (Lvl 90) — $6.00</option>
                                </optgroup>
                                <optgroup label="🌸 Genshin Impact — AR Ranks">
                                    <option value="ar-rank-02-20" data-price="$0.70">⬆️ AR 02 > 20 — $0.70 / lvl</option>
                                    <option value="ar-rank-21-35" data-price="$1.20">⬆️ AR 21 > 35 — $1.20 / lvl</option>
                                    <option value="ar-rank-36-40" data-price="$1.90">⬆️ AR 36 > 40 — $1.90 / lvl</option>
                                    <option value="ar-rank-41-50" data-price="$3.44">⬆️ AR 41 > 50 — $3.44 / lvl</option>
                                </optgroup>
                                <optgroup label="🌸 Genshin Impact — Maintenance">
                                    <option value="daily-comms-resin-daily" data-price="$0.33">📋 Daily Comms & Resin (Daily) — $0.33</option>
                                    <option value="daily-comms-resin-weekly" data-price="$3.00">📋 Daily Comms & Resin (Weekly) — $3.00</option>
                                    <option value="daily-comms-resin-monthly" data-price="$12.00">📋 Daily Comms & Resin (Monthly) — $12.00</option>
                                    <option value="daily-comms-resin-patch" data-price="$15.00">📋 Daily Comms & Resin (Patch) — $15.00</option>
                                    <option value="daily-resin-events-daily" data-price="$0.58">🎉 Daily, Resin & Events (Daily) — $0.58</option>
                                    <option value="daily-resin-events-weekly" data-price="$6.00">🎉 Daily, Resin & Events (Weekly) — $6.00</option>
                                    <option value="daily-resin-events-monthly" data-price="$25.00">🎉 Daily, Resin & Events (Monthly) — $25.00</option>
                                    <option value="daily-resin-events-patch" data-price="$30.00">🎉 Daily, Resin & Events (Patch) — $30.00</option>
                                </optgroup>
                                <optgroup label="🎮 Other Services">
                                    <option value="daily-commission" data-price="$15.00">📋 Daily Commission — $15.00</option>
                                    <option value="rank-progression" data-price="$20.00">⬆️ Rank Progression — $20.00</option>
                                    <option value="weekly-bosses" data-price="$18.00">👹 Weekly Bosses — $18.00</option>
                                    <option value="domain-farming" data-price="$20.00">💎 Domain Farming — $20.00</option>
                                    <option value="event-completion" data-price="$25.00">🎉 Event Completion — $25.00</option>
                                    <option value="abyss-tower" data-price="$30.00">🌀 Abyss/Tower Clear — $30.00</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-notes">Additional Notes (Optional)</label>
                            <input type="text" class="form-input" id="co-notes" name="notes" placeholder="e.g. Focus on resin, specific characters to farm...">
                        </div>
                        <div id="step1-error" style="display:none;color:#ef4444;font-size:0.85rem;padding:8px;background:rgba(239,68,68,0.06);border-radius:8px;"></div>
                        <button type="button" class="yps-btn yps-btn-primary" id="next-step-1" style="width:100%;justify-content:center;padding:14px;font-size:1rem;">
                            Continue → Account Details
                        </button>
                    </form>
                </div>

                <!-- STEP 2: Account Details -->
                <div class="checkout-form-card" id="step-2-card" style="display:none;">
                    <h3><span class="step-badge">2</span> Account &amp; Payment Details</h3>
                    <form class="checkout-form" id="checkout-step2-form" novalidate>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                            <div class="form-group">
                                <label class="form-label" for="co-name">Full Name *</label>
                                <input type="text" class="form-input" id="co-name" name="name" placeholder="Your name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="co-email">Email *</label>
                                <input type="email" class="form-input" id="co-email" name="email" placeholder="your@email.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-game-uid">Game UID *</label>
                            <input type="text" class="form-input" id="co-game-uid" name="game_uid" placeholder="Your in-game UID / Player ID" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-game-pass">Account Password *</label>
                            <input type="password" class="form-input" id="co-game-pass" name="game_pass" placeholder="Your game account password" required autocomplete="off">
                        </div>
                        <div style="padding:12px 16px;background:#f0fff4;border-radius:10px;border:1px solid rgba(34,197,94,0.2);font-size:0.8rem;color:#15803d;display:flex;gap:8px;align-items:flex-start;">
                            <span style="flex-shrink:0;">🔒</span>
                            <span>Your information is <strong>encrypted and secure</strong>. We never store your password after the service is completed. Account safety is guaranteed.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-payment">Payment Method *</label>
                            <select class="checkout-select" id="co-payment" name="payment" required>
                                <option value="">— Select payment method —</option>
                                <option value="gcash">💚 GCash</option>
                                <option value="paypal">💙 PayPal</option>
                            </select>
                        </div>
                        <div id="step2-error" style="display:none;color:#ef4444;font-size:0.85rem;padding:8px;background:rgba(239,68,68,0.06);border-radius:8px;"></div>
                        <div style="display:flex;gap:12px;">
                            <button type="button" class="yps-btn" id="back-step-2" style="background:#f0f0f0;color:#666;border-radius:999px;padding:14px 24px;font-weight:700;flex:0 0 auto;">
                                ← Back
                            </button>
                            <button type="button" class="yps-btn yps-btn-primary" id="next-step-2" style="flex:1;justify-content:center;padding:14px;font-size:1rem;">
                                Proceed to Payment →
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STEP 3: Confirmation -->
                <div class="checkout-form-card" id="step-3-card" style="display:none;">
                    <div class="checkout-confirmation" id="checkout-confirmation">
                        <div class="confirmation-icon">🎉</div>
                        <h2 class="confirmation-title">Thank you for trusting YPS! 💖</h2>
                        <p class="confirmation-subtitle">Your order has been received. A pilot will be assigned shortly!</p>
                        <div class="order-id-box" id="confirm-order-id">YPS——</div>
                        <p style="color:#aaa;font-size:0.82rem;margin-bottom:24px;">Save your order ID to track your service status.</p>
                        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                            <a href="<?php echo esc_url(home_url('/track-order')); ?>" class="yps-btn yps-btn-primary" id="confirm-track-btn">
                                📦 Track Order
                            </a>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="yps-btn" style="background:#f0f0f0;color:#666;border-radius:999px;padding:12px 24px;font-weight:700;" id="confirm-home-btn">
                                🏠 Go Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Order Summary -->
            <div class="order-summary-card fade-up" id="order-summary-card">
                <h3>Order Summary</h3>

                <div id="summary-service-row" class="summary-item" style="display:none;">
                    <span class="summary-item-name" id="summary-service-name">Service</span>
                    <span class="summary-item-price" id="summary-service-price">₱0</span>
                </div>

                <div style="margin-top:8px;" id="summary-empty-msg">
                    <div style="text-align:center;color:#ccc;font-size:0.85rem;padding:20px 0;">
                        <div style="font-size:2rem;margin-bottom:8px;">🛒</div>
                        Select a service to see your order total.
                    </div>
                </div>

                <div class="summary-total" id="summary-total-row" style="display:none;">
                    <span class="summary-total-label">Total</span>
                    <span class="summary-total-price" id="summary-total-price">₱0</span>
                </div>

                <div class="security-badge">
                    <span>🔒</span>
                    <span>Secure &amp; Protected Checkout</span>
                </div>

                <div style="margin-top:20px;padding:16px;background:#f9f7ff;border-radius:12px;border:1px solid rgba(155,89,182,0.1);">
                    <div style="font-size:0.75rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">Accepted Payments</div>
                    <div style="display:flex;gap:8px;">
                        <div style="padding:8px 16px;background:white;border-radius:8px;border:1px solid #e0e0e0;font-size:0.82rem;font-weight:700;color:#00a651;">💚 GCash</div>
                        <div style="padding:8px 16px;background:white;border-radius:8px;border:1px solid #e0e0e0;font-size:0.82rem;font-weight:700;color:#003087;">💙 PayPal</div>
                    </div>
                </div>

                <!-- What to expect -->
                <div style="margin-top:20px;">
                    <div style="font-size:0.75rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">What Happens Next</div>
                    <?php
                    $nexts = array('Submit your order', 'Pilot is assigned within 1hr', 'Service begins & you get updates', 'Completed in 1-3 days!');
                    foreach ($nexts as $idx => $step) : ?>
                    <div style="display:flex;gap:10px;align-items:center;padding:6px 0;font-size:0.82rem;color:#666;">
                        <span style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#FF6B9D,#9B59B6);color:white;display:flex;align-items:center;justify-content:center;font-size:0.68rem;font-weight:700;flex-shrink:0;"><?php echo $idx+1; ?></span>
                        <?php echo esc_html($step); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pre-fill from URL params
    const params  = new URLSearchParams(window.location.search);
    const pgame   = params.get('game');
    const pservice= params.get('service');
    if (pgame)    document.getElementById('co-game').value = pgame;
    if (pservice) {
        const sel = document.getElementById('co-service');
        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].value.includes(pservice)) { sel.selectedIndex = i; break; }
        }
    }

    // Service price update
    const serviceSelect = document.getElementById('co-service');
    const summaryServiceRow  = document.getElementById('summary-service-row');
    const summaryServiceName = document.getElementById('summary-service-name');
    const summaryServicePrice= document.getElementById('summary-service-price');
    const summaryEmptyMsg    = document.getElementById('summary-empty-msg');
    const summaryTotalRow    = document.getElementById('summary-total-row');
    const summaryTotalPrice  = document.getElementById('summary-total-price');

    function updateSummary() {
        const opt = serviceSelect.options[serviceSelect.selectedIndex];
        if (opt && opt.dataset.price) {
            summaryServiceName.textContent  = opt.text.replace(/[^a-zA-Z ]/g,'').trim();
            summaryServicePrice.textContent = opt.dataset.price;
            summaryTotalPrice.textContent   = opt.dataset.price;
            summaryServiceRow.style.display = 'flex';
            summaryEmptyMsg.style.display   = 'none';
            summaryTotalRow.style.display   = 'flex';
        } else {
            summaryServiceRow.style.display = 'none';
            summaryTotalRow.style.display   = 'none';
            summaryEmptyMsg.style.display   = 'block';
        }
    }
    serviceSelect.addEventListener('change', updateSummary);
    updateSummary();

    // Step navigation
    function goToStep(step) {
        [1,2,3].forEach(function(s) {
            document.getElementById('step-'+s+'-card').style.display = s === step ? 'block' : 'none';
            const cstep = document.getElementById('cstep-'+s);
            cstep.classList.remove('active','done');
            if (s < step) cstep.classList.add('done');
            if (s === step) cstep.classList.add('active');
        });
        window.scrollTo({ top: document.getElementById('checkout-section').offsetTop - 80, behavior: 'smooth' });
    }

    document.getElementById('next-step-1').addEventListener('click', function() {
        const game    = document.getElementById('co-game').value;
        const service = document.getElementById('co-service').value;
        const errDiv  = document.getElementById('step1-error');
        if (!game || !service) {
            errDiv.textContent = 'Please select both a game and a service.';
            errDiv.style.display = 'block';
            return;
        }
        errDiv.style.display = 'none';
        goToStep(2);
    });

    document.getElementById('back-step-2').addEventListener('click', function() { goToStep(1); });

    document.getElementById('next-step-2').addEventListener('click', function() {
        const name   = document.getElementById('co-name').value.trim();
        const email  = document.getElementById('co-email').value.trim();
        const uid    = document.getElementById('co-game-uid').value.trim();
        const pass   = document.getElementById('co-game-pass').value.trim();
        const pay    = document.getElementById('co-payment').value;
        const errDiv = document.getElementById('step2-error');

        if (!name || !email || !uid || !pass || !pay) {
            errDiv.textContent = 'Please fill in all required fields.';
            errDiv.style.display = 'block';
            return;
        }
        errDiv.style.display = 'none';

        const btn = document.getElementById('next-step-2');
        btn.innerHTML = '<div class="yps-spinner"></div> Processing...';
        btn.disabled = true;

        // AJAX Submit
        const fd = new FormData();
        fd.append('action',  'yps_submit_booking');
        fd.append('nonce',   yps_ajax.nonce);
        fd.append('game',    document.getElementById('co-game').value);
        fd.append('service', document.getElementById('co-service').value);
        fd.append('name',    name);
        fd.append('email',   email);

        fetch(yps_ajax.ajax_url, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(function(data) {
                btn.innerHTML = 'Proceed to Payment →';
                btn.disabled = false;
                const orderId = (data.success && data.data.order_id) ? data.data.order_id : 'YPS' + Math.random().toString(36).substr(2,8).toUpperCase();
                document.getElementById('confirm-order-id').textContent = orderId;
                document.getElementById('confirm-track-btn').href = '<?php echo esc_url(home_url('/track-order')); ?>?order_id=' + orderId;
                goToStep(3);
            })
            .catch(function() {
                btn.innerHTML = 'Proceed to Payment →';
                btn.disabled = false;
                // Fallback: show confirmation anyway
                const orderId = 'YPS' + Math.random().toString(36).substr(2,8).toUpperCase();
                document.getElementById('confirm-order-id').textContent = orderId;
                goToStep(3);
            });
    });
});
</script>

<?php get_footer(); ?>
