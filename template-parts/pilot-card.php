<?php
/**
 * Template Part: Pilot Card
 */
if (!defined('ABSPATH')) exit;

$pilot = $args['pilot'] ?? array();
$idx   = $args['idx'] ?? 0;
?>

<div class="fade-up" style="background:white;border-radius:24px;padding:28px;box-shadow:0 4px 24px rgba(0,0,0,0.07);display:flex;flex-direction:column;align-items:center;text-align:center;transition:all 0.3s ease;"
     id="pilot-card-<?php echo $idx+1; ?>"
     onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(255,107,157,0.18)'"
     onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 24px rgba(0,0,0,0.07)'">
    <div style="width:90px;height:90px;border-radius:50%;background:<?php echo $pilot['color']; ?>;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:900;color:white;margin-bottom:16px;box-shadow:0 4px 16px rgba(0,0,0,0.2);">
        <?php echo esc_html($pilot['initial']); ?>
    </div>
    <h3 style="font-size:1.15rem;font-weight:800;color:#1a1a2e;margin-bottom:6px;"><?php echo esc_html($pilot['handle']); ?></h3>
    <span style="display:inline-block;background:<?php echo $pilot['badge']; ?>22;color:<?php echo $pilot['badge']; ?>;border:1px solid <?php echo $pilot['badge']; ?>44;border-radius:999px;padding:4px 14px;font-size:0.75rem;font-weight:700;margin-bottom:12px;">
        <?php echo esc_html($pilot['spec']); ?>
    </span>
    <div style="color:#FFD700;font-size:1rem;margin-bottom:8px;">★★★★★</div>
    <div style="font-size:0.8rem;color:#999;margin-bottom:12px;"><?php echo esc_html($pilot['orders']); ?> orders completed</div>
    <div style="display:flex;flex-wrap:wrap;gap:6px;justify-content:center;margin-bottom:16px;">
        <?php foreach ($pilot['games'] as $game) : ?>
        <span style="background:#f0f0f8;color:#555;border-radius:999px;padding:3px 10px;font-size:0.7rem;font-weight:600;"><?php echo esc_html($game); ?></span>
        <?php endforeach; ?>
    </div>
    <p style="font-size:0.85rem;color:#666;line-height:1.6;margin-bottom:20px;"><?php echo esc_html($pilot['desc']); ?></p>
    <a href="<?php echo esc_url(home_url('/checkout?pilot='.sanitize_title($pilot['handle']))); ?>"
       class="yps-btn yps-btn-primary yps-btn-sm"
       id="book-<?php echo esc_attr(sanitize_title($pilot['handle'])); ?>"
       style="width:100%;text-align:center;">
        Book This Pilot →
    </a>
</div>
