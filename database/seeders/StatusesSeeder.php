<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\SeederHelper;

class StatusesSeeder extends Seeder
{
    use SeederHelper;

    /**
     * @var string $model
     */
    private static $model = Status::class;

    /**
     * @var array $records
     */
    private static array $records = [
        [
            'uuid' => '98050bb7-d851-487a-8fc2-72bebc7ea6ab',
            'name' => 'Initiated',
        ],
        [
            'uuid' => 'ec0b53c7-a8f1-4fa5-a95d-7bdd7322609c',
            'name' => 'Finished',
        ],
        [
            'uuid' => 'ac26d157-0361-4331-8aef-2f13293e0a52',
            'name' => 'Failed',
        ]
    ];
}
