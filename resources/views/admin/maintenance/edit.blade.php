@extends('admin.layouts.master')

@section('title', 'Maintenance Mode')
@section('header', 'System Maintenance')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-amber-500"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-amber-700">Access Lockdown</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Site Maintenance Control</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Temporarily take the public portfolio offline for maintenance, upgrades or content overhaul.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @php
        $isEnabled = $maintenance && $maintenance->value == '1';
    @endphp

    <div class="admin-form-card space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 p-6 rounded-2xl border {{ $isEnabled ? 'border-amber-200 bg-amber-50/30' : 'border-[#E5E1D5] bg-[#FAF9F5]' }}">
            <div>
                <div class="flex items-center gap-2.5">
                    @if($isEnabled)
                        <span class="inline-flex h-3 w-3 rounded-full bg-amber-500 animate-ping"></span>
                        <span class="text-base font-bold text-amber-900">Maintenance Mode is ACTIVE</span>
                    @else
                        <span class="inline-flex h-3 w-3 rounded-full bg-emerald-500"></span>
                        <span class="text-base font-bold text-stone-900">Website is Publicly LIVE</span>
                    @endif
                </div>
                <p class="text-xs text-stone-500 mt-1 max-w-lg">
                    @if($isEnabled)
                        Visitors see a clean "Under Scheduled Maintenance" landing screen. Only logged-in administrators can access pages.
                    @else
                        All visitors can freely browse your portfolio, projects, services and contact form.
                    @endif
                </p>
            </div>

            <div>
                @if($isEnabled)
                    <form method="POST" action="{{ route('admin.maintenance.disable') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="maintenance_mode" value="0">
                        <button type="submit" class="admin-btn-primary">
                            Turn Off Maintenance (Go Live)
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.maintenance.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="maintenance_mode" value="1">
                        <button type="submit" onclick="return confirm('Enable maintenance mode? Public visitors will be blocked.')" class="rounded-xl border border-amber-300 bg-amber-100 px-5 py-2.5 text-sm font-semibold text-amber-900 hover:bg-amber-200 transition">
                            Enable Maintenance Mode
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="rounded-xl border border-[#E5E1D5] bg-white p-4 text-xs text-stone-600 space-y-1">
            <span class="font-bold text-stone-900 block text-sm">Security &amp; Admin Bypass</span>
            <p>Admin panel access (`/admin/*`) is never locked out. You can continue updating content, projects, and settings safely while maintenance mode is active.</p>
        </div>
    </div>

</div>
@endsection
