<?php
/**
 * Template Name: Our Pilots Page
 * YPS Gaming - Pilots Directory Page Template
 */
get_header();
?>

<!-- PAGE HERO -->
<section class="yps-page-hero" id="pilots-hero">
    <div class="yps-container">
        <div class="page-hero-content">
            <div class="hero-badge"
                style="display:inline-flex;margin:0 auto 16px;background:rgba(255,107,157,0.15);border:1px solid rgba(255,107,157,0.3);color:#FFB3CF;border-radius:999px;padding:6px 16px;font-size:0.8rem;font-weight:600;">
                &#9992; Meet the Team
            </div>
            <h1>Meet Our Pilots</h1>
            <p>7 skilled pilots. 6 games. 1 trusted team.<br>Verified, experienced, and dedicated to giving you the best
                service possible.</p>
        </div>
    </div>
</section>

<!-- STATS BAR -->
<section style="background: linear-gradient(135deg, #0D2137, #1a0a3e); padding: 40px 0;" id="pilots-stats-section">
    <div class="yps-container">
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:24px; text-align:center;">
            <?php
            $stats = array(
                array('num' => '500+', 'label' => 'Orders Completed'),
                array('num' => '7', 'label' => 'Active Pilots'),
                array('num' => '6', 'label' => 'Games Covered'),
                array('num' => '4.9★', 'label' => 'Average Rating'),
            );
            foreach ($stats as $s): ?>
                <div class="fade-up">
                    <div style="font-size:2rem;font-weight:900;color:#FF6B9D;margin-bottom:4px;">
                        <?php echo esc_html($s['num']); ?></div>
                    <div style="font-size:0.85rem;color:rgba(255,255,255,0.65);font-weight:500;">
                        <?php echo esc_html($s['label']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PILOTS GRID -->
<section class="yps-section" style="background: linear-gradient(180deg, #f0f8ff 0%, #fdf0f6 100%);" id="pilots-content">
    <div class="yps-container">
        <h2 class="section-title text-center fade-up">Our Pilot Team</h2>
        <p class="section-subtitle text-center fade-up">Every pilot is verified, experienced, and assigned based on your
            game and service.</p>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;margin-top:48px;" id="pilots-grid">
            <?php
            $pilots = array(
                array('handle' => 'Yuna', 'initial' => 'Y', 'color' => 'linear-gradient(135deg,#FF6B9D,#9B59B6)', 'spec' => 'Genshin Impact Expert', 'badge' => '#FF6B9D', 'games' => array('Genshin Impact', 'Honkai: Star Rail'), 'orders' => 142, 'desc' => 'Top-ranked pilot specializing in Account Maintenance, Primohunts, and Character Ascension.'),
                array('handle' => 'Yulia', 'initial' => 'Y', 'color' => 'linear-gradient(135deg,#9B59B6,#3498DB)', 'spec' => 'Honkai Star Rail Pro', 'badge' => '#9B59B6', 'games' => array('Honkai: Star Rail', 'Zenless Zone Zero'), 'orders' => 118, 'desc' => 'Specialist in Stellar Jade Farming, Trailblazer leveling, and Memory of Chaos clears.'),
                array('handle' => 'Anastasya', 'initial' => 'A', 'color' => 'linear-gradient(135deg,#00BCD4,#3F51B5)', 'spec' => 'Wuthering Waves Specialist', 'badge' => '#00BCD4', 'games' => array('Wuthering Waves', 'Genshin Impact'), 'orders' => 98, 'desc' => 'Expert in Astrites Hunting, Tower of Adversity clears, and Echo farming.'),
                array('handle' => 'Fruenah', 'initial' => 'F', 'color' => 'linear-gradient(135deg,#4CAF50,#00BCD4)', 'spec' => 'Quests & Exploration Pro', 'badge' => '#4CAF50', 'games' => array('Genshin Impact', 'Wuthering Waves'), 'orders' => 84, 'desc' => 'Veteran pilot focused on full map exploration, quests, and resource gathering.'),
                array('handle' => 'April', 'initial' => 'A', 'color' => 'linear-gradient(135deg,#FF9800,#FF6B9D)', 'spec' => 'Multi-Game Specialist', 'badge' => '#FF9800', 'games' => array('Genshin Impact', 'ZZZ', 'HSR'), 'orders' => 79, 'desc' => 'Versatile pilot covering multiple titles — fast turnarounds and high efficiency.'),
                array('handle' => 'Uno', 'initial' => 'U', 'color' => 'linear-gradient(135deg,#F44336,#9B59B6)', 'spec' => 'Rank Leveling Expert', 'badge' => '#F44336', 'games' => array('Genshin Impact', 'HSR', 'ZZZ'), 'orders' => 65, 'desc' => 'Adventure Rank and InterKnot leveling specialist with proven 100% success rate.'),
                array('handle' => 'Chanelia', 'initial' => 'C', 'color' => 'linear-gradient(135deg,#E91E63,#3F51B5)', 'spec' => 'Events & Maintenance Pro', 'badge' => '#E91E63', 'games' => array('Genshin Impact', 'Honkai: Star Rail'), 'orders' => 58, 'desc' => 'Dedicated to daily maintenance, patch tasks, and limited-time events.'),
                array('handle' => 'Bonnie', 'initial' => 'B', 'color' => 'linear-gradient(135deg,#673AB7,#009688)', 'spec' => 'Combat & Bosses Specialist', 'badge' => '#673AB7', 'games' => array('Zenless Zone Zero', 'Wuthering Waves'), 'orders' => 51, 'desc' => 'Combat challenge specialist for Hollow Zero, weekly bosses, and end-game clears.'),
            );
            foreach ($pilots as $idx => $pilot): ?>
                <div class="fade-up"
                    style="background:white;border-radius:24px;padding:28px;box-shadow:0 4px 24px rgba(0,0,0,0.07);display:flex;flex-direction:column;align-items:center;text-align:center;transition:all 0.3s ease;"
                    id="pilot-card-<?php echo $idx + 1; ?>"
                    onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(255,107,157,0.18)'"
                    onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 24px rgba(0,0,0,0.07)'">
                    <div
                        style="width:90px;height:90px;border-radius:50%;background:<?php echo $pilot['color']; ?>;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:900;color:white;margin-bottom:16px;box-shadow:0 4px 16px rgba(0,0,0,0.2);">
                        <?php echo esc_html($pilot['initial']); ?>
                    </div>
                    <h3 style="font-size:1.15rem;font-weight:800;color:#1a1a2e;margin-bottom:6px;">
                        <?php echo esc_html($pilot['handle']); ?></h3>
                    <span
                        style="display:inline-block;background:<?php echo $pilot['badge']; ?>22;color:<?php echo $pilot['badge']; ?>;border:1px solid <?php echo $pilot['badge']; ?>44;border-radius:999px;padding:4px 14px;font-size:0.75rem;font-weight:700;margin-bottom:12px;">
                        <?php echo esc_html($pilot['spec']); ?>
                    </span>
                    <div style="color:#FFD700;font-size:1rem;margin-bottom:8px;">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <div style="font-size:0.8rem;color:#999;margin-bottom:12px;"><?php echo esc_html($pilot['orders']); ?>
                        orders completed</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;justify-content:center;margin-bottom:16px;">
                        <?php foreach ($pilot['games'] as $game): ?>
                            <span
                                style="background:#f0f0f8;color:#555;border-radius:999px;padding:3px 10px;font-size:0.7rem;font-weight:600;"><?php echo esc_html($game); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <p style="font-size:0.85rem;color:#666;line-height:1.6;margin-bottom:20px;">
                        <?php echo esc_html($pilot['desc']); ?></p>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="yps-section" style="background:white;" id="how-it-works">
    <div class="yps-container">
        <h2 class="section-title text-center fade-up">How It Works</h2>
        <p class="section-subtitle text-center fade-up">Get started in 3 simple steps.</p>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:40px;margin-top:48px;position:relative;">
            <div
                style="position:absolute;top:40px;left:20%;right:20%;height:2px;background:linear-gradient(90deg,#FF6B9D,#9B59B6);z-index:0;">
            </div>
            <?php
            $steps = array(
                array('icon' => '&#128722;', 'title' => 'Book a Service', 'desc' => 'Choose your game and service. Select from our pricing and proceed to checkout.'),
                array('icon' => '&#128100;', 'title' => 'Pilot Gets Assigned', 'desc' => 'We match you with the best pilot for your game. You\'ll receive a confirmation with their details.'),
                array('icon' => '&#127881;', 'title' => 'Sit Back & Enjoy', 'desc' => 'Your pilot handles everything. Get real-time updates and track your order until complete.'),
            );
            foreach ($steps as $i => $step): ?>
                <div class="fade-up" style="text-align:center;position:relative;z-index:1;"
                    id="how-step-<?php echo $i + 1; ?>">
                    <div
                        style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#FF6B9D,#9B59B6);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 20px;box-shadow:0 8px 24px rgba(255,107,157,0.3);">
                        <?php echo $step['icon']; ?>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:800;color:#1a1a2e;margin-bottom:10px;">
                        <?php echo esc_html($step['title']); ?></h3>
                    <p style="font-size:0.9rem;color:#666;line-height:1.6;"><?php echo esc_html($step['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TRUST STRIP -->
<section style="background:linear-gradient(135deg,#0D2137,#1a0a3e);padding:48px 0;" id="trust-strip">
    <div class="yps-container">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;text-align:center;">
            <?php
            $trust = array(
                array('icon' => '&#9989;', 'title' => 'Verified Pilots', 'desc' => 'Every pilot is manually reviewed before joining the team.'),
                array('icon' => '&#128274;', 'title' => 'NDA Signed', 'desc' => 'All pilots sign a confidentiality agreement to protect your data.'),
                array('icon' => '&#128737;', 'title' => 'Account Safe', 'desc' => 'Secure methods used. Your credentials are never stored or shared.'),
                array('icon' => '&#128172;', 'title' => '24/7 Support', 'desc' => 'Our support team is always available to answer your questions.'),
            );
            foreach ($trust as $t): ?>
                <div class="fade-up" style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                    <div style="font-size:2rem;"><?php echo $t['icon']; ?></div>
                    <div style="font-size:0.95rem;font-weight:800;color:white;"><?php echo esc_html($t['title']); ?></div>
                    <div style="font-size:0.8rem;color:rgba(255,255,255,0.6);line-height:1.5;">
                        <?php echo esc_html($t['desc']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>