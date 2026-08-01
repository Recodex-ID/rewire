<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Documentation')] class extends Component
{
    /**
     * Quick-nav sections, in page order. Drives both the sticky quick-nav and each section's heading icon.
     *
     * @return array<int, array{id: string, label: string, icon: string}>
     */
    #[Computed]
    public function sections(): array
    {
        return [
            ['id' => 'getting-started', 'label' => 'Getting started', 'icon' => 'rocket-launch'],
            ['id' => 'authentication', 'label' => 'Authentication', 'icon' => 'key'],
            ['id' => 'roles', 'label' => 'Roles & permissions', 'icon' => 'shield-check'],
            ['id' => 'blog', 'label' => 'Blog', 'icon' => 'newspaper'],
            ['id' => 'settings', 'label' => 'Site settings', 'icon' => 'cog-6-tooth'],
            ['id' => 'sitemap', 'label' => 'Sitemap', 'icon' => 'map'],
            ['id' => 'stack', 'label' => 'Tech stack', 'icon' => 'cpu-chip'],
            ['id' => 'quality', 'label' => 'Tests & quality', 'icon' => 'beaker'],
        ];
    }
};
?>

<div class="w-full space-y-8">
    <div>
        <flux:heading size="xl">Documentation</flux:heading>
        <flux:subheading>What this starter kit gives you, and where to find it.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-[272px_1fr] lg:items-start">
        <flux:card class="lg:sticky lg:top-20">
            <flux:text size="sm" class="mb-3 font-semibold tracking-wide text-zinc-400 uppercase">On this page</flux:text>
            <nav class="flex flex-col gap-1">
                @foreach ($this->sections() as $section)
                    <flux:link
                        href="#{{ $section['id'] }}"
                        variant="ghost"
                        class="rounded-lg px-2 py-1.5 text-sm text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900"
                    >
                        <span class="flex items-center gap-2.5">
                            <flux:icon :name="$section['icon']" class="size-4 text-zinc-400" />
                            {{ $section['label'] }}
                        </span>
                    </flux:link>
                @endforeach
            </nav>
        </flux:card>

        <div class="space-y-6">
            <section id="getting-started" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="rocket-launch" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Getting started</flux:heading>
                    </div>
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
                                    <td class="px-4 py-2 font-mono">admin@mail.test</td>
                                    <td class="px-4 py-2"><flux:badge size="sm">admin</flux:badge></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-mono">member@mail.test</td>
                                    <td class="px-4 py-2"><flux:badge size="sm" color="zinc">member</flux:badge></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <flux:text>
                        The public landing page lives at <flux:link :href="route('home')">/</flux:link>, the blog at
                        <flux:link :href="route('blogs')">/blog</flux:link>, and this dashboard at
                        <flux:link :href="route('dashboard')">/dashboard</flux:link>. Any signed-in, verified user sees the
                        "Content Management" section in the sidebar (Blog); signing in as an admin additionally unlocks the
                        "Admin" section (Users, Activity log, Sitemap, Settings).
                    </flux:text>
                </flux:card>
            </section>

            <section id="authentication" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="key" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Authentication</flux:heading>
                    </div>
                    <flux:text>
                        Auth runs on <flux:link href="https://laravel.com/docs/fortify" target="_blank">Laravel Fortify</flux:link>: login,
                        registration, password reset, and email verification are all wired up under
                        <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">app/Actions/Fortify</code> and
                        <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">app/Providers/FortifyServiceProvider.php</code>.
                    </flux:text>
                    <flux:callout variant="secondary">
                        <flux:callout.heading icon="information-circle">Two-factor auth &amp; passkeys were removed by default</flux:callout.heading>
                        <flux:callout.text>
                            Two-factor authentication and passkeys were intentionally removed to keep the default footprint small — add them back
                            via <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">config/fortify.php</code>'s
                            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">features</code> array if a project actually
                            needs them.
                        </flux:callout.text>
                    </flux:callout>
                </flux:card>
            </section>

            <section id="roles" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="shield-check" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Roles &amp; permissions</flux:heading>
                    </div>
                    <flux:text>
                        Built on <flux:link href="https://spatie.be/docs/laravel-permission" target="_blank">spatie/laravel-permission</flux:link>.
                        Every new user is assigned the <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">member</code> role
                        automatically (see <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">App\Models\User::booted()</code>).
                    </flux:text>
                    <flux:callout variant="secondary">
                        <flux:callout.heading icon="information-circle">No permissions table yet</flux:callout.heading>
                        <flux:callout.text>
                            There is no separate <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">permissions</code> table in
                            use yet — start with roles, add granular permissions only once a project actually needs them.
                        </flux:callout.text>
                    </flux:callout>
                    <flux:text>
                        Gate a route to admins with the <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">role:admin</code>
                        middleware (alias registered in <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">bootstrap/app.php</code>),
                        as <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">routes/app.php</code> already does.
                    </flux:text>
                </flux:card>
            </section>

            <section id="blog" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="newspaper" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Blog</flux:heading>
                    </div>
                    <flux:text>
                        The public blog (<code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">App\Models\Post</code>) is the one
                        piece of content that stays admin-editable without a redeploy: title, excerpt, body, a featured image,
                        and a published toggle. The slug isn't a form field at all —
                        <flux:link href="https://github.com/spatie/laravel-sluggable" target="_blank">spatie/laravel-sluggable</flux:link>
                        generates it from the title on create and never silently regenerates it on update, so published URLs stay stable.
                    </flux:text>
                    <flux:text>
                        Any signed-in, verified user manages posts from <flux:link :href="route('content-management.blogs')">/content-management/blogs</flux:link>
                        (not admin-gated — see <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">routes/app.php</code>) — one Livewire
                        component (<code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/pages/app/content-management/⚡blogs.blade.php</code>)
                        handles the list, and a single Flux modal shared by both create and edit (an <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">editingPost</code>
                        property tells the form which mode it's in). The public pages
                        (<code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">pages/main/blogs.blade.php</code> and
                        <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">blog-detail.blade.php</code>) are plain Tailwind, no Flux,
                        same as the rest of the public site — both share
                        <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/layouts/main.blade.php</code> for the
                        navbar/footer/head boilerplate.
                    </flux:text>
                </flux:card>
            </section>

            <section id="settings" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="cog-6-tooth" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Site settings</flux:heading>
                    </div>
                    <flux:text>
                        Everything else on the public site (branding, copy, images) is hardcoded directly in
                        <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/components/landing/*</code> — edit those
                        files and redeploy. The handful of values that are genuinely per-deployment config live in the
                        <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">App\Models\Setting</code> key-value store instead, editable
                        from <flux:link :href="route('system.settings')">/system/settings</flux:link>: SEO meta description, a Google
                        Analytics ID, social links, and the contact address/email/phone shown on the landing page's call-to-action.
                    </flux:text>
                </flux:card>
            </section>

            <section id="sitemap" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="map" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Sitemap</flux:heading>
                    </div>
                    <flux:text>
                        <flux:link href="https://github.com/spatie/laravel-sitemap" target="_blank">spatie/laravel-sitemap</flux:link>
                        powers the public <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">/sitemap.xml</code>
                        (<code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">MainController::sitemap()</code>), built manually rather
                        than crawled — it lists the home page, the blog index, and every published
                        <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">Post</code>, and never includes drafts or authenticated routes.
                    </flux:text>
                    <flux:text>
                        Admins can review the same list in a friendlier table at
                        <flux:link :href="route('system.sitemap')">/system/sitemap</flux:link>, with a link out to the raw XML.
                    </flux:text>
                </flux:card>
            </section>

            <section id="stack" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="cpu-chip" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Tech stack</flux:heading>
                    </div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        <div class="space-y-1.5">
                            <flux:text size="sm" class="text-zinc-500">PHP</flux:text>
                            <div><flux:badge color="indigo">8.4</flux:badge></div>
                        </div>
                        <div class="space-y-1.5">
                            <flux:text size="sm" class="text-zinc-500">Laravel</flux:text>
                            <div><flux:badge color="red">13</flux:badge></div>
                        </div>
                        <div class="space-y-1.5">
                            <flux:text size="sm" class="text-zinc-500">Auth</flux:text>
                            <div><flux:badge color="amber">Fortify</flux:badge></div>
                        </div>
                        <div class="space-y-1.5">
                            <flux:text size="sm" class="text-zinc-500">Frontend</flux:text>
                            <div><flux:badge color="sky">Livewire 4 + Flux UI</flux:badge></div>
                        </div>
                        <div class="space-y-1.5">
                            <flux:text size="sm" class="text-zinc-500">Styling</flux:text>
                            <div><flux:badge color="cyan">Tailwind v4</flux:badge></div>
                        </div>
                        <div class="space-y-1.5">
                            <flux:text size="sm" class="text-zinc-500">Roles</flux:text>
                            <div><flux:badge color="emerald">Spatie Permission</flux:badge></div>
                        </div>
                    </div>
                </flux:card>
            </section>

            <section id="quality" class="scroll-mt-24">
                <flux:card class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="beaker" class="size-5 text-zinc-400" />
                        <flux:heading size="lg">Tests &amp; quality</flux:heading>
                    </div>
                    <flux:text>Every change should pass all three before it's considered done:</flux:text>
                    <div class="space-y-2 font-mono text-sm">
                        <div class="rounded-lg bg-zinc-900 px-4 py-2.5 text-zinc-100">php artisan test --compact</div>
                        <div class="rounded-lg bg-zinc-900 px-4 py-2.5 text-zinc-100">vendor/bin/pint --dirty</div>
                        <div class="rounded-lg bg-zinc-900 px-4 py-2.5 text-zinc-100">vendor/bin/phpstan analyse</div>
                    </div>
                </flux:card>
            </section>
        </div>
    </div>
</div>
