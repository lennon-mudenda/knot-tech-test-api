<?php

namespace App\Repositories;

use App\Models\Status;
use App\Models\CardSwitchTask;
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

        $search['user_id'] = auth()->user()->getAuthIdentifier();

        $query = $this->allQuery($search, $skip, $limit);

        $query->join('merchants as m', 'card_switch_tasks.merchant_id', '=', 'm.id');

        $query->join('cards as c', 'card_switch_tasks.card_id', '=', 'c.id');

        $query->join('statuses as s', 'card_switch_tasks.status_id', '=', 's.id');

        $columns = [
            'card_switch_tasks.id',
            'card_switch_tasks.card_id',
            'card_switch_tasks.merchant_id',
            'card_switch_tasks.user_id',
            'card_switch_tasks.status_id',
            's.name as status',
            'm.name as merchant_name',
            'c.number as card_number',
            'c.cvv as card_cvv',
            'c.expiry as card_expiry',
            'card_switch_tasks.updated_at',
            'card_switch_tasks.deleted_at'
        ];

        return $query->get($columns);
    }
}
