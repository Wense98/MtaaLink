<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Elderly Care (Huduma kwa Wazee)',
            'Child Care (Malezi ya Watoto)',
            'Home Cleaning (Usafi wa Nyumbani)',
            'Community Cleaning (Usafi wa Jamii)',
            'Plumbing (Fundi Bomba)',
            'Electrical (Fundi Umeme)',
            'Tutoring (Masomo ya Ziada)',
            'Counseling (Ushauri Nasaha)',
            'Nursing / First Aid (Huduma ya Kwanza)',
            'Masonry / Construction (Ujenzi)',
            'Farm Help (Msaidizi wa Shamba)',
            'Security / Guarding (Ulinzi)',
            'Laundry (Ufuaji)',
        ];

        foreach ($services as $name) {
            Service::updateOrCreate([
                'slug' => \Str::slug($name)
            ], [
                'name' => $name,
                'description' => null,
            ]);
        }
    }
}
