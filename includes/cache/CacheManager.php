<?php
/**
 * YPS Gaming - Cache Manager
 *
 * Lightweight caching layer built on WordPress Transients API.
 * - Full-page HTML cache for anonymous visitors (no DB hit at all)
 * - Query-level cache via remember() pattern
 * - Group-based cache flush when data changes
 *
 * Usage examples:
 *   $data = YPS_Cache::remember('orders_all', fn() => get_posts([...]), YPS_Cache::TTL_ORDERS);
 *   YPS_Cache::flush_group('orders');
 *   YPS_Cache::delete('my_key');
 */

if (!defined('ABSPATH')) exit;

class YPS_Cache {

    // TTLs — how long each type of cache lives
    const TTL_PAGE   = 3600;   // 1 hour   — full rendered HTML pages
    const TTL_QUERY  = 1800;   // 30 min   — DB query results
    const TTL_ORDERS = 120;    // 2 min    — order data (changes often)
    const TTL_STATIC = 86400;  // 24 hours — service catalog, pilots list

    const PREFIX     = 'yps_cache_';
    const KEYS_OPT   = 'yps_cache_tracked_keys';

    // --------------------------------------------------
    // Core Get / Set / Delete
    // --------------------------------------------------

    /** Get a cached value. Returns false if not found or expired. */
    public static function get($key) {
        return get_transient(self::PREFIX . $key);
    }

    /** Store a value. $ttl in seconds. */
    public static function set($key, $value, $ttl = self::TTL_QUERY) {
        set_transient(self::PREFIX . $key, $value, $ttl);
        self::track_key($key);
    }

    /** Delete one cached entry. */
    public static function delete($key) {
        delete_transient(self::PREFIX . $key);
        self::untrack_key($key);
    }

    /**
     * "Remember" pattern — get from cache or compute & store.
     *
     *   $pilots = YPS_Cache::remember('pilots_list', function() {
     *       return get_users(['role' => 'yps_pilot']);
     *   }, YPS_Cache::TTL_STATIC);
     */
    public static function remember($key, callable $callback, $ttl = self::TTL_QUERY) {
        $hit = self::get($key);
        if ($hit !== false) {
            return $hit;   // Served from cache — no DB query
        }
        $value = call_user_func($callback);
        self::set($key, $value, $ttl);
        return $value;
    }

    // --------------------------------------------------
    // Group Flush
    // --------------------------------------------------

    /**
     * Delete all cached keys that belong to a group.
     * A key belongs to group "orders" if it starts with "orders_".
     *
     * Built-in groups:
     *   'orders'  — order query results
     *   'pilots'  — pilot list
     *   'pages'   — full-page HTML cache
     *   'catalog' — service catalog
     *   'all'     — everything
     */
    public static function flush_group($group = 'all') {
        $all_keys = get_option(self::KEYS_OPT, array());
        $remaining = array();

        foreach ($all_keys as $key) {
            if ($group === 'all' || strpos($key, $group . '_') === 0) {
                delete_transient(self::PREFIX . $key);
            } else {
                $remaining[] = $key;
            }
        }

        update_option(self::KEYS_OPT, $group === 'all' ? array() : $remaining, false);
    }

    // --------------------------------------------------
    // Full-Page Output Cache
    // --------------------------------------------------

    /**
     * Call at the very start of a page template.
     * For anonymous GET visitors: either serve cached HTML instantly
     * or start buffering output to save it.
     */
    public static function page_cache_start() {
        // Full-page HTML output caching is disabled to guarantee real-time session header synchronization.
        // Object & Query-level caching via YPS_Cache::remember() handles DB performance.
        return;
    }

    /**
     * Output buffer callback — receives full HTML, saves to cache, returns it.
     */
    public static function page_cache_save($html) {
        if (strlen($html) > 500) {
            self::set(self::page_key(), $html, self::TTL_PAGE);
        }
        return $html;
    }

    // --------------------------------------------------
    // Auto-invalidation Hooks (wired in functions.php)
    // --------------------------------------------------

    /** Flush order caches when an order is saved/updated. */
    public static function on_order_save($post_id, $post) {
        if (($post->post_type ?? '') === 'yps_order') {
            self::flush_group('orders');
            self::flush_group('pages');  // dashboard pages may show counts
        }
    }

    /** Flush page cache when any post is published/updated. */
    public static function on_post_save($post_id, $post) {
        if (!in_array($post->post_type ?? '', array('nav_menu_item', 'revision', 'acf-field'), true)) {
            self::flush_group('pages');
        }
    }

    // --------------------------------------------------
    // Helpers
    // --------------------------------------------------

    private static function page_key() {
        $uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field($_SERVER['REQUEST_URI']) : '/';
        return 'pages_' . md5($uri);
    }

    private static function should_skip_page_cache() {
        if (is_user_logged_in())                          return true; // personalised content
        if (!empty($_POST))                               return true; // form submission
        if (defined('DOING_AJAX') && DOING_AJAX)          return true;
        if (defined('DOING_CRON') && DOING_CRON)          return true;
        if (defined('REST_REQUEST') && REST_REQUEST)      return true;
        if (is_admin())                                   return true;
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        if ($method !== 'GET')                            return true;
        // Don't cache 404 / search (need WP to load first to detect these)
        return false;
    }

    private static function track_key($key) {
        $keys = get_option(self::KEYS_OPT, array());
        if (!in_array($key, $keys, true)) {
            $keys[] = $key;
            update_option(self::KEYS_OPT, $keys, false);
        }
    }

    private static function untrack_key($key) {
        $keys    = get_option(self::KEYS_OPT, array());
        $cleaned = array_values(array_filter($keys, function($k) use ($key) {
            return $k !== $key;
        }));
        update_option(self::KEYS_OPT, $cleaned, false);
    }
}

