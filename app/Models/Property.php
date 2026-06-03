<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = [
        'property_number',
        'real_estate_area',
        'floor_number',
        'detailed_address',
        'location_id',
    ];

    protected $casts = [
        'floor_number' => 'integer',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function residents(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)
            ->withPivot('relation_type')
            ->withTimestamps();
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
