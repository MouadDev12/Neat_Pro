@extends('layouts.app')
@section('title', __('messages.notifications'))
@section('page-title', __('messages.notifications'))

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">Notifications</span>
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline"><i class="fas fa-check-double"></i> Mark all read</button>
        </form>
    </div>
    <div>
        @forelse($notifications as $notif)
        @php
            $icons = ['info'=>'fa-info-circle','success'=>'fa-check-circle','warning'=>'fa-exclamation-triangle','danger'=>'fa-times-circle'];
            $colors = ['info'=>'var(--info)','success'=>'var(--success)','warning'=>'var(--warning)','danger'=>'var(--danger)'];
        @endphp
        <div style="display:flex;align-items:flex-start;gap:14px;padding:18px 20px;border-bottom:1px solid var(--border);background:{{ $notif->read_at ? '#fff' : '#fafbff' }};transition:background .2s;">
            <div style="width:40px;height:40px;border-radius:50%;background:{{ $colors[$notif->type] ?? 'var(--info)' }}1a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas {{ $icons[$notif->type] ?? 'fa-bell' }}" style="color:{{ $colors[$notif->type] ?? 'var(--info)' }};"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                    <div>
                        <div class="fw-600" style="font-size:14px;">{{ $notif->title }}</div>
                        <div class="text-muted text-sm" style="margin-top:2px;">{{ $notif->message }}</div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                        <span class="text-muted text-sm">{{ $notif->created_at->diffForHumans() }}</span>
                        @if(!$notif->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notif) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline" title="Mark read"><i class="fas fa-check"></i></button>
                        </form>
                        @else
                        <span style="width:8px;height:8px;border-radius:50%;background:var(--border);display:inline-block;"></span>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy', $notif) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;color:var(--text-muted);padding:48px;">
            <i class="fas fa-bell-slash" style="font-size:32px;margin-bottom:12px;display:block;"></i>
            No notifications
        </div>
        @endforelse
    </div>
    <div style="padding:0 20px;">{{ $notifications->links() }}</div>
</div>
@endsection
