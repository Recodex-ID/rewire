# Rewire Starter Kit

A reusable Laravel starter kit for internal and client projects — authentication, roles, a blog, and a back office ready to go, so every new engagement starts from a working foundation instead of a blank repo.

## Stack

| | |
|---|---|
| PHP | 8.4 |
| Laravel | 13 |
| Auth | Fortify (login, registration, password reset — no 2FA/passkeys) |
| Frontend | Livewire 4 + Flux UI |
| Styling | Tailwind CSS v4 |
| Roles | Spatie Permission |
| Media | Spatie Media Library |
| Quality | Pest 4, Pint, Larastan |

## Features

- **Authentication** — login, registration, password reset out of the box; logging out always lands back on the login page.
- **Roles & permissions** — every new user gets `staff` automatically; `admin` and `super-admin` unlock more of the back office. Built on `spatie/laravel-permission`; new roles/permissions are created via tinker or a seeder, there's no in-app UI for it.
- **Blog** — the one piece of public content that's editable without a redeploy: title, excerpt, body, featured image, publish toggle, auto-generated slugs that never change on edit. The featured image runs on Spatie Media Library, with `thumb`/`card`/`hero` conversions generated automatically and a reusable `<x-media-upload>` component ready for other models.
- **System panel** (`admin`/`super-admin`) — user management (list, create, change role, delete), a sitemap viewer, a media library (browse and delete any uploaded file across models), and site settings (SEO description, Google Analytics, social links, contact info). Super admins alone additionally get the audit trail of admin actions.
- **Per-role dashboard** — a thin dashboard shell dispatches to a self-contained Livewire component per role (super-admin, admin, staff), each showing the stats relevant to that role.
- **Branded system pages** — error pages (404, 500, ...) and transactional emails match the app's look, not the framework defaults.
- **In-app docs** — a docs page inside the app with project-specific setup and architecture notes.
- **Launch checklist built in** — Privacy Policy and Terms of Service pages (`/privacy`, `/terms`), a cookie consent banner that keeps Google Analytics off until the visitor accepts, per-page meta titles and descriptions with canonical URLs and Open Graph/X preview tags (a default 1200×630 preview image ships in `public/images/og-default.png`), a sitemap and a dynamic `robots.txt`, `noindex` on every signed-in and auth screen, honeypot plus rate limiting on the register and forgot-password forms, baseline security headers, and HTTPS enforcement in production. Chart.js loads only on the dashboards, and blog images are converted to WebP.
- **Tests from day one** — Pest feature tests, Pint formatting, and Larastan static analysis wired into CI.

## Getting started

Uses SQLite by default — no separate database server to set up first.

Starting a brand new project, via the [Laravel installer](https://packagist.org/packages/recodex-id/rewire):

```bash
laravel new my-app --using=recodex-id/rewire
```

Or clone it directly:

```bash
git clone https://github.com/Recodex-ID/rewire.git
cd rewire
composer install
npm install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
composer run dev
```

Visit `http://localhost:8000`. `composer run dev` runs the app server, queue listener, and Vite together.

### Default accounts

Seeded by `database/seeders/DatabaseSeeder.php`, password `password` for all three:

| Email | Role |
|---|---|
| `super-admin@mail.test` | super-admin |
| `admin@mail.test` | admin |
| `staff@mail.test` | staff |

## Quality checks

```bash
php artisan test --compact
vendor/bin/pint --dirty
vendor/bin/phpstan analyse
```

Or `composer test`, which runs formatting, static analysis, and the full suite together — the same thing CI runs on every push.

## Reusing this for a new project

1. Update `APP_NAME` and other `.env` values for the new project.
2. Swap the brand palette in `resources/css/app.css` (`--color-brand-*`) and the logo mark in `public/images/logo.png` (256×256 is plenty; it is shown at 36 to 44 px). Regenerate `public/images/og-default.png` (1200×630) and the `public/favicon*` files to match.
3. Replace the seeded accounts (`database/seeders/UserSeeder.php`) and the landing page copy, which lives directly in `resources/views/pages/main/index.blade.php` and `resources/views/layouts/main.blade.php` (no separate landing components).
4. **Rewrite the legal pages for your own business.** `resources/views/pages/main/privacy.blade.php` and `terms.blade.php` describe this deployment, name PT Reka Mitra Teknologi as the responsible party, and carry the date they were last reviewed. Change the company details, check every statement against what your fork actually collects, and have a lawyer review them (add a governing-law clause if you need one). The footer credit line ("Built by Recodex ID") is in `layouts/main.blade.php`.
5. Update `composer.json`'s `name`/`description` if the repo is being renamed too.

### Going to production

| Setting | What it does |
|---|---|
| `APP_ENV=production`, `APP_DEBUG=false` | Turns on HTTPS enforcement and keeps stack traces off the public site. |
| `FORCE_HTTPS` | Defaults to `true` in production. Redirects http to https, generates https URLs, sends the HSTS header and marks the session cookie secure. The `/up` health check is exempt. |
| `TRUSTED_PROXIES` | Set to your load balancer's IPs (comma separated), or `*` if a proxy you control terminates TLS. Without it, the redirect cannot see the original scheme behind a proxy. |
| Scheduler | Add `* * * * * php /path/to/artisan schedule:run` to cron. It runs `activitylog:clean` daily, which enforces the 365 day audit-log retention the privacy policy promises. |
| Contact details | Fill in the contact address, email and phone in **System → Settings**. Empty fields are hidden on the site instead of showing placeholders. |
| Google Analytics | Optional. Enter a `G-XXXXXXXXXX` measurement ID in **System → Settings**. The script only loads after a visitor accepts the cookie banner. |

Nothing sensitive reaches the browser: the only `VITE_` variable is the app name, and the GA measurement ID is public by design. The security headers do not include a `Content-Security-Policy`, because Livewire, Alpine and the analytics snippet use inline scripts, so write one for your own deployment if you need it. Also remember that the `WebP` conversions only apply to images uploaded after this change; run `php artisan media-library:regenerate` to convert older ones.

More detail — architecture notes, where each feature lives, how to extend the landing page — is in the in-app docs at `/docs` once you're logged in.

## Contributing

Commits to `main` must follow [Conventional Commits](https://www.conventionalcommits.org/) (`feat:`, `fix:`, `chore:`, ...) — [release-please](https://github.com/googleapis/release-please) reads them to version and publish [GitHub Releases](https://github.com/Recodex-ID/rewire/releases) automatically, so every merge shows up in a changelog users can actually read. `feat:` bumps a minor version, `fix:` a patch, and `feat!:`/a `BREAKING CHANGE:` footer bumps major.

## License

MIT.
