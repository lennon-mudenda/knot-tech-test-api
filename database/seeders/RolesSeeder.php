<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\SeederHelper;

class RolesSeeder extends Seeder
{
    use SeederHelper;

    /**
     * @var string $model
     */
    private static $model = Role::class;

    /**
     * @var array $records
     */
    private static array $records = [
        [
            'uuid' => '268f472e-38de-4830-b758-c0d220070f60',
            'name' => 'admin',
        ],
        [
            'uuid' => 'ced75453-a388-495f-b860-606abed1cb59',
            'name' => 'user',
        ],
    ];
}
