<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeatPro — Professional Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{--primary:#6366f1;--primary-dark:#4f46e5;--dark:#0f172a;--text:#334155;--muted:#94a3b8;--border:#e2e8f0}
        body{font-family:'Inter',sans-serif;background:#fff;color:var(--text);overflow-x:hidden}
        a{text-decoration:none;color:inherit}

        /* NAV */
        nav{position:fixed;top:0;left:0;right:0;z-index:100;padding:0 40px;height:68px;display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,.9);backdrop-filter:blur(12px);border-bottom:1px solid rgba(226,232,240,.6)}
        .nav-logo{display:flex;align-items:center;gap:10px;font-size:18px;font-weight:800;color:var(--dark)}
        .nav-logo span{color:var(--primary)}
        .nav-logo svg{width:36px;height:36px}
        .nav-links{display:flex;align-items:center;gap:32px}
        .nav-links a{font-size:14px;font-weight:500;color:var(--text);transition:color .2s}
        .nav-links a:hover{color:var(--primary)}
        .nav-cta{display:flex;align-items:center;gap:12px}
        .btn-ghost{padding:8px 18px;border-radius:8px;font-size:14px;font-weight:600;color:var(--text);border:1px solid var(--border);transition:all .2s}
        .btn-ghost:hover{border-color:var(--primary);color:var(--primary)}
        .btn-solid{padding:8px 20px;border-radius:8px;font-size:14px;font-weight:600;color:#fff;background:var(--primary);transition:all .2s}
        .btn-solid:hover{background:var(--primary-dark);transform:translateY(-1px);box-shadow:0 4px 14px rgba(99,102,241,.4)}

        /* HERO */
        .hero{padding:140px 40px 80px;text-align:center;background:linear-gradient(180deg,#f8faff 0%,#fff 100%);position:relative;overflow:hidden}
        .hero::before{content:'';position:absolute;top:-200px;left:50%;transform:translateX(-50%);width:800px;height:800px;background:radial-gradient(circle,rgba(99,102,241,.08) 0%,transparent 70%);pointer-events:none}
        .hero-badge{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;background:#ede9fe;color:#5b21b6;border-radius:20px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:24px}
        .hero h1{font-size:clamp(36px,5vw,64px);font-weight:800;color:var(--dark);line-height:1.1;letter-spacing:-.03em;margin-bottom:20px}
        .hero h1 span{background:linear-gradient(135deg,#6366f1,#8b5cf6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero p{font-size:18px;color:var(--muted);max-width:560px;margin:0 auto 36px;line-height:1.7}
        .hero-btns{display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap}
        .btn-hero{padding:14px 28px;border-radius:10px;font-size:15px;font-weight:700;transition:all .2s}
        .btn-hero-primary{background:var(--primary);color:#fff;box-shadow:0 4px 20px rgba(99,102,241,.35)}
        .btn-hero-primary:hover{background:var(--primary-dark);transform:translateY(-2px);box-shadow:0 8px 28px rgba(99,102,241,.45)}
        .btn-hero-secondary{background:#fff;color:var(--dark);border:1.5px solid var(--border)}
        .btn-hero-secondary:hover{border-color:var(--primary);color:var(--primary)}
        .hero-stats{display:flex;align-items:center;justify-content:center;gap:40px;margin-top:48px;flex-wrap:wrap}
        .hero-stat{text-align:center}
        .hero-stat .num{font-size:28px;font-weight:800;color:var(--dark)}
        .hero-stat .lbl{font-size:13px;color:var(--muted);margin-top:2px}

        /* PREVIEW */
        .preview{padding:0 40px 80px;display:flex;justify-content:center}
        .preview-wrap{max-width:1100px;width:100%;border-radius:20px;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,.12),0 0 0 1px rgba(0,0,0,.06);position:relative}
        .preview-bar{background:#1e293b;padding:12px 16px;display:flex;align-items:center;gap:8px}
        .preview-dot{width:12px;height:12px;border-radius:50%}
        .preview-url{flex:1;background:rgba(255,255,255,.08);border-radius:6px;padding:5px 12px;font-size:12px;color:#94a3b8;margin:0 12px;font-family:monospace}
        .preview-img{width:100%;display:block;background:linear-gradient(135deg,#f8fafc 0%,#e0e7ff 100%);min-height:400px;position:relative;overflow:hidden}

        /* FEATURES */
        .features{padding:80px 40px;background:#f8fafc}
        .section-label{text-align:center;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--primary);margin-bottom:12px}
        .section-title{text-align:center;font-size:clamp(28px,3vw,40px);font-weight:800;color:var(--dark);margin-bottom:14px;letter-spacing:-.02em}
        .section-sub{text-align:center;font-size:16px;color:var(--muted);max-width:520px;margin:0 auto 56px;line-height:1.6}
        .features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:1100px;margin:0 auto}
        .feature-card{background:#fff;border-radius:16px;padding:28px;border:1px solid var(--border);transition:all .25s}
        .feature-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,.08);border-color:rgba(99,102,241,.2)}
        .feature-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:16px}
        .feature-card h3{font-size:16px;font-weight:700;color:var(--dark);margin-bottom:8px}
        .feature-card p{font-size:14px;color:var(--muted);line-height:1.6}

        /* TECH STACK */
        .stack{padding:60px 40px;text-align:center}
        .stack-title{font-size:13px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:28px}
        .stack-logos{display:flex;align-items:center;justify-content:center;gap:40px;flex-wrap:wrap}
        .stack-item{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:600;color:#64748b;opacity:.7;transition:opacity .2s}
        .stack-item:hover{opacity:1}
        .stack-item i{font-size:20px}

        /* CTA */
        .cta-section{padding:80px 40px;background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 100%);text-align:center;position:relative;overflow:hidden}
        .cta-section::before{content:'';position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:radial-gradient(circle,rgba(99,102,241,.2) 0%,transparent 70%);pointer-events:none}
        .cta-section h2{font-size:clamp(28px,3vw,42px);font-weight:800;color:#fff;margin-bottom:14px;letter-spacing:-.02em}
        .cta-section p{font-size:16px;color:#94a3b8;margin-bottom:32px}
        .cta-btns{display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap}

        /* FOOTER */
        footer{padding:32px 40px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
        footer .logo{font-size:15px;font-weight:800;color:var(--dark)}
        footer .logo span{color:var(--primary)}
        footer p{font-size:13px;color:var(--muted)}

        @media(max-width:768px){
            nav{padding:0 20px}.nav-links{display:none}
            .hero{padding:100px 20px 60px}.features-grid{grid-template-columns:1fr}
            .features,.stack,.cta-section{padding:60px 20px}.preview{padding:0 20px 60px}
            footer{padding:24px 20px;flex-direction:column;text-align:center}
        }
        @media(max-width:1024px){.features-grid{grid-template-columns:repeat(2,1fr)}}

        /* Animations */
        @keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
        .fade-up{animation:fadeUp .6s ease both}
        .delay-1{animation-delay:.1s}.delay-2{animation-delay:.2s}.delay-3{animation-delay:.3s}
    </style>
</head>
<body>

<nav>
    <div class="nav-logo">
        <svg viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="36" height="36" rx="9" fill="url(#wlg)"/>
            <path d="M9 26V14l9-4 9 4v12l-9 4-9-4z" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.3)" stroke-width="1"/>
            <circle cx="18" cy="18" r="4" fill="white" opacity=".9"/>
            <path d="M18 14v8M14 18h8" stroke="#6366f1" stroke-width="1.5" stroke-linecap="round"/>
            <defs><linearGradient id="wlg" x1="0" y1="0" x2="36" y2="36" gradientUnits="userSpaceOnUse"><stop stop-color="#6366f1"/><stop offset="1" stop-color="#8b5cf6"/></linearGradient></defs>
        </svg>
        Neat<span>Pro</span>
    </div>
    <div class="nav-links">
        <a href="#features">Features</a>
        <a href="#stack">Stack</a>
        <a href="https://github.com" target="_blank">GitHub</a>
    </div>
    <div class="nav-cta">
        <a href="{{ route('login') }}" class="btn-ghost">Sign in</a>
        <a href="{{ route('register') }}" class="btn-solid">Get started</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-badge fade-up"><i class="fas fa-bolt"></i> Laravel 12 + Tailwind CSS</div>
    <h1 class="fade-up delay-1">The admin dashboard<br><span>built for real work</span></h1>
    <p class="fade-up delay-2">NeatPro gives you everything you need to manage your business — orders, customers, analytics, and more. Clean, fast, and ready to ship.</p>
    <div class="hero-btns fade-up delay-3">
        <a href="{{ route('register') }}" class="btn-hero btn-hero-primary"><i class="fas fa-rocket"></i> Start for free</a>
        <a href="{{ route('login') }}" class="btn-hero btn-hero-secondary"><i class="fas fa-sign-in-alt"></i> Sign in</a>
    </div>
    <div class="hero-stats fade-up delay-3">
        <div class="hero-stat"><div class="num">12+</div><div class="lbl">Modules</div></div>
        <div class="hero-stat"><div class="num">3</div><div class="lbl">Languages</div></div>
        <div class="hero-stat"><div class="num">100%</div><div class="lbl">Open source</div></div>
        <div class="hero-stat"><div class="num">RTL</div><div class="lbl">Support</div></div>
    </div>
</section>

<!-- PREVIEW -->
<div class="preview">
    <div class="preview-wrap">
        <div class="preview-bar">
            <div class="preview-dot" style="background:#ef4444"></div>
            <div class="preview-dot" style="background:#f59e0b"></div>
            <div class="preview-dot" style="background:#10b981"></div>
            <div class="preview-url">app.neatpro.dev/dashboard</div>
        </div>
        <div class="preview-img" style="padding:24px;background:#f8fafc;">
            <!-- Mini dashboard mockup -->
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px;">
                @foreach([['#ede9fe','#6366f1','fas fa-dollar-sign','$48,295','Revenue'],['#dbeafe','#3b82f6','fas fa-shopping-cart','1,284','Orders'],['#d1fae5','#10b981','fas fa-users','892','Customers'],['#fef3c7','#f59e0b','fas fa-chart-line','94.2%','Satisfaction']] as $s)
                <div style="background:#fff;border-radius:10px;padding:14px;border:1px solid #e2e8f0;display:flex;align-items:center;gap:10px;">
                    <div style="width:38px;height:38px;border-radius:9px;background:{{ $s[0] }};display:flex;align-items:center;justify-content:center;color:{{ $s[1] }};font-size:16px;flex-shrink:0;"><i class="{{ $s[2] }}"></i></div>
                    <div><div style="font-size:16px;font-weight:800;color:#0f172a;">{{ $s[3] }}</div><div style="font-size:11px;color:#94a3b8;">{{ $s[4] }}</div></div>
                </div>
                @endforeach
            </div>
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:12px;">
                <div style="background:#fff;border-radius:10px;padding:16px;border:1px solid #e2e8f0;">
                    <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:12px;">Revenue Overview</div>
                    <div style="display:flex;align-items:flex-end;gap:6px;height:80px;">
                        @foreach([40,65,45,80,55,90,70,85,60,95,75,100] as $h)
                        <div style="flex:1;background:linear-gradient(180deg,#6366f1,#8b5cf6);border-radius:4px 4px 0 0;height:{{ $h }}%;opacity:.8;"></div>
                        @endforeach
                    </div>
                </div>
                <div style="background:#fff;border-radius:10px;padding:16px;border:1px solid #e2e8f0;">
                    <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:12px;">Order Status</div>
                    @foreach([['Delivered','#10b981',60],['Processing','#3b82f6',25],['Pending','#f59e0b',15]] as $s)
                    <div style="margin-bottom:8px;">
                        <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:3px;"><span>{{ $s[0] }}</span><span style="color:{{ $s[1] }};font-weight:700;">{{ $s[2] }}%</span></div>
                        <div style="height:5px;background:#f1f5f9;border-radius:3px;"><div style="height:100%;width:{{ $s[2] }}%;background:{{ $s[1] }};border-radius:3px;"></div></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FEATURES -->
<section class="features" id="features">
    <div class="section-label">Everything you need</div>
    <h2 class="section-title">Built for modern businesses</h2>
    <p class="section-sub">From order management to customer analytics, NeatPro covers every aspect of your operations.</p>
    <div class="features-grid">
        @foreach([
            ['#ede9fe','#6366f1','fas fa-chart-pie','Analytics Dashboard','Real-time KPIs, revenue charts, conversion rates, and geographic breakdowns — all in one view.'],
            ['#dbeafe','#3b82f6','fas fa-shopping-cart','Order Management','Track orders through every stage. Export to PDF or CSV. Update statuses with one click.'],
            ['#d1fae5','#10b981','fas fa-users','CRM','Full customer profiles with order history, transaction records, and status tracking.'],
            ['#fef3c7','#f59e0b','fas fa-box','Ecommerce','Manage your product catalog with stock tracking, categories, and active/inactive states.'],
            ['#fee2e2','#ef4444','fas fa-credit-card','Transactions','Complete payment history with type, method, and status filtering.'],
            ['#f0fdf4','#22c55e','fas fa-shield-alt','Role-Based Access','Admin and manager roles with granular permissions. Social login via Google & GitHub.'],
            ['#fdf4ff','#a855f7','fas fa-bell','Notifications','In-app notification system with read/unread states and real-time badge counts.'],
            ['#fff7ed','#f97316','fas fa-globe','Multi-language','Full i18n support for English, French, and Arabic with RTL layout switching.'],
            ['#f0f9ff','#0ea5e9','fas fa-file-export','Export Tools','Generate PDF reports and CSV exports for orders with custom filters.'],
        ] as $f)
        <div class="feature-card">
            <div class="feature-icon" style="background:{{ $f[0] }};color:{{ $f[1] }};"><i class="{{ $f[2] }}"></i></div>
            <h3>{{ $f[3] }}</h3>
            <p>{{ $f[4] }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- STACK -->
<section class="stack" id="stack">
    <div class="stack-title">Powered by</div>
    <div class="stack-logos">
        <div class="stack-item"><i class="fab fa-laravel" style="color:#ef4444;"></i> Laravel 12</div>
        <div class="stack-item"><i class="fab fa-css3-alt" style="color:#06b6d4;"></i> Tailwind CSS</div>
        <div class="stack-item"><i class="fas fa-database" style="color:#f59e0b;"></i> SQLite / MySQL</div>
        <div class="stack-item"><i class="fab fa-js-square" style="color:#eab308;"></i> Chart.js</div>
        <div class="stack-item"><i class="fas fa-bolt" style="color:#6366f1;"></i> Vite</div>
        <div class="stack-item"><i class="fab fa-github" style="color:#24292e;"></i> Social Auth</div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <h2>Ready to get started?</h2>
    <p>Create your account in seconds. No credit card required.</p>
    <div class="cta-btns">
        <a href="{{ route('register') }}" class="btn-hero btn-hero-primary"><i class="fas fa-rocket"></i> Create free account</a>
        <a href="{{ route('login') }}" style="padding:14px 28px;border-radius:10px;font-size:15px;font-weight:700;color:#94a3b8;border:1.5px solid rgba(255,255,255,.15);transition:all .2s;" onmouseover="this.style.color='#fff';this.style.borderColor='rgba(255,255,255,.4)'" onmouseout="this.style.color='#94a3b8';this.style.borderColor='rgba(255,255,255,.15)'">Sign in instead</a>
    </div>
</section>

<footer>
    <div class="logo">Neat<span>Pro</span></div>
    <p>Built with Laravel 12 &amp; ❤️</p>
    <p style="font-size:13px;color:var(--muted);">© {{ date('Y') }} NeatPro. All rights reserved.</p>
</footer>

</body>
</html>
