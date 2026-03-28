@extends('layouts.app')
@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('content')
<div style="max-width:720px;">
    <div class="card">
        <div class="card-header"><span class="card-title">Profile Settings</span></div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <!-- Avatar -->
                <div style="display:flex;align-items:center;gap:20px;margin-bottom:28px;padding-bottom:24px;border-bottom:1px solid var(--border);">
                    <img src="{{ $user->avatar_url }}" alt="" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--primary-light);">
                    <div>
                        <div class="fw-600" style="margin-bottom:6px;">Profile Photo</div>
                        <div class="text-muted text-sm" style="margin-bottom:10px;">JPG, PNG or GIF. Max 2MB.</div>
                        <label class="btn btn-sm btn-outline" style="cursor:pointer;">
                            <i class="fas fa-upload"></i> Upload photo
                            <input type="file" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                        </label>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select name="locale" class="form-control form-select" style="max-width:200px;">
                        <option value="en" {{ $user->locale === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                        <option value="fr" {{ $user->locale === 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                        <option value="ar" {{ $user->locale === 'ar' ? 'selected' : '' }}>🇲🇦 العربية</option>
                    </select>
                </div>

                <div style="border-top:1px solid var(--border);padding-top:20px;margin-top:8px;">
                    <div class="fw-600" style="margin-bottom:16px;">Change Password</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Account info -->
    <div class="card" style="margin-top:20px;">
        <div class="card-header"><span class="card-title">Account Info</span></div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;justify-content:space-between;"><span class="text-muted">Role</span><span class="badge badge-purple">{{ ucfirst($user->role) }}</span></div>
                <div style="display:flex;justify-content:space-between;"><span class="text-muted">Member since</span><span>{{ $user->created_at->format('M d, Y') }}</span></div>
                @if($user->provider)
                <div style="display:flex;justify-content:space-between;"><span class="text-muted">Login via</span><span class="badge badge-info">{{ ucfirst($user->provider) }}</span></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.querySelector('img[alt=""]').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
