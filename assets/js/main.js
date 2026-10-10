/**
 * YPS Gaming Theme - Main JavaScript
 * Handles: Navbar scroll, mobile menu, scroll animations, booking tabs, dynamic UI initializations
 * SPA-aware: all per-page inits run inside initPage() which fires on
 *   both initial load and on every AJAX page swap (yps:page-loaded event).
 */

(function() {
    'use strict';

    /* ==========================================================================
       GLOBAL INITIALIZATION (Runs once per document lifetime)
       ========================================================================== */
    function initGlobal() {
        // Navbar Scroll Blur & Shadow
        const navbar = document.getElementById('yps-navbar');
        if (navbar) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 20) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }, { passive: true });
        }

        // Mobile Menu Toggle
        const mobileToggle = document.getElementById('mobile-toggle');
        const navLinks = document.querySelector('.yps-nav-links');
        if (mobileToggle && navLinks) {
            mobileToggle.addEventListener('click', function() {
                navLinks.classList.toggle('active');
                mobileToggle.classList.toggle('open');
                document.body.classList.toggle('menu-open');
            });

            // Close on link click inside mobile menu
            navLinks.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') {
                    navLinks.classList.remove('active');
                    mobileToggle.classList.remove('open');
                    document.body.classList.remove('menu-open');
                }
            });
        }

        // Back to Top Button
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 400) {
                    backToTopBtn.classList.add('visible');
                } else {
                    backToTopBtn.classList.remove('visible');
                }
            }, { passive: true });

            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    }

    /* ==========================================================================
       PER-PAGE INITIALIZATION (Runs on DOMContentLoaded AND after SPA page swaps)
       ========================================================================== */
    function initPage() {
        // Auto-Dismiss Flash Alerts & Warnings after 3 seconds
        const autoDismissAlerts = document.querySelectorAll('.yps-alert, .alert-warning, .alert-info, .alert-success, .alert-danger, .flash-message, .yps-notice');
        autoDismissAlerts.forEach(function(alert) {
            // Check if timer already attached
            if (alert.dataset.dismissTimerSet) return;
            alert.dataset.dismissTimerSet = 'true';

            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease, max-height 0.5s ease, margin 0.5s ease, padding 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }, 3000);
        });

        // Close Alert Button Event Listeners
        const closeAlertBtns = document.querySelectorAll('.alert-close, .notice-dismiss');
        closeAlertBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const parent = btn.closest('.yps-alert, .alert, .yps-notice');
                if (parent) {
                    parent.style.opacity = '0';
                    setTimeout(function() {
                        if (parent.parentNode) parent.parentNode.removeChild(parent);
                    }, 300);
                }
            });
        });

        // Tab Navigation Systems (e.g. Services, Booking, Dashboard)
        const tabBtns = document.querySelectorAll('[data-tab]');
        tabBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTabId = btn.getAttribute('data-tab');
                const parentContainer = btn.closest('.tab-container, .services-section, .dashboard-section, .yps-tabs-wrapper') || document;

                // Deactivate all sibling tabs
                const siblingBtns = parentContainer.querySelectorAll('[data-tab]');
                siblingBtns.forEach(b => b.classList.remove('active'));

                // Hide all sibling content panels
                const tabPanels = parentContainer.querySelectorAll('.tab-panel, .tab-content');
                tabPanels.forEach(p => p.classList.remove('active'));

                // Activate clicked tab
                btn.classList.add('active');

                // Show target content panel
                const targetPanel = document.getElementById(targetTabId);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
            });
        });

        // Animate on Scroll Elements
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            const animateObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const animatableElements = document.querySelectorAll('.animate-on-scroll, .feature-card, .service-card, .pilot-card');
            animatableElements.forEach(el => animateObserver.observe(el));
        }

        // Smooth Scrolling for Hash Anchor Links (#)
        const hashLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
        hashLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const targetId = link.getAttribute('href').substring(1);
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    e.preventDefault();
                    const navOffset = 80;
                    const elementPosition = targetEl.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - navOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Initialize Global setup once
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initGlobal();
            initPage();
        });
    } else {
        initGlobal();
        initPage();
    }

    // Re-initialize page logic when SPA router updates page content dynamically
    document.addEventListener('yps:page-loaded', function() {
        initPage();
    });

})();
