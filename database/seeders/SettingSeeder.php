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
        Setting::put('contact_address', 'Jakarta, Indonesia');
        Setting::put('contact_email', 'hello@recodex.id');
        Setting::put('contact_phone', '+62 21 0000 0000');
    }
}
