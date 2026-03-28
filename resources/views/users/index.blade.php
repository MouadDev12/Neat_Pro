@extends('layouts.app')
@section('title', __('messages.users'))
@section('page-title', __('messages.users'))

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">Users Management</span>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add User</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>User</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <img src="{{ $user->avatar_url }}" alt="" class="avatar avatar-sm">
                            <span class="fw-600">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted text-sm">{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'manager' ? 'warning' : 'info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="text-muted text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:32px;">No users found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0 20px;">{{ $users->links() }}</div>
</div>
@endsection
