<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\SeederHelper;

class UsersSeeder extends Seeder
{
    use SeederHelper;

    /**
     * @var string $model
     */
    private static $model = User::class;

    /**
     * @var array $records
     */
    private static array $records = [
        [
            'uuid' => '93073b1e-80a8-44f9-ac3f-0dfcf530e428',
            'role_uuid' => '268f472e-38de-4830-b758-c0d220070f60',
            'role_id' => 1,
            'name' => 'Lee Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => '2023-08-13 10:54:39',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ],
    ];
}
