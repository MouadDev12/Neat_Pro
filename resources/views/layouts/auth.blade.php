<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth') — Neat Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .auth-left {
            flex: 1; display: flex; flex-direction: column; justify-content: center;
            align-items: center; padding: 60px; color: #fff;
        }
        .auth-left h1 { font-size: 42px; font-weight: 800; margin-bottom: 16px; }
        .auth-left p { font-size: 18px; opacity: .85; max-width: 400px; text-align: center; line-height: 1.6; }
        .auth-features { margin-top: 40px; display: flex; flex-direction: column; gap: 16px; }
        .auth-feature { display: flex; align-items: center; gap: 12px; font-size: 15px; }
        .auth-feature i { width: 36px; height: 36px; background: rgba(255,255,255,.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; }

        .auth-right {
            width: 480px; background: #fff; display: flex; flex-direction: column;
            justify-content: center; padding: 60px 48px; min-height: 100vh;
        }
        .auth-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 40px; }
        .auth-logo .logo { width: 40px; height: 40px; flex-shrink: 0; }
        .auth-logo .logo svg { width: 40px; height: 40px; }
        .auth-logo .brand-name { font-size: 20px; font-weight: 800; color: #0f172a; letter-spacing: -.3px; }
        .auth-logo .brand-name span { color: #6366f1; }

        .auth-title { font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
        .auth-subtitle { font-size: 14px; color: #94a3b8; margin-bottom: 32px; }

        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #334155; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 11px 14px; border: 1px solid #e2e8f0; border-radius: 8px;
            font-size: 14px; outline: none; transition: all .2s; color: #334155;
        }
        .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
        .input-icon { position: relative; }
        .input-icon i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; }
        .input-icon .form-control { padding-left: 40px; }

        .btn-auth {
            width: 100%; padding: 12px; background: #6366f1; color: #fff; border: none;
            border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer;
            transition: background .2s; margin-top: 8px;
        }
        .btn-auth:hover { background: #4f46e5; }

        .divider { display: flex; align-items: center; gap: 12px; margin: 24px 0; color: #94a3b8; font-size: 13px; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }

        .social-btns { display: flex; gap: 12px; }
        .btn-social {
            flex: 1; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;
            background: #fff; cursor: pointer; font-size: 13px; font-weight: 500;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            color: #334155; text-decoration: none; transition: all .2s;
        }
        .btn-social:hover { border-color: #6366f1; color: #6366f1; background: #f5f3ff; }

        .auth-footer { margin-top: 28px; text-align: center; font-size: 14px; color: #94a3b8; }
        .auth-footer a { color: #6366f1; font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }

        .alert { padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 40px 24px; }
        }
    </style>
</head>
<body>
    <div class="auth-left">
        <h1>NeatPro</h1>
        <p>A professional admin panel built with Laravel. Manage your business with clarity.</p>
        <div class="auth-features">
            <div class="auth-feature"><i class="fas fa-chart-pie"></i> Real-time analytics & insights</div>
            <div class="auth-feature"><i class="fas fa-users"></i> CRM & customer management</div>
            <div class="auth-feature"><i class="fas fa-shopping-cart"></i> Orders & ecommerce tracking</div>
            <div class="auth-feature"><i class="fas fa-shield-alt"></i> Role-based access control</div>
        </div>
    </div>
    <div class="auth-right">
        <div class="auth-logo">
            <div class="logo">
                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="10" fill="url(#alg1)"/>
                    <path d="M11 28V15l9-4 9 4v13l-9 4-9-4z" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.3)" stroke-width="1"/>
                    <path d="M20 11l9 4v13l-9 4V11z" fill="rgba(255,255,255,.1)"/>
                    <circle cx="20" cy="20" r="4" fill="white" opacity=".9"/>
                    <path d="M20 16v8M16 20h8" stroke="#6366f1" stroke-width="1.5" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="alg1" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#6366f1"/>
                            <stop offset="1" stop-color="#8b5cf6"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="brand-name">Neat<span>Pro</span></div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error){{ $error }}<br>@endforeach
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>
