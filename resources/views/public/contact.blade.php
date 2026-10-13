@extends('public.layouts.app')

@section('title', 'Contact - ' . $websiteName)
@section('meta_description', 'Get in touch with me')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-20 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Let's Talk</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Have a project in mind? Want to discuss opportunities? Drop me a message and I'll get back to you.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    @if($profile)
                        <div class="space-y-6">
                            @if($profile->email)
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Email</span>
                                        <span class="block font-medium text-gray-900 dark:text-white">{{ $profile->email }}</span>
                                    </div>
                                </div>
                            @endif
                            @if($profile->phone)
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.14 3.317a1 1 0 01-.54 1.212l-2.52 1.027a.5.5 0 00-.25.278L8.19 11.88a6 6 0 005.92 5.92l.27-1.35a1 1 0 01.27-.41l2.2-2.2a1 1 0 011.11-.22l3.31 1.14A1 1 0 0121 11.72V15a2 2 0 01-2 2h-2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Phone</span>
                                        <span class="block font-medium text-gray-900 dark:text-white">{{ $profile->phone }}</span>
                                    </div>
                                </div>
                            @endif
                            @if($profile->location)
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.982 18.724A7.481 7.481 0 0112 20a7.481 7.481 0 01-5.982-2.276m11.964 0A10.954 10.954 0 0012 22c-2.648 0-5.145-.97-7.024-2.545A7.478 7.478 0 0112 17.5a7.478 7.478 0 015.982 2.276z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Location</span>
                                        <span class="block font-medium text-gray-900 dark:text-white">{{ $profile->location }}</span>
                                    </div>
                                </div>
                            @endif
                            @if($profile->social_links)
                                <div class="flex gap-4 pt-2">
                                    @foreach($profile->social_links as $platform => $url)
                                        <a href="{{ $url }}" target="_blank"
                                            class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary transition-colors">
                                            <span class="sr-only">{{ ucfirst($platform) }}</span>
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0C5.371 0 0 5.371 0 12.004c0 5.302 3.544 9.8 8.434 11.386.6.112.82-.262.82-.58 0-.286-.01-1.186-.015-2.148-3.429.756-4.141-1.647-4.141-1.647-.555-1.401-1.342-1.77-1.342-1.77-1.09-.75.084-.735.084-.735 1.203.084 1.836 1.24 1.836 1.24 1.067 1.83 2.805 1.305 3.49.996.108-.782.418-1.305.762-1.605-2.665-.305-5.467-1.335-5.467-5.935 0-1.311.47-2.381 1.236-3.221-.124-.303-.053-.823.027-1.646 0 0 .027-.086.997 1.203 3.186-.998 4.263-.274 4.263-.274.34.861.995 1.685 1.715 1.998.82-.122 1.64-.247 2.456-.449 0 0 1.09-.19 2.24 1.226 0 0 1.105-1.156 1.568-2.779 0 0 .42-1.325.027-2.779 0 0 1.59-.041 2.997 1.229.96-.273 1.99-.822 3.01-1.599.762 1.155 1.142 2.497 1.142 3.91 0 1.566.015 3.132.015 3.589 0 0 .084.49.82 1.295.932 1.2 1.42 1.964 1.42 1.964.534.889 1.158 1.341 1.81.995 1.27-.338 1.72-.881 2.03.336.265.999.82 1.787 1.427 2.423.81-.161 1.6-.48 2.27-.93.074-.554.136-1.435.136-1.97 0-4.608-3.135-8.342-7.41-9.466 1.32-.975 2.295-2.975 2.295-6.215 0-4.816-3.135-8.746-7.412-8.746-2.322 0-4.522.85-6.29 2.282-.643-.12-1.28.2-1.92.49-.995 22.07-7.7 15.62-12.06 15.66-1.35-.27-2.74-.42-4.15-.42z"></path>
                                            </svg>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <form id="contactForm" method="POST" action="{{ route('contact.submit') }}" class="space-y-6 bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    @csrf
                    <!-- Honeypot anti-spam field -->
                    <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="label">Name *</label>
                            <input type="text" name="name" required class="input" value="{{ old('name') }}" placeholder="Your Full Name">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="label">Email *</label>
                            <input type="email" name="email" required class="input" value="{{ old('email') }}" placeholder="name@example.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="label">Phone (Optional)</label>
                        <input type="tel" name="phone" class="input" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000">
                    </div>

                    <div>
                        <label class="label">Subject *</label>
                        <input type="text" name="subject" required class="input" value="{{ old('subject', 'Freelance Project Inquiry') }}" placeholder="What is this regarding?">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Message *</label>
                        <textarea name="message" rows="5" required class="textarea"
                            placeholder="Tell me about your project, timeline, and goals...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <span>Send Message</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

