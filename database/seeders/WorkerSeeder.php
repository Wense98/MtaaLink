<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkerProfile;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = [
            [
                'name' => 'Juma Mtoto - TV Repair',
                'email' => 'juma@example.com',
                'phone' => '+255700000001',
                'service_id' => 1,
                'region' => 'Dar es Salaam',
                'district' => 'Ilala',
                'ward' => 'Upanga',
                'street' => 'Sample Street',
                'experience_years' => 5,
                'latitude' => -6.8000000,
                'longitude' => 39.2850000,
            ],
            [
                'name' => 'Ali Hassan - Electrician',
                'email' => 'ali@example.com',
                'phone' => '+255700000002',
                'service_id' => 6,
                'region' => 'Dar es Salaam',
                'district' => 'Kinondoni',
                'ward' => 'Makuburi',
                'street' => 'Main Road',
                'experience_years' => 8,
                'latitude' => -6.7500000,
                'longitude' => 39.2200000,
            ],
            [
                'name' => 'Maria Mwangi - Cleaning',
                'email' => 'maria@example.com',
                'phone' => '+255700000003',
                'service_id' => 5,
                'region' => 'Dar es Salaam',
                'district' => 'Temeke',
                'ward' => 'Chalinze',
                'street' => 'Park Avenue',
                'experience_years' => 3,
                'latitude' => -6.9000000,
                'longitude' => 39.3000000,
            ],
        ];

        foreach ($workers as $data) {
            $service_id = $data['service_id'];
            unset($data['service_id']);

            $user = User::create([
                ...$data,
                'password' => bcrypt('password'),
                'role' => User::ROLE_WORKER,
                'is_verified' => true,
            ]);

            WorkerProfile::create([
                'user_id' => $user->id,
                'service_id' => $service_id,
                'region' => $data['region'],
                'district' => $data['district'],
                'ward' => $data['ward'],
                'street' => $data['street'],
                'experience_years' => $data['experience_years'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
        }
    }
}
