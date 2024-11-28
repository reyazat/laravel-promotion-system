<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property integer id
 * @property string name
 * @property string code
 * @property boolean is_available
 * @property array avb_days
 * @property boolean have_times
 * @property array times
 * @property array discount
 * @property array usage_limit
 * @property integer limit_num
 * @property boolean have_dates
 * @property array dates
 * @property mixed usage_count
 * @property Carbon created_at
 */
class Promotion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'is_available',
        'avb_days',
        'have_times',
        'times',
        'discount',
        'usage_limit',
        'limit_num',
        'have_dates',
        'dates',
        'usage_count'
    ];

    protected $casts = [
        'avb_days' => 'array',
        'times' => 'array',
        'discount' => 'array',
        'usage_limit' => 'array',
        'dates' => 'array',
    ];

    public static function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
            $code = Str::upper($code);
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($promotion) {
            if (empty($promotion->code)) {
                $promotion->code = self::generateUniqueCode();
            }
        });
    }
}
