<?php
/**
 * YPS Gaming Theme - Header Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0d1b2e">
    <!-- Preload critical CSS for instant first paint -->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css" as="style">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="yps-site-wrapper">
    <!-- Navigation -->
    <nav id="yps-navbar" class="yps-navbar" role="navigation" aria-label="Main Navigation">
        <div class="yps-nav-inner">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="yps-logo" id="yps-logo-link" aria-label="YPS.CO Home">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <div class="yps-logo-text">
                        <span class="logo-icon">✦</span>
                        <span class="logo-name">YPS<span class="logo-dot">.CO</span></span>
                    </div>
                <?php endif; ?>
            </a>

            <!-- Desktop Nav Links -->
            <ul class="yps-nav-links" id="yps-nav-links">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo esc_url(home_url('/services')); ?>" class="nav-link <?php echo is_page('services') ? 'active' : ''; ?>">Services</a></li>
                <li><a href="<?php echo esc_url(home_url('/our-pilots')); ?>" class="nav-link <?php echo is_page('our-pilots') ? 'active' : ''; ?>">Our Pilots</a></li>
                <li><a href="<?php echo esc_url(home_url('/track-order')); ?>" class="nav-link <?php echo is_page('track-order') ? 'active' : ''; ?>">Track Order</a></li>
                <li><a href="<?php echo esc_url(home_url('/about-us')); ?>" class="nav-link <?php echo is_page('about-us') ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="nav-link <?php echo is_page('contact-us') ? 'active' : ''; ?>">Contact Us</a></li>
            </ul>

            <!-- Nav Actions -->
            <div class="yps-nav-actions">
                <a href="<?php echo esc_url(home_url('/track-order')); ?>" class="nav-icon-btn" id="nav-search-btn" title="Track Order" aria-label="Track Order">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </a>
                <?php if (is_user_logged_in()) :
                    $yps_home  = YPS_Login_Routing::role_home_url();
                    $yps_label = (current_user_can('access_admin_dashboard') || YPS_RBAC::has_role(get_current_user_id(), 'yps_pilot')) ? 'Dashboard' : 'My Orders';
                ?>
                    <a href="<?php echo esc_url($yps_home); ?>" class="yps-btn-login" id="nav-login-btn"><?php echo esc_html($yps_label); ?></a>
                    <a href="<?php echo esc_url(wp_logout_url()); ?>" class="nav-icon-btn" id="nav-logout-btn" title="Logout" aria-label="Logout">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url(YPS_Login_Routing::login_page_url()); ?>" class="yps-btn-login" id="nav-login-btn">Login / Sign Up</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Hamburger -->
            <button class="yps-hamburger" id="yps-hamburger" aria-label="Toggle Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="yps-mobile-menu" id="yps-mobile-menu" role="dialog" aria-label="Mobile Navigation">
        <div class="mobile-menu-inner">
            <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">🏠 Home</a></li>
                <li><a href="<?php echo esc_url(home_url('/services')); ?>">🎮 Services</a></li>
                <li><a href="<?php echo esc_url(home_url('/our-pilots')); ?>">👤 Our Pilots</a></li>
                <li><a href="<?php echo esc_url(home_url('/track-order')); ?>">📦 Track Order</a></li>
                <li><a href="<?php echo esc_url(home_url('/about-us')); ?>">ℹ️ About Us</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact-us')); ?>">📞 Contact Us</a></li>
            </ul>
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(YPS_Login_Routing::role_home_url()); ?>" class="yps-btn-login mobile-login" id="mobile-dashboard-btn"><?php echo esc_html($yps_label); ?></a>
                <a href="<?php echo esc_url(wp_logout_url()); ?>" class="mobile-logout" id="mobile-logout-btn" style="display:block;text-align:center;margin-top:12px;font-weight:700;opacity:.8;">Logout</a>
            <?php else : ?>
                <a href="<?php echo esc_url(YPS_Login_Routing::login_page_url()); ?>" class="yps-btn-login mobile-login" id="mobile-login-btn">Login / Sign Up</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Page Content Start -->
    <main id="yps-main-content">

