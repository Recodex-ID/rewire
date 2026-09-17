import Chart from 'chart.js/auto';

window.Chart = Chart;

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
