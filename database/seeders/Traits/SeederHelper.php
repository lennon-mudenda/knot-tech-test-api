<?php

namespace Database\Seeders\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * @property string $model
 * @property array $records
 */
trait SeederHelper
{
    /**
     * @throws BindingResolutionException
     */
    public function run(): void
    {
        $model = app()->make(self::$model);

        $data = self::$records;

        foreach ($data as $datum) {
            if (!$model::where('uuid', $datum['uuid'])->exists()) {
                $model::create($datum);
            }
        }
    }
}
