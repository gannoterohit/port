@extends('admin.layouts.master')

@section('title', 'Maintenance Mode')
@section('header', 'Maintenance Mode')

@section('admin-content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Maintenance Mode</h3>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">Current Status: </p>
                        <p class="text-sm text-gray-500 mt-1">
                            @if($maintenance && $maintenance->value == '1')
                                <span class="text-red-600 font-semibold">ENABLED</span> - Visitors see the maintenance page
                            @else
                                <span class="text-green-600 font-semibold">DISABLED</span> - Site is live
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2">
                        @php
                            $isEnabled = $maintenance && $maintenance->value == '1';
                        @endphp

                    @if($isEnabled)
                            <form method="POST" action="{{ route('admin.maintenance.disable') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="maintenance_mode" value="0">
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Disable Maintenance
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.maintenance.update') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="maintenance_mode" value="1">
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Enable Maintenance
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm">
                <strong>Note:</strong> Admin panel access is always available during maintenance mode.
                Non-admin visitors will see a maintenance page while maintenance mode is enabled.
            </div>
        </div>
    </div>
</div>
@endsection

