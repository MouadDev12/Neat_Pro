@extends('layouts.app')
@section('title', 'Create User')
@section('page-title', 'Create User')

@section('content')
<div style="max-width:560px;">
    <div class="card">
        <div class="card-header"><span class="card-title">New User</span></div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                <div class="form-group"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-control form-select" required>
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Confirm Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>
                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
