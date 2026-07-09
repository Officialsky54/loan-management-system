<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\EmailTemplate;
use App\Models\WebsiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WebsiteSettingSeeder::class,
            EmailTemplateSeeder::class,
            UserSeeder::class,
        ]);
    }
}
