<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Documentation')] class extends Component
{
    //
};
?>

<div class="w-full space-y-12">
    <div>
        <flux:heading size="xl">Documentation</flux:heading>
        <flux:subheading>What this starter kit gives you, and where to find it.</flux:subheading>
    </div>

    <div class="flex flex-wrap gap-2">
        <flux:link href="#getting-started" class="text-sm">Getting started</flux:link>
        <flux:link href="#authentication" class="text-sm">Authentication</flux:link>
        <flux:link href="#roles" class="text-sm">Roles &amp; permissions</flux:link>
        <flux:link href="#landing-page" class="text-sm">Landing page CMS</flux:link>
        <flux:link href="#stack" class="text-sm">Tech stack</flux:link>
        <flux:link href="#quality" class="text-sm">Tests &amp; quality</flux:link>
    </div>

    <section id="getting-started" class="space-y-4">
        <flux:heading size="lg">Getting started</flux:heading>
        <flux:text>
            Running <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">php artisan migrate --seed</code>
            creates two accounts, both with the password <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">password</code>:
        </flux:text>
        <div class="overflow-hidden rounded-lg border border-zinc-200">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 text-left">
                    <tr>
                        <th class="px-4 py-2 font-medium">Email</th>
                        <th class="px-4 py-2 font-medium">Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200">
                    <tr>
                        <td class="px-4 py-2 font-mono">admin@recodex.id</td>
                        <td class="px-4 py-2"><flux:badge size="sm">admin</flux:badge></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">member@recodex.id</td>
                        <td class="px-4 py-2"><flux:badge size="sm" color="zinc">member</flux:badge></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <flux:text>
            The public landing page lives at <flux:link :href="route('home')">/</flux:link>, this dashboard at
            <flux:link :href="route('dashboard')">/dashboard</flux:link>, and the admin-only landing page editor at
            <flux:link :href="route('app.landing-page.edit')">/app/landing-page</flux:link> (visible in the sidebar once you're
            signed in as an admin).
        </flux:text>
    </section>

    <flux:separator />

    <section id="authentication" class="space-y-4">
        <flux:heading size="lg">Authentication</flux:heading>
        <flux:text>
            Auth runs on <flux:link href="https://laravel.com/docs/fortify" target="_blank">Laravel Fortify</flux:link>: login,
            registration, password reset, and email verification are all wired up under
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">app/Actions/Fortify</code> and
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">app/Providers/FortifyServiceProvider.php</code>.
        </flux:text>
        <flux:text>
            Two-factor authentication and passkeys were intentionally removed to keep the default footprint small — add them back
            via <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">config/fortify.php</code>'s
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">features</code> array if a project actually
            needs them.
        </flux:text>
    </section>

    <flux:separator />

    <section id="roles" class="space-y-4">
        <flux:heading size="lg">Roles &amp; permissions</flux:heading>
        <flux:text>
            Built on <flux:link href="https://spatie.be/docs/laravel-permission" target="_blank">spatie/laravel-permission</flux:link>.
            Every new user is assigned the <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">member</code> role
            automatically (see <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">App\Models\User::booted()</code>).
            There is no separate <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">permissions</code> table in
            use yet — start with roles, add granular permissions only once a project actually needs them.
        </flux:text>
        <flux:text>
            Gate a route to admins with the <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">role:admin</code>
            middleware (alias registered in <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">bootstrap/app.php</code>),
            as <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">routes/app.php</code> already does.
        </flux:text>
    </section>

    <flux:separator />

    <section id="landing-page" class="space-y-4">
        <flux:heading size="lg">Landing page CMS</flux:heading>
        <flux:text>
            The public landing page is fully content-managed: every section's copy lives in the
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">landing_page_sections</code> table
            (<code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">App\Models\LandingPageSection</code>), one row
            per section keyed by name, with a JSON <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">content</code>
            column and an <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">is_visible</code> toggle.
        </flux:text>
        <flux:text>Eleven sections ship by default:</flux:text>
        <div class="flex flex-wrap gap-2">
            @foreach (['navbar', 'hero', 'trusted_by', 'services', 'infrastructure', 'stats', 'case_studies', 'process', 'testimonials', 'cta', 'footer'] as $section)
                <flux:badge size="sm" color="zinc">{{ $section }}</flux:badge>
            @endforeach
        </div>
        <flux:text>
            Admins edit all of it from <flux:link :href="route('app.landing-page.edit')">/app/landing-page</flux:link>. That page
            (<code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/pages/app/⚡landing-page.blade.php</code>)
            is just a tab switcher — each section is its own Livewire component under
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/pages/app/landing-page/</code>
            (e.g. <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">⚡hero.blade.php</code>), embedded with
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">&lt;livewire:pages::app.landing-page.hero&gt;</code>.
            The public page is rendered by <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">App\Http\Controllers\MainController</code>
            through the <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/components/landing/*</code> Blade
            components. To add a twelfth section: seed a new row with a unique key, add a matching editor component under
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">pages/app/landing-page/</code>, wire it into the
            tab switcher, and add a matching <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">&lt;x-landing.your-section&gt;</code>
            component to <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/index.blade.php</code>.
        </flux:text>
        <flux:text>
            The landing page deliberately does not use Flux components — it's plain Tailwind plus the shared
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">&lt;x-landing.icon&gt;</code> inline-SVG set, so it
            never inherits app-UI styling. The authenticated app you're looking at right now (including this page) is the opposite —
            build it with Flux.
        </flux:text>
    </section>

    <flux:separator />

    <section id="stack" class="space-y-4">
        <flux:heading size="lg">Tech stack</flux:heading>
        <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm sm:grid-cols-3">
            <div><span class="text-zinc-500">PHP</span><div class="font-medium">8.4</div></div>
            <div><span class="text-zinc-500">Laravel</span><div class="font-medium">13</div></div>
            <div><span class="text-zinc-500">Auth</span><div class="font-medium">Fortify</div></div>
            <div><span class="text-zinc-500">Frontend</span><div class="font-medium">Livewire 4 + Flux UI</div></div>
            <div><span class="text-zinc-500">Styling</span><div class="font-medium">Tailwind v4</div></div>
            <div><span class="text-zinc-500">Roles</span><div class="font-medium">Spatie Permission</div></div>
        </div>
    </section>

    <flux:separator />

    <section id="quality" class="space-y-4">
        <flux:heading size="lg">Tests &amp; quality</flux:heading>
        <flux:text>Every change should pass all three before it's considered done:</flux:text>
        <div class="space-y-2 font-mono text-sm">
            <div class="rounded-lg bg-zinc-900 px-4 py-2.5 text-zinc-100">php artisan test --compact</div>
            <div class="rounded-lg bg-zinc-900 px-4 py-2.5 text-zinc-100">vendor/bin/pint --dirty</div>
            <div class="rounded-lg bg-zinc-900 px-4 py-2.5 text-zinc-100">vendor/bin/phpstan analyse</div>
        </div>
    </section>
</div>
