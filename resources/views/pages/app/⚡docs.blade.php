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
        <flux:link href="#blog" class="text-sm">Blog</flux:link>
        <flux:link href="#settings" class="text-sm">Site settings</flux:link>
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
            The public landing page lives at <flux:link :href="route('home')">/</flux:link>, the blog at
            <flux:link :href="route('blogs')">/blog</flux:link>, and this dashboard at
            <flux:link :href="route('dashboard')">/dashboard</flux:link>. Any signed-in, verified user sees the
            "Content Management" section in the sidebar (Blog); signing in as an admin additionally unlocks the
            "Admin" section (Settings, Users, Activity log).
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

    <section id="blog" class="space-y-4">
        <flux:heading size="lg">Blog</flux:heading>
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
    </section>

    <flux:separator />

    <section id="settings" class="space-y-4">
        <flux:heading size="lg">Site settings</flux:heading>
        <flux:text>
            Everything else on the public site (branding, copy, images) is hardcoded directly in
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">resources/views/components/landing/*</code> — edit those
            files and redeploy. The handful of values that are genuinely per-deployment config live in the
            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-sm">App\Models\Setting</code> key-value store instead, editable
            from <flux:link :href="route('admin.settings')">/admin/settings</flux:link>: SEO meta description, a Google
            Analytics ID, social links, and the contact address/email/phone shown on the landing page's call-to-action.
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
