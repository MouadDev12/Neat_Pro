@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div style="max-width:560px;">
    <div class="card">
        <div class="card-header"><span class="card-title">Edit: {{ $user->name }}</span></div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf @method('PUT')
                <div class="form-group"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
                <div class="form-group"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-control form-select" required>
                        @foreach(['user','manager','admin'] as $r)
                        <option value="{{ $r }}" {{ $user->role === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group"><label class="form-label">New Password <span class="text-muted">(leave blank to keep)</span></label><input type="password" name="password" class="form-control"></div>
                <div class="form-group"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control"></div>
                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
