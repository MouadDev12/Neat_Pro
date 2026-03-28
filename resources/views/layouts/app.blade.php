<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Neat Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #e0e7ff;
            --secondary: #f1f5f9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #0f172a;
            --text: #334155;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --sidebar-w: 260px;
            --topbar-h: 64px;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: var(--text); min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w);
            height: 100vh; background: var(--dark); z-index: 100;
            display: flex; flex-direction: column; transition: transform .3s ease;
            overflow-y: auto;
        }
        [dir=rtl] .sidebar { left: auto; right: 0; }
        .sidebar-brand {
            padding: 18px 24px; display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .logo {
            width: 38px; height: 38px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-brand .logo svg { width: 38px; height: 38px; }
        .sidebar-brand .brand-text { display: flex; flex-direction: column; }
        .sidebar-brand .brand-name { color: #fff; font-size: 16px; font-weight: 800; letter-spacing: -.3px; line-height: 1.2; }
        .sidebar-brand .brand-name span { color: #818cf8; }
        .sidebar-brand .brand-sub { color: #475569; font-size: 10px; font-weight: 500; text-transform: uppercase; letter-spacing: .08em; }

        .sidebar-section { padding: 8px 16px; margin-top: 8px; }
        .sidebar-section-label {
            font-size: 10px; font-weight: 600; text-transform: uppercase;
            letter-spacing: .08em; color: #475569; padding: 0 8px; margin-bottom: 4px;
        }
        .nav-item { display: block; }
        .nav-link {
            display: flex; align-items: center; gap: 12px; padding: 10px 12px;
            border-radius: 8px; color: #94a3b8; text-decoration: none;
            font-size: 14px; font-weight: 500; transition: all .2s;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(99,102,241,.15); color: #fff;
        }
        .nav-link.active { color: var(--primary); }
        .nav-link i { width: 18px; text-align: center; font-size: 15px; }
        .nav-badge {
            margin-left: auto; background: var(--danger); color: #fff;
            font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 20px;
        }
        [dir=rtl] .nav-badge { margin-left: 0; margin-right: auto; }

        .sidebar-footer {
            margin-top: auto; padding: 16px; border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px; padding: 10px;
            border-radius: 8px; cursor: pointer; transition: background .2s;
        }
        .sidebar-user:hover { background: rgba(255,255,255,.05); }
        .sidebar-user img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
        .sidebar-user .info { flex: 1; min-width: 0; }
        .sidebar-user .name { color: #fff; font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user .role { color: var(--text-muted); font-size: 11px; text-transform: capitalize; }

        /* Topbar */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--topbar-h); background: #fff; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; padding: 0 24px; gap: 16px; z-index: 99;
            transition: left .3s ease;
        }
        [dir=rtl] .topbar { left: 0; right: var(--sidebar-w); }
        .topbar-toggle {
            display: none; background: none; border: none; cursor: pointer;
            font-size: 20px; color: var(--text); padding: 4px;
        }
        .topbar-title { font-size: 18px; font-weight: 600; color: var(--dark); }
        .topbar-spacer { flex: 1; }

        .topbar-search {
            position: relative; display: flex; align-items: center;
        }
        .topbar-search input {
            border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px 8px 36px;
            font-size: 13px; outline: none; background: var(--secondary); width: 220px;
            transition: all .2s;
        }
        .topbar-search input:focus { border-color: var(--primary); background: #fff; width: 280px; }
        .topbar-search i { position: absolute; left: 12px; color: var(--text-muted); font-size: 13px; }
        [dir=rtl] .topbar-search input { padding: 8px 36px 8px 12px; }
        [dir=rtl] .topbar-search i { left: auto; right: 12px; }

        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .topbar-btn {
            position: relative; width: 38px; height: 38px; border-radius: 8px;
            border: 1px solid var(--border); background: #fff; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--text); font-size: 16px; transition: all .2s; text-decoration: none;
        }
        .topbar-btn:hover { background: var(--secondary); border-color: var(--primary); color: var(--primary); }
        .topbar-btn .badge {
            position: absolute; top: -4px; right: -4px; background: var(--danger);
            color: #fff; font-size: 9px; font-weight: 700; width: 16px; height: 16px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            border: 2px solid #fff;
        }

        /* Locale dropdown */
        .locale-dropdown { position: relative; }
        .locale-btn {
            display: flex; align-items: center; gap: 6px; padding: 6px 12px;
            border: 1px solid var(--border); border-radius: 8px; background: #fff;
            cursor: pointer; font-size: 13px; font-weight: 500; color: var(--text);
            transition: all .2s;
        }
        .locale-btn:hover { border-color: var(--primary); color: var(--primary); }
        .locale-menu {
            position: absolute; top: calc(100% + 8px); right: 0; background: #fff;
            border: 1px solid var(--border); border-radius: 10px; box-shadow: var(--shadow-md);
            min-width: 120px; display: none; z-index: 200;
        }
        [dir=rtl] .locale-menu { right: auto; left: 0; }
        .locale-menu.show { display: block; }
        .locale-menu a {
            display: flex; align-items: center; gap: 8px; padding: 10px 14px;
            font-size: 13px; color: var(--text); text-decoration: none; transition: background .15s;
        }
        .locale-menu a:hover { background: var(--secondary); }
        .locale-menu a:first-child { border-radius: 10px 10px 0 0; }
        .locale-menu a:last-child { border-radius: 0 0 10px 10px; }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-w); padding-top: var(--topbar-h);
            min-height: 100vh; transition: margin .3s ease;
        }
        [dir=rtl] .main-content { margin-left: 0; margin-right: var(--sidebar-w); }
        .page-content { padding: 28px; }

        /* Cards */
        .card {
            background: #fff; border-radius: var(--radius); border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .card-header {
            padding: 18px 20px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 15px; font-weight: 600; color: var(--dark); }
        .card-body { padding: 20px; }

        /* Stat cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px; }
        .stat-card {
            background: #fff; border-radius: var(--radius); border: 1px solid var(--border);
            padding: 20px; display: flex; align-items: center; gap: 16px;
            box-shadow: var(--shadow); transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;
        }
        .stat-icon.purple { background: #ede9fe; color: var(--primary); }
        .stat-icon.green  { background: #d1fae5; color: var(--success); }
        .stat-icon.blue   { background: #dbeafe; color: var(--info); }
        .stat-icon.orange { background: #fef3c7; color: var(--warning); }
        .stat-info { flex: 1; min-width: 0; }
        .stat-value { font-size: 24px; font-weight: 700; color: var(--dark); line-height: 1.2; }
        .stat-label { font-size: 13px; color: var(--text-muted); margin-top: 2px; }
        .stat-change { font-size: 12px; font-weight: 600; margin-top: 4px; }
        .stat-change.up { color: var(--success); }
        .stat-change.down { color: var(--danger); }

        /* Tables */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead th {
            padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .05em; color: var(--text-muted);
            background: var(--secondary); border-bottom: 1px solid var(--border);
        }
        [dir=rtl] thead th { text-align: right; }
        tbody td { padding: 14px 16px; border-bottom: 1px solid var(--border); color: var(--text); }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafafa; }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center; padding: 3px 10px;
            border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }
        .badge-info    { background: #dbeafe; color: #1e40af; }
        .badge-secondary { background: var(--secondary); color: var(--text-muted); }
        .badge-purple  { background: #ede9fe; color: #5b21b6; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px;
            border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;
            border: none; text-decoration: none; transition: all .2s; white-space: nowrap;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: var(--secondary); color: var(--text); border: 1px solid var(--border); }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }

        /* Forms */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;
            font-size: 14px; outline: none; transition: border-color .2s; background: #fff;
            color: var(--text);
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
        .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px; }
        [dir=rtl] .form-select { background-position: left 12px center; padding-right: 12px; padding-left: 32px; }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .alert-info    { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }

        /* Pagination */
        .pagination { display: flex; gap: 4px; align-items: center; justify-content: center; padding: 16px 0; }
        .pagination a, .pagination span {
            padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 500;
            border: 1px solid var(--border); color: var(--text); text-decoration: none; transition: all .2s;
        }
        .pagination a:hover { border-color: var(--primary); color: var(--primary); }
        .pagination .active span { background: var(--primary); color: #fff; border-color: var(--primary); }

        /* Avatar */
        .avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
        .avatar-sm { width: 28px; height: 28px; }
        .avatar-lg { width: 64px; height: 64px; }

        /* Overlay */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 99;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            [dir=rtl] .sidebar { transform: translateX(100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .topbar { left: 0; right: 0; }
            .topbar-toggle { display: flex; }
            .topbar-search { display: none; }
            .main-content { margin-left: 0; margin-right: 0; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .page-content { padding: 16px; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }

        /* Utilities */
        .d-flex { display: flex; }
        .align-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .text-muted { color: var(--text-muted); }
        .text-sm { font-size: 13px; }
        .fw-600 { font-weight: 600; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        @media (max-width: 768px) { .grid-2, .grid-3 { grid-template-columns: 1fr; } }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="logo">
            <svg viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="38" height="38" rx="10" fill="url(#lg1)"/>
                <path d="M10 27V14l9-4 9 4v13l-9 4-9-4z" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.3)" stroke-width="1"/>
                <path d="M19 10l9 4v13l-9 4V10z" fill="rgba(255,255,255,.1)"/>
                <circle cx="19" cy="19" r="4" fill="white" opacity=".9"/>
                <path d="M19 15v8M15 19h8" stroke="#6366f1" stroke-width="1.5" stroke-linecap="round"/>
                <defs>
                    <linearGradient id="lg1" x1="0" y1="0" x2="38" y2="38" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#6366f1"/>
                        <stop offset="1" stop-color="#8b5cf6"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <div class="brand-text">
            <div class="brand-name">Neat<span>Pro</span></div>
            <div class="brand-sub">Dashboard</div>
        </div>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">{{ __('messages.main') }}</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> {{ __('messages.dashboard') }}
        </a>
        <a href="{{ route('analytics.index') }}" class="nav-link {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> {{ __('messages.analytics') }}
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">{{ __('messages.commerce') }}</div>
        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i> {{ __('messages.orders') }}
        </a>
        <a href="{{ route('ecommerce.index') }}" class="nav-link {{ request()->routeIs('ecommerce.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> {{ __('messages.products') }}
        </a>
        <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> {{ __('messages.transactions') }}
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">{{ __('messages.management') }}</div>
        <a href="{{ route('crm.index') }}" class="nav-link {{ request()->routeIs('crm.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> {{ __('messages.crm') }}
        </a>
        <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> {{ __('messages.notifications') }}
            @php $unread = auth()->user()->unreadNotificationsCount(); @endphp
            @if($unread > 0)
                <span class="nav-badge">{{ $unread }}</span>
            @endif
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> {{ __('messages.users') }}
        </a>
        @endif
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}" class="sidebar-user" style="text-decoration:none;">
            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
            <div class="info">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="role">{{ auth()->user()->role }}</div>
            </div>
            <i class="fas fa-cog" style="color:#475569;font-size:13px;"></i>
        </a>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <button class="topbar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <span class="topbar-title">@yield('page-title', __('messages.dashboard'))</span>
    <div class="topbar-spacer"></div>

    <div class="topbar-search">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="{{ __('messages.search') }}...">
    </div>

    <div class="topbar-actions">
        <!-- Locale -->
        <div class="locale-dropdown">
            <button class="locale-btn" onclick="toggleLocale()">
                <i class="fas fa-globe"></i>
                {{ strtoupper(app()->getLocale()) }}
                <i class="fas fa-chevron-down" style="font-size:10px;"></i>
            </button>
            <div class="locale-menu" id="localeMenu">
                <a href="{{ route('locale.switch', 'en') }}">🇬🇧 English</a>
                <a href="{{ route('locale.switch', 'fr') }}">🇫🇷 Français</a>
                <a href="{{ route('locale.switch', 'ar') }}">🇲🇦 العربية</a>
            </div>
        </div>

        <!-- Notifications bell -->
        <a href="{{ route('notifications.index') }}" class="topbar-btn">
            <i class="fas fa-bell"></i>
            @if(auth()->user()->unreadNotificationsCount() > 0)
                <span class="badge">{{ auth()->user()->unreadNotificationsCount() }}</span>
            @endif
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="topbar-btn" style="padding:0;overflow:hidden;">
            <img src="{{ auth()->user()->avatar_url }}" alt="" style="width:38px;height:38px;object-fit:cover;">
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="topbar-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</header>

<!-- Main -->
<main class="main-content">
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin:0;padding-left:16px;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
</main>

<script>
    // Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    document.getElementById('sidebarToggle').addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    // Locale dropdown
    function toggleLocale() {
        document.getElementById('localeMenu').classList.toggle('show');
    }
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.locale-dropdown')) {
            document.getElementById('localeMenu').classList.remove('show');
        }
    });
</script>
@stack('scripts')
</body>
</html>
