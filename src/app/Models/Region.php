<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|Region where(string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 */
class Region extends Model
{
    protected $fillable = ['code', 'name'];

    use HasFactory;

    public function options(): HasMany
    {
        return $this->hasMany(ShipmentOption::class);
    }
}
