@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<h2 class="auth-title">Welcome back</h2>
<p class="auth-subtitle">Sign in to your account to continue</p>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Email address</label>
        <div class="input-icon">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">Password</label>
        <div class="input-icon">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
        <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;">
            <input type="checkbox" name="remember"> Remember me
        </label>
    </div>
    <button type="submit" class="btn-auth">Sign in</button>
</form>

<div class="divider">or continue with</div>
<div class="social-btns">
    <button type="button" class="btn-social" onclick="openSocialModal('google')">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        Google
    </button>
    <button type="button" class="btn-social" onclick="openSocialModal('github')">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#24292e"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
        GitHub
    </button>
</div>

<div class="auth-footer">
    Don't have an account? <a href="{{ route('register') }}">Sign up</a>
</div>

<!-- Social Demo Modal -->
<div id="socialModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(6px);">
    <div style="background:#fff;border-radius:20px;padding:32px;width:100%;max-width:380px;margin:16px;box-shadow:0 32px 64px rgba(0,0,0,.2);animation:slideUp .2s ease;">

        <div style="text-align:center;margin-bottom:24px;">
            <div id="modalProviderIcon" style="width:60px;height:60px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;"></div>
            <h3 id="modalTitle" style="font-size:18px;font-weight:800;color:#0f172a;margin-bottom:6px;"></h3>
            <p style="font-size:13px;color:#94a3b8;line-height:1.5;">Demo credentials for this OAuth provider</p>
        </div>

        <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;overflow:hidden;margin-bottom:20px;">
            <!-- Email row -->
            <div style="padding:14px 16px;border-bottom:1px solid #e2e8f0;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                    <span style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;">Email</span>
                    <button onclick="copyField('modalEmail',this)" style="background:none;border:none;cursor:pointer;font-size:12px;font-weight:700;color:#6366f1;padding:2px 6px;border-radius:4px;transition:all .15s;">Copy</button>
                </div>
                <div id="modalEmail" style="font-size:13px;font-weight:600;color:#334155;font-family:'Courier New',monospace;word-break:break-all;"></div>
            </div>
            <!-- Password row -->
            <div style="padding:14px 16px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                    <span style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;">Note</span>
                </div>
                <div id="modalNote" style="font-size:13px;color:#64748b;font-style:italic;"></div>
            </div>
        </div>

        <div style="display:flex;gap:10px;">
            <button onclick="closeSocialModal()" style="flex:1;padding:12px;border:1.5px solid #e2e8f0;border-radius:10px;background:#fff;cursor:pointer;font-size:14px;font-weight:600;color:#64748b;transition:all .2s;" onmouseover="this.style.borderColor='#6366f1';this.style.color='#6366f1'" onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#64748b'">
                Cancel
            </button>
            <a id="modalContinueBtn" href="#" style="flex:2;padding:12px;border-radius:10px;background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);color:#fff;text-align:center;text-decoration:none;font-size:14px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(99,102,241,.4);transition:opacity .2s;" onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                Continue &rarr;
            </a>
        </div>
    </div>
</div>

<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px) scale(.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
</style>

<script>
const socialData = {
    google: {
        title: 'Sign in with Google',
        email: 'google-demo@neat-dashboard.dev',
        note: 'Auto-login — no password required in demo mode.',
        url: '{{ app()->environment("local") ? route("dev.social", "google") : route("social.redirect", "google") }}',
        iconHtml: `<svg width="30" height="30" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>`,
        bg: '#eef2ff',
    },
    github: {
        title: 'Sign in with GitHub',
        email: 'github-demo@neat-dashboard.dev',
        note: 'Auto-login — no password required in demo mode.',
        url: '{{ app()->environment("local") ? route("dev.social", "github") : route("social.redirect", "github") }}',
        iconHtml: `<svg width="30" height="30" viewBox="0 0 24 24" fill="#24292e"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>`,
        bg: '#f1f5f9',
    }
};

function openSocialModal(provider) {
    const d = socialData[provider];
    document.getElementById('modalTitle').textContent = d.title;
    document.getElementById('modalEmail').textContent = d.email;
    document.getElementById('modalNote').textContent = d.note;
    document.getElementById('modalContinueBtn').href = d.url;
    const icon = document.getElementById('modalProviderIcon');
    icon.innerHTML = d.iconHtml;
    icon.style.background = d.bg;
    document.getElementById('socialModal').style.display = 'flex';
}

function closeSocialModal() {
    document.getElementById('socialModal').style.display = 'none';
}

function copyField(id, btn) {
    navigator.clipboard.writeText(document.getElementById(id).textContent).then(() => {
        const orig = btn.textContent;
        btn.textContent = '✓ Copied';
        btn.style.color = '#10b981';
        setTimeout(() => { btn.textContent = orig; btn.style.color = '#6366f1'; }, 1800);
    });
}

document.getElementById('socialModal').addEventListener('click', function(e) {
    if (e.target === this) closeSocialModal();
});
</script>
@endsection
