<?php
/**
 * Template Name: Login
 * YPS Gaming - Unified Login Page (Admin, Staff, Pilots, Customers)
 *
 * Views: signin | register | forgot | reset | reset-invalid
 * Routed automatically for the page with slug "login" (see functions.php).
 */

if (!defined('ABSPATH')) exit;

$yps_action      = isset($_GET['action']) ? sanitize_key($_GET['action']) : '';
$yps_redirect_to = YPS_Login_Routing::safe_redirect_target($_GET['redirect_to'] ?? '');

// Already signed in? Skip the form (except for the reset-password screen).
if (is_user_logged_in() && $yps_action !== 'reset') {
    wp_safe_redirect($yps_redirect_to !== '' ? $yps_redirect_to : YPS_Login_Routing::role_home_url());
    exit;
}

// Password reset link validation
$rp_key   = isset($_GET['key'])   ? sanitize_text_field(wp_unslash($_GET['key']))   : '';
$rp_login = isset($_GET['login']) ? sanitize_user(wp_unslash($_GET['login']))       : '';
$rp_valid = false;
if ($yps_action === 'reset' && $rp_key !== '' && $rp_login !== '') {
    $rp_valid = !is_wp_error(check_password_reset_key($rp_key, $rp_login));
}

switch ($yps_action) {
    case 'register': $initial_view = 'register'; break;
    case 'forgot':   $initial_view = 'forgot';   break;
    case 'reset':    $initial_view = $rp_valid ? 'reset' : 'reset-invalid'; break;
    default:         $initial_view = 'signin';
}

$notice = '';
if (!empty($_GET['loggedout']))               $notice = "You've been logged out. See you soon! 👋";
if (($_GET['reset'] ?? '') === 'done')        $notice = 'Password updated. Sign in with your new password.';

add_filter('show_admin_bar', '__return_false');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Sign in to YPS.CO — staff, pilots and customers.">
    <title>Sign In | <?php echo esc_html(get_bloginfo('name')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: { extend: { colors: { ypsPink: '#FF6B9D', ypsPurple: '#9B59B6', ypsTeal: '#0D2137' } } }
        }
    </script>
    <?php wp_head(); ?>
    <style>
        html, body.yps-login-page { margin-top: 0 !important; background: #0D2137; }
        .yps-login-page button, .yps-login-page input, .yps-login-page select { font-family: inherit; }
        .yps-view { display: none; }
        .yps-view.is-active { display: block; animation: ypsFadeUp .35s ease both; }
        @keyframes ypsFadeUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
        .yps-orb { position: absolute; border-radius: 9999px; filter: blur(70px); opacity: .55; pointer-events: none; }
        @keyframes ypsFloat { 0%,100% { transform: translateY(0) } 50% { transform: translateY(-18px) } }
        .yps-float { animation: ypsFloat 7s ease-in-out infinite; }
        .yps-input { width: 100%; border: 1px solid #e2e8f0; border-radius: 12px; background: #fff; padding: 12px 14px; font-size: .92rem; color: #1A1A2E; outline: none; transition: border-color .2s, box-shadow .2s; }
        .yps-input:focus { border-color: #FF6B9D; box-shadow: 0 0 0 4px rgba(255,107,157,.15); }
        .yps-input::placeholder { color: #a0aec0; }
        .yps-submit { width: 100%; border: 0; cursor: pointer; border-radius: 12px; padding: 13px 16px; font-weight: 800; font-size: .95rem; color: #fff; background: linear-gradient(135deg, #FF6B9D, #9B59B6); box-shadow: 0 10px 24px rgba(255,107,157,.30); transition: transform .15s, box-shadow .2s, opacity .2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .yps-submit:hover { transform: translateY(-1px); box-shadow: 0 14px 30px rgba(255,107,157,.40); }
        .yps-submit:disabled { opacity: .7; cursor: wait; transform: none; }
        .yps-link { background: none; border: 0; padding: 0; cursor: pointer; color: #E0457A; font-weight: 700; }
        .yps-link:hover { text-decoration: underline; }
        .yps-tab { flex: 1; border: 0; cursor: pointer; background: transparent; padding: 10px; border-radius: 10px; font-weight: 700; font-size: .88rem; color: #64748b; transition: all .2s; }
        .yps-tab.is-active { background: #fff; color: #1A1A2E; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
        .yps-spin { width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.5); border-top-color: #fff; border-radius: 50%; animation: ypsSpin .7s linear infinite; }
        @keyframes ypsSpin { to { transform: rotate(360deg); } }
    </style>
</head>

<body <?php body_class('yps-login-page'); ?>>

    <main class="min-h-screen flex">

        <!-- Brand panel -->
        <section class="relative hidden lg:flex lg:w-1/2 flex-col justify-between overflow-hidden p-12 text-white"
            style="background: radial-gradient(120% 120% at 0% 0%, #0F2D4A 0%, #0D2137 55%, #0a1828 100%);">
            <div class="yps-orb yps-float" style="width:340px;height:340px;background:#FF6B9D;top:-80px;left:-60px;"></div>
            <div class="yps-orb yps-float" style="width:300px;height:300px;background:#9B59B6;bottom:-60px;right:-40px;animation-delay:-3s;"></div>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="relative z-10 flex items-center gap-2 text-xl font-extrabold tracking-wide no-underline text-white">
                <span style="color:#FF6B9D;" class="text-2xl">✦</span> YPS<span style="color:#FF6B9D;">.CO</span>
            </a>

            <div class="relative z-10 max-w-md mx-auto my-auto w-full">
                <h2 class="text-4xl font-black leading-tight mb-4">
                    One portal for the<br>
                    <span style="background:linear-gradient(90deg,#FF6B9D,#C39BD3);-webkit-background-clip:text;background-clip:text;color:transparent;">whole YPS crew.</span>
                </h2>
                <p class="text-slate-300 text-base leading-relaxed mb-8">
                    Sign in once — we'll take you straight to the right place based on your account.
                </p>

                <ul class="space-y-3 list-none p-0">
                    <li class="flex items-center gap-3 rounded-2xl px-4 py-3" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);">
                        <span class="text-xl">👑</span>
                        <div><div class="font-bold text-sm">Admin &amp; Staff</div><div class="text-xs text-slate-400">Sales, bookings &amp; pilot assignment</div></div>
                    </li>
                    <li class="flex items-center gap-3 rounded-2xl px-4 py-3" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);">
                        <span class="text-xl">⚡</span>
                        <div><div class="font-bold text-sm">Pilots</div><div class="text-xs text-slate-400">Your assigned orders &amp; progress</div></div>
                    </li>
                    <li class="flex items-center gap-3 rounded-2xl px-4 py-3" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);">
                        <span class="text-xl">🛍️</span>
                        <div><div class="font-bold text-sm">Customers</div><div class="text-xs text-slate-400">Track your boosts in real time</div></div>
                    </li>
                </ul>
            </div>

            <p class="relative z-10 text-xs text-slate-500">© <?php echo esc_html(date('Y')); ?> YPS.CO · Secure sign-in</p>
        </section>

        <!-- Form panel -->
        <section class="flex w-full lg:w-1/2 items-center justify-center p-6 sm:p-10" style="background:#F8F6FF;">
            <div class="w-full max-w-md">

                <!-- Mobile logo -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="lg:hidden flex items-center justify-center gap-2 mb-8 text-xl font-extrabold no-underline" style="color:#0D2137;">
                    <span style="color:#FF6B9D;" class="text-2xl">✦</span> YPS<span style="color:#FF6B9D;">.CO</span>
                </a>

                <div class="rounded-3xl bg-white p-7 sm:p-9" style="box-shadow:0 20px 60px rgba(13,33,55,.10);border:1px solid rgba(255,107,157,.12);">

                    <?php if ($notice) : ?>
                        <div class="mb-5 rounded-xl px-4 py-3 text-sm font-semibold" style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;" id="yps-login-notice" role="status">
                            <?php echo esc_html($notice); ?>
                        </div>
                    <?php endif; ?>

                    <div id="yps-login-msg" class="hidden mb-5 rounded-xl px-4 py-3 text-sm font-semibold" role="alert" aria-live="polite"></div>

                    <!-- Sign In / Register tabs -->
                    <div id="yps-tabs" class="flex gap-1 rounded-xl p-1 mb-7" style="background:#f1f5f9;">
                        <button type="button" class="yps-tab" data-view="signin" id="tab-signin">Sign In</button>
                        <button type="button" class="yps-tab" data-view="register" id="tab-register">Create Account</button>
                    </div>

                    <!-- ============ SIGN IN ============ -->
                    <div class="yps-view" data-view-panel="signin">
                        <h1 class="text-2xl font-black mb-1" style="color:#1A1A2E;">Welcome back 👋</h1>
                        <p class="text-sm text-slate-500 mb-6">Sign in to continue to your dashboard.</p>

                        <form id="yps-signin-form" class="space-y-4" novalidate>
                            <div>
                                <label for="signin-username" class="block text-xs font-bold text-slate-600 mb-1.5">Username or Email</label>
                                <input type="text" id="signin-username" name="username" class="yps-input" autocomplete="username" required placeholder="you@example.com">
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label for="signin-password" class="block text-xs font-bold text-slate-600">Password</label>
                                    <button type="button" class="yps-link text-xs" data-view="forgot" id="link-forgot">Forgot password?</button>
                                </div>
                                <div class="relative">
                                    <input type="password" id="signin-password" name="password" class="yps-input" style="padding-right:46px;" autocomplete="current-password" required placeholder="••••••••">
                                    <button type="button" class="yps-pw-toggle absolute right-2 top-1/2 -translate-y-1/2 border-0 bg-transparent cursor-pointer text-slate-400 hover:text-slate-600 p-2" aria-label="Show password" data-target="signin-password">👁️</button>
                                </div>
                                <p class="yps-caps hidden text-xs font-semibold mt-1.5" style="color:#b45309;">⚠️ Caps Lock is on</p>
                            </div>
                            <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer select-none">
                                <input type="checkbox" name="remember" id="signin-remember" value="1" checked style="accent-color:#FF6B9D;width:16px;height:16px;">
                                Remember me
                            </label>
                            <button type="submit" class="yps-submit" id="signin-submit">Sign In →</button>
                        </form>

                        <p class="text-xs text-slate-400 text-center mt-6">
                            Staff &amp; pilot accounts are created by an administrator.
                        </p>
                    </div>

                    <!-- ============ REGISTER ============ -->
                    <div class="yps-view" data-view-panel="register">
                        <h1 class="text-2xl font-black mb-1" style="color:#1A1A2E;">Create your account ✨</h1>
                        <p class="text-sm text-slate-500 mb-6">Save your details and keep track of your orders. Guest checkout still works without one.</p>

                        <form id="yps-register-form" class="space-y-4" novalidate>
                            <div>
                                <label for="reg-name" class="block text-xs font-bold text-slate-600 mb-1.5">Display Name</label>
                                <input type="text" id="reg-name" name="display_name" class="yps-input" autocomplete="name" placeholder="e.g. Aether">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="reg-username" class="block text-xs font-bold text-slate-600 mb-1.5">Username *</label>
                                    <input type="text" id="reg-username" name="username" class="yps-input" autocomplete="username" required placeholder="aether_01">
                                </div>
                                <div>
                                    <label for="reg-email" class="block text-xs font-bold text-slate-600 mb-1.5">Email *</label>
                                    <input type="email" id="reg-email" name="email" class="yps-input" autocomplete="email" required placeholder="you@example.com">
                                </div>
                            </div>
                            <div>
                                <label for="reg-password" class="block text-xs font-bold text-slate-600 mb-1.5">Password * <span class="font-normal text-slate-400">(min. 8 characters)</span></label>
                                <div class="relative">
                                    <input type="password" id="reg-password" name="password" class="yps-input" style="padding-right:46px;" autocomplete="new-password" required minlength="8" placeholder="••••••••">
                                    <button type="button" class="yps-pw-toggle absolute right-2 top-1/2 -translate-y-1/2 border-0 bg-transparent cursor-pointer text-slate-400 hover:text-slate-600 p-2" aria-label="Show password" data-target="reg-password">👁️</button>
                                </div>
                                <div class="mt-2 h-1.5 w-full rounded-full overflow-hidden" style="background:#f1f5f9;">
                                    <div id="reg-strength" class="h-full rounded-full transition-all duration-300" style="width:0;background:#FF6B9D;"></div>
                                </div>
                            </div>
                            <button type="submit" class="yps-submit" id="register-submit">Create Account →</button>
                        </form>
                    </div>

                    <!-- ============ FORGOT ============ -->
                    <div class="yps-view" data-view-panel="forgot">
                        <h1 class="text-2xl font-black mb-1" style="color:#1A1A2E;">Forgot password? 🔑</h1>
                        <p class="text-sm text-slate-500 mb-6">Enter your username or email and we'll send you a reset link.</p>

                        <form id="yps-forgot-form" class="space-y-4" novalidate>
                            <div>
                                <label for="forgot-login" class="block text-xs font-bold text-slate-600 mb-1.5">Username or Email</label>
                                <input type="text" id="forgot-login" name="user_login" class="yps-input" autocomplete="username" required placeholder="you@example.com">
                            </div>
                            <button type="submit" class="yps-submit" id="forgot-submit">Send Reset Link →</button>
                        </form>

                        <p class="text-sm text-center mt-6"><button type="button" class="yps-link" data-view="signin" id="forgot-back">← Back to sign in</button></p>
                    </div>

                    <!-- ============ RESET ============ -->
                    <div class="yps-view" data-view-panel="reset">
                        <h1 class="text-2xl font-black mb-1" style="color:#1A1A2E;">Set a new password 🔒</h1>
                        <p class="text-sm text-slate-500 mb-6">For account <strong><?php echo esc_html($rp_login); ?></strong>.</p>

                        <form id="yps-reset-form" class="space-y-4" novalidate>
                            <input type="hidden" name="key" value="<?php echo esc_attr($rp_key); ?>">
                            <input type="hidden" name="login" value="<?php echo esc_attr($rp_login); ?>">
                            <div>
                                <label for="reset-password" class="block text-xs font-bold text-slate-600 mb-1.5">New Password <span class="font-normal text-slate-400">(min. 8 characters)</span></label>
                                <div class="relative">
                                    <input type="password" id="reset-password" name="password" class="yps-input" style="padding-right:46px;" autocomplete="new-password" required minlength="8" placeholder="••••••••">
                                    <button type="button" class="yps-pw-toggle absolute right-2 top-1/2 -translate-y-1/2 border-0 bg-transparent cursor-pointer text-slate-400 hover:text-slate-600 p-2" aria-label="Show password" data-target="reset-password">👁️</button>
                                </div>
                            </div>
                            <div>
                                <label for="reset-password2" class="block text-xs font-bold text-slate-600 mb-1.5">Confirm Password</label>
                                <input type="password" id="reset-password2" name="password2" class="yps-input" autocomplete="new-password" required minlength="8" placeholder="••••••••">
                            </div>
                            <button type="submit" class="yps-submit" id="reset-submit">Update Password →</button>
                        </form>
                    </div>

                    <!-- ============ RESET INVALID ============ -->
                    <div class="yps-view text-center" data-view-panel="reset-invalid">
                        <div class="text-5xl mb-3">⏰</div>
                        <h1 class="text-2xl font-black mb-2" style="color:#1A1A2E;">Link expired</h1>
                        <p class="text-sm text-slate-500 mb-6">This password reset link is invalid or has already been used.</p>
                        <button type="button" class="yps-submit" data-view="forgot" id="reset-request-new">Request a New Link →</button>
                    </div>

                </div>

                <p class="text-center text-sm text-slate-500 mt-6">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="no-underline font-semibold hover:underline" style="color:#64748b;">← Back to YPS.CO</a>
                    <span class="mx-2 text-slate-300">·</span>
                    <a href="<?php echo esc_url(home_url('/track-order/')); ?>" class="no-underline font-semibold hover:underline" style="color:#64748b;">Track an order as guest</a>
                </p>
            </div>
        </section>
    </main>

    <script>
        (function () {
            var CFG = {
                ajaxUrl: <?php echo wp_json_encode(admin_url('admin-ajax.php')); ?>,
                nonce: <?php echo wp_json_encode(wp_create_nonce('yps_nonce')); ?>,
                redirectTo: <?php echo wp_json_encode($yps_redirect_to); ?>,
                initialView: <?php echo wp_json_encode($initial_view); ?>
            };

            var msgBox = document.getElementById('yps-login-msg');
            var tabs = document.getElementById('yps-tabs');

            function showMsg(text, type) {
                var ok = type === 'success';
                msgBox.textContent = text;
                msgBox.style.background = ok ? '#f0fdf4' : '#fef2f2';
                msgBox.style.color = ok ? '#166534' : '#991b1b';
                msgBox.style.border = '1px solid ' + (ok ? '#bbf7d0' : '#fecaca');
                msgBox.classList.remove('hidden');
            }
            function clearMsg() { msgBox.classList.add('hidden'); msgBox.textContent = ''; }

            function setView(view, push) {
                document.querySelectorAll('[data-view-panel]').forEach(function (p) {
                    p.classList.toggle('is-active', p.getAttribute('data-view-panel') === view);
                });
                document.querySelectorAll('.yps-tab').forEach(function (t) {
                    t.classList.toggle('is-active', t.getAttribute('data-view') === view);
                });
                // Tabs only make sense for sign in / register
                tabs.style.display = (view === 'signin' || view === 'register') ? 'flex' : 'none';
                clearMsg();

                var panel = document.querySelector('[data-view-panel="' + view + '"]');
                var first = panel && panel.querySelector('input:not([type=hidden]):not([type=checkbox])');
                if (first) setTimeout(function () { first.focus(); }, 50);

                if (push && history.replaceState) {
                    var url = new URL(window.location.href);
                    ['action', 'key', 'login', 'loggedout', 'reset'].forEach(function (k) { url.searchParams.delete(k); });
                    if (view === 'register' || view === 'forgot') url.searchParams.set('action', view);
                    history.replaceState(null, '', url.toString());
                }
            }

            document.querySelectorAll('[data-view]').forEach(function (el) {
                el.addEventListener('click', function () { setView(this.getAttribute('data-view'), true); });
            });

            // Show / hide password
            document.querySelectorAll('.yps-pw-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var input = document.getElementById(this.getAttribute('data-target'));
                    var show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    this.textContent = show ? '🙈' : '👁️';
                    this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                });
            });

            // Caps Lock hint
            var signinPw = document.getElementById('signin-password');
            var capsHint = document.querySelector('.yps-caps');
            ['keyup', 'keydown'].forEach(function (evt) {
                signinPw.addEventListener(evt, function (e) {
                    if (e.getModifierState) capsHint.classList.toggle('hidden', !e.getModifierState('CapsLock'));
                });
            });

            // Password strength meter
            var regPw = document.getElementById('reg-password');
            var meter = document.getElementById('reg-strength');
            regPw.addEventListener('input', function () {
                var v = this.value, s = 0;
                if (v.length >= 8) s++;
                if (v.length >= 12) s++;
                if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
                if (/\d/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s++;
                var colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#16a34a'];
                meter.style.width = (v ? Math.max(1, s) * 20 : 0) + '%';
                meter.style.background = colors[Math.max(0, s - 1)];
            });

            // Generic AJAX form submit
            function bindForm(formId, action, btnLabel, validate) {
                var form = document.getElementById(formId);
                var btn = form.querySelector('button[type=submit]');

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    clearMsg();

                    var err = validate ? validate(form) : '';
                    if (err) { showMsg(err, 'error'); return; }

                    var fd = new FormData(form);
                    fd.append('action', action);
                    fd.append('nonce', CFG.nonce);
                    if (CFG.redirectTo) fd.append('redirect_to', CFG.redirectTo);

                    btn.disabled = true;
                    btn.innerHTML = '<span class="yps-spin"></span> Please wait…';

                    fetch(CFG.ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
                        .then(function (r) { return r.json(); })
                        .then(function (res) {
                            var data = res.data || {};
                            if (res.success) {
                                showMsg(data.message || 'Success!', 'success');
                                if (data.redirect) {
                                    btn.innerHTML = '✓ Redirecting…';
                                    setTimeout(function () { window.location.href = data.redirect; }, 700);
                                    return;
                                }
                                form.reset();
                            } else {
                                showMsg(data.message || 'Something went wrong. Please try again.', 'error');
                                if (data.expired) setView('reset-invalid', false);
                            }
                            btn.disabled = false;
                            btn.innerHTML = btnLabel;
                        })
                        .catch(function () {
                            showMsg('Connection error. Please check your internet and try again.', 'error');
                            btn.disabled = false;
                            btn.innerHTML = btnLabel;
                        });
                });
            }

            bindForm('yps-signin-form', 'yps_login', 'Sign In →', function (f) {
                if (!f.username.value.trim() || !f.password.value) return 'Please enter your username and password.';
            });
            bindForm('yps-register-form', 'yps_register', 'Create Account →', function (f) {
                if (!f.username.value.trim() || !f.email.value.trim() || !f.password.value) return 'Please fill in all required fields.';
                if (!/^\S+@\S+\.\S+$/.test(f.email.value.trim())) return 'Please enter a valid email address.';
                if (f.password.value.length < 8) return 'Password must be at least 8 characters.';
            });
            bindForm('yps-forgot-form', 'yps_forgot_password', 'Send Reset Link →', function (f) {
                if (!f.user_login.value.trim()) return 'Please enter your username or email.';
            });
            bindForm('yps-reset-form', 'yps_reset_password', 'Update Password →', function (f) {
                if (f.password.value.length < 8) return 'Password must be at least 8 characters.';
                if (f.password.value !== f.password2.value) return 'Passwords do not match.';
            });

            setView(CFG.initialView, false);
        })();
    </script>

    <?php wp_footer(); ?>
</body>

</html>
