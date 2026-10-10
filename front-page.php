<?php
/**
 * Template Name: Home Page
 * YPS Gaming - Front Page Template
 */
get_header();
?>

<!-- HERO SECTION -->
<section class="yps-hero" id="hero-section">
    <div class="hero-bg">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-poster.png"
            alt="YPS Gaming Hero Background" loading="eager" fetchpriority="high" decoding="async">
    </div>
    <div class="yps-container">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Trusted by 5,000+ Gamers
            </div>
            <h1 class="hero-title">
                Your Trusted<br>
                <span class="accent">Gaming Piloting</span><br>
                Services
            </h1>
            <p class="hero-desc">
                Let our skilled pilots help you enjoy your favorite games — faster, easier, and worry-free!
                Safe • Reliable • Professional
            </p>
            <div class="hero-actions">
                <a href="<?php echo esc_url(home_url('/checkout')); ?>" class="yps-btn yps-btn-primary"
                    id="hero-book-btn">
                    Book Now →
                </a>
                <a href="<?php echo esc_url(home_url('/services')); ?>" class="yps-btn yps-btn-outline"
                    id="hero-services-btn">
                    View Services
                </a>
            </div>
            <div class="hero-badges">
                <div class="trust-badge">
                    <span class="badge-icon">🛡️</span>
                    <div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.55);">Account</div>
                        Safe &amp; Secure
                    </div>
                </div>
                <div class="trust-badge">
                    <span class="badge-icon">👾</span>
                    <div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.55);">Verified</div>
                        Experienced Pilots
                    </div>
                </div>
                <div class="trust-badge">
                    <span class="badge-icon">⚡</span>
                    <div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.55);">Always</div>
                        Real-Time Updates
                    </div>
                </div>
                <div class="trust-badge">
                    <span class="badge-icon">💬</span>
                    <div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.55);">Always Here</div>
                        24/7 Support
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- QUICK BOOKING BAR -->
<div class="yps-quick-booking" id="quick-booking">
    <div class="yps-container">
        <div class="booking-bar-inner">
            <span class="booking-bar-label">Quick Book:</span>
            <div class="booking-tabs" role="tablist">
                <a href="<?php echo esc_url(home_url('/checkout?service=maintenance')); ?>" class="booking-tab active"
                    id="book-tab-maintenance" role="tab">
                    <span class="booking-tab-icon">🔧</span> Maintenance
                </a>
                <a href="<?php echo esc_url(home_url('/checkout?service=rank-progression')); ?>" class="booking-tab"
                    id="book-tab-rank" role="tab">
                    <span class="booking-tab-icon">⬆️</span> Rank Progression
                </a>
                <a href="<?php echo esc_url(home_url('/checkout?service=questing')); ?>" class="booking-tab"
                    id="book-tab-questing" role="tab">
                    <span class="booking-tab-icon">⚔️</span> Questing
                </a>
                <a href="<?php echo esc_url(home_url('/checkout?service=events')); ?>" class="booking-tab"
                    id="book-tab-events" role="tab">
                    <span class="booking-tab-icon">🎉</span> Events
                </a>
            </div>
        </div>
    </div>
</div>

<!-- FEATURED GAMES SECTION -->
<section class="yps-featured-games" id="featured-games">
    <div class="featured-games-bg"></div>
    <div class="yps-container" style="position:relative;z-index:1;">
        <h2 class="section-title fade-up">Featured Games</h2>
        <p class="section-subtitle fade-up">Choose your game and we'll handle the rest!</p>

        <div class="games-grid">
            <?php
            $games = array(
                array('name' => 'Genshin Impact', 'icon' => '🌸', 'slug' => 'genshin', 'color' => 'linear-gradient(135deg,#a8edea,#fed6e3)'),
                array('name' => 'Honkai: Star Rail', 'icon' => '⭐', 'slug' => 'honkai', 'color' => 'linear-gradient(135deg,#c2e9fb,#a1c4fd)'),
                array('name' => 'Zenless Zone Zero', 'icon' => '⚡', 'slug' => 'zenless', 'color' => 'linear-gradient(135deg,#fccb90,#d57eeb)'),
                array('name' => 'Wuthering Waves', 'icon' => '🌊', 'slug' => 'wuthering', 'color' => 'linear-gradient(135deg,#e0c3fc,#8ec5fc)'),
            );

            foreach ($games as $idx => $game):
                ?>
                <div class="game-card fade-up" id="game-card-<?php echo esc_attr($game['slug']); ?>">
                    <div class="game-thumb" style="background: <?php echo $game['color']; ?>;">
                        <?php
                        $slug = $game['slug'];
                        $possible_files = array("game-{$slug}.jpg", "bg-{$slug}.jpg", "game-{$slug}.png", "bg-{$slug}.png", "game-{$slug}.webp", "bg-{$slug}.webp");
                        $found_image = '';
                        foreach ($possible_files as $pf) {
                            if (file_exists(get_template_directory() . '/assets/images/' . $pf)) {
                                $found_image = $pf;
                                break;
                            }
                        }
                        if ($found_image): ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo esc_attr($found_image); ?>"
                                alt="<?php echo esc_attr($game['name']); ?>">
                        <?php else: ?>
                            <div class="game-thumb-placeholder"><?php echo $game['icon']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="game-info">
                        <h3><?php echo esc_html($game['name']); ?></h3>
                        <a href="<?php echo esc_url(home_url('/services#' . $game['slug'])); ?>"
                            class="yps-btn yps-btn-primary yps-btn-sm" id="book-<?php echo esc_attr($game['slug']); ?>">
                            Book Now →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 
GAMES OFFERED SECTION
<section class="yps-section" style="background: #fff; padding: 80px 0;" id="games-offered">
    <div class="yps-container">
        <h2 class="section-title text-center fade-up" style="font-size:2.2rem; font-weight:900; letter-spacing:0.05em; text-transform:uppercase; margin-bottom:48px;">Games Offered</h2>
        <div style="display:grid; grid-template-columns: repeat(3,1fr); gap:40px; max-width:800px; margin:0 auto;">
            <?php
            $games_offered = array(
                array('name' => 'Genshin Impact', 'slug' => 'genshin-impact', 'color' => '#E8D5A3'),
                array('name' => 'Honkai Star Rail', 'slug' => 'honkai-star-rail', 'color' => '#D5C8E8'),
                array('name' => 'Zenless Zone Zero', 'slug' => 'zenless-zone-zero', 'color' => '#F5A623'),
                array('name' => 'Wuthering Waves', 'slug' => 'wuthering-waves', 'color' => '#A3C4E8'),
                array('name' => 'Neverness to Everness', 'slug' => 'neverness-to-everness', 'color' => '#A8D8A8'),
                array('name' => 'Arknight Endfields', 'slug' => 'arknight-endfields', 'color' => '#E8A3A3'),
            );
            foreach ($games_offered as $g):
                $img_path = get_template_directory() . '/assets/images/game-' . $g['slug'] . '.jpg';
                ?>
            <div class="fade-up" style="display:flex; flex-direction:column; align-items:center; gap:14px; text-align:center;">
                <div style="width:140px; height:140px; border-radius:20px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.12); background:<?php echo $g['color']; ?>;">
                    <?php if (file_exists($img_path)): ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/game-<?php echo esc_attr($g['slug']); ?>.jpg"
                             alt="<?php echo esc_attr($g['name']); ?>"
                             style="width:100%; height:100%; object-fit:cover;">
                    <?php else: ?>
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:3rem;">??</div>
                    <?php endif; ?>
                </div>
                <span style="font-size:1rem; font-weight:700; color:#1a1a2e;"><?php echo esc_html($g['name']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> -->

<!-- SERVICES & PAYMENT SECTION -->
<section class="yps-section" style="background: #f9f7ff; padding: 80px 0;" id="services-payment">
    <div class="yps-container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:60px; max-width:900px; margin:0 auto;">
            <!-- Services Offered -->
            <div class="fade-up">
                <h2
                    style="font-size:1.5rem; font-weight:900; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:24px; color:#1a1a2e;">
                    Services Offered</h2>
                <ul style="list-style:disc; padding-left:24px; display:flex; flex-direction:column; gap:10px;">
                    <?php
                    $services = array('Maintenance', 'Exploration', 'Quest', 'Rank Leveling', 'Currency Farming', 'Character Building', 'Events');
                    foreach ($services as $s): ?>
                        <li style="font-size:1rem; color:#2d2d4e; font-weight:500;"><?php echo esc_html($s); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- Payment Methods -->
            <div class="fade-up">
                <h2
                    style="font-size:1.5rem; font-weight:900; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:24px; color:#1a1a2e;">
                    Payment Methods</h2>
                <ul style="list-style:disc; padding-left:24px; display:flex; flex-direction:column; gap:10px;">
                    <?php
                    $payments = array('GCash', 'Paymaya', 'PayPal (FNF option only)', 'Binance', 'Remitly');
                    foreach ($payments as $p): ?>
                        <li style="font-size:1rem; color:#2d2d4e; font-weight:500;"><?php echo esc_html($p); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- WHY CHOOSE US SECTION -->
<section class="yps-section" style="background: white;" id="why-us">
    <div class="yps-container">
        <h2 class="section-title text-center fade-up">Why Choose YPS.CO?</h2>
        <p class="section-subtitle text-center fade-up">We make gaming stress-free and fun again.</p>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-top: 40px;">
            <?php
            $whys = array(
                array('icon' => '🛡️', 'title' => 'Account Safety First', 'desc' => 'Your account credentials are encrypted and never shared. We use secure methods to protect your privacy.'),
                array('icon' => '⚡', 'title' => 'Fast Completion', 'desc' => 'Our experienced pilots work efficiently. Most services are completed within 1-3 days with real-time updates.'),
                array('icon' => '💎', 'title' => 'Premium Quality', 'desc' => 'Every pilot is tested and verified. We guarantee high-quality results or we redo it for free.'),
                array('icon' => '💰', 'title' => 'Affordable Pricing', 'desc' => 'Competitive rates with no hidden fees. Transparent pricing so you always know what you\'re paying for.'),
                array('icon' => '📱', 'title' => '24/7 Customer Support', 'desc' => 'Our support team is always online to answer your questions and provide updates on your orders.'),
                array('icon' => '🎮', 'title' => 'Multiple Games', 'desc' => 'Genshin Impact, Honkai: Star Rail, Zenless Zone Zero, and Wuthering Waves — all covered by our expert pilots.'),
            );
            foreach ($whys as $idx => $why): ?>
                <div class="feature-card fade-up" id="why-card-<?php echo $idx + 1; ?>">
                    <span class="feature-icon"><?php echo $why['icon']; ?></span>
                    <h3 class="feature-title"><?php echo esc_html($why['title']); ?></h3>
                    <p class="feature-desc"><?php echo esc_html($why['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TESTIMONIALS / TRUST SECTION -->
<section class="yps-section" style="background: linear-gradient(180deg, #f0f8ff 0%, #fce4ef 100%);" id="testimonials">
    <div class="yps-container">
        <h2 class="section-title text-center fade-up">What Our Clients Say</h2>
        <p class="section-subtitle text-center fade-up">5,000+ happy gamers and counting! ⭐</p>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 40px;">
            <?php
            $reviews = array(
                array('name' => 'Rae M.', 'game' => 'Genshin Impact', 'stars' => 5, 'text' => 'Completed my daily commissions and resin farming so fast! Pilot was super professional and communicated well throughout.'),
                array('name' => 'Kai T.', 'game' => 'Honkai: Star Rail', 'stars' => 5, 'text' => 'Reached the rank I wanted in 2 days! Amazing service, totally worth it. Will definitely book again!'),
                array('name' => 'Mika J.', 'game' => 'Zenless Zone Zero', 'stars' => 5, 'text' => 'The event completion service saved me so much time. Got all the limited items I wanted. YPS is the best!'),
            );
            foreach ($reviews as $idx => $review): ?>
                <div style="background: white; border-radius: 20px; padding: 28px; box-shadow: 0 4px 24px rgba(0,0,0,0.07); transition: all 0.3s ease;"
                    class="fade-up" id="review-card-<?php echo $idx + 1; ?>"
                    onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(255,107,157,0.18)'"
                    onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 24px rgba(0,0,0,0.07)'">
                    <div style="color: #FFD700; font-size: 1.1rem; margin-bottom: 12px;">
                        <?php echo str_repeat('★', $review['stars']); ?>
                    </div>
                    <p style="font-size: 0.9rem; color: #555; line-height: 1.7; margin-bottom: 16px; font-style: italic;">
                        "<?php echo esc_html($review['text']); ?>"
                    </p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #FF6B9D, #9B59B6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.9rem;">
                            <?php echo esc_html(substr($review['name'], 0, 1)); ?>
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 0.9rem;"><?php echo esc_html($review['name']); ?></div>
                            <div style="font-size: 0.75rem; color: #999;"><?php echo esc_html($review['game']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section
    style="background: linear-gradient(135deg, #0D2137, #1a0a3e); padding: 80px 0; text-align: center; position: relative; overflow: hidden;"
    id="cta-section">
    <div
        style="position:absolute;top:-60px;left:-60px;width:200px;height:200px;background:radial-gradient(circle,rgba(255,107,157,0.12) 0%,transparent 70%);border-radius:50%;">
    </div>
    <div
        style="position:absolute;bottom:-60px;right:-60px;width:200px;height:200px;background:radial-gradient(circle,rgba(155,89,182,0.12) 0%,transparent 70%);border-radius:50%;">
    </div>
    <div class="yps-container" style="position:relative;z-index:1;">
        <h2 style="font-size: clamp(1.8rem,4vw,2.8rem); font-weight:900; color:white; margin-bottom:16px;">
            Ready to Level Up? 🚀
        </h2>
        <p
            style="color: rgba(255,255,255,0.7); font-size: 1rem; margin-bottom: 32px; max-width: 500px; margin-left: auto; margin-right: auto;">
            Join thousands of gamers who trust YPS.CO for their gaming journey. Book your first service today!
        </p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="<?php echo esc_url(home_url('/checkout')); ?>" class="yps-btn yps-btn-primary" id="cta-book-btn"
                style="font-size:1rem; padding:14px 36px;">
                Book Now →
            </a>
            <a href="<?php echo esc_url(home_url('/our-pilots')); ?>" class="yps-btn" id="cta-pilots-btn"
                style="background:rgba(255,255,255,0.1); color:white; border:2px solid rgba(255,255,255,0.2); font-size:1rem; padding:14px 36px; border-radius:999px; font-weight:700; transition:all 0.3s;">
                Meet Our Pilots
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>