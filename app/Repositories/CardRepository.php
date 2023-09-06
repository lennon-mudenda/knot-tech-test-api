<?php

namespace App\Repositories;

use App\Models\Card;
use App\Repositories\BaseRepository;

class CardRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'uuid',
        'number',
        'cvv',
        'expiry'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Card::class;
    }
}
