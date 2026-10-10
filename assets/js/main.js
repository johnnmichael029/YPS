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
        // 1. Auto-Dismiss Flash Alerts & Warnings after 3 seconds
        const autoDismissAlerts = document.querySelectorAll('.yps-alert, .alert-warning, .alert-info, .alert-success, .alert-danger, .flash-message, .yps-notice');
        autoDismissAlerts.forEach(function(alert) {
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

        // 2. Generic Tab Navigation Systems (e.g. Dashboard, Booking)
        const tabBtns = document.querySelectorAll('[data-tab]');
        tabBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTabId = btn.getAttribute('data-tab');
                const parentContainer = btn.closest('.tab-container, .services-section, .dashboard-section, .yps-tabs-wrapper') || document;

                const siblingBtns = parentContainer.querySelectorAll('[data-tab]');
                siblingBtns.forEach(b => b.classList.remove('active'));

                const tabPanels = parentContainer.querySelectorAll('.tab-panel, .tab-content');
                tabPanels.forEach(p => p.classList.remove('active'));

                btn.classList.add('active');
                const targetPanel = document.getElementById(targetTabId);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
            });
        });

        // 3. Services Page Game Filter Tabs (.filter-tab & .service-game-block)
        const filterTabs = document.querySelectorAll('.filter-tab');
        const serviceBlocks = document.querySelectorAll('.service-game-block');
        if (filterTabs.length > 0 && serviceBlocks.length > 0) {
            function activateFilter(filter, scroll) {
                filterTabs.forEach(t => {
                    if (t.dataset.filter === filter) {
                        t.classList.add('active');
                        t.setAttribute('aria-selected', 'true');
                    } else {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    }
                });

                serviceBlocks.forEach(function(block) {
                    if (filter === 'all' || block.dataset.game === filter) {
                        block.style.display = 'block';
                        block.classList.add('visible');
                    } else {
                        block.style.display = 'none';
                    }
                });

                if (scroll) {
                    const target = document.getElementById('services-content');
                    if (target) {
                        const navOffset = 80;
                        const elementPosition = target.getBoundingClientRect().top + window.pageYOffset;
                        window.scrollTo({
                            top: elementPosition - navOffset,
                            behavior: 'smooth'
                        });
                    }
                }
            }

            const hash = window.location.hash.replace('#', '');
            if (hash && ['genshin', 'honkai', 'zenless', 'wuthering'].includes(hash)) {
                activateFilter(hash, true);
            } else {
                activateFilter('all', false);
            }

            filterTabs.forEach(function(tab) {
                tab.onclick = function(e) {
                    e.preventDefault();
                    const filter = this.dataset.filter;
                    activateFilter(filter, false);
                    if (filter !== 'all') {
                        window.history.replaceState(null, null, '#' + filter);
                    } else {
                        window.history.replaceState(null, null, window.location.pathname);
                    }
                };
            });
        }

        // 4. Fade-Up & Scroll Animations (IntersectionObserver + Immediate Fallback)
        const animatableElements = document.querySelectorAll('.fade-up, .animate-on-scroll, .feature-card, .service-card, .pilot-card, .game-card');
        if ('IntersectionObserver' in window && animatableElements.length > 0) {
            const observerOptions = {
                threshold: 0.05,
                rootMargin: '50px 0px 0px 0px'
            };
            const animateObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            animatableElements.forEach(el => {
                // If element is already in viewport, make it visible immediately
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom >= 0) {
                    el.classList.add('visible');
                    el.classList.add('animated');
                } else {
                    animateObserver.observe(el);
                }
            });
        } else {
            // Fallback: make all animated elements visible
            animatableElements.forEach(el => {
                el.classList.add('visible');
                el.classList.add('animated');
            });
        }

        // 5. Smooth Scroll for Hash Anchor Links (#)
        const hashLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
        hashLinks.forEach(function(link) {
            link.onclick = function(e) {
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
            };
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
