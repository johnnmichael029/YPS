<?php
/**
 * Template Name: Services Page
 * YPS Gaming - Services Page Template
 */
get_header();
?>

<!-- PAGE HERO -->
<section class="yps-page-hero" id="services-hero">
    <div class="yps-container">
        <div class="page-hero-content">
            <div class="hero-badge" style="display:inline-flex; margin: 0 auto 16px; background:rgba(255,107,157,0.15); border:1px solid rgba(255,107,157,0.3); color:#FFB3CF; border-radius:999px; padding:6px 16px; font-size:0.8rem; font-weight:600; letter-spacing:0.5px;">
                🎮 Professional Gaming Services
            </div>
            <h1>Our Services</h1>
            <p>Choose your game and service. We'll take care of the rest!</p>
        </div>
    </div>
</section>

<!-- SERVICES SECTION -->
<section class="services-section" id="services-content">
    <div class="yps-container">
        <!-- Filter Tabs -->
        <div class="yps-filter-tabs" id="services-filter-tabs" role="tablist">
            <button class="filter-tab active" data-filter="all" id="filter-all" role="tab" aria-selected="true">
                🎮 All Games
            </button>
            <button class="filter-tab" data-filter="genshin" id="filter-genshin" role="tab">
                🌸 Genshin Impact
            </button>
            <button class="filter-tab" data-filter="honkai" id="filter-honkai" role="tab">
                ⭐ Honkai: Star Rail
            </button>
            <button class="filter-tab" data-filter="zenless" id="filter-zenless" role="tab">
                ⚡ Zenless Zone Zero
            </button>
            <button class="filter-tab" data-filter="wuthering" id="filter-wuthering" role="tab">
                🌊 Wuthering Waves
            </button>
        </div>

        <?php
        $service_blocks = array(
            array(
                'id'       => 'genshin',
                'name'     => 'Genshin Impact',
                'icon'     => '🌸',
                'services' => array(
                    array('name'=>'Character Ascension (Level 70)', 'type'=>'Ascension',   'icon'=>'⚔️','price'=>'$4.00',  'desc'=>'Character Ascension from Lvl 1 to Level 70.'),
                    array('name'=>'Character Ascension (Level 80)', 'type'=>'Ascension',   'icon'=>'⚔️','price'=>'$5.00',  'desc'=>'Character Ascension from Lvl 1 to Level 80.'),
                    array('name'=>'Character Ascension (Level 90)', 'type'=>'Ascension',   'icon'=>'⭐','price'=>'$6.00',  'desc'=>'Character Ascension from Lvl 1 to Level 90.'),
                    array('name'=>'Talent Ascension (08/08/08)',    'type'=>'Talent',      'icon'=>'📜','price'=>'$6.00',  'desc'=>'Talent level ascension from Lvl 1 up to 8/8/8.'),
                    array('name'=>'Talent Ascension (09/09/09)',    'type'=>'Talent',      'icon'=>'📜','price'=>'$10.00', 'desc'=>'Talent level ascension from Lvl 1 up to 9/9/9.'),
                    array('name'=>'Talent Ascension (10/10/10)',    'type'=>'Talent',      'icon'=>'👑','price'=>'$15.00', 'desc'=>'Crown Talent ascension up to 10/10/10.'),
                    array('name'=>'Weapon Ascension (Level 70)',    'type'=>'Weapon',      'icon'=>'🗡️','price'=>'$4.00',  'desc'=>'Weapon Ascension from Lvl 1 to Level 70.'),
                    array('name'=>'Weapon Ascension (Level 80)',    'type'=>'Weapon',      'icon'=>'🗡️','price'=>'$5.00',  'desc'=>'Weapon Ascension from Lvl 1 to Level 80.'),
                    array('name'=>'Weapon Ascension (Level 90)',    'type'=>'Weapon',      'icon'=>'🗡️','price'=>'$6.00',  'desc'=>'Weapon Ascension from Lvl 1 to Level 90.'),
                    array('name'=>'AR Rank 02 > 20',               'type'=>'AR Rank',     'icon'=>'⬆️','price'=>'$0.70',  'desc'=>'AR rank level progression. Includes quests & commissions.'),
                    array('name'=>'AR Rank 21 > 35',               'type'=>'AR Rank',     'icon'=>'⬆️','price'=>'$1.20',  'desc'=>'AR rank level progression. Includes quests & commissions.'),
                    array('name'=>'AR Rank 36 > 40',               'type'=>'AR Rank',     'icon'=>'⬆️','price'=>'$1.90',  'desc'=>'AR rank level progression. Includes quests & commissions.'),
                    array('name'=>'AR Rank 41 > 50',               'type'=>'AR Rank',     'icon'=>'⬆️','price'=>'$3.44',  'desc'=>'AR rank level progression. Includes quests & commissions.'),
                    array('name'=>'Daily Comms & Resin (Daily)',   'type'=>'Maintenance', 'icon'=>'📋','price'=>'$0.33',  'desc'=>'1 Day of Daily commissions & resin spending.'),
                    array('name'=>'Daily Comms & Resin (Weekly)',  'type'=>'Maintenance', 'icon'=>'📋','price'=>'$3.00',  'desc'=>'7 Days of Daily commissions & resin spending.'),
                    array('name'=>'Daily Comms & Resin (Monthly)', 'type'=>'Maintenance', 'icon'=>'📋','price'=>'$12.00', 'desc'=>'30 Days of Daily commissions & resin spending.'),
                    array('name'=>'Daily Comms & Resin (Patch)',   'type'=>'Maintenance', 'icon'=>'📋','price'=>'$15.00', 'desc'=>'Full Patch duration of Daily comms & resin.'),
                    array('name'=>'Daily, Resin & Events (Daily)',  'type'=>'Full Maint',  'icon'=>'🎉','price'=>'$0.58',  'desc'=>'1 Day of Daily comms, resin & active events.'),
                    array('name'=>'Daily, Resin & Events (Weekly)', 'type'=>'Full Maint',  'icon'=>'🎉','price'=>'$6.00',  'desc'=>'7 Days of Daily comms, resin & active events.'),
                    array('name'=>'Daily, Resin & Events (Monthly)','type'=>'Full Maint',  'icon'=>'🎉','price'=>'$25.00', 'desc'=>'30 Days of Daily comms, resin & active events.'),
                    array('name'=>'Daily, Resin & Events (Patch)',  'type'=>'Full Maint',  'icon'=>'🎉','price'=>'$30.00', 'desc'=>'Full Patch of Daily comms, resin & active events.'),
                ),
            ),
            array(
                'id'       => 'honkai',
                'name'     => 'Honkai: Star Rail',
                'icon'     => '⭐',
                'services' => array(
                    array('name'=>'Daily Missions',       'type'=>'Maintenance','icon'=>'📋','price'=>'$1.00',  'desc'=>'Complete daily training missions and assignments.'),
                    array('name'=>'Trailblazer Level',    'type'=>'Rank',      'icon'=>'⬆️','price'=>'$5.00', 'desc'=>'Fast Trailblazer EXP and story quest progression.'),
                    array('name'=>'Memory of Chaos',      'type'=>'Challenge', 'icon'=>'🌀','price'=>'$10.00', 'desc'=>'Full Memory of Chaos clear for maximum stellar jades.'),
                    array('name'=>'Stellar Jade Farming', 'type'=>'Farming',   'icon'=>'💎','price'=>'$8.00',  'desc'=>'Targeted Calyx, Gold and Crimson runs for Stellar Jades.'),
                    array('name'=>'Simulated Universe',   'type'=>'Challenge','icon'=>'🎮','price'=>'$6.00', 'desc'=>'Weekly Simulated Universe runs for maximum rewards.'),
                    array('name'=>'Event Farming',        'type'=>'Events',    'icon'=>'🎉','price'=>'$10.00', 'desc'=>'All limited-time event quests and reward collection.'),
                ),
            ),
            array(
                'id'       => 'zenless',
                'name'     => 'Zenless Zone Zero',
                'icon'     => '⚡',
                'services' => array(
                    array('name'=>'Daily Tasks',     'type'=>'Maintenance','icon'=>'📋','price'=>'$1.00',  'desc'=>'VT Daily tasks and commission completions.'),
                    array('name'=>'InterKnot Level', 'type'=>'Rank',       'icon'=>'⬆️','price'=>'$5.00', 'desc'=>'Efficient InterKnot level and story progression.'),
                    array('name'=>'Hollow Zero',     'type'=>'Challenge',  'icon'=>'🌀','price'=>'$8.00', 'desc'=>'Weekly Hollow Zero runs for maximum polychrome.'),
                    array('name'=>'Drive Disc Farm', 'type'=>'Farming',    'icon'=>'💎','price'=>'$6.00',  'desc'=>'Targeted drive disc domain farming for your agents.'),
                    array('name'=>'Event Completion','type'=>'Events',     'icon'=>'🎉','price'=>'$6.00', 'desc'=>'All limited-time events and collection missions.'),
                    array('name'=>'Combat Challenges','type'=>'Challenge', 'icon'=>'⚔️','price'=>'$10.00', 'desc'=>'Combat challenge completions for shop currency.'),
                ),
            ),
            array(
                'id'       => 'wuthering',
                'name'     => 'Wuthering Waves',
                'icon'     => '🌊',
                'services' => array(
                    array('name'=>'Daily Activities',   'type'=>'Maintenance','icon'=>'📋','price'=>'$1.00',  'desc'=>'Daily vigor spending and activity completions.'),
                    array('name'=>'Union Level',         'type'=>'Rank',       'icon'=>'⬆️','price'=>'$5.00', 'desc'=>'Union EXP farming and story chapter progression.'),
                    array('name'=>'Tower of Adversity',  'type'=>'Challenge','icon'=>'🌀','price'=>'$12.00', 'desc'=>'Full Tower of Adversity clear for Astrite rewards.'),
                    array('name'=>'Echo Farming',        'type'=>'Farming',    'icon'=>'💎','price'=>'$6.00',  'desc'=>'Boss echo farming for optimal character builds.'),
                    array('name'=>'Simulation Training','type'=>'Challenge','icon'=>'⚔️','price'=>'$5.00', 'desc'=>'Simulation training for materials and experience.'),
                    array('name'=>'Astrites Hunting',   'type'=>'Events',     'icon'=>'🎉','price'=>'$8.00', 'desc'=>'All limited event missions and Astrite reward collections.'),
                ),
            ),
        );

        foreach ($service_blocks as $block) :
        ?>
        <div class="service-game-block fade-up" data-game="<?php echo esc_attr($block['id']); ?>" id="services-<?php echo esc_attr($block['id']); ?>">
            <div class="game-block-header">
                <div class="game-block-icon"><?php echo $block['icon']; ?></div>
                <div>
                    <h2 class="game-block-title"><?php echo esc_html($block['name']); ?></h2>
                    <div class="game-block-sub">Choose a service to get started</div>
                </div>
            </div>
            <div class="service-cards-grid">
                <?php foreach ($block['services'] as $idx => $service) : ?>
                <div class="service-card" id="service-<?php echo esc_attr($block['id'] . '-' . $idx); ?>">
                    <div class="service-icon"><?php echo $service['icon']; ?></div>
                    <h3 class="service-name"><?php echo esc_html($service['name']); ?></h3>
                    <span class="service-type-badge"><?php echo esc_html($service['type']); ?></span>
                    <div class="service-price">
                        <?php echo esc_html($service['price']); ?>
                        <span>/ session</span>
                    </div>
                    <p class="service-desc"><?php echo esc_html($service['desc']); ?></p>
                    <a href="<?php echo esc_url(add_query_arg(array('game' => $block['id'], 'service' => sanitize_title($service['name'])), home_url('/checkout'))); ?>" 
                       class="yps-btn yps-btn-primary yps-btn-sm">
                        Book Now →
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.filter-tab');
    const blocks = document.querySelectorAll('.service-game-block');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;

            tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
            this.classList.add('active');
            this.setAttribute('aria-selected','true');

            blocks.forEach(function(block) {
                if (filter === 'all' || block.dataset.game === filter) {
                    block.style.display = 'block';
                } else {
                    block.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>

