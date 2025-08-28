(function() {
    if (typeof window === 'undefined' || !('IntersectionObserver' in window)) return;

    function addRevealClasses() {
        const isTablet = window.matchMedia('(max-width: 992px)').matches;
        const isPhone = window.matchMedia('(max-width: 600px)').matches;
        const tabStep = isPhone ? 40 : (isTablet ? 50 : 60);
        const cardStep = isPhone ? 40 : (isTablet ? 60 : 60);
        const reviewStep = isPhone ? 60 : (isTablet ? 70 : 80);

        const groups = [{
                selector: '.hero-overlay',
                variant: 'fade-in',
                baseDelay: 0,
                step: 0
            },
            {
                selector: '.services-top-nav .service-tab',
                variant: 'fade-up',
                baseDelay: 40,
                step: tabStep
            },
            {
                selector: '.services-banner',
                variant: 'zoom-in banner-pop',
                baseDelay: 120,
                step: 0
            },
            {
                selector: '.subcategory-title',
                variant: 'fade-up',
                baseDelay: 0,
                step: 0
            },
            {
                selector: '.services-grid .service-card',
                variant: 'fade-up',
                baseDelay: 60,
                step: cardStep
            },
            {
                selector: '.google-review-section .rating-header',
                variant: 'fade-up',
                baseDelay: 0,
                step: 0
            },
            {
                selector: '.google-review-section .review-card',
                variant: 'slide-in-right',
                baseDelay: 80,
                step: reviewStep
            },
            {
                selector: '.footer .footer-top .footer-box',
                variant: 'fade-up',
                baseDelay: 0,
                step: 80
            },
            {
                selector: '.footer .footer-middle .footer-box',
                variant: 'fade-up',
                baseDelay: 0,
                step: 80
            },
            // Contact page elements (only applied if present)
            {
                selector: '.contact-banner',
                variant: 'fade-in banner-pop',
                baseDelay: 80,
                step: 0
            },
            {
                selector: '.contact-container .contact-left',
                variant: 'slide-in-left',
                baseDelay: 80,
                step: 0
            },
            {
                selector: '.contact-container .contact-right',
                variant: 'slide-in-right',
                baseDelay: 140,
                step: 0
            },
            {
                selector: '.find-us .find-us-image, .find-us .find-us-header, .find-us .find-us-map',
                variant: 'fade-up',
                baseDelay: 60,
                step: 80
            }
        ];

        groups.forEach(({
            selector,
            variant,
            baseDelay,
            step
        }) => {
            const elements = document.querySelectorAll(selector);
            elements.forEach((el, index) => {
                if (!el.classList.contains('reveal')) {
                    el.classList.add('reveal');
                }
                variant.split(/\s+/).forEach(v => v && el.classList.add(v));
                const delay = baseDelay + index * step;
                el.style.setProperty('--reveal-delay', delay + 'ms');
            });
        });
    }

    function initObserver() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '0px 0px -10% 0px',
            threshold: 0.1
        });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    }

    function rebindOnTabChange() {
        // When service tabs change, reapply reveals for newly visible content
        document.addEventListener('click', function(e) {
            const target = e.target;
            if (target && target.classList && target.classList.contains('service-tab')) {
                // Wait for DOM changes/active class switch
                setTimeout(() => {
                    addRevealClasses();
                    initObserver();
                }, 0);
            }
        });
    }

    function rerun() {
        addRevealClasses();
        initObserver();
        rebindOnTabChange();
    }

    document.addEventListener('DOMContentLoaded', function() {
        rerun();
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                // Recalculate delays and re-observe elements on layout breakpoint changes
                document.querySelectorAll('.reveal').forEach(el => {
                    el.classList.remove('in-view');
                    el.style.removeProperty('--reveal-delay');
                });
                rerun();
            }, 150);
        });
    });
})();