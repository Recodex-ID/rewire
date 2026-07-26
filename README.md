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
| Quality | Pest 4, Pint, Larastan |

## Features

- **Authentication** — login, registration, password reset out of the box.
- **Roles & permissions** — every new user gets `member` automatically; `admin` unlocks a gated back office.
- **Blog** — the one piece of public content that's editable without a redeploy: title, excerpt, body, featured image, publish toggle, auto-generated slugs that never change on edit.
- **Admin panel** — user management (list, create, change role, delete), an audit trail of admin actions, a sitemap viewer, and site settings (SEO description, Google Analytics, social links, contact info).
- **Branded system pages** — error pages (404, 500, ...) and transactional emails match the app's look, not the framework defaults.
- **Dashboard** — real usage stats, not placeholder data.
- **In-app docs** — a `/docs` page inside the app with project-specific setup and architecture notes.
- **Tests from day one** — Pest feature tests, Pint formatting, and Larastan static analysis wired into CI.

## Getting started

Requires a running MySQL server with an empty database created ahead of time (matching `DB_DATABASE` in `.env`, `rewire` by default):

```bash
mysql -u root -e "CREATE DATABASE rewire"
```

Then:

```bash
git clone https://github.com/Recodex-ID/rewire.git
cd rewire
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
composer run dev
```

Visit `http://localhost:8000`. `composer run dev` runs the app server, queue listener, and Vite together.

### Default accounts

Seeded by `database/seeders/DatabaseSeeder.php`, password `password` for both:

| Email | Role |
|---|---|
| `admin@recodex.id` | admin |
| `member@recodex.id` | member |

## Quality checks

```bash
php artisan test --compact
vendor/bin/pint --dirty
vendor/bin/phpstan analyse
```

Or `composer test`, which runs formatting, static analysis, and the full suite together — the same thing CI runs on every push.

## Reusing this for a new project

1. Update `APP_NAME` and other `.env` values for the new project.
2. Swap the brand palette in `resources/css/app.css` (`--color-brand-*`) and the logo mark in `resources/views/components/landing/icon.blade.php`.
3. Replace the seeded accounts (`database/seeders/UserSeeder.php`) and the landing page copy, which is hardcoded directly in `resources/views/components/landing/*`.
4. Update `composer.json`'s `name`/`description` if the repo is being renamed too.

More detail — architecture notes, where each feature lives, how to extend the landing page — is in the in-app docs at `/docs` once you're logged in.

## License

MIT.
