/* ==========================================================================
   SolarSphere — Global Animation Controller
   Handles: Scroll Reveal, Navbar Shrink, Counter, Stagger
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       1. NAVBAR SHRINK ON SCROLL (Disabled for rock-solid stability)
    ============================================================ */
    // Navbar scroll listener disabled to prevent header shifts

    /* ============================================================
       2. SCROLL REVEAL — IntersectionObserver
       Targets: [data-aos], .reveal, .reveal-left, .reveal-right, .reveal-scale
    ============================================================ */
    const revealClasses = ['.reveal', '.reveal-left', '.reveal-right', '.reveal-scale'];

    const revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target); // animate only once
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    revealClasses.forEach(function (cls) {
        document.querySelectorAll(cls).forEach(function (el) {
            revealObserver.observe(el);
        });
    });

    /* ============================================================
       3. AUTO-APPLY REVEAL TO COMMON ELEMENTS (if not already set)
    ============================================================ */
    const autoRevealSelectors = [
        'section h2', 'section h3',
        '.card', '.product-card',
        '.border-light-subtle',
        '.testimonial-card',
        '.service-step-box',
        '.stat-number',
        'footer .col-lg-3, footer .col-lg-2, footer .col-md-6'
    ];

    autoRevealSelectors.forEach(function (selector) {
        document.querySelectorAll(selector).forEach(function (el, i) {
            // Skip if already has a reveal class or data-aos
            if (!el.classList.contains('reveal') &&
                !el.classList.contains('reveal-left') &&
                !el.classList.contains('reveal-right') &&
                !el.classList.contains('reveal-scale') &&
                !el.hasAttribute('data-aos')) {

                el.classList.add('reveal');
                // Stagger delay based on index within parent
                const siblings = el.parentElement ? el.parentElement.children : [];
                const sibIdx = Array.from(siblings).indexOf(el);
                if (sibIdx >= 0 && sibIdx < 6) {
                    el.classList.add('delay-' + (sibIdx + 1));
                }
                revealObserver.observe(el);
            }
        });
    });

    /* ============================================================
       4. ANIMATED STAT COUNTER
    ============================================================ */
    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-target') || el.innerText, 10);
        const suffix = el.getAttribute('data-suffix') || '';
        if (isNaN(target)) return;

        const duration = 1800;
        const step = 16;
        const increment = target / (duration / step);
        let current = 0;

        el.innerText = '0' + suffix;

        const timer = setInterval(function () {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.innerText = Math.floor(current) + suffix;
        }, step);
    }

    const counterObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-number[data-target]').forEach(function (el) {
        counterObserver.observe(el);
    });

    /* ============================================================
       5. SECTION HEADING UNDERLINE GROW (on scroll)
    ============================================================ */
    document.querySelectorAll('.section-heading-underline').forEach(function (el) {
        const obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.5 });
        obs.observe(el);
    });

    /* ============================================================
       6. BUTTON RIPPLE EFFECT (touch-friendly)
    ============================================================ */
    document.querySelectorAll('.btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.35);
                transform: scale(0);
                animation: rippleAnim 0.55s linear;
                pointer-events: none;
                width: 120px; height: 120px;
                left: ${e.offsetX - 60}px;
                top: ${e.offsetY - 60}px;
            `;
            // inject keyframe once
            if (!document.getElementById('ripple-style')) {
                const s = document.createElement('style');
                s.id = 'ripple-style';
                s.innerHTML = '@keyframes rippleAnim { to { transform: scale(2.5); opacity: 0; } }';
                document.head.appendChild(s);
            }
            btn.style.position = 'relative';
            btn.style.overflow = 'hidden';
            btn.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 600);
        });
    });

    /* ============================================================
       7. STAGGER PRODUCT / CATEGORY CARDS
    ============================================================ */
    const cardGroups = document.querySelectorAll('.row.g-4, .row.g-3');
    cardGroups.forEach(function (row) {
        const cards = row.querySelectorAll('.col-lg-4, .col-md-6, .col-lg-3');
        cards.forEach(function (card, i) {
            if (!card.classList.contains('reveal')) {
                card.classList.add('reveal');
                card.style.transitionDelay = (i * 0.1) + 's';
                revealObserver.observe(card);
            }
        });
    });

    /* ============================================================
       8. HERO VIDEO SECTION FADE-IN
    ============================================================ */
    const heroSection = document.querySelector('.hero-video-section');
    if (heroSection) {
        heroSection.style.opacity = '0';
        heroSection.style.transition = 'opacity 0.8s ease';
        setTimeout(function () {
            heroSection.style.opacity = '1';
        }, 100);
    }

    /* ============================================================
       9. SMOOTH BACK-TO-TOP (if button exists)
    ============================================================ */
    const backToTop = document.querySelector('#backToTop, .back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }, { passive: true });

        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ============================================================
       10. IMAGE LAZY LOAD + FADE IN
    ============================================================ */
    const lazyImages = document.querySelectorAll('img[loading="lazy"], img:not([loading])');
    lazyImages.forEach(function (img) {
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.5s ease';
        if (img.complete) {
            img.style.opacity = '1';
        } else {
            img.addEventListener('load', function () {
                img.style.opacity = '1';
            });
        }
    });

});
