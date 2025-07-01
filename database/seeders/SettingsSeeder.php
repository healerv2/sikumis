<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $settings = Settings::create([
            'nama_aplikasi'     => 'sikumis',
            'path_logo'         => 'logo.png',
        ]);
    }
}
