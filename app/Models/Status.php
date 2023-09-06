<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Status",
 *      required={"uuid","name"},
 *      @OA\Property(
 *          property="uuid",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="deleted_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Status extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'statuses';

    const INITIATED_UUID = '98050bb7-d851-487a-8fc2-72bebc7ea6ab';
    const FINISHED_UUID = 'ec0b53c7-a8f1-4fa5-a95d-7bdd7322609c';
    const FAILED_UUID = 'ac26d157-0361-4331-8aef-2f13293e0a52';

    public $fillable = [
        'uuid',
        'name'
    ];

    protected $casts = [
        'uuid' => 'string',
        'name' => 'string'
    ];

    public static array $rules = [
        'uuid' => 'required|string|max:36',
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    protected $hidden = [
        'uuid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function cardSwitchTasks(): HasMany
    {
        return $this->hasMany(CardSwitchTask::class, 'status_id');
    }
}
