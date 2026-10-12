<footer class="bg-gray-900 dark:bg-gray-950 text-gray-300 pt-12 pb-6 mt-auto">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-4">{{ $websiteName ?? config('app.name') }}</h3>
                <p class="text-sm text-gray-400 mb-4">{{ \App\Models\Setting::get('footer_description') ?: ($profile->bio ?? ($profile->intro ?? 'Full Stack Web Developer crafting scalable applications.')) }}</p>
                @if($profile)
                    <div class="flex space-x-4">
                        @if($profile->email)
                            <a href="mailto:{{ $profile->email }}" class="text-gray-400 hover:text-white" title="Email me">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </a>
                        @endif
                        @foreach(['github', 'linkedin', 'twitter'] as $social)
                            @isset($profile->social_links[$social])
                                <a href="{{ $profile->social_links[$social] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors">
                                    <span class="sr-only">{{ ucfirst($social) }}</span>
                                    @if($social === 'github')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .296C5.371 0 0 5.371 0 12.004c0 5.302 3.544 9.8 8.434 11.386.6.112.82-.262.82-.58 0-.286-.01-1.186-.015-2.148-3.429.756-4.141-1.647-4.141-1.647-.555-1.401-1.342-1.77-1.342-1.77-1.09-.75.084-.735.084-.735 1.203.084 1.836 1.24 1.836 1.24 1.067 1.83 2.805 1.305 3.49.996.108-.782.418-1.305.762-1.605-2.665-.305-5.467-1.335-5.467-5.935 0-1.311.47-2.381 1.236-3.221-.124-.303-.053-.823.027-1.646 0 0 .027-.086.997 1.203 3.186-.998 4.263-.274 4.263-.274.34.861.995 1.685 1.715 1.998.82-.122 1.64-.247 2.456-.449 0 0 1.09-.19 2.24 1.226 0 0 1.105-1.156 1.568-2.779 0 0 .42-1.325.027-2.779 0 0 1.59-.041 2.997 1.229.96-.273 1.99-.822 3.01-1.599.762 1.155 1.142 2.497 1.142 3.91 0 1.566.015 3.132.015 3.589 0 0 .084.49.82 1.295.932 1.2 1.42 1.964 1.42 1.964.534.889 1.158 1.341 1.81.995 1.27-.338 1.72-.881 2.03.336.265.999.82 1.787 1.427 2.423.81-.161 1.6-.48 2.27-.93.074-.554.136-1.435.136-1.97 0-4.608-3.135-8.342-7.41-9.466 1.32-.975 2.295-2.975 2.295-6.215 0-4.816-3.135-8.746-7.412-8.746-2.322 0-4.522.85-6.29 2.282-.643-.12-1.28.2-1.92.49-.995 22.07-7.7 15.62-12.06 15.66-1.35-.27-2.74-.42-4.15-.42z"></path></svg>
                                    @elseif($social === 'linkedin')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.846-3.037-1.851 0-2.136 1.445-2.136 2.942v5.664h-3.554V9h3.373v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.456v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019h-3.554V9h3.554v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path></svg>
                                    @elseif($social === 'twitter')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.897-.959-2.178-1.559-3.594-1.559-2.723 0-4.928 2.206-4.928 4.928 0 .386.043.762.127 1.124C8.191 8.094 5.192 6.135 3.074 3.17c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.19 2.188 4.07-.802-.025-1.56-.245-2.228-.616v.062c0 2.386 1.698 4.376 3.951 4.827-.414.112-.85.17-1.276.17.181-.001.35-.021.515-.058-.43 1.335-1.416 2.554-2.629 3.269C5.125 19.145 7.375 20 9.29 20 3.514 20 0 16.486 0 12.082 1.29 11.414 2.755 10.759 4.308 10.297c-.035-.008-.066-.016-.1-.023 0-.023.001-.046.001-.069 0-2.723 2.213-4.935 4.928-4.935 1.345 0 2.541.39 3.536 1.028l.001-.002c.05 1.704 1.25 3.182 2.942 3.547-1.02.755-2.255 1.202-3.617 1.202-.017 0-.033-.001-.05-.001.045 1.841 1.435 3.372 3.318 3.694 3.166 3.166 8.475 1.49 9.846-2.462 1.028-.745 1.912-1.69 2.536-2.76l.001-.001c1.2-.865 2.18-1.92 2.78-3.066 1.235-.987 2.174-2.298 2.77-3.736 0-.047-.001-.093-.001-.14z"></path></svg>
                                    @endif
                                </a>
                            @endisset
                        @endforeach
                    </div>
                @endif
            </div>

            @foreach($footerWidgets as $widget)
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">{{ $widget->title }}</h4>
                    <ul class="space-y-2">
                        @foreach($widget->links as $link)
                            <li>
                                <a href="{{ $link->url }}" target="{{ $link->target }}"
                                    class="text-sm text-gray-400 hover:text-white transition-colors">
                                    {{ $link->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            @if($orphanedFooterLinks->isNotEmpty())
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Links</h4>
                    <ul class="space-y-2">
                        @foreach($orphanedFooterLinks as $link)
                            <li>
                                <a href="{{ $link->url }}" target="{{ $link->target }}"
                                    class="text-sm text-gray-400 hover:text-white transition-colors">
                                    {{ $link->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="border-t border-gray-800 pt-6 text-center text-sm text-gray-500">
            <p>{{ \App\Models\Setting::get('copyright_text') ?: ('© ' . date('Y') . ' ' . ($websiteName ?? config('app.name')) . '. All rights reserved.') }}</p>
        </div>
    </div>
</footer>
