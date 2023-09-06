<?php

namespace App\Repositories;

use App\Models\Merchant;
use App\Repositories\BaseRepository;

class MerchantRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'uuid',
        'name',
        'website'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Merchant::class;
    }
}
