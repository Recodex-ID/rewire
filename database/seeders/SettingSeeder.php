<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // No phone number on purpose: a made-up one would show on the public site. Set a real one in System > Settings.
        Setting::put('contact_address', 'Jakarta, Indonesia');
        Setting::put('contact_email', 'hello@recodex.id');
    }
}
