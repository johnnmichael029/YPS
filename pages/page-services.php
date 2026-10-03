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
        $service_blocks = yps_get_service_catalog();

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

