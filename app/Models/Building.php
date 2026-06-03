<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $fillable = [
        'location_id',
        'building_number',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class)->orderBy('sort_order')->orderBy('label');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
