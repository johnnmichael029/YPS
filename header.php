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
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(admin_url()); ?>" class="yps-btn-login" id="nav-login-btn">Dashboard</a>
                <?php else : ?>
                    <a href="<?php echo esc_url(wp_login_url()); ?>" class="yps-btn-login" id="nav-login-btn">Login / Sign Up</a>
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
            <a href="<?php echo esc_url(wp_login_url()); ?>" class="yps-btn-login mobile-login">Login / Sign Up</a>
        </div>
    </div>

    <!-- Page Content Start -->
    <main id="yps-main-content">

