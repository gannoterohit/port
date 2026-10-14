@extends('admin.layouts.app')

@section('title', 'Login')

@section('content')
<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#F3F6F2] px-4 py-10">
    <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-[#DCE8D6]/70 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-28 -right-20 h-80 w-80 rounded-full bg-[#E1EDE7]/80 blur-3xl"></div>
    <div class="w-full max-w-md">
        <div class="relative rounded-3xl border border-white/80 bg-white p-7 shadow-[0_24px_80px_-32px_rgba(31,41,55,0.28)] sm:p-9">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#1B560B] text-2xl font-bold text-white shadow-lg shadow-[#1B560B]/20">
                    {{ substr(\App\Models\Setting::get('website_name', 'CMS'), 0, 1) }}
                </div>
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.16em] text-[#62815B]">Portfolio control panel</p>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ \App\Models\Setting::get('website_name', 'Portfolio CMS') }}</h1>
                <p class="mt-2 text-sm text-gray-500">Sign in to manage your portfolio</p>
            </div>

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-5">
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-700">Email address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            id="email" autocomplete="username" class="admin-input py-3"
                            placeholder="Enter your email">
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-gray-700">Password</label>
                        <input type="password" name="password" required
                            id="password" autocomplete="current-password" class="admin-input py-3"
                            placeholder="Enter your password">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-gray-300 text-[#1B560B] focus:ring-[#1B560B]">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="admin-btn-primary w-full py-3">
                        Sign in to admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
