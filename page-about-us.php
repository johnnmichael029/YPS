<?php
/**
 * Template Name: About Us Page
 * YPS Gaming - About Page Template
 */
get_header();
?>

<!-- ABOUT HERO -->
<section class="about-hero" id="about-hero">
    <div style="position:absolute;top:-80px;left:-80px;width:300px;height:300px;background:radial-gradient(circle,rgba(255,107,157,0.1) 0%,transparent 70%);border-radius:50%;"></div>
    <div style="position:absolute;bottom:-80px;right:-80px;width:300px;height:300px;background:radial-gradient(circle,rgba(155,89,182,0.1) 0%,transparent 70%);border-radius:50%;"></div>
    <div class="yps-container">
        <div class="about-hero-grid">
            <div class="about-hero-text">
                <span class="sub-heading">More Than Just a Service</span>
                <h1>About <span style="background:linear-gradient(135deg,#FF6B9D,#9B59B6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">YPS.CO</span></h1>
                <p>
                    YPS.CO is a gaming piloting service platform dedicated to helping players enjoy their favorite games without the stress. We provide safe, reliable, and professional piloting services for Genshin Impact, Honkai: Star Rail, Zenless Zone Zero, and Wuthering Waves.
                </p>
                <p>
                    Our team of verified pilots brings years of gaming experience to every order. Whether you need daily maintenance, rank progression, event completion, or questing — we've got you covered with transparency and care.
                </p>
                <p style="font-weight: 700; color: #FFB3CF; font-size: 1.05rem; font-style: italic;">
                    "Play Higher, Stress Less." ✨
                </p>
                <div style="display:flex;gap:12px;margin-top:24px;flex-wrap:wrap;">
                    <a href="<?php echo esc_url(home_url('/checkout')); ?>" class="yps-btn yps-btn-primary" id="about-book-btn">
                        Book a Service →
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="yps-btn" id="about-contact-btn" style="background:rgba(255,255,255,0.1);color:white;border:2px solid rgba(255,255,255,0.25);border-radius:999px;padding:12px 28px;font-weight:700;font-size:0.95rem;transition:all 0.3s;">
                        Contact Us
                    </a>
                </div>
            </div>
            <div class="about-hero-image">
                <div style="width:100%;max-width:400px;height:400px;border-radius:24px;background:linear-gradient(135deg,rgba(255,107,157,0.15),rgba(155,89,182,0.15));border:1px solid rgba(255,107,157,0.2);display:flex;align-items:center;justify-content:center;font-size:8rem;backdrop-filter:blur(10px);">
                    🎮
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TRUST FEATURES -->
<section class="about-features" id="about-features">
    <div class="yps-container">
        <h2 class="section-title text-center fade-up">Why Thousands Trust Us</h2>
        <p class="section-subtitle text-center fade-up">Our commitment to quality and safety sets us apart.</p>
        <div class="features-grid">
            <?php
            $features = array(
                array('icon'=>'🛡️', 'title'=>'Trusted Pilots',        'desc'=>'All pilots are verified and experienced. We background-check and test every pilot before they join our team.'),
                array('icon'=>'🔒', 'title'=>'Account Safety',         'desc'=>'Your account security is our top priority. We use secure methods and never store your passwords.'),
                array('icon'=>'💰', 'title'=>'Transparent Pricing',    'desc'=>'No hidden fees. What you see is what you pay. Clear pricing for every service and game.'),
                array('icon'=>'💬', 'title'=>'24/7 Support',           'desc'=>'Our support team is always online to assist you, answer questions, and provide real-time order updates.'),
            );
            foreach ($features as $idx => $f) : ?>
            <div class="feature-card fade-up" id="feature-<?php echo $idx+1; ?>">
                <span class="feature-icon"><?php echo $f['icon']; ?></span>
                <h3 class="feature-title"><?php echo esc_html($f['title']); ?></h3>
                <p class="feature-desc"><?php echo esc_html($f['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- OUR STORY TIMELINE -->
<section class="yps-section" style="background: linear-gradient(180deg, #f0f8ff 0%, #f8f0ff 100%);" id="our-story">
    <div class="yps-container">
        <h2 class="section-title text-center fade-up">Our Story</h2>
        <p class="section-subtitle text-center fade-up">How YPS.CO came to be your trusted gaming partner.</p>

        <div style="max-width:700px;margin:40px auto 0;display:flex;flex-direction:column;gap:0;" id="story-timeline">
            <?php
            $timeline = array(
                array('year'=>'2022', 'icon'=>'🌱', 'title'=>'The Beginning',       'desc'=>'YPS.CO started as a small group of Genshin Impact enthusiasts who wanted to help friends manage their daily resin without the burnout.'),
                array('year'=>'2023', 'icon'=>'🚀', 'title'=>'Expanding Our Reach', 'desc'=>'We expanded to Honkai: Star Rail at launch, growing our pilot team and building our first order tracking system.'),
                array('year'=>'2024', 'icon'=>'⭐', 'title'=>'Going Professional',  'desc'=>'With 1,000+ orders completed, we officially launched YPS.CO with a full website, verified pilot system, and 24/7 support.'),
                array('year'=>'2025', 'icon'=>'🎮', 'title'=>'All 4 Games',         'desc'=>'Added Zenless Zone Zero and Wuthering Waves. Now serving 5,000+ happy clients across all major gacha games.'),
            );
            foreach ($timeline as $idx => $item) : ?>
            <div class="fade-up" style="display:flex;gap:24px;padding-bottom:<?php echo $idx < count($timeline)-1 ? '32px':'0'; ?>;position:relative;" id="timeline-<?php echo $idx+1; ?>">
                <?php if ($idx < count($timeline)-1) : ?>
                <div style="position:absolute;left:20px;top:40px;bottom:0;width:2px;background:linear-gradient(180deg,rgba(255,107,157,0.4),transparent);z-index:0;"></div>
                <?php endif; ?>
                <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#FF6B9D,#9B59B6);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;box-shadow:0 4px 12px rgba(255,107,157,0.3);z-index:1;">
                    <?php echo $item['icon']; ?>
                </div>
                <div>
                    <div style="font-size:0.75rem;font-weight:700;color:#FF6B9D;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;"><?php echo esc_html($item['year']); ?></div>
                    <h3 style="font-size:1.05rem;font-weight:800;margin-bottom:8px;"><?php echo esc_html($item['title']); ?></h3>
                    <p style="font-size:0.88rem;color:#666;line-height:1.7;"><?php echo esc_html($item['desc']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CONTACT INFO STRIP -->
<section style="background: var(--teal-dark); padding: 60px 0;" id="about-contact-strip">
    <div class="yps-container">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:32px;text-align:center;">
            <?php
            $contacts = array(
                array('icon'=>'📧','label'=>'Email',    'value'=>'yps@gmail.com',      'href'=>'mailto:yps@gmail.com'),
                array('icon'=>'💬','label'=>'Discord',  'value'=>'YPS.123456789',      'href'=>'#'),
                array('icon'=>'📘','label'=>'Facebook', 'value'=>'YPS.123456789',      'href'=>'#'),
            );
            foreach ($contacts as $c) : ?>
            <div style="color:rgba(255,255,255,0.9);">
                <div style="font-size:2rem;margin-bottom:12px;"><?php echo $c['icon']; ?></div>
                <div style="font-size:0.75rem;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;"><?php echo esc_html($c['label']); ?></div>
                <a href="<?php echo esc_attr($c['href']); ?>" style="font-size:0.95rem;font-weight:600;color:white;transition:color 0.3s;" onmouseover="this.style.color='#FF6B9D'" onmouseout="this.style.color='white'">
                    <?php echo esc_html($c['value']); ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
