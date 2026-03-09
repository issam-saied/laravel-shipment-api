<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|Country where(string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 */
class Country extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'region_id'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
