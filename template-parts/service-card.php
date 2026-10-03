<?php
/**
 * Template Part: Service Card
 */
if (!defined('ABSPATH')) exit;

$service = $args['service'] ?? array();
$block_id = $args['block_id'] ?? '';
$idx     = $args['idx'] ?? 0;
?>

<div class="service-card" id="service-<?php echo esc_attr($block_id . '-' . $idx); ?>">
    <div class="service-icon"><?php echo $service['icon'] ?? '🎮'; ?></div>
    <h3 class="service-name"><?php echo esc_html($service['name'] ?? ''); ?></h3>
    <span class="service-type-badge"><?php echo esc_html($service['type'] ?? ''); ?></span>
    <div class="service-price">
        <?php echo esc_html($service['price'] ?? ''); ?>
        <span>/ session</span>
    </div>
    <p class="service-desc"><?php echo esc_html($service['desc'] ?? ''); ?></p>
    <a href="<?php echo esc_url(add_query_arg(array('game' => $block_id, 'service' => sanitize_title($service['name'] ?? '')), home_url('/checkout'))); ?>" 
       class="yps-btn yps-btn-primary yps-btn-sm">
        Book Now →
    </a>
</div>
