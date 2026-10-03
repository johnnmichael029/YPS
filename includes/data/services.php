<?php
/**
 * YPS Gaming - Service Catalog (single source of truth for services & prices)
 *
 * Used by: Services page, Checkout dropdown, order pricing, admin dashboard, order tracking.
 * To change a price or add a service, edit ONLY this file.
 *
 * Structure:  game -> categories -> items
 *   item 'name'  : full name (its slug is stored on orders — don't rename existing items)
 *   item 'label' : short label shown inside its category
 *   item 'price' : float, or null for "quote on request"
 *   item 'unit'  : null for flat price, or e.g. 'level' => price is per unit and customer picks quantity
 *   category 'note'  : shown on the Services page and under the dropdown at checkout
 *   category 'addon' : optional paid add-on (checkbox at checkout)
 */

if (!defined('ABSPATH'))
    exit;

/** Build a catalog item. */
function yps_svc($name, $label, $price, $unit = null)
{
    return array('name' => $name, 'label' => $label, 'price' => $price, 'unit' => $unit);
}

function yps_get_service_catalog()
{
    static $catalog = null;
    if ($catalog !== null)
        return $catalog;

    $catalog = array(

        // =====================================================
        // GENSHIN IMPACT
        // =====================================================
        array(
            'id' => 'genshin',
            'name' => 'Genshin Impact',
            'icon' => '🌸',
            'categories' => array(
                array(
                    'name' => 'Character Ascension',
                    'icon' => '⚔️',
                    'note' => 'Character ascension starts from level 1.',
                    'items' => array(
                        yps_svc('Character Ascension (Level 70)', 'Level 70', 4.00),
                        yps_svc('Character Ascension (Level 80)', 'Level 80', 5.00),
                        yps_svc('Character Ascension (Level 90)', 'Level 90', 6.00),
                    ),
                ),
                array(
                    'name' => 'Talent Ascension',
                    'icon' => '📜',
                    'note' => 'Talent ascension starts from level 1.',
                    'items' => array(
                        yps_svc('Talent Ascension (08/08/08)', '08/08/08', 6.00),
                        yps_svc('Talent Ascension (09/09/09)', '09/09/09', 10.00),
                        yps_svc('Talent Ascension (10/10/10)', '10/10/10', 15.00),
                    ),
                ),
                array(
                    'name' => 'Weapon Ascension',
                    'icon' => '🗡️',
                    'note' => 'Weapon ascension starts from level 1.',
                    'items' => array(
                        yps_svc('Weapon Ascension (Level 70)', 'Level 70', 4.00),
                        yps_svc('Weapon Ascension (Level 80)', 'Level 80', 5.00),
                        yps_svc('Weapon Ascension (Level 90)', 'Level 90', 6.00),
                    ),
                ),
                array(
                    'name' => 'AR Ranks',
                    'icon' => '⬆️',
                    'note' => 'This service includes progression through quests, commissions and resources (priced per level).',
                    'items' => array(
                        yps_svc('AR Rank 02 > 20', 'AR 02 > 20', 0.70, 'level'),
                        yps_svc('AR Rank 21 > 35', 'AR 21 > 35', 1.20, 'level'),
                        yps_svc('AR Rank 36 > 40', 'AR 36 > 40', 1.90, 'level'),
                        yps_svc('AR Rank 41 > 50', 'AR 41 > 50', 3.44, 'level'),
                    ),
                ),
                array(
                    'name' => 'Maintenance',
                    'icon' => '📋',
                    'note' => 'Add $10.00 for endgame tasks (Imaginarium Theatre, Spiral Abyss & Stygian Onslaught).',
                    'addon' => array('name' => 'Endgame tasks (Theatre, Abyss & Stygian Onslaught)', 'price' => 10.00),
                    'items' => array(
                        yps_svc('Daily Comms & Resin (Daily)', 'Daily Comms & Resin — Daily', 0.33),
                        yps_svc('Daily Comms & Resin (Weekly)', 'Daily Comms & Resin — Weekly', 3.00),
                        yps_svc('Daily Comms & Resin (Monthly)', 'Daily Comms & Resin — Monthly', 12.00),
                        yps_svc('Daily Comms & Resin (Patch)', 'Daily Comms & Resin — Patch', 15.00),
                        yps_svc('Daily, Resin & Events (Daily)', 'Daily, Resin & Events — Daily', 0.58),
                        yps_svc('Daily, Resin & Events (Weekly)', 'Daily, Resin & Events — Weekly', 6.00),
                        yps_svc('Daily, Resin & Events (Monthly)', 'Daily, Resin & Events — Monthly', 25.00),
                        yps_svc('Daily, Resin & Events (Patch)', 'Daily, Resin & Events — Patch', 30.00),
                    ),
                ),
                array(
                    'name' => 'Archon Quest',
                    'icon' => '👑',
                    'note' => 'Service includes all acts, interludes & prelude quests for each region.',
                    'items' => array(
                        yps_svc('Archon Quest: Mondstadt', 'Mondstadt', 11.00),
                        yps_svc('Archon Quest: Liyue', 'Liyue', 11.00),
                        yps_svc('Archon Quest: Inazuma', 'Inazuma', 15.00),
                        yps_svc('Archon Quest: Sumeru', 'Sumeru', 32.00),
                        yps_svc('Archon Quest: Fontaine', 'Fontaine', 36.00),
                        yps_svc('Archon Quest: Natlan', 'Natlan', 39.00),
                        yps_svc('Archon Quest: Nod-Krai', 'Nod-Krai', 55.00),
                        yps_svc('Archon Quest: Snezhnaya', 'Snezhnaya', 20.00),
                    ),
                ),
                array(
                    'name' => 'Exploration',
                    'icon' => '🗺️',
                    'note' => 'Exploration price depends on your current exploration % (e.g. 30% to 100%). Final quote will be calculated after staff/pilot verification.',
                    'items' => array(
                        yps_svc('Exploration: Mondstadt', 'Mondstadt', 18.00),
                        yps_svc('Exploration: Dragonspine', 'Dragonspine', 13.00),
                        yps_svc('Exploration: Liyue', 'Liyue', 45.00),
                        yps_svc('Exploration: The Chasm', 'The Chasm', 20.00),
                        yps_svc('Exploration: Inazuma', 'Inazuma', 70.00),
                        yps_svc('Exploration: Enkanomiya', 'Enkanomiya', 20.00),
                        yps_svc('Exploration: Sumeru Desert', 'Sumeru Desert', 70.00),
                        yps_svc('Exploration: Sumeru Forest', 'Sumeru Forest', 60.00),
                        yps_svc('Exploration: Fontaine', 'Fontaine', 80.00),
                        yps_svc('Exploration: Natlan', 'Natlan', 80.00),
                        yps_svc('Exploration: Nod-Krai', 'Nod-Krai', 45.00),
                        yps_svc('Exploration: Frost Moon', 'Frost Moon', 35.00),
                        yps_svc('Exploration: New Mond', 'New Mond', 30.00),
                        yps_svc('Exploration: Snezhnaya', 'Snezhnaya', 50.00),
                    ),
                ),
                array(
                    'name' => 'Quests',
                    'icon' => '📖',
                    'note' => 'This service includes the entire questline. World quests may range from $1–10 (quoted per quest).',
                    'items' => array(
                        yps_svc('Hangout Quest', 'Hangout', 3.00),
                        yps_svc('Ascension Quest', 'Ascension', 5.00),
                        yps_svc('Story Quest', 'Story', 7.00),
                        yps_svc('World Quest', 'World', null),
                    ),
                ),
                array(
                    'name' => 'Fished Weapons',
                    'icon' => '🎣',
                    'note' => 'Refinements for weapons obtained from fishing are priced per rank.',
                    'items' => array(
                        yps_svc('Fished Weapon', 'Weapon', 5.00),
                        yps_svc('Fished Weapon Refinement', 'Refinement', 4.00, 'rank'),
                    ),
                ),
                array(
                    'name' => 'Primogem Hunting',
                    'icon' => '💎',
                    'note' => 'Final quote depends on your available world resources & progress.',
                    'items' => array(
                        yps_svc('Primogem Hunting', 'Per 10 pulls', 6.00, '10-pull'),
                    ),
                ),
            ),
        ),

        // =====================================================
        // HONKAI: STAR RAIL
        // =====================================================
        array(
            'id' => 'honkai',
            'name' => 'Honkai: Star Rail',
            'icon' => '⭐',
            'categories' => array(
                array(
                    'name' => 'Maintenance — Dailies, Fuel Burn & BP',
                    'icon' => '🔋',
                    'note' => 'Endgame full clear add-on: $20.00 (MoC, Pure Fiction & Apocalyptic Shadow). Although turn-based, there is more fuel capacity, more weekly tasks and harder endgame bosses.',
                    'addon' => array('name' => 'Endgame full clear (MoC, Pure Fiction & Apocalyptic Shadow)', 'price' => 20.00),
                    'items' => array(
                        yps_svc('Dailies, Fuel Burn & BP (Daily)', 'Daily', 0.80),
                        yps_svc('Dailies, Fuel Burn & BP (Weekly)', 'Weekly', 7.00),
                        yps_svc('Dailies, Fuel Burn & BP (Monthly)', 'Monthly', 13.00),
                        yps_svc('Dailies, Fuel Burn & BP (Patch)', 'Patch', 16.00),
                    ),
                ),
                array(
                    'name' => 'Maintenance — Full (Events, Div. Universe & Currency Wars)',
                    'icon' => '🎉',
                    'note' => 'Includes dailies, fuel burn, BP, events, Divergent Universe & Currency Wars. Endgame full clear add-on: $20.00 (MoC, Pure Fiction & Apocalyptic Shadow).',
                    'addon' => array('name' => 'Endgame full clear (MoC, Pure Fiction & Apocalyptic Shadow)', 'price' => 20.00),
                    'items' => array(
                        yps_svc('Full Maintenance (Daily)', 'Daily', 0.80),
                        yps_svc('Full Maintenance (Weekly)', 'Weekly', 15.00),
                        yps_svc('Full Maintenance (Monthly)', 'Monthly', 32.00),
                        yps_svc('Full Maintenance (Patch)', 'Patch', 37.00),
                    ),
                ),
                array(
                    'name' => 'Trailblaze Mission',
                    'icon' => '🚂',
                    'note' => 'Includes all acts. Trailblaze Continuance is not included.',
                    'items' => array(
                        yps_svc('Trailblaze Mission: Herta Space', 'Herta Space', 3.00),
                        yps_svc('Trailblaze Mission: Jarilo-VI', 'Jarilo-VI', 6.00),
                        yps_svc('Trailblaze Mission: Xianzhou', 'Xianzhou', 11.00),
                        yps_svc('Trailblaze Mission: Penacony', 'Penacony', 16.00),
                        yps_svc('Trailblaze Mission: Amphoreus', 'Amphoreus', 36.00),
                        yps_svc('Trailblaze Mission: Plancardia', 'Plancardia', 30.00),
                    ),
                ),
                array(
                    'name' => 'Trailblaze Continuance',
                    'icon' => '🛤️',
                    'note' => '',
                    'items' => array(
                        yps_svc('Trailblaze Continuance: Herta Space', 'Herta Space', 4.00),
                        yps_svc('Trailblaze Continuance: Jarilo-VI', 'Jarilo-VI', 5.00),
                        yps_svc('Trailblaze Continuance: Xianzhou', 'Xianzhou', 27.00),
                        yps_svc('Trailblaze Continuance: Penacony', 'Penacony', 20.00),
                        yps_svc('Trailblaze Continuance: Plancardia', 'Plancardia', 18.00),
                    ),
                ),
                array(
                    'name' => 'Simulated Universe — Worlds',
                    'icon' => '🌌',
                    'note' => 'Simulated Universe worlds are priced per world.',
                    'items' => array(
                        yps_svc('SU World (Per Difficulty)', 'Per difficulty', 3.50, 'difficulty'),
                        yps_svc('SU World (All Difficulties 1-4)', 'All difficulties (1–4)', 17.50),
                        yps_svc('SU World (All Difficulties 5-9)', 'All difficulties (5–9)', 14.00),
                    ),
                ),
                array(
                    'name' => 'Ascension Level Up',
                    'icon' => '⬆️',
                    'note' => 'Priced per level.',
                    'items' => array(
                        yps_svc('Ascension Level Up: Divergent', 'Divergent', 1.00, 'level'),
                        yps_svc('Ascension Level Up: Currency Wars', 'Currency Wars', 1.50, 'level'),
                    ),
                ),
                array(
                    'name' => 'SU Modes — 100% Jades Only',
                    'icon' => '💠',
                    'note' => '',
                    'items' => array(
                        yps_svc('Swarm Disaster (100% Jades)', 'Swarm Disaster', 28.00),
                        yps_svc('Gold and Gears (100% Jades)', 'Gold and Gears', 35.00),
                        yps_svc('Unknowable Domain (100% Jades)', 'Unknowable Domain', 35.00),
                    ),
                ),
                array(
                    'name' => 'SU Modes — 100% Completion',
                    'icon' => '✅',
                    'note' => '',
                    'items' => array(
                        yps_svc('Swarm Disaster (100% Completion)', 'Swarm Disaster', 35.00),
                        yps_svc('Gold and Gears (100% Completion)', 'Gold and Gears', 42.00),
                        yps_svc('Unknowable Domain (100% Completion)', 'Unknowable Domain', 45.00),
                    ),
                ),
                array(
                    'name' => 'Exploration',
                    'icon' => '🗺️',
                    'note' => 'Exploration price depends on your current exploration % (e.g. 30% to 100%). Final quote will be calculated after staff/pilot verification.',
                    'items' => array(
                        yps_svc('HSR Exploration: Herta Space', 'Herta Space', 16.00),
                        yps_svc('HSR Exploration: Jarilo-VI', 'Jarilo-VI', 24.00),
                        yps_svc('HSR Exploration: Xianzhou', 'Xianzhou', 31.00),
                        yps_svc('HSR Exploration: Penacony', 'Penacony', 35.00),
                        yps_svc('HSR Exploration: Amphoreus', 'Amphoreus', 40.00),
                        yps_svc('HSR Exploration: Plancardia', 'Plancardia', 40.00),
                        yps_svc('HSR Exploration: Astropolis', 'Astropolis', 9.00),
                    ),
                ),
                array(
                    'name' => 'Quests',
                    'icon' => '📖',
                    'note' => 'Adventure missions are quoted per quest.',
                    'items' => array(
                        yps_svc('Companion Quest', 'Companion', 6.00),
                        yps_svc('Equilibrium Trial', 'Equilibrium Trial', 5.00),
                        yps_svc('Adventure Mission', 'Adventure', null),
                    ),
                ),
                array(
                    'name' => 'Jadehunt',
                    'icon' => '💎',
                    'note' => 'Final quote depends on your available world resources & progress.',
                    'items' => array(
                        yps_svc('Stellar Jade Hunt', 'Per 10 pulls', 6.00, '10-pull'),
                    ),
                ),
            ),
        ),

        // =====================================================
        // ZENLESS ZONE ZERO
        // =====================================================
        array(
            'id' => 'zenless',
            'name' => 'Zenless Zone Zero',
            'icon' => '⚡',
            'categories' => array(
                array(
                    'name' => 'Services',
                    'icon' => '⚡',
                    'note' => '',
                    'items' => array(
                        yps_svc('Daily Tasks', 'Daily Tasks', 1.00),
                        yps_svc('InterKnot Level', 'InterKnot Level', 5.00),
                        yps_svc('Hollow Zero', 'Hollow Zero', 8.00),
                        yps_svc('Drive Disc Farm', 'Drive Disc Farm', 6.00),
                        yps_svc('Event Completion', 'Event Completion', 6.00),
                        yps_svc('Combat Challenges', 'Combat Challenges', 10.00),
                    ),
                ),
            ),
        ),

        // =====================================================
        // WUTHERING WAVES
        // =====================================================
        array(
            'id' => 'wuthering',
            'name' => 'Wuthering Waves',
            'icon' => '🌊',
            'categories' => array(
                array(
                    'name' => 'Services',
                    'icon' => '🌊',
                    'note' => '',
                    'items' => array(
                        yps_svc('Daily Activities', 'Daily Activities', 1.00),
                        yps_svc('Union Level', 'Union Level', 5.00),
                        yps_svc('Tower of Adversity', 'Tower of Adversity', 12.00),
                        yps_svc('Echo Farming', 'Echo Farming', 6.00),
                        yps_svc('Simulation Training', 'Simulation Training', 5.00),
                        yps_svc('Astrites Hunting', 'Astrites Hunting', 8.00),
                    ),
                ),
            ),
        ),
    );

    // Attach slugs once
    foreach ($catalog as &$game) {
        foreach ($game['categories'] as &$cat) {
            foreach ($cat['items'] as &$item) {
                $item['slug'] = sanitize_title($item['name']);
            }
        }
    }
    unset($game, $cat, $item);

    return $catalog;
}

/**
 * Find a service by game + slug. Returns array('item' => ..., 'category' => ...) or null.
 */
function yps_find_service($game_id, $service_slug)
{
    foreach (yps_get_service_catalog() as $game) {
        if ($game['id'] !== $game_id)
            continue;
        foreach ($game['categories'] as $cat) {
            foreach ($cat['items'] as $item) {
                if ($item['slug'] === $service_slug) {
                    return array('item' => $item, 'category' => $cat);
                }
            }
        }
    }
    return null;
}

/** Unit price (float) for a service, or null if not found / quote-only. */
function yps_get_service_price($game_id, $service_slug)
{
    $found = yps_find_service($game_id, $service_slug);
    return $found ? $found['item']['price'] : null;
}

/** Readable service name for a slug (falls back to a prettified slug). */
function yps_get_service_name($game_id, $service_slug)
{
    $found = yps_find_service($game_id, $service_slug);
    return $found ? $found['item']['name'] : ucwords(str_replace('-', ' ', (string) $service_slug));
}

/** Display info for a game id. */
function yps_get_game_info($game_id)
{
    foreach (yps_get_service_catalog() as $game) {
        if ($game['id'] === $game_id) {
            return array('name' => $game['name'], 'icon' => $game['icon']);
        }
    }
    return array('name' => ucfirst((string) $game_id), 'icon' => '🎮');
}

/**
 * Calculate an order total server-side. Never trust prices sent from the browser.
 * Returns float, or null if the service is quote-only / unknown.
 */
function yps_calculate_order_amount($game_id, $service_slug, $quantity = 1, $with_addon = false)
{
    $found = yps_find_service($game_id, $service_slug);
    if (!$found || $found['item']['price'] === null)
        return null;

    $qty = $found['item']['unit'] ? max(1, min(999, intval($quantity))) : 1;
    $amount = $found['item']['price'] * $qty;
    if ($with_addon && !empty($found['category']['addon'])) {
        $amount += $found['category']['addon']['price'];
    }
    return round($amount, 2);
}

/** Order amount: stored amount, falling back to catalog price for older orders. */
function yps_get_order_amount($post_id)
{
    $stored = get_post_meta($post_id, 'yps_amount', true);
    if ($stored !== '' && $stored !== false) {
        return (float) $stored;
    }
    $price = yps_get_service_price(
        get_post_meta($post_id, 'yps_game', true),
        get_post_meta($post_id, 'yps_service', true)
    );
    return $price !== null ? (float) $price : 0.0;
}

function yps_format_money($amount)
{
    return '$' . number_format((float) $amount, 2);
}

/** "$4.00", "$0.70 / level", or "Quote". */
function yps_format_service_price($item)
{
    if ($item['price'] === null)
        return 'Quote';
    $str = yps_format_money($item['price']);
    if (!empty($item['unit']))
        $str .= ' / ' . $item['unit'];
    return $str;
}
