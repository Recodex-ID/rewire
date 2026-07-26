const revealEls = document.querySelectorAll('.landing-reveal');
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('landing-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
revealEls.forEach((el) => revealObserver.observe(el));

const counters = document.querySelectorAll('.landing-counter');
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseFloat(el.dataset.target);
        const decimals = parseInt(el.dataset.decimals || '0', 10);
        const duration = 2000;
        const start = performance.now();

        function animate(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = (target * eased).toFixed(decimals);
            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                el.textContent = target.toFixed(decimals);
            }
        }
        requestAnimationFrame(animate);
        counterObserver.unobserve(el);
    });
}, { threshold: 0.5 });
counters.forEach((c) => counterObserver.observe(c));
