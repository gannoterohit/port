@extends('public.layouts.app')

@section('title', 'Contact & Hire Me - ' . $websiteName)
@section('meta_description', 'Have a project in mind? Contact me to discuss custom Laravel applications, RESTful APIs, ERPs, dashboards, and freelance web development.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-7xl 2xl:max-w-[1400px] mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full mb-3.5 shadow-2xs">
                    Start a Conversation
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-[var(--theme-text-heading)] tracking-tight mb-4">
                    Have a Project in Mind?
                </h1>
                <p class="text-base sm:text-lg text-[var(--theme-text-body)] max-w-2xl mx-auto leading-relaxed">
                    Let's discuss your project goals, technical requirements, and timeline. I provide upfront estimates and clear technical consultation.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <!-- Left Column: Contact Details & Credibility -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-[var(--theme-bg-card)] rounded-3xl p-7 sm:p-8 border border-[var(--theme-border)] shadow-xs space-y-6">
                        <div class="flex items-center gap-4 pb-6 border-b border-[var(--theme-border)]">
                            @if($profile->profile_photo_url)
                                <img src="{{ $profile->profile_photo_url }}" alt="{{ $profile->full_name }}"
                                    class="w-14 h-14 rounded-2xl object-cover border-2 border-brand/40 shadow-2xs">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-brand/10 text-brand flex items-center justify-center font-bold text-xl border border-brand/20">
                                    {{ substr($profile->name ?: $websiteName, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h2 class="text-lg font-bold text-[var(--theme-text-heading)]">{{ $profile->name ?: 'Full Stack Web Developer' }}</h2>
                                <p class="text-xs text-[var(--theme-text-body)]">{{ $profile->title ?: 'Laravel & MySQL Specialist' }}</p>
                                <span class="inline-flex items-center gap-1.5 text-xs text-brand font-medium mt-1">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    Average response time: &lt; 24h
                                </span>
                            </div>
                        </div>

                        <!-- Communication Channels -->
                        <div class="space-y-4">
                            @php
                                $contactEmail = $profile->contact_email ?: ($profile->email ?: \App\Models\Setting::get('contact_email'));
                                $contactPhone = $profile->contact_phone ?: ($profile->phone ?: \App\Models\Setting::get('contact_phone'));
                                $contactWhatsapp = $profile->whatsapp_url ?: (\App\Models\Setting::get('contact_whatsapp') ? 'https://wa.me/' . preg_replace('/\D+/', '', \App\Models\Setting::get('contact_whatsapp')) : null);
                                $contactLocation = ($profile->location_visible && $profile->location) ? $profile->location : (\App\Models\Setting::get('website_address') ?: \App\Models\Setting::get('contact_location'));
                            @endphp

                            @if($contactEmail)
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] flex items-center justify-center shrink-0 text-brand">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)]">Direct Email</span>
                                        <a href="mailto:{{ $contactEmail }}" class="text-sm font-medium text-[var(--theme-text-heading)] hover:text-brand break-all transition-colors">
                                            {{ $contactEmail }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($contactPhone)
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] flex items-center justify-center shrink-0 text-brand">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.14 3.317a1 1 0 01-.54 1.212l-2.52 1.027a.5.5 0 00-.25.278L8.19 11.88a6 6 0 005.92 5.92l.27-1.35a1 1 0 01.27-.41l2.2-2.2a1 1 0 011.11-.22l3.31 1.14A1 1 0 0121 11.72V15a2 2 0 01-2 2h-2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)]">Phone</span>
                                        <a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}" class="text-sm font-medium text-[var(--theme-text-heading)] hover:text-brand transition-colors">{{ $contactPhone }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($contactWhatsapp)
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] flex items-center justify-center shrink-0 text-brand">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)]">WhatsApp</span>
                                        <a href="{{ $contactWhatsapp }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-brand hover:underline transition-colors">
                                            Chat on WhatsApp
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($contactLocation)
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] flex items-center justify-center shrink-0 text-brand">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.982 18.724A7.481 7.481 0 0112 20a7.481 7.481 0 01-5.982-2.276m11.964 0A10.954 10.954 0 0012 22c-2.648 0-5.145-.97-7.024-2.545A7.478 7.478 0 0112 17.5a7.478 7.478 0 015.982 2.276z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)]">Location</span>
                                        <span class="text-sm font-medium text-[var(--theme-text-heading)]">{{ $contactLocation }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Social & Professional Verification -->
                        @if(!empty($profile->social_links) && is_array($profile->social_links))
                            <div class="pt-6 border-t border-[var(--theme-border)]">
                                <span class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)] mb-3">Verified Profiles</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($profile->social_links as $platform => $url)
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                                class="px-3 py-1.5 rounded-lg bg-[var(--theme-bg-alt)] hover:border-brand/40 text-xs font-medium text-[var(--theme-text-heading)] border border-[var(--theme-border)] transition-colors capitalize">
                                                {{ $platform }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Project Enquiry Form -->
                <div class="lg:col-span-7">
                    <form id="contactForm" method="POST" action="{{ route('contact.submit') }}"
                        class="bg-[var(--theme-bg-card)] p-7 sm:p-9 rounded-3xl border border-[var(--theme-border)] shadow-xs space-y-6">
                        @csrf
                        <!-- Honeypot anti-spam field -->
                        <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-[var(--theme-text-heading)] mb-1.5">
                                    Your Name <span class="text-brand">*</span>
                                </label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent text-sm"
                                    value="{{ old('name') }}" placeholder="Rohit / Client Name">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-[var(--theme-text-heading)] mb-1.5">
                                    Email Address <span class="text-brand">*</span>
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent text-sm"
                                    value="{{ old('email') }}" placeholder="client@company.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-[var(--theme-text-heading)] mb-1.5">
                                    Phone Number (Optional)
                                </label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent text-sm"
                                    value="{{ old('phone') }}" placeholder="+91 98765 00000">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Service / Project Type Dropdown -->
                            <div>
                                <label for="service_type" class="block text-sm font-semibold text-[var(--theme-text-heading)] mb-1.5">
                                    Project / Service Type
                                </label>
                                @php
                                    $selectedService = old('service_type', request('service'));
                                @endphp
                                <select id="service_type" name="service_type"
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent text-sm">
                                    <option value="">Select project type...</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->name }}"
                                            {{ $selectedService === $service->slug || $selectedService === $service->name ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                    <option value="Full-Time / Contract Backend Role" {{ $selectedService === 'Full-Time / Contract Backend Role' ? 'selected' : '' }}>Full-Time / Contract Backend Role</option>
                                    <option value="Other / Custom Inquiry" {{ in_array($selectedService, ['Other / Custom Inquiry', 'Other / Not listed']) ? 'selected' : '' }}>Other / Custom Inquiry</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Budget Range -->
                            <div>
                                <label for="budget_range" class="block text-sm font-semibold text-[var(--theme-text-heading)] mb-1.5">
                                    Approx. Budget Range
                                </label>
                                <select id="budget_range" name="budget_range"
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent text-sm">
                                    <option value="">Select budget range...</option>
                                    <option value="₹25,000 - ₹50,000 (~$300 - $600)" {{ old('budget_range') === '₹25,000 - ₹50,000 (~$300 - $600)' ? 'selected' : '' }}>₹25,000 - ₹50,000 (~$300 - $600)</option>
                                    <option value="₹50,000 - ₹1,00,000 (~$600 - $1,200)" {{ old('budget_range') === '₹50,000 - ₹1,00,000 (~$600 - $1,200)' ? 'selected' : '' }}>₹50,000 - ₹1,00,000 (~$600 - $1,200)</option>
                                    <option value="₹1,00,000 - ₹2,50,000 (~$1,200 - $3,000)" {{ old('budget_range') === '₹1,00,000 - ₹2,50,000 (~$1,200 - $3,000)' ? 'selected' : '' }}>₹1,00,000 - ₹2,50,000 (~$1,200 - $3,000)</option>
                                    <option value="₹2,50,000+ ($3,000+)" {{ old('budget_range') === '₹2,50,000+ ($3,000+)' ? 'selected' : '' }}>₹2,50,000+ ($3,000+)</option>
                                    <option value="Flexible / Needs Discussion" {{ old('budget_range') === 'Flexible / Needs Discussion' ? 'selected' : '' }}>Flexible / Needs Discussion</option>
                                </select>
                            </div>

                            <!-- Timeline -->
                            <div>
                                <label for="timeline" class="block text-sm font-semibold text-[var(--theme-text-heading)] mb-1.5">
                                    Expected Timeline
                                </label>
                                <select id="timeline" name="timeline"
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent text-sm">
                                    <option value="">Select expected timeline...</option>
                                    <option value="Urgent (< 2 weeks)" {{ old('timeline') === 'Urgent (< 2 weeks)' ? 'selected' : '' }}>Urgent (&lt; 2 weeks)</option>
                                    <option value="1 - 4 weeks" {{ old('timeline') === '1 - 4 weeks' ? 'selected' : '' }}>1 - 4 weeks</option>
                                    <option value="1 - 3 months" {{ old('timeline') === '1 - 3 months' ? 'selected' : '' }}>1 - 3 months</option>
                                    <option value="3+ months" {{ old('timeline') === '3+ months' ? 'selected' : '' }}>3+ months</option>
                                    <option value="Flexible" {{ old('timeline') === 'Flexible' ? 'selected' : '' }}>Flexible</option>
                                </select>
                            </div>
                        </div>

                        <!-- Project Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-[var(--theme-text-heading)] mb-1.5">
                                Project Message &amp; Requirements <span class="text-brand">*</span>
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent text-sm resize-y min-h-[130px]"
                                placeholder="Describe the web application, key features, business goals, and any reference websites or APIs...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="theme-btn-primary w-full inline-flex items-center justify-center gap-2 px-7 py-4 rounded-full font-semibold text-sm sm:text-base shadow-sm transition-all duration-200 cursor-pointer hover:scale-[1.01]">
                                <span>Send Project Enquiry</span>
                                <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                            <p class="text-center text-xs text-[var(--theme-text-muted)] mt-3">
                                Your project details and contact information are treated strictly with confidentiality.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
