/**
 * YPS Gaming Theme - Main JavaScript
 * Handles: Navbar scroll, mobile menu, scroll animations, booking tabs
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {

        // =============================================
        // NAVBAR SCROLL EFFECT
        // =============================================
        const navbar = document.getElementById('yps-navbar');
        if (navbar) {
            window.addEventListener('scroll', function() {
                navbar.classList.toggle('scrolled', window.scrollY > 50);
            }, { passive: true });
        }

        // =============================================
        // MOBILE HAMBURGER MENU
        // =============================================
        const hamburger   = document.getElementById('yps-hamburger');
        const mobileMenu  = document.getElementById('yps-mobile-menu');

        if (hamburger && mobileMenu) {
            hamburger.addEventListener('click', function() {
                const isOpen = mobileMenu.classList.toggle('open');
                hamburger.classList.toggle('open', isOpen);
                hamburger.setAttribute('aria-expanded', isOpen.toString());
                document.body.style.overflow = isOpen ? 'hidden' : '';
            });

            // Close on link click
            mobileMenu.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    mobileMenu.classList.remove('open');
                    hamburger.classList.remove('open');
                    hamburger.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = '';
                });
            });

            // Close on backdrop click
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
                    mobileMenu.classList.remove('open');
                    hamburger.classList.remove('open');
                    hamburger.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = '';
                }
            });
        }

        // =============================================
        // SCROLL ANIMATIONS (Intersection Observer)
        // =============================================
        const fadeEls = document.querySelectorAll('.fade-up');
        if (fadeEls.length && 'IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            fadeEls.forEach(function(el, idx) {
                el.style.transitionDelay = (idx % 4) * 0.08 + 's';
                observer.observe(el);
            });
        } else {
            // Fallback: show all
            fadeEls.forEach(function(el) { el.classList.add('visible'); });
        }

        // =============================================
        // BOOKING TABS (Home Page)
        // =============================================
        const bookingTabs = document.querySelectorAll('.booking-tab');
        bookingTabs.forEach(function(tab) {
            tab.addEventListener('mouseenter', function() {
                bookingTabs.forEach(function(t) { t.classList.remove('active'); });
                tab.classList.add('active');
            });
        });

        // =============================================
        // SMOOTH HOVER EFFECTS ON STAT CARDS
        // =============================================
        document.querySelectorAll('.stat-card, .feature-card').forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });

        // =============================================
        // TOAST NOTIFICATION SYSTEM
        // =============================================
        window.ypsToast = function(message, type) {
            type = type || 'info';
            var toast = document.createElement('div');
            toast.className = 'yps-toast ' + type;
            toast.innerHTML = (type === 'success' ? '✅ ' : type === 'error' ? '❌ ' : 'ℹ️ ') + message;
            document.body.appendChild(toast);
            setTimeout(function() { toast.classList.add('show'); }, 10);
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 400);
            }, 4000);
        };

        // =============================================
        // COUNTER ANIMATION
        // =============================================
        function animateCounter(el, target, suffix) {
            suffix = suffix || '';
            var start = 0;
            var duration = 1500;
            var startTime = null;
            var targetNum = parseInt(target.toString().replace(/[^0-9]/g, ''));

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                var current = Math.floor(eased * targetNum);

                if (targetNum >= 1000) {
                    el.textContent = current.toLocaleString() + suffix;
                } else {
                    el.textContent = current + suffix;
                }

                if (progress < 1) { requestAnimationFrame(step); }
                else { el.textContent = target; }
            }
            requestAnimationFrame(step);
        }

        // Animate stat numbers when in view
        var statNums = document.querySelectorAll('.pilot-stat-num, .stat-value');
        if (statNums.length && 'IntersectionObserver' in window) {
            var counterObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var el = entry.target;
                        var raw = el.textContent;
                        var suffix = raw.replace(/[0-9,]/g, '').trim();
                        animateCounter(el, raw, '');
                        counterObserver.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });

            statNums.forEach(function(el) { counterObserver.observe(el); });
        }

        // =============================================
        // CHART HOVER TOOLTIPS (Admin Dashboard)
        // =============================================
        document.querySelectorAll('.chart-bar').forEach(function(bar) {
            bar.addEventListener('mouseenter', function(e) {
                var tooltip = document.createElement('div');
                tooltip.className = 'chart-tooltip';
                tooltip.textContent = bar.title || '';
                tooltip.style.cssText = 'position:fixed;background:#0D2137;color:white;padding:4px 10px;border-radius:6px;font-size:0.75rem;font-weight:700;pointer-events:none;z-index:9999;transform:translate(-50%,-110%);';
                tooltip.style.left = e.clientX + 'px';
                tooltip.style.top  = e.clientY + 'px';
                tooltip.id = 'yps-chart-tooltip';
                document.body.appendChild(tooltip);
            });
            bar.addEventListener('mouseleave', function() {
                var t = document.getElementById('yps-chart-tooltip');
                if (t) t.remove();
            });
        });

        // =============================================
        // SCROLL TO TOP (if > 400px)
        // =============================================
        var scrollTopBtn = document.createElement('button');
        scrollTopBtn.innerHTML = '↑';
        scrollTopBtn.id = 'yps-scroll-top';
        scrollTopBtn.setAttribute('aria-label', 'Scroll to top');
        scrollTopBtn.style.cssText = 'position:fixed;bottom:24px;left:24px;width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#FF6B9D,#9B59B6);color:white;font-size:1.1rem;font-weight:700;box-shadow:0 4px 15px rgba(255,107,157,0.4);opacity:0;transition:all 0.3s;z-index:998;cursor:pointer;border:none;display:flex;align-items:center;justify-content:center;';
        document.body.appendChild(scrollTopBtn);

        window.addEventListener('scroll', function() {
            scrollTopBtn.style.opacity = window.scrollY > 400 ? '1' : '0';
            scrollTopBtn.style.pointerEvents = window.scrollY > 400 ? 'all' : 'none';
        }, { passive: true });

        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

    }); // DOMContentLoaded

})();
