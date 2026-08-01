<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::query()->where('email', 'admin@mail.test')->first();

        Post::create([
            'author_id' => $author?->id,
            'title' => 'Welcome to Rewire Starter Kit',
            'excerpt' => 'A quick tour of what ships out of the box: auth, roles, a blog, and a back office ready to go.',
            'body' => "Rewire Starter Kit exists so a new client project doesn't start from a blank repo. Authentication, roles, a publishable blog, and an admin panel with user management, an audit trail, and site settings are all wired up on day one.\n\nThis post itself is a good example -- it's stored in the database and editable from the admin panel, unlike the rest of the public site, which is hardcoded and redeployed when it changes.",
            'is_published' => true,
        ]);

        Post::create([
            'author_id' => $author?->id,
            'title' => 'Five packages doing the heavy lifting',
            'excerpt' => 'Fortify, Livewire, Flux UI, Spatie Permission, and Spatie Activitylog -- what each one is actually responsible for.',
            'body' => "Laravel Fortify handles authentication (login, registration, password reset, email verification) without locking the app into any particular frontend.\n\nLivewire 4 and Flux UI power every authenticated page -- the dashboard, the blog editor, user management -- so almost none of it needed hand-written JavaScript.\n\nspatie/laravel-permission gives every new user a staff role automatically, with admin and super-admin unlocking more of the back office.\n\nspatie/laravel-activitylog records what actually happened: who created a post, who changed a role, who logged in. It's the audit trail behind /super-admin/activity.\n\nspatie/laravel-sluggable generates this post's URL from its title once, and never touches it again after that -- so editing a title later never breaks a link someone already bookmarked.",
            'is_published' => true,
        ]);

        Post::create([
            'author_id' => $author?->id,
            'title' => 'Drafting the next announcement',
            'excerpt' => 'This one is still a draft -- it only shows up in the admin blog list, not on the public site.',
            'body' => "Unpublished posts like this one are exactly what the published() query scope filters out on the public /blog pages. Flip the switch in the editor when it's ready to go out.",
            'is_published' => false,
        ]);
    }
}
