@extends('admin.layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-xl p-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-emerald-700 rounded-xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-3">
                    {{ substr(\App\Models\Setting::get('website_name', 'CMS'), 0, 1) }}
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ \App\Models\Setting::get('website_name', 'Portfolio CMS') }}</h1>
                <p class="text-gray-500 text-sm mt-1">Admin Panel</p>
            </div>

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-2 border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-700 focus:border-transparent outline-none transition-colors"
                            placeholder="Enter your email">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-700 focus:border-transparent outline-none transition-colors"
                            placeholder="Enter your password">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remember" value="1" class="w-4 h-4 text-emerald-700 border-gray-300 rounded focus:ring-emerald-700">
                            Remember me
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 rounded-lg transition-colors">
                        Login to Admin Panel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

