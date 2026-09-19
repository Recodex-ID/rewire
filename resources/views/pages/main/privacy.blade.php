@php
    $contactEmail = \App\Models\Setting::get('contact_email');
    $analyticsEnabled = filled(\App\Models\Setting::get('analytics_id'));
    $retentionDays = config('activitylog.clean_after_days');
    $sessionMinutes = config('session.lifetime');
@endphp

<x-layouts::main
    title="Privacy Policy"
    seo-description="What personal data Rewire Starter Kit collects, why it collects it, how long it keeps it, and how you can control it."
>
    <article class="pt-32 pb-24 sm:pt-40 sm:pb-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <p class="font-mono text-xs font-semibold tracking-widest text-brand-accent-dark uppercase">Legal</p>
            <h1 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">Privacy Policy</h1>
            <p class="mt-4 text-sm text-brand-navy/70">Last updated 19 September 2026</p>

            <div class="mt-10 space-y-4 text-base leading-relaxed text-brand-navy/80">
                <p>
                    This policy explains what personal data Rewire Starter Kit collects, why, and what you can do about it.
                    Rewire Starter Kit is an open source Laravel starter kit built by Recodex ID (PT Reka Mitra Teknologi).
                    This website is its public site and sign-in area, and PT Reka Mitra Teknologi is responsible for the data described below.
                </p>
            </div>

            <div class="mt-12 space-y-12 text-base leading-relaxed text-brand-navy/80">
                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">What we collect</h2>
                    <ul class="mt-4 list-disc space-y-3 pl-6">
                        <li><strong class="font-semibold text-brand-navy">Account details.</strong> When you register we store your name, your email address, and a hash of your password. We never store the password itself. Your role (staff, admin, or super-admin) is stored with your account.</li>
                        <li><strong class="font-semibold text-brand-navy">Sign-in activity.</strong> We keep an audit trail of sign-ins, sign-outs, failed sign-in attempts (including the email address that was typed), password resets, and email verification. Changes that signed-in team members make to users, settings, and blog posts are logged with their name and the time.</li>
                        <li><strong class="font-semibold text-brand-navy">Session data.</strong> While you are signed in, the server keeps a session record that includes your IP address and your browser's user agent. It is used to keep you signed in and to protect your account.</li>
                        <li><strong class="font-semibold text-brand-navy">Content you add.</strong> Blog posts and images that signed-in team members upload.</li>
                        <li><strong class="font-semibold text-brand-navy">Emails.</strong> We send verification and password reset emails to the address on your account. We do not send marketing email.</li>
                        <li><strong class="font-semibold text-brand-navy">Server logs.</strong> Like most web servers, the server that hosts this site may log the IP address, the page requested, and the time of each request, for security and troubleshooting.</li>
                        @if ($analyticsEnabled)
                            <li><strong class="font-semibold text-brand-navy">Analytics, only with your consent.</strong> If you accept analytics cookies, Google Analytics records which pages you view, your approximate location, and your device and browser type. We use it to see which pages are read, not to show ads.</li>
                        @endif
                    </ul>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Cookies and local storage</h2>
                    <p class="mt-4">Essential cookies are needed for the site to work and are set without asking. Nothing else is set unless you agree.</p>
                    <ul class="mt-4 list-disc space-y-3 pl-6">
                        <li><code class="rounded bg-brand-navy/5 px-1.5 py-0.5 font-mono text-sm">{{ config('session.cookie') }}</code>: keeps you signed in. Essential. It expires after {{ $sessionMinutes }} minutes without activity.</li>
                        <li><code class="rounded bg-brand-navy/5 px-1.5 py-0.5 font-mono text-sm">XSRF-TOKEN</code>: protects forms against cross-site request forgery. Essential.</li>
                        <li><code class="rounded bg-brand-navy/5 px-1.5 py-0.5 font-mono text-sm">remember_web_*</code>: set only if you tick "Keep me signed in on this device". It keeps you signed in after you close the browser.</li>
                        @if ($analyticsEnabled)
                            <li><code class="rounded bg-brand-navy/5 px-1.5 py-0.5 font-mono text-sm">_ga</code> and <code class="rounded bg-brand-navy/5 px-1.5 py-0.5 font-mono text-sm">_ga_*</code>: Google Analytics. Set only if you accept analytics cookies, and they last up to two years.</li>
                            <li><code class="rounded bg-brand-navy/5 px-1.5 py-0.5 font-mono text-sm">rewire-cookie-consent</code>: stored in your browser's local storage, not a cookie, to remember your choice. It is never sent to our server.</li>
                        @endif
                    </ul>
                    <p class="mt-4">Fonts are served from this site, so no font provider sees your visit.</p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Why we use your data</h2>
                    <ul class="mt-4 list-disc space-y-3 pl-6">
                        <li>To create and run your account, and to keep it secure.</li>
                        <li>To send the account emails described above.</li>
                        <li>To keep the audit trail that shows who changed what in the dashboard.</li>
                        @if ($analyticsEnabled)
                            <li>To understand how the site is used, only if you accept analytics cookies.</li>
                        @endif
                        <li>To meet legal obligations when they apply to us.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Who we share it with</h2>
                    <p class="mt-4">
                        We do not sell personal data. We share it only with the service providers that run this site for us: our hosting provider, our email delivery provider, and Google if you accept analytics cookies.
                        We may also disclose data when the law requires it.
                    </p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">How long we keep it</h2>
                    <ul class="mt-4 list-disc space-y-3 pl-6">
                        <li>Account details are kept until you ask us to delete your account or an administrator removes it.</li>
                        <li>Audit trail entries are kept for {{ $retentionDays }} days. A scheduled job deletes older entries.</li>
                        <li>Session records expire after {{ $sessionMinutes }} minutes without activity.</li>
                        @if ($analyticsEnabled)
                            <li>Analytics data is kept for the retention period set in our Google Analytics property.</li>
                        @endif
                    </ul>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Your rights and choices</h2>
                    <p class="mt-4">
                        Depending on where you live, laws such as the EU GDPR or Indonesia's Personal Data Protection Law (Law No. 27 of 2022) give you rights to access, correct, delete, or restrict the use of your personal data, and to object to processing or withdraw consent.
                    </p>
                    <ul class="mt-4 list-disc space-y-3 pl-6">
                        <li>You can change your name and email address in your account settings after you sign in.</li>
                        <li>
                            To get a copy of your data or to have your account deleted,
                            @if (filled($contactEmail))
                                email <a href="mailto:{{ $contactEmail }}" class="font-medium text-brand-accent-dark underline underline-offset-2 hover:text-brand-navy">{{ $contactEmail }}</a>.
                            @else
                                contact the site administrator.
                            @endif
                        </li>
                        @if ($analyticsEnabled)
                            <li>To withdraw your consent to analytics, choose "Cookie settings" in the footer and decline.</li>
                        @endif
                    </ul>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Security</h2>
                    <p class="mt-4">
                        In production, pages are served over HTTPS, passwords are stored as hashes, and admin areas are limited by role.
                        No system is completely secure, so we cannot promise absolute security.
                    </p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Children</h2>
                    <p class="mt-4">This site is not aimed at children, and we do not knowingly collect their personal data.</p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Changes to this policy</h2>
                    <p class="mt-4">When we change this policy we update the date at the top of the page. If a change is significant, we say so here.</p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Contact</h2>
                    <p class="mt-4">
                        Questions about this policy go to PT Reka Mitra Teknologi
                        @if (filled($contactEmail))
                            at <a href="mailto:{{ $contactEmail }}" class="font-medium text-brand-accent-dark underline underline-offset-2 hover:text-brand-navy">{{ $contactEmail }}</a>.
                        @else
                            through <a href="https://recodex.id" target="_blank" rel="noopener" class="font-medium text-brand-accent-dark underline underline-offset-2 hover:text-brand-navy">recodex.id</a>.
                        @endif
                    </p>
                </section>
            </div>
        </div>
    </article>
</x-layouts::main>
