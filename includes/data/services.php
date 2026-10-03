<?php
/**
 * YPS Gaming - Service Catalog (single source of truth for services & prices)
 * Used by the Services page, order pricing, and the admin dashboard.
 */

if (!defined('ABSPATH')) exit;

function yps_get_service_catalog() {
    return array(
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
}

/**
 * Look up a service price (float) by game id and service slug. Returns null if not found.
 */
function yps_get_service_price($game_id, $service_slug) {
    foreach (yps_get_service_catalog() as $block) {
        if ($block['id'] !== $game_id) continue;
        foreach ($block['services'] as $service) {
            if (sanitize_title($service['name']) === $service_slug) {
                return (float) preg_replace('/[^0-9.]/', '', $service['price']);
            }
        }
    }
    return null;
}

/**
 * Get the readable service name for a slug (falls back to a prettified slug).
 */
function yps_get_service_name($game_id, $service_slug) {
    foreach (yps_get_service_catalog() as $block) {
        if ($block['id'] !== $game_id) continue;
        foreach ($block['services'] as $service) {
            if (sanitize_title($service['name']) === $service_slug) {
                return $service['name'];
            }
        }
    }
    return ucwords(str_replace('-', ' ', (string) $service_slug));
}

/**
 * Get display info for a game id.
 */
function yps_get_game_info($game_id) {
    foreach (yps_get_service_catalog() as $block) {
        if ($block['id'] === $game_id) {
            return array('name' => $block['name'], 'icon' => $block['icon']);
        }
    }
    return array('name' => ucfirst($game_id), 'icon' => '🎮');
}

/**
 * Get an order's amount: stored amount, falling back to catalog price for older orders.
 */
function yps_get_order_amount($post_id) {
    $stored = get_post_meta($post_id, 'yps_amount', true);
    if ($stored !== '' && $stored !== false) {
        return (float) $stored;
    }
    $price = yps_get_service_price(
        get_post_meta($post_id, 'yps_game', true),
        get_post_meta($post_id, 'yps_service', true)
    );
    return $price !== null ? $price : 0.0;
}

function yps_format_money($amount) {
    return '$' . number_format((float) $amount, 2);
}
