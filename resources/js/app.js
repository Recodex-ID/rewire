// Chart.js is only needed on the signed-in dashboards, so it is a separate chunk that
// loads on demand instead of shipping (~200 kB) with every public page.
window.loadChart = () => import('chart.js/auto').then((module) => module.default);

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

// Analytics loads only after the visitor opts in, and can be switched off again.
document.addEventListener('alpine:init', () => {
    window.Alpine.data('cookieConsent', (measurementId) => ({
        open: false,
        storageKey: 'rewire-cookie-consent',

        init() {
            const choice = this.read();

            if (choice === 'granted') {
                this.loadAnalytics();
            } else if (choice === null) {
                this.open = true;
            }
        },

        read() {
            try {
                return window.localStorage.getItem(this.storageKey);
            } catch (error) {
                return null;
            }
        },

        save(choice) {
            try {
                window.localStorage.setItem(this.storageKey, choice);
            } catch (error) {
                // Private mode or blocked storage: the choice just applies to this page view.
            }
        },

        reopen() {
            this.open = true;
            this.$nextTick(() => this.$refs.decline.focus());
        },

        accept() {
            this.save('granted');
            window[`ga-disable-${measurementId}`] = false;
            this.loadAnalytics();
            this.open = false;
        },

        decline() {
            this.save('denied');
            window[`ga-disable-${measurementId}`] = true;
            this.clearAnalyticsCookies();
            this.open = false;
        },

        loadAnalytics() {
            if (window.__analyticsLoaded) {
                return;
            }

            window.__analyticsLoaded = true;
            window.dataLayer = window.dataLayer || [];
            window.gtag = function () {
                window.dataLayer.push(arguments);
            };
            window.gtag('js', new Date());
            window.gtag('config', measurementId, { anonymize_ip: true });

            const script = document.createElement('script');
            script.async = true;
            script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(measurementId)}`;
            document.head.appendChild(script);
        },

        clearAnalyticsCookies() {
            const hostParts = window.location.hostname.split('.');
            const domains = [window.location.hostname, `.${window.location.hostname}`];

            if (hostParts.length > 2) {
                domains.push(`.${hostParts.slice(-2).join('.')}`);
            }

            document.cookie.split(';').forEach((cookie) => {
                const name = cookie.split('=')[0].trim();

                if (name === '_ga' || name.startsWith('_ga_')) {
                    domains.forEach((domain) => {
                        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; domain=${domain}`;
                    });
                    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/`;
                }
            });
        },
    }));
});
