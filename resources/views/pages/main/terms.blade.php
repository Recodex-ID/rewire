@php
    $contactEmail = \App\Models\Setting::get('contact_email');
@endphp

<x-layouts::main
    title="Terms of Service"
    seo-description="The rules for using the Rewire Starter Kit website and creating an account on it."
>
    <article class="pt-32 pb-24 sm:pt-40 sm:pb-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <p class="font-mono text-xs font-semibold tracking-widest text-brand-accent-dark uppercase">Legal</p>
            <h1 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">Terms of Service</h1>
            <p class="mt-4 text-sm text-brand-navy/70">Last updated 19 September 2026</p>

            <div class="mt-10 space-y-4 text-base leading-relaxed text-brand-navy/80">
                <p>
                    These terms cover your use of the Rewire Starter Kit website and any account you create on it.
                    The website is run by PT Reka Mitra Teknologi, which builds Rewire Starter Kit as Recodex ID.
                    By using the site or creating an account, you agree to these terms and to the
                    <a href="{{ route('privacy') }}" class="font-medium text-brand-accent-dark underline underline-offset-2 hover:text-brand-navy">Privacy Policy</a>.
                    If you do not agree, please do not use the site.
                </p>
            </div>

            <div class="mt-12 space-y-12 text-base leading-relaxed text-brand-navy/80">
                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">The site and the source code</h2>
                    <p class="mt-4">
                        Rewire Starter Kit is open source. Its source code is published under the
                        <a href="https://github.com/Recodex-ID/rewire/blob/main/LICENSE" target="_blank" rel="noopener" class="font-medium text-brand-accent-dark underline underline-offset-2 hover:text-brand-navy">MIT License</a>,
                        and that license, not these terms, governs what you may do with the code.
                        These terms only cover your use of this website.
                    </p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Your account</h2>
                    <ul class="mt-4 list-disc space-y-3 pl-6">
                        <li>Give us accurate details when you register, and keep them up to date.</li>
                        <li>Keep your password private. You are responsible for what happens under your account, so tell us quickly if you think someone else has access to it.</li>
                        <li>Administrators assign roles (staff, admin, or super-admin). A role decides which parts of the dashboard you can see and change.</li>
                        <li>We may suspend or remove an account that breaks these terms or puts the site or other people at risk.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Acceptable use</h2>
                    <p class="mt-4">You agree not to:</p>
                    <ul class="mt-4 list-disc space-y-3 pl-6">
                        <li>break the law, or use the site to harm or harass anyone;</li>
                        <li>try to get into accounts, areas, or data you are not allowed to access;</li>
                        <li>scan, probe, or overload the site without our written permission;</li>
                        <li>send spam through the site's forms, or create accounts in bulk;</li>
                        <li>upload malware, or content that infringes someone else's rights.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Content you publish</h2>
                    <p class="mt-4">
                        Team members can publish blog posts and upload images. You keep the rights to what you publish.
                        By publishing it on this site you give us permission to host it, display it, and make the copies needed to run the site.
                        You are responsible for having the right to publish what you upload.
                    </p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Availability and warranty</h2>
                    <p class="mt-4">
                        The site and the starter kit are provided as is, without warranties of any kind, as the MIT License states.
                        We may change, pause, or shut down any part of the site, and we do not promise it will always be available or free of errors.
                    </p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Limit of liability</h2>
                    <p class="mt-4">
                        To the extent the law allows, PT Reka Mitra Teknologi is not liable for indirect or consequential losses, or for lost data, profit, or business, that come from using the site.
                        Nothing in these terms limits liability that cannot be limited by law.
                    </p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Ending your use</h2>
                    <p class="mt-4">
                        You can stop using the site at any time.
                        @if (filled($contactEmail))
                            To have your account deleted, email <a href="mailto:{{ $contactEmail }}" class="font-medium text-brand-accent-dark underline underline-offset-2 hover:text-brand-navy">{{ $contactEmail }}</a>.
                        @else
                            To have your account deleted, contact the site administrator.
                        @endif
                        We may end your access if you break these terms.
                    </p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Changes to these terms</h2>
                    <p class="mt-4">When we change these terms we update the date at the top of the page. If you keep using the site after a change, you accept the new terms.</p>
                </section>

                <section>
                    <h2 class="font-display text-2xl font-bold text-brand-navy">Contact</h2>
                    <p class="mt-4">
                        Questions about these terms go to PT Reka Mitra Teknologi
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
