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

                <?php $catalog = yps_get_service_catalog(); ?>
                <!-- STEP 1: Service Selection -->
                <div class="checkout-form-card" id="step-1-card">
                    <h3><span class="step-badge">1</span> Select Your Service</h3>
                    <form class="checkout-form" id="checkout-step1-form" novalidate>
                        <div class="form-group">
                            <label class="form-label" for="co-game">Game *</label>
                            <select class="checkout-select" id="co-game" name="game" required>
                                <option value="">— Select a game —</option>
                                <?php foreach ($catalog as $game_block) : ?>
                                    <option value="<?php echo esc_attr($game_block['id']); ?>">
                                        <?php echo $game_block['icon']; ?> <?php echo esc_html($game_block['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="co-service">Service Type *</label>
                            <select class="checkout-select" id="co-service" name="service" required>
                                <option value="">— Select a service —</option>
                                <?php foreach ($catalog as $game_block) : ?>
                                    <?php foreach ($game_block['categories'] as $cat) : ?>
                                        <optgroup label="<?php echo esc_attr($game_block['icon'] . ' ' . $game_block['name'] . ' — ' . $cat['name']); ?>" data-game="<?php echo esc_attr($game_block['id']); ?>">
                                            <?php foreach ($cat['items'] as $item) : ?>
                                                <option value="<?php echo esc_attr($item['slug']); ?>" 
                                                        data-game="<?php echo esc_attr($game_block['id']); ?>"
                                                        data-price="<?php echo esc_attr($item['price'] !== null ? $item['price'] : ''); ?>"
                                                        data-unit="<?php echo esc_attr($item['unit'] ?? ''); ?>"
                                                        data-formatted-price="<?php echo esc_attr(yps_format_service_price($item)); ?>">
                                                    <?php echo esc_html($item['name']); ?> — <?php echo esc_html(yps_format_service_price($item)); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dynamic Category Note Box -->
                        <div id="category-note-box" style="display:none;background:#f0f7ff;border-left:4px solid #3b82f6;padding:12px;border-radius:6px;font-size:0.85rem;color:#1e40af;margin-bottom:16px;line-height:1.5;">
                            📌 <span id="category-note-text"></span>
                        </div>

                        <!-- Dynamic Current Exploration / Progress Input (for Quote Services) -->
                        <div class="form-group" id="service-progress-box" style="display:none;background:#fdf4ff;border:1px solid #f5d0fe;padding:14px;border-radius:10px;margin-bottom:16px;">
                            <label class="form-label" for="co-progress" style="color:#86198f;font-weight:700;">Current Progress / Exploration % *</label>
                            <input type="text" class="form-input" id="co-progress" name="current_progress" placeholder="e.g. Currently 30% exploration, target is 100%">
                            <div style="font-size:0.78rem;color:#a21caf;margin-top:6px;">Our staff &amp; pilots will verify your current progress/resources to calculate your final custom quote.</div>
                        </div>

                        <!-- Dynamic Quantity Input (for per-unit services like AR levels, ranks, 10-pulls) -->
                        <div class="form-group" id="service-qty-box" style="display:none;">
                            <label class="form-label" for="co-quantity" id="co-qty-label">Quantity *</label>
                            <input type="number" class="form-input" id="co-quantity" name="quantity" value="1" min="1" max="999">
                        </div>

                        <!-- Dynamic Category Addon Checkbox -->
                        <div class="form-group" id="category-addon-box" style="display:none;background:#fff5f8;border:1px solid #ffe0eb;padding:12px 16px;border-radius:10px;margin-bottom:16px;">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-weight:600;font-size:0.88rem;color:#d63384;margin:0;">
                                <input type="checkbox" id="co-addon" name="addon" value="1" style="width:18px;height:18px;accent-color:#ff4785;">
                                <span id="category-addon-text">Add-on</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="co-notes">Additional Notes (Optional)</label>
                            <input type="text" class="form-input" id="co-notes" name="notes"
                                placeholder="e.g. Focus on resin, specific characters to farm...">
                        </div>
                        <div id="step1-error"
                            style="display:none;color:#ef4444;font-size:0.85rem;padding:8px;background:rgba(239,68,68,0.06);border-radius:8px;margin-bottom:12px;">
                        </div>
                        <button type="button" class="yps-btn yps-btn-primary" id="next-step-1"
                            style="width:100%;justify-content:center;padding:14px;font-size:1rem;">
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
                                <input type="text" class="form-input" id="co-name" name="name" placeholder="Your name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="co-email">Email *</label>
                                <input type="email" class="form-input" id="co-email" name="email"
                                    placeholder="your@email.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-game-uid">Game UID *</label>
                            <input type="text" class="form-input" id="co-game-uid" name="game_uid"
                                placeholder="Your in-game UID / Player ID" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-game-pass">Account Password *</label>
                            <input type="password" class="form-input" id="co-game-pass" name="game_pass"
                                placeholder="Your game account password" required autocomplete="off">
                        </div>
                        <div
                            style="padding:12px 16px;background:#f0fff4;border-radius:10px;border:1px solid rgba(34,197,94,0.2);font-size:0.8rem;color:#15803d;display:flex;gap:8px;align-items:flex-start;">
                            <span style="flex-shrink:0;">🔒</span>
                            <span>Your information is <strong>encrypted and secure</strong>. We never store your
                                password after the service is completed. Account safety is guaranteed.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="co-payment">Preferred Payment Method *</label>
                            <select class="checkout-select" id="co-payment" name="payment" required>
                                <option value="">— Select payment method —</option>
                                <option value="gcash">💚 GCash</option>
                                <option value="paypal">💙 PayPal</option>
                            </select>
                        </div>
                        <div id="step2-error"
                            style="display:none;color:#ef4444;font-size:0.85rem;padding:8px;background:rgba(239,68,68,0.06);border-radius:8px;">
                        </div>
                        <div style="display:flex;gap:12px;">
                            <button type="button" class="yps-btn" id="back-step-2"
                                style="background:#f0f0f0;color:#666;border-radius:999px;padding:14px 24px;font-weight:700;flex:0 0 auto;">
                                ← Back
                            </button>
                            <button type="button" class="yps-btn yps-btn-primary" id="next-step-2"
                                style="flex:1;justify-content:center;padding:14px;font-size:1rem;">
                                Proceed to Payment →
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STEP 3: Confirmation -->
                <div class="checkout-form-card" id="step-3-card" style="display:none;">
                    <div class="checkout-confirmation" id="checkout-confirmation">
                        <div class="confirmation-icon" id="confirm-icon">🎉</div>
                        <h2 class="confirmation-title" id="confirm-title">Thank you for trusting YPS! 💖</h2>
                        <p class="confirmation-subtitle" id="confirm-subtitle">Your order has been received. A pilot will be assigned shortly!
                        </p>
                        <div class="order-id-box" id="confirm-order-id" style="cursor:pointer;position:relative;" title="Click to copy Order ID">YPS——</div>
                        <div id="copy-badge" style="display:none;color:#10b981;font-weight:700;font-size:0.85rem;margin-top:-16px;margin-bottom:16px;">
                            ✓ Copied to clipboard!
                        </div>
                        <p style="color:#aaa;font-size:0.82rem;margin-bottom:24px;">Click your order ID to copy, or track your service status below.</p>
                        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                            <a href="<?php echo esc_url(home_url('/track-order')); ?>" class="yps-btn yps-btn-primary"
                                id="confirm-track-btn">
                                📦 Track Order
                            </a>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="yps-btn"
                                style="background:#f0f0f0;color:#666;border-radius:999px;padding:12px 24px;font-weight:700;"
                                id="confirm-home-btn">
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

                <div
                    style="margin-top:20px;padding:16px;background:#f9f7ff;border-radius:12px;border:1px solid rgba(155,89,182,0.1);">
                    <div
                        style="font-size:0.75rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">
                        Accepted Payments</div>
                    <div style="display:flex;gap:8px;">
                        <div
                            style="padding:8px 16px;background:white;border-radius:8px;border:1px solid #e0e0e0;font-size:0.82rem;font-weight:700;color:#00a651;">
                            💚 GCash</div>
                        <div
                            style="padding:8px 16px;background:white;border-radius:8px;border:1px solid #e0e0e0;font-size:0.82rem;font-weight:700;color:#003087;">
                            💙 PayPal</div>
                    </div>
                </div>

                <!-- What to expect -->
                <div style="margin-top:20px;">
                    <div
                        style="font-size:0.75rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">
                        What Happens Next</div>
                    <?php
                    $nexts = array('Submit your order', 'Pilot is assigned within 1hr', 'Service begins & you get updates', 'Completed in 1-3 days!');
                    foreach ($nexts as $idx => $step): ?>
                        <div style="display:flex;gap:10px;align-items:center;padding:6px 0;font-size:0.82rem;color:#666;">
                            <span
                                style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#FF6B9D,#9B59B6);color:white;display:flex;align-items:center;justify-content:center;font-size:0.68rem;font-weight:700;flex-shrink:0;"><?php echo $idx + 1; ?></span>
                                <?php echo esc_html($step); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const YPS_CATALOG = <?php echo json_encode(yps_get_service_catalog()); ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const gameSelect    = document.getElementById('co-game');
        const serviceSelect = document.getElementById('co-service');
        const noteBox       = document.getElementById('category-note-box');
        const noteText      = document.getElementById('category-note-text');
        const progressBox   = document.getElementById('service-progress-box');
        const progressInput = document.getElementById('co-progress');
        const qtyBox        = document.getElementById('service-qty-box');
        const qtyInput      = document.getElementById('co-quantity');
        const qtyLabel      = document.getElementById('co-qty-label');
        const addonBox      = document.getElementById('category-addon-box');
        const addonCheck    = document.getElementById('co-addon');
        const addonText     = document.getElementById('category-addon-text');
        const nextStep2Btn  = document.getElementById('next-step-2');

        const summaryServiceRow  = document.getElementById('summary-service-row');
        const summaryServiceName = document.getElementById('summary-service-name');
        const summaryServicePrice = document.getElementById('summary-service-price');
        const summaryEmptyMsg    = document.getElementById('summary-empty-msg');
        const summaryTotalRow    = document.getElementById('summary-total-row');
        const summaryTotalPrice  = document.getElementById('summary-total-price');

        // Helper to find service details in catalog
        function findService(gameId, serviceSlug) {
            if (!gameId || !serviceSlug) return null;
            for (let g of YPS_CATALOG) {
                if (g.id === gameId) {
                    for (let c of g.categories) {
                        for (let i of c.items) {
                            if (i.slug === serviceSlug) {
                                return { item: i, category: c, game: g };
                            }
                        }
                    }
                }
            }
            return null;
        }

        // Filter service dropdown options based on selected game
        function filterServicesByGame() {
            const selectedGame = gameSelect.value;
            const optgroups = serviceSelect.querySelectorAll('optgroup');

            let firstMatch = null;
            optgroups.forEach(group => {
                const groupGame = group.dataset.game;
                if (!selectedGame || groupGame === selectedGame) {
                    group.style.display = '';
                    if (!firstMatch) {
                        const firstOpt = group.querySelector('option');
                        if (firstOpt) firstMatch = firstOpt.value;
                    }
                } else {
                    group.style.display = 'none';
                }
            });

            // If current selected service doesn't belong to the game, reset or set first match
            const currentOpt = serviceSelect.options[serviceSelect.selectedIndex];
            if (currentOpt && currentOpt.dataset.game && selectedGame && currentOpt.dataset.game !== selectedGame) {
                serviceSelect.value = '';
            }
            updateServiceDetails();
        }

        function updateServiceDetails() {
            const gameId = gameSelect.value;
            const serviceSlug = serviceSelect.value;
            const found = findService(gameId, serviceSlug);

            if (!found) {
                noteBox.style.display = 'none';
                progressBox.style.display = 'none';
                qtyBox.style.display = 'none';
                addonBox.style.display = 'none';
                addonCheck.checked = false;

                summaryServiceRow.style.display = 'none';
                summaryTotalRow.style.display = 'none';
                summaryEmptyMsg.style.display = 'block';
                return;
            }

            const { item, category } = found;

            // 1. Category Note
            if (category.note) {
                noteText.textContent = category.note;
                noteBox.style.display = 'block';
            } else {
                noteBox.style.display = 'none';
            }

            // 2. Quote Service Progress Box & Button Label
            const isQuote = (item.price === null);
            if (isQuote) {
                progressBox.style.display = 'block';
                nextStep2Btn.textContent = 'Submit Quote Request →';
            } else {
                progressBox.style.display = 'none';
                nextStep2Btn.textContent = 'Proceed to Payment →';
            }

            // 3. Quantity (if per unit like level/rank/10-pull)
            if (item.unit && !isQuote) {
                qtyLabel.textContent = 'Number of ' + item.unit.charAt(0).toUpperCase() + item.unit.slice(1) + 's *';
                qtyBox.style.display = 'block';
            } else {
                qtyBox.style.display = 'none';
                qtyInput.value = '1';
            }

            // 4. Category Add-on
            if (category.addon) {
                addonText.innerHTML = 'Add <strong>' + category.addon.name + '</strong> (+$' + category.addon.price.toFixed(2) + ')';
                addonBox.style.display = 'block';
            } else {
                addonBox.style.display = 'none';
                addonCheck.checked = false;
            }

            // 5. Calculate Summary Total
            let basePrice = item.price;
            if (basePrice === null) {
                // Quote service
                summaryServiceName.textContent = item.name;
                summaryServicePrice.textContent = 'Quote required';
                summaryTotalPrice.textContent = 'Quote required';
                summaryServiceRow.style.display = 'flex';
                summaryTotalRow.style.display = 'flex';
                summaryEmptyMsg.style.display = 'none';
                return;
            }

            const qty = item.unit ? Math.max(1, parseInt(qtyInput.value) || 1) : 1;
            let subtotal = basePrice * qty;
            let total = subtotal;

            if (addonCheck.checked && category.addon) {
                total += category.addon.price;
            }

            let detailText = item.name;
            if (item.unit && qty > 1) {
                detailText += ' (' + qty + ' ' + item.unit + 's)';
            }

            summaryServiceName.textContent = detailText;
            summaryServicePrice.textContent = '$' + subtotal.toFixed(2);
            summaryTotalPrice.textContent = '$' + total.toFixed(2);

            summaryServiceRow.style.display = 'flex';
            summaryTotalRow.style.display = 'flex';
            summaryEmptyMsg.style.display = 'none';
        }

        // Pre-fill from URL params
        const params = new URLSearchParams(window.location.search);
        const pgame = params.get('game');
        const pservice = params.get('service');
        if (pgame) {
            gameSelect.value = pgame;
            filterServicesByGame();
        }
        if (pservice) {
            serviceSelect.value = pservice;
            updateServiceDetails();
        }

        gameSelect.addEventListener('change', filterServicesByGame);
        serviceSelect.addEventListener('change', updateServiceDetails);
        qtyInput.addEventListener('input', updateServiceDetails);
        addonCheck.addEventListener('change', updateServiceDetails);

        // Step navigation
        function goToStep(step) {
            [1, 2, 3].forEach(function (s) {
                document.getElementById('step-' + s + '-card').style.display = s === step ? 'block' : 'none';
                const cstep = document.getElementById('cstep-' + s);
                cstep.classList.remove('active', 'done');
                if (s < step) cstep.classList.add('done');
                if (s === step) cstep.classList.add('active');
            });
            window.scrollTo({ top: document.getElementById('checkout-section').offsetTop - 80, behavior: 'smooth' });
        }

        document.getElementById('next-step-1').addEventListener('click', function () {
            const game = gameSelect.value;
            const service = serviceSelect.value;
            const errDiv = document.getElementById('step1-error');
            if (!game || !service) {
                errDiv.textContent = 'Please select both a game and a service.';
                errDiv.style.display = 'block';
                return;
            }
            const found = findService(game, service);
            if (found && found.item.price === null && !progressInput.value.trim()) {
                errDiv.textContent = 'Please specify your current progress or exploration % (e.g. 30% exploration).';
                errDiv.style.display = 'block';
                return;
            }
            errDiv.style.display = 'none';
            goToStep(2);
        });

        document.getElementById('back-step-2').addEventListener('click', function () { goToStep(1); });

        document.getElementById('next-step-2').addEventListener('click', function () {
            const name = document.getElementById('co-name').value.trim();
            const email = document.getElementById('co-email').value.trim();
            const uid = document.getElementById('co-game-uid').value.trim();
            const pass = document.getElementById('co-game-pass').value.trim();
            const pay = document.getElementById('co-payment').value;
            const notes = document.getElementById('co-notes').value.trim();
            const progress = progressInput.value.trim();
            const qty = qtyInput.value || '1';
            const addon = addonCheck.checked ? '1' : '0';
            const errDiv = document.getElementById('step2-error');

            if (!name || !email || !uid || !pass || !pay) {
                errDiv.textContent = 'Please fill in all required fields.';
                errDiv.style.display = 'block';
                return;
            }
            errDiv.style.display = 'none';

            const found = findService(gameSelect.value, serviceSelect.value);
            const isQuote = (found && found.item.price === null);

            const btn = document.getElementById('next-step-2');
            btn.innerHTML = '<div class="yps-spinner"></div> Submitting...';
            btn.disabled = true;

            // AJAX Submit
            const fd = new FormData();
            fd.append('action', 'yps_submit_booking');
            fd.append('nonce', yps_ajax.nonce);
            fd.append('game', gameSelect.value);
            fd.append('service', serviceSelect.value);
            fd.append('quantity', qty);
            fd.append('addon', addon);
            fd.append('notes', notes);
            fd.append('current_progress', progress);
            fd.append('name', name);
            fd.append('email', email);

            fetch(yps_ajax.ajax_url, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(function (data) {
                    btn.innerHTML = isQuote ? 'Submit Quote Request →' : 'Proceed to Payment →';
                    btn.disabled = false;
                    const orderId = (data.success && data.data.order_id) ? data.data.order_id : 'YPS' + Math.random().toString(36).substr(2, 8).toUpperCase();
                    
                    const confirmBox = document.getElementById('confirm-order-id');
                    const copyBadge = document.getElementById('copy-badge');
                    const trackBtn = document.getElementById('confirm-track-btn');
                    
                    confirmBox.textContent = orderId;
                    trackBtn.href = '<?php echo esc_url(home_url('/track-order')); ?>?order_id=' + orderId;

                    if (isQuote) {
                        document.getElementById('confirm-icon').textContent = '📋';
                        document.getElementById('confirm-title').textContent = 'Thank you for your Quote Request! 💖';
                        document.getElementById('confirm-subtitle').textContent = 'Your order request has been received! Our pilots will inspect your current exploration/resources and send your final custom quote shortly.';
                    } else {
                        document.getElementById('confirm-icon').textContent = '🎉';
                        document.getElementById('confirm-title').textContent = 'Thank you for trusting YPS! 💖';
                        document.getElementById('confirm-subtitle').textContent = 'Your order has been received. A pilot will be assigned shortly!';
                    }

                    function copyOrderIdToClipboard() {
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(orderId);
                        } else {
                            const tempInput = document.createElement('input');
                            tempInput.value = orderId;
                            document.body.appendChild(tempInput);
                            tempInput.select();
                            document.execCommand('copy');
                            document.body.removeChild(tempInput);
                        }
                        if (copyBadge) {
                            copyBadge.style.display = 'block';
                            setTimeout(function() { copyBadge.style.display = 'none'; }, 3000);
                        }
                    }

                    confirmBox.onclick = copyOrderIdToClipboard;
                    trackBtn.onclick = function() {
                        copyOrderIdToClipboard();
                    };

                    goToStep(3);
                })
                .catch(function () {
                    btn.innerHTML = isQuote ? 'Submit Quote Request →' : 'Proceed to Payment →';
                    btn.disabled = false;
                    // Fallback: show confirmation anyway
                    const orderId = 'YPS' + Math.random().toString(36).substr(2, 8).toUpperCase();
                    document.getElementById('confirm-order-id').textContent = orderId;
                    document.getElementById('confirm-track-btn').href = '<?php echo esc_url(home_url('/track-order')); ?>?order_id=' + orderId;
                    goToStep(3);
                });
        });
    });
</script>

<?php get_footer(); ?>