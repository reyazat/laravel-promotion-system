<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int user_id
 * @property User user
 * @property string uuid
 * @property string tracking_code
 * @property string original_amount
 * @property string amount
 * @property Carbon paid_at
 * @property string link
 * @property array info
 * @property Carbon created_at
 * @property int|mixed $promotion_id
 * @property Promotion $promotion
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'original_amount',
        'amount',
        'tracking_code',
        'paid_at',
        'link',
        'info',
        'promotion_id',
    ];

    protected $casts = [
        'user_id' => 'int',
        'original_amount' => 'string',
        'amount' => 'string',
        'info' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }
}
