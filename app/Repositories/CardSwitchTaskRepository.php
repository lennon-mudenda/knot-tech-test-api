<?php

namespace App\Repositories;

use App\Models\Status;
use App\Models\CardSwitchTask;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class CardSwitchTaskRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'uuid',
        'card_uuid',
        'previous_card_uuid',
        'merchant_uuid',
        'status_uuid',
        'user_uuid',
        'card_id',
        'previous_card_id',
        'merchant_id',
        'status_id',
        'user_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CardSwitchTask::class;
    }

    public function all(array $search = [], int $skip = null, int $limit = null, array $columns = ['*']): Collection
    {
        $search['status_uuid'] = Status::FINISHED_UUID;

        return parent::all($search, $skip, $limit, $columns);
    }
}
