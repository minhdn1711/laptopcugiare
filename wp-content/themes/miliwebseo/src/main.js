import './main.css';

// ──────────────────────────────────────────────────────────────
// PERFORMANCE UTILITIES
// ──────────────────────────────────────────────────────────────

/**
 * Debounce utility - prevent excessive function calls
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

/**
 * Throttle utility - limit function calls to once per interval
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ──────────────────────────────────────────────────────────────
// LAZY LOAD IMAGES (Intersection Observer API)
// ──────────────────────────────────────────────────────────────
if ('IntersectionObserver' in window) {
    const lazyImageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                
                // Load image
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
                
                // Load srcset if available
                if (img.dataset.srcset) {
                    img.srcset = img.dataset.srcset;
                }
                
                // Load picture sources
                const sources = img.parentElement.querySelectorAll('source[data-srcset]');
                sources.forEach(source => {
                    source.srcset = source.dataset.srcset;
                });
                
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px' // Start loading 50px before coming into view
    });

    // Observe all lazy images
    document.querySelectorAll('img[data-src]').forEach(img => {
        lazyImageObserver.observe(img);
    });
}

// ──────────────────────────────────────────────────────────────
// LAZY INIT SPLIDE SLIDER (Only when visible)
// ──────────────────────────────────────────────────────────────
if ('IntersectionObserver' in window && window.Splide) {
    const sliderObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const slider = entry.target;
                if (!slider.dataset.splideInitialized) {
                    try {
                        new Splide(slider, {
                            type: 'loop',
                            autoplay: true,
                            interval: 4000,
                            arrows: false,
                            pagination: true,
                            perPage: 1,
                            pauseOnHover: true,
                            trimSpace: false,
                        }).mount();
                        slider.dataset.splideInitialized = 'true';
                    } catch (e) {
                        console.warn('Splide initialization failed:', e);
                    }
                }
                sliderObserver.unobserve(slider);
            }
        });
    }, { rootMargin: '100px' });

    // Observe sliders
    document.querySelectorAll('.splide').forEach(slider => {
        sliderObserver.observe(slider);
    });
}

// ──────────────────────────────────────────────────────────────
// EXPORT UTILITIES FOR USE IN ALPINE.JS
// ──────────────────────────────────────────────────────────────
window.debounce = debounce;
window.throttle = throttle;
