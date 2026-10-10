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
            <?php
            $tab_games = array(
                'genshin'   => 'Genshin Impact',
                'honkai'    => 'Honkai: Star Rail',
                'zenless'   => 'Zenless Zone Zero',
                'wuthering' => 'Wuthering Waves',
            );
            $emojis = array('genshin' => '🌸', 'honkai' => '⭐', 'zenless' => '⚡', 'wuthering' => '🌊');
            foreach ($tab_games as $tslug => $tname) :
                $t_possible = array("game-{$tslug}.jpg", "game-{$tslug}.png", "game-{$tslug}.webp", "bg-{$tslug}.jpg", "bg-{$tslug}.png", "bg-{$tslug}.webp");
                $t_img = '';
                foreach ($t_possible as $tpf) {
                    if (file_exists(get_template_directory() . '/assets/images/' . $tpf)) {
                        $t_img = $tpf;
                        break;
                    }
                }
            ?>
            <button class="filter-tab" data-filter="<?php echo esc_attr($tslug); ?>" id="filter-<?php echo esc_attr($tslug); ?>" role="tab" style="display:inline-flex;align-items:center;gap:6px;">
                <?php if ($t_img) : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo esc_attr($t_img); ?>" alt="<?php echo esc_attr($tname); ?>" style="width:20px;height:20px;border-radius:6px;object-fit:cover;">
                <?php else : ?>
                    <span><?php echo $emojis[$tslug]; ?></span>
                <?php endif; ?>
                <?php echo esc_html($tname); ?>
            </button>
            <?php endforeach; ?>
        </div>

        <?php
        $service_blocks = yps_get_service_catalog();

        foreach ($service_blocks as $block) : ?>
        <div class="service-game-block fade-up" data-game="<?php echo esc_attr($block['id']); ?>" id="services-<?php echo esc_attr($block['id']); ?>">
            <div class="game-block-header" style="margin-bottom:28px;">
                <?php
                $slug = $block['id'];
                $possible_files = array("game-{$slug}.jpg", "game-{$slug}.png", "game-{$slug}.webp", "bg-{$slug}.jpg", "bg-{$slug}.png", "bg-{$slug}.webp");
                $block_img = '';
                foreach ($possible_files as $pf) {
                    if (file_exists(get_template_directory() . '/assets/images/' . $pf)) {
                        $block_img = $pf;
                        break;
                    }
                }
                if ($block_img) : ?>
                    <div class="game-block-icon" style="overflow:hidden; padding:0; width:52px; height:52px; border-radius:14px; box-shadow:0 4px 14px rgba(0,0,0,0.12);">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo esc_attr($block_img); ?>" 
                             alt="<?php echo esc_attr($block['name']); ?>" 
                             style="width:100%; height:100%; object-fit:cover;">
                    </div>
                <?php else : ?>
                    <div class="game-block-icon"><?php echo $block['icon']; ?></div>
                <?php endif; ?>
                <div>
                    <h2 class="game-block-title" style="font-size:1.8rem;font-weight:800;"><?php echo esc_html($block['name']); ?></h2>
                    <div class="game-block-sub" style="color:#777;font-size:0.9rem;">Choose a service category to get started</div>
                </div>
            </div>

            <?php foreach ($block['categories'] as $cat_idx => $cat) : ?>
                <div class="service-category-group" style="margin-bottom:36px;background:#fff;border-radius:16px;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:16px;border-bottom:2px solid #f5f5f7;padding-bottom:12px;">
                        <h3 style="font-size:1.25rem;font-weight:800;color:#1e1e2f;display:flex;align-items:center;gap:8px;margin:0;">
                            <span><?php echo $cat['icon']; ?></span> <?php echo esc_html($cat['name']); ?>
                        </h3>
                        <?php if (!empty($cat['addon'])) : ?>
                            <span style="background:rgba(255,107,157,0.12);color:#ff4785;border:1px dashed #ff4785;padding:4px 12px;border-radius:99px;font-size:0.78rem;font-weight:700;">
                                ⚡ Add-on available: <?php echo esc_html($cat['addon']['name']); ?> (+<?php echo esc_html(yps_format_money($cat['addon']['price'])); ?>)
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($cat['note'])) : ?>
                        <div style="background:#f0f7ff;border-left:4px solid #3b82f6;padding:10px 14px;border-radius:6px;font-size:0.83rem;color:#1e40af;margin-bottom:20px;line-height:1.5;">
                            📌 <strong>Important Note:</strong> <?php echo esc_html($cat['note']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="service-cards-grid">
                        <?php foreach ($cat['items'] as $item_idx => $item) : ?>
                        <div class="service-card" id="service-<?php echo esc_attr($block['id'] . '-' . $item['slug']); ?>">
                            <div class="service-icon" style="font-size:1.8rem;margin-bottom:8px;"><?php echo $cat['icon']; ?></div>
                            <h4 class="service-name" style="font-size:1.05rem;font-weight:700;margin-bottom:6px;"><?php echo esc_html($item['name']); ?></h4>
                            <span class="service-type-badge"><?php echo esc_html($cat['name']); ?></span>
                            <div class="service-price" style="margin:12px 0;font-size:1.3rem;font-weight:800;color:#ff4785;">
                                <?php echo esc_html(yps_format_service_price($item)); ?>
                            </div>
                            <a href="<?php echo esc_url(add_query_arg(array('game' => $block['id'], 'service' => $item['slug']), home_url('/checkout'))); ?>" 
                               class="yps-btn yps-btn-primary yps-btn-sm" style="width:100%;text-align:center;">
                                Book Now →
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
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

