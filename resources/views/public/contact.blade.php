@extends('public.layouts.app')

@section('title', 'Contact & Hire Me - ' . $websiteName)
@section('meta_description', 'Have a project in mind? Contact me to discuss custom Laravel applications, RESTful APIs, ERPs, dashboards, and freelance web development.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3.5 py-1 rounded-full mb-3.5">
                    Start a Conversation
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-[#1F2937] tracking-tight mb-4">
                    Have a Project in Mind?
                </h1>
                <p class="text-base sm:text-lg text-[#667085] max-w-2xl mx-auto leading-relaxed">
                    Let's discuss your project goals, technical requirements, and timeline. I provide upfront estimates and clear technical consultation.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <!-- Left Column: Contact Details & Credibility -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl p-7 sm:p-8 border border-[#E5E7EB] shadow-xs space-y-6">
                        <div class="flex items-center gap-4 pb-6 border-b border-[#E5E7EB]">
                            <div class="w-14 h-14 rounded-2xl bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center font-bold text-xl">
                                {{ substr($websiteName, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-[#1F2937]">{{ $profile->name ?: 'Full Stack Web Developer' }}</h2>
                                <p class="text-xs text-[#667085]">{{ $profile->title ?: 'Laravel & MySQL Specialist' }}</p>
                                <span class="inline-flex items-center gap-1.5 text-xs text-[#1B560B] font-medium mt-1">
                                    <span class="w-2 h-2 rounded-full bg-[#1B560B] animate-pulse"></span>
                                    Average response time: &lt; 24h
                                </span>
                            </div>
                        </div>

                        <!-- Communication Channels -->
                        <div class="space-y-4">
                            @if($profile->contact_email || $profile->email)
                                @php $email = $profile->contact_email ?: $profile->email; @endphp
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#F5F7F2] border border-[#E5E7EB] flex items-center justify-center shrink-0 text-[#1B560B]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#667085]">Direct Email</span>
                                        <a href="mailto:{{ $email }}" class="text-sm font-medium text-[#1F2937] hover:text-[#1B560B] break-all transition-colors">
                                            {{ $email }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($profile->contact_phone || $profile->phone)
                                @php $phone = $profile->contact_phone ?: $profile->phone; @endphp
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#F5F7F2] border border-[#E5E7EB] flex items-center justify-center shrink-0 text-[#1B560B]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.14 3.317a1 1 0 01-.54 1.212l-2.52 1.027a.5.5 0 00-.25.278L8.19 11.88a6 6 0 005.92 5.92l.27-1.35a1 1 0 01.27-.41l2.2-2.2a1 1 0 011.11-.22l3.31 1.14A1 1 0 0121 11.72V15a2 2 0 01-2 2h-2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#667085]">Phone / WhatsApp</span>
                                        <span class="text-sm font-medium text-[#1F2937]">{{ $phone }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($profile->location && $profile->location_visible)
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#F5F7F2] border border-[#E5E7EB] flex items-center justify-center shrink-0 text-[#1B560B]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.982 18.724A7.481 7.481 0 0112 20a7.481 7.481 0 01-5.982-2.276m11.964 0A10.954 10.954 0 0012 22c-2.648 0-5.145-.97-7.024-2.545A7.478 7.478 0 0112 17.5a7.478 7.478 0 015.982 2.276z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#667085]">Location</span>
                                        <span class="text-sm font-medium text-[#1F2937]">{{ $profile->location }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Social & Professional Verification -->
                        @if(!empty($profile->social_links) && is_array($profile->social_links))
                            <div class="pt-6 border-t border-[#E5E7EB]">
                                <span class="block text-xs font-semibold uppercase tracking-wider text-[#667085] mb-3">Verified Profiles</span>
                                <div class="flex gap-3">
                                    @foreach($profile->social_links as $platform => $url)
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                                class="px-3 py-1.5 rounded-lg bg-[#F5F7F2] hover:bg-[#E5E7EB] text-xs font-medium text-[#1F2937] border border-[#E5E7EB] transition-colors capitalize">
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
                        class="bg-white p-7 sm:p-9 rounded-2xl border border-[#E5E7EB] shadow-xs space-y-6">
                        @csrf
                        <!-- Honeypot anti-spam field -->
                        <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-[#1F2937] mb-1.5">
                                    Your Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#1F2937] placeholder-[#9CA3AF] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1B560B] focus:border-transparent text-sm"
                                    value="{{ old('name') }}" placeholder="John Doe">
                                @error('name')
                                    <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-[#1F2937] mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#1F2937] placeholder-[#9CA3AF] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1B560B] focus:border-transparent text-sm"
                                    value="{{ old('email') }}" placeholder="john@company.com">
                                @error('email')
                                    <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-[#1F2937] mb-1.5">
                                    Phone Number (Optional)
                                </label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#1F2937] placeholder-[#9CA3AF] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1B560B] focus:border-transparent text-sm"
                                    value="{{ old('phone') }}" placeholder="+1 (555) 000-0000">
                                @error('phone')
                                    <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Service Type Dropdown -->
                            <div>
                                <label for="service_type" class="block text-sm font-semibold text-[#1F2937] mb-1.5">
                                    Service or Project Type
                                </label>
                                <select id="service_type" name="service_type"
                                    class="w-full px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#1F2937] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1B560B] focus:border-transparent text-sm">
                                    <option value="">Select a project type...</option>
                                    <option value="Custom Website Development" {{ old('service_type', request('service')) === 'custom-website-development' || old('service_type') === 'Custom Website Development' ? 'selected' : '' }}>Custom Website Development</option>
                                    <option value="Laravel Application Development" {{ old('service_type', request('service')) === 'laravel-application-development' || old('service_type') === 'Laravel Application Development' ? 'selected' : '' }}>Laravel Application Development</option>
                                    <option value="REST API Development & Integration" {{ old('service_type', request('service')) === 'rest-api-development-integration' || old('service_type') === 'REST API Development & Integration' ? 'selected' : '' }}>REST API Development & Integration</option>
                                    <option value="Admin Panel & Dashboard Development" {{ old('service_type', request('service')) === 'admin-panel-dashboard-development' || old('service_type') === 'Admin Panel & Dashboard Development' ? 'selected' : '' }}>Admin Panel & Dashboard Development</option>
                                    <option value="ERP & Business Management Systems" {{ old('service_type', request('service')) === 'erp-business-management-systems' || old('service_type') === 'ERP & Business Management Systems' ? 'selected' : '' }}>ERP & Business Management Systems</option>
                                    <option value="School Management Systems" {{ old('service_type', request('service')) === 'school-management-systems' || old('service_type') === 'School Management Systems' ? 'selected' : '' }}>School Management Systems</option>
                                    <option value="Maintenance & Bug Fixing" {{ old('service_type', request('service')) === 'maintenance-bug-fixing' || old('service_type') === 'Maintenance & Bug Fixing' ? 'selected' : '' }}>Maintenance & Bug Fixing</option>
                                    <option value="General Freelance / Consultation" {{ old('service_type') === 'General Freelance / Consultation' ? 'selected' : '' }}>General Freelance / Consultation</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Approximate Budget -->
                            <div>
                                <label for="budget" class="block text-sm font-semibold text-[#1F2937] mb-1.5">
                                    Approximate Budget (Optional)
                                </label>
                                <select id="budget" name="budget"
                                    class="w-full px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#1F2937] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1B560B] focus:border-transparent text-sm">
                                    <option value="">Select budget range...</option>
                                    <option value="Under $1,000" {{ old('budget') === 'Under $1,000' ? 'selected' : '' }}>Under $1,000</option>
                                    <option value="$1,000 - $3,000" {{ old('budget') === '$1,000 - $3,000' ? 'selected' : '' }}>$1,000 - $3,000</option>
                                    <option value="$3,000 - $5,000" {{ old('budget') === '$3,000 - $5,000' ? 'selected' : '' }}>$3,000 - $5,000</option>
                                    <option value="$5,000+" {{ old('budget') === '$5,000+' ? 'selected' : '' }}>$5,000+</option>
                                    <option value="Flexible / Hourly" {{ old('budget') === 'Flexible / Hourly' ? 'selected' : '' }}>Flexible / Hourly</option>
                                </select>
                            </div>

                            <!-- Expected Timeline -->
                            <div>
                                <label for="timeline" class="block text-sm font-semibold text-[#1F2937] mb-1.5">
                                    Expected Timeline (Optional)
                                </label>
                                <select id="timeline" name="timeline"
                                    class="w-full px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#1F2937] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1B560B] focus:border-transparent text-sm">
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
                            <label for="message" class="block text-sm font-semibold text-[#1F2937] mb-1.5">
                                Project Message &amp; Requirements <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#1F2937] placeholder-[#9CA3AF] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1B560B] focus:border-transparent text-sm resize-y min-h-[130px]"
                                placeholder="Describe the web application, key features, business goals, and any reference websites or APIs...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-lg bg-[#1B560B] hover:bg-[#144208] text-white font-semibold text-base shadow-sm hover:shadow transition-all duration-200 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                <span>Send Project Enquiry</span>
                            </button>
                            <p class="text-center text-xs text-[#667085] mt-3">
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
