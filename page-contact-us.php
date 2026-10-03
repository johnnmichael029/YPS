<?php
/**
 * Template Name: Contact Us Page
 * YPS Gaming - Contact Page Template
 */
get_header();
?>

<section class="contact-section" id="contact-section">
    <div class="yps-container">
        <div class="text-center" style="margin-bottom:40px;">
            <h1 class="section-title fade-up">Contact Us</h1>
            <p class="section-subtitle fade-up">We're here to help! Reach out and we'll respond within 24 hours.</p>
        </div>

        <div class="contact-grid">
            <!-- Contact Info Column -->
            <div class="contact-info fade-up" id="contact-info-col">
                <div class="contact-info-card" id="contact-email-card">
                    <div class="contact-icon">📧</div>
                    <div class="contact-info-text">
                        <h4>Email Us</h4>
                        <p>We respond within a few hours</p>
                        <a href="mailto:yps@gmail.com">yps@gmail.com</a>
                    </div>
                </div>

                <div class="contact-info-card" id="contact-discord-card">
                    <div class="contact-icon">💬</div>
                    <div class="contact-info-text">
                        <h4>Discord</h4>
                        <p>Join our community server</p>
                        <a href="#">YPS.123456789</a>
                    </div>
                </div>

                <div class="contact-info-card" id="contact-facebook-card">
                    <div class="contact-icon">📘</div>
                    <div class="contact-info-text">
                        <h4>Facebook</h4>
                        <p>Message us on Facebook</p>
                        <a href="#">YPS.123456789</a>
                    </div>
                </div>

                <div class="contact-info-card" id="contact-payment-card">
                    <div class="contact-icon">💳</div>
                    <div class="contact-info-text">
                        <h4>Payment Methods</h4>
                        <p>We accept</p>
                        <div style="display:flex;gap:8px;margin-top:6px;">
                            <span class="pay-badge" style="background:rgba(0,119,204,0.1);color:#0077CC;border:1px solid rgba(0,119,204,0.2);">GCash</span>
                            <span class="pay-badge" style="background:rgba(0,115,195,0.1);color:#003087;border:1px solid rgba(0,115,195,0.2);">PayPal</span>
                        </div>
                    </div>
                </div>

                <!-- Hours Card -->
                <div style="background:linear-gradient(135deg,#0D2137,#1a0a3e);border-radius:16px;padding:24px;color:white;" id="contact-hours-card">
                    <h4 style="font-size:0.9rem;font-weight:700;margin-bottom:16px;color:rgba(255,255,255,0.9);">⏰ Support Hours</h4>
                    <?php
                    $hours = array('Mon - Fri: 9AM - 11PM', 'Sat - Sun: 10AM - 10PM', 'Holidays: 12PM - 8PM');
                    foreach ($hours as $h) : ?>
                    <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.06);font-size:0.82rem;color:rgba(255,255,255,0.65);"><?php echo esc_html($h); ?></div>
                    <?php endforeach; ?>
                    <div style="margin-top:12px;padding:10px;background:rgba(255,107,157,0.12);border-radius:8px;font-size:0.78rem;color:#FFB3CF;font-weight:600;">
                        💬 24/7 Order Support Available
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-card fade-up" id="contact-form-card">
                <h2 style="font-size:1.3rem;font-weight:900;margin-bottom:6px;">Send Us a Message</h2>
                <p style="color:#aaa;font-size:0.88rem;margin-bottom:24px;">Fill out the form below and we'll get back to you shortly!</p>

                <form class="contact-form" id="yps-contact-form" novalidate>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact-name">Full Name *</label>
                            <input type="text" class="form-input" id="contact-name" name="name" placeholder="Your name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact-email">Email Address *</label>
                            <input type="email" class="form-input" id="contact-email" name="email" placeholder="your@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact-game">Game</label>
                        <select class="form-input checkout-select" id="contact-game" name="game">
                            <option value="">Select a game (optional)</option>
                            <option value="genshin">🌸 Genshin Impact</option>
                            <option value="honkai">⭐ Honkai: Star Rail</option>
                            <option value="zenless">⚡ Zenless Zone Zero</option>
                            <option value="wuthering">🌊 Wuthering Waves</option>
                            <option value="other">Other / General Inquiry</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact-subject">Subject *</label>
                        <input type="text" class="form-input" id="contact-subject" name="subject" placeholder="e.g. Order inquiry, Service question..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact-message">Message *</label>
                        <textarea id="contact-message" name="message" placeholder="Tell us how we can help you..." required></textarea>
                    </div>

                    <div id="contact-error-msg" style="display:none;color:#ef4444;font-size:0.85rem;padding:10px;background:rgba(239,68,68,0.06);border-radius:8px;"></div>
                    <div id="contact-success-msg" style="display:none;color:#16a34a;font-size:0.88rem;padding:12px 16px;background:rgba(34,197,94,0.08);border-radius:10px;border:1px solid rgba(34,197,94,0.2);font-weight:600;text-align:center;"></div>

                    <button type="submit" class="yps-btn yps-btn-primary" id="contact-submit-btn" style="width:100%;justify-content:center;padding:16px;font-size:1rem;">
                        Send Message 📨
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form       = document.getElementById('yps-contact-form');
    const submitBtn  = document.getElementById('contact-submit-btn');
    const errDiv     = document.getElementById('contact-error-msg');
    const successDiv = document.getElementById('contact-success-msg');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        errDiv.style.display = 'none';
        successDiv.style.display = 'none';

        const name    = document.getElementById('contact-name').value.trim();
        const email   = document.getElementById('contact-email').value.trim();
        const subject = document.getElementById('contact-subject').value.trim();
        const message = document.getElementById('contact-message').value.trim();

        if (!name || !email || !subject || !message) {
            errDiv.textContent = 'Please fill in all required fields.';
            errDiv.style.display = 'block';
            return;
        }

        submitBtn.innerHTML = '<div class="yps-spinner"></div> Sending...';
        submitBtn.disabled = true;

        // Simulate sending (replace with actual AJAX/EmailJS in production)
        setTimeout(function() {
            submitBtn.innerHTML = 'Send Message 📨';
            submitBtn.disabled = false;
            successDiv.textContent = '✅ Message sent! We\'ll get back to you within 24 hours. Thank you, ' + name + '!';
            successDiv.style.display = 'block';
            form.reset();
        }, 1500);
    });
});
</script>

<?php get_footer(); ?>
