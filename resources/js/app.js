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

    const isMobileOrTouch = window.innerWidth < 768 || window.matchMedia('(hover: none), (pointer: coarse)').matches || 'ontouchstart' in window || (navigator.maxTouchPoints > 0);

    // On touch mobile screens or reduced motion, instantly show all content to avoid layout thrashing during scroll
    if (isMobileOrTouch || !('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        reveals.forEach(el => el.classList.add('reveal-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-visible');
                obs.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.01,
        rootMargin: '250px 0px 250px 0px'
    });

    reveals.forEach(el => observer.observe(el));
}

// Top Scroll Dynamic Progress Bar
function initScrollProgress() {
    const progressBar = document.getElementById('scroll-progress-bar');
    if (!progressBar) return;

    const isMobileOrTouch = window.innerWidth < 768 || window.matchMedia('(hover: none), (pointer: coarse)').matches || 'ontouchstart' in window || (navigator.maxTouchPoints > 0);
    if (isMobileOrTouch) return;

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

// High-Performance Animated Number Counters (0 to Target with cubic easing)
function initStatCounters() {
    const counters = document.querySelectorAll('.stat-counter');
    if (!counters.length) return;

    const isMobileOrTouch = window.innerWidth < 768 || window.matchMedia('(hover: none), (pointer: coarse)').matches || 'ontouchstart' in window || (navigator.maxTouchPoints > 0);

    // On touch mobile devices or reduced motion, keep server-rendered final values directly (0 RAF, 0 forced reflows)
    if (isMobileOrTouch || !('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        counters.forEach(el => {
            const target = el.getAttribute('data-target');
            const suffix = el.getAttribute('data-suffix') || '';
            if (target) el.textContent = `${target}${suffix}`;
        });
        return;
    }

    // Set initial 0 text before entering viewport (using textContent to prevent synchronous layout reflows)
    counters.forEach(el => {
        const suffix = el.getAttribute('data-suffix') || '';
        const decimals = (el.getAttribute('data-target') || '').includes('.') ? 1 : 0;
        el.textContent = `0${decimals ? '.0' : ''}${suffix}`;
    });

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseFloat(el.getAttribute('data-target') || '0');
                const suffix = el.getAttribute('data-suffix') || '';
                const decimals = (el.getAttribute('data-target') || '').includes('.') ? 1 : 0;
                const duration = 1000;
                const startTime = performance.now();
                let lastPaint = 0;

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Throttle DOM text mutations to every 30ms (~30fps) to eliminate main-thread layout thrashing
                    if (currentTime - lastPaint >= 30 || progress >= 1) {
                        lastPaint = currentTime;
                        const easeOut = 1 - Math.pow(1 - progress, 3);
                        const currentVal = easeOut * target;
                        // Use textContent instead of innerText: textContent never forces synchronous layout
                        el.textContent = `${progress >= 1 ? target.toFixed(decimals) : currentVal.toFixed(decimals)}${suffix}`;
                    }

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    }
                }

                requestAnimationFrame(updateCounter);
                obs.unobserve(el);
            }
        });
    }, { threshold: 0.15 });

    counters.forEach(counter => observer.observe(counter));
}

// Subtle 3D Card Tilt with Parallax Effect
function initCardTilt() {
    if (window.innerWidth < 768 || window.matchMedia('(hover: none), (pointer: coarse)').matches || 'ontouchstart' in window || navigator.maxTouchPoints > 0) {
        return;
    }

    const cards = document.querySelectorAll('.tilt-card');
    if (!cards.length) return;

    cards.forEach(card => {
        let bounds = null;

        function updateBounds() {
            bounds = card.getBoundingClientRect();
        }

        function onMouseMove(e) {
            if (!bounds) updateBounds();
            const mouseX = e.clientX - bounds.left;
            const mouseY = e.clientY - bounds.top;

            const xPct = (mouseX / bounds.width) - 0.5;
            const yPct = (mouseY / bounds.height) - 0.5;

            // Subtle, luxurious 5-degree tilt
            const tiltX = -(yPct * 6).toFixed(2);
            const tiltY = (xPct * 6).toFixed(2);

            card.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translateY(-4px)`;
        }

        function onMouseEnter() {
            updateBounds();
            card.style.transition = 'transform 0.15s ease-out, box-shadow 0.25s ease';
        }

        function onMouseLeave() {
            card.style.transition = 'transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s ease';
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px)';
            bounds = null;
        }

        card.addEventListener('mouseenter', onMouseEnter);
        card.addEventListener('mousemove', onMouseMove, { passive: true });
        card.addEventListener('mouseleave', onMouseLeave);
    });
}


// Awwwards-Style Magnetic Dot & Lag Ring Custom Cursor
function initMagneticCursor() {
    if (window.matchMedia('(hover: none), (pointer: coarse)').matches || 'ontouchstart' in window || navigator.maxTouchPoints > 0) {
        return;
    }

    const dot = document.getElementById('cursor-dot');
    const ring = document.getElementById('cursor-ring');
    if (!dot || !ring) return;

    let mouseX = -100;
    let mouseY = -100;
    let ringX = -100;
    let ringY = -100;
    let isVisible = false;
    let isHovering = false;
    let isClicking = false;
    let rafId = null;

    // Silky smooth inertia lag (0.18 lerp factor)
    const LERP_FACTOR = 0.18;

    function render() {
        if (isVisible) {
            const dx = mouseX - ringX;
            const dy = mouseY - ringY;
            ringX += dx * LERP_FACTOR;
            ringY += dy * LERP_FACTOR;

            dot.style.transform = `translate3d(${mouseX}px, ${mouseY}px, 0) translate(-50%, -50%) ${isClicking ? 'scale(1.6)' : (isHovering ? 'scale(0)' : 'scale(1)')}`;
            ring.style.transform = `translate3d(${ringX}px, ${ringY}px, 0) translate(-50%, -50%) ${isClicking ? 'scale(0.8)' : 'scale(1)'}`;

            // Idle check: stop animation frame when cursor stops to free main-thread
            if (Math.abs(dx) > 0.1 || Math.abs(dy) > 0.1) {
                rafId = requestAnimationFrame(render);
            } else {
                rafId = null;
            }
        } else {
            rafId = null;
        }
    }

    function wakeLoop() {
        if (!rafId) {
            rafId = requestAnimationFrame(render);
        }
    }

    window.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        if (!isVisible) {
            isVisible = true;
            ringX = mouseX;
            ringY = mouseY;
            dot.classList.add('cursor-visible');
            ring.classList.add('cursor-visible');
        }
        wakeLoop();
    }, { passive: true });

    document.addEventListener('mouseleave', () => {
        isVisible = false;
        dot.classList.remove('cursor-visible');
        ring.classList.remove('cursor-visible');
    });

    document.addEventListener('mouseenter', () => {
        isVisible = true;
        dot.classList.add('cursor-visible');
        ring.classList.add('cursor-visible');
    });

    window.addEventListener('mousedown', () => {
        isClicking = true;
        ring.classList.add('cursor-clicking');
        dot.classList.add('cursor-clicking');
        wakeLoop();
    });

    window.addEventListener('mouseup', () => {
        isClicking = false;
        ring.classList.remove('cursor-clicking');
        dot.classList.remove('cursor-clicking');
        wakeLoop();
    });

    // Delegation for interactive elements & text inputs
    const interactiveSelector = 'a, button, [role="button"], summary, .hover-target, [data-cursor="pointer"]';
    const textSelector = 'input[type="text"], input[type="email"], input[type="password"], input[type="search"], input[type="tel"], textarea';

    document.addEventListener('mouseover', (e) => {
        const textTarget = e.target.closest(textSelector);
        if (textTarget) {
            ring.classList.add('cursor-text-input');
            return;
        }

        const interactiveTarget = e.target.closest(interactiveSelector);
        if (interactiveTarget) {
            isHovering = true;
            ring.classList.add('cursor-hover');
            dot.classList.add('cursor-hover');
            wakeLoop();
        }
    });

    document.addEventListener('mouseout', (e) => {
        const textTarget = e.target.closest(textSelector);
        if (textTarget) {
            const related = e.relatedTarget ? e.relatedTarget.closest(textSelector) : null;
            if (!related) {
                ring.classList.remove('cursor-text-input');
            }
        }

        const interactiveTarget = e.target.closest(interactiveSelector);
        if (interactiveTarget) {
            const related = e.relatedTarget ? e.relatedTarget.closest(interactiveSelector) : null;
            if (!related) {
                isHovering = false;
                ring.classList.remove('cursor-hover');
                dot.classList.remove('cursor-hover');
                wakeLoop();
            }
        }
    });
}

function setupEnhancements() {
    initScrollReveal();
    initScrollProgress();
    initStatCounters();
    initCardTilt();
}

function bootPublicEnhancements() {
    if (document.body && document.body.dataset.customCursor === '1') {
        initMagneticCursor();
    }
    if ('requestIdleCallback' in window) {
        requestIdleCallback(setupEnhancements, { timeout: 1200 });
    } else {
        requestAnimationFrame(setupEnhancements);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootPublicEnhancements);
} else {
    bootPublicEnhancements();
}

// Expose globally if dynamic Alpine tabs or pagination need to re-scan
window.initScrollReveal = initScrollReveal;
window.initMagneticCursor = initMagneticCursor;
window.initStatCounters = initStatCounters;
window.initCardTilt = initCardTilt;
