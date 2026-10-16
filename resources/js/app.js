import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

/**
 * High-performance, lightweight Scroll Reveal system using Intersection Observer
 * Zero external library dependencies, 60fps GPU-accelerated transforms
 */
function initScrollReveal() {
    const reveals = document.querySelectorAll('.reveal-on-scroll:not(.reveal-visible)');
    if (!reveals.length) return;

    // Graceful fallback for reduced motion or older browsers
    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        reveals.forEach(el => el.classList.add('reveal-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-visible');
                // Unobserve once revealed to keep scrolling fast and memory clean
                obs.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px'
    });

    reveals.forEach(el => observer.observe(el));
}

// Top Scroll Dynamic Progress Bar
function initScrollProgress() {
    const progressBar = document.getElementById('scroll-progress-bar');
    if (!progressBar) return;

    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrollTop = window.scrollY || document.documentElement.scrollTop;
                const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const progress = scrollHeight > 0 ? (scrollTop / scrollHeight) * 100 : 0;
                progressBar.style.width = `${Math.min(100, Math.max(0, progress))}%`;
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
}

// Interactive 3D Card Mouse Tilt Effect & Spotlight Coordinates
function initCard3DTilt() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || window.innerWidth < 768 || !window.matchMedia('(hover: hover)').matches) {
        return;
    }

    const cards = document.querySelectorAll('.card-glow-hover, .card-spotlight');
    cards.forEach(card => {
        let isHovered = false;

        card.addEventListener('mouseenter', () => {
            isHovered = true;
            card.style.transition = 'transform 0.12s ease-out, box-shadow 0.25s ease, border-color 0.25s ease';
        });

        card.addEventListener('mousemove', (e) => {
            if (!isHovered) return;
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            // Set dynamic spotlight coordinates
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);

            // Subtle 3D tilt angles
            const rotateX = ((y - centerY) / centerY) * -5.5;
            const rotateY = ((x - centerX) / centerX) * 5.5;

            card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-8px) scale(1.015)`;
        });

        card.addEventListener('mouseleave', () => {
            isHovered = false;
            card.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease, border-color 0.3s ease';
            card.style.transform = '';
            card.style.setProperty('--mouse-x', `-999px`);
            card.style.setProperty('--mouse-y', `-999px`);
        });
    });
}

// High-Performance Animated Number Counters
function initStatCounters() {
    const counters = document.querySelectorAll('.stat-counter');
    if (!counters.length) return;

    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        counters.forEach(el => {
            const target = el.getAttribute('data-target');
            const suffix = el.getAttribute('data-suffix') || '';
            if (target) el.innerText = `${target}${suffix}`;
        });
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseFloat(el.getAttribute('data-target') || '0');
                const suffix = el.getAttribute('data-suffix') || '';
                const decimals = (el.getAttribute('data-target') || '').includes('.') ? 1 : 0;
                const duration = 1400;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    // Smooth cubic ease-out
                    const easeOut = 1 - Math.pow(1 - progress, 3);
                    const currentVal = easeOut * target;

                    el.innerText = `${currentVal.toFixed(decimals)}${suffix}`;

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        el.innerText = `${target.toFixed(decimals)}${suffix}`;
                    }
                }

                requestAnimationFrame(updateCounter);
                obs.unobserve(el);
            }
        });
    }, { threshold: 0.2 });

    counters.forEach(counter => observer.observe(counter));
}

function setupEnhancements() {
    initScrollReveal();
    initScrollProgress();
    initCard3DTilt();
    initStatCounters();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if ('requestIdleCallback' in window) {
            requestIdleCallback(setupEnhancements, { timeout: 1200 });
        } else {
            requestAnimationFrame(setupEnhancements);
        }
    });
} else {
    if ('requestIdleCallback' in window) {
        requestIdleCallback(setupEnhancements, { timeout: 1200 });
    } else {
        requestAnimationFrame(setupEnhancements);
    }
}

// Expose globally if dynamic Alpine tabs or pagination need to re-scan
window.initScrollReveal = initScrollReveal;
