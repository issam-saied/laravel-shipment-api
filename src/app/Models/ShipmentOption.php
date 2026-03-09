<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentOption where(string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 */
class ShipmentOption extends Model
{
    protected $fillable = [
        'carrier_id',
        'package_id',
        'region_id',
        'weekends',
        'price',
    ];

    use HasFactory;

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

}
