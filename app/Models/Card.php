<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Card",
 *      required={"uuid","number","cvv","expiry"},
 *      @OA\Property(
 *          property="uuid",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="number",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="cvv",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="expiry",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date"
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
class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'cards';

    public $fillable = [
        'uuid',
        'number',
        'cvv',
        'expiry'
    ];

    protected $casts = [
        'uuid' => 'string',
        'number' => 'string',
        'cvv' => 'string',
        'expiry' => 'date'
    ];

    public static array $rules = [
        'number' => 'required|string|size:16',
        'cvv' => 'required|string|size:3',
        'expiry' => 'required',
    ];

    public function cardSwitchTasks(): HasMany
    {
        return $this->hasMany(CardSwitchTask::class, 'card_id');
    }
}
