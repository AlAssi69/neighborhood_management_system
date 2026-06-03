<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = [
        'property_number',
        'real_estate_area_id',
        'detailed_address',
        'location_id',
        'building_id',
        'floor_id',
    ];

    public function realEstateArea(): BelongsTo
    {
        return $this->belongsTo(RealEstateArea::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
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

    /**
     * Eager-load relations needed to compute the formatted residential address.
     */
    public function scopeWithResidentialAddress(Builder $query): Builder
    {
        return $query->with(['location.parent.parent', 'building', 'floor']);
    }

    /**
     * منطقة السكن, رقم البناء, الطابق, عنوان تفصيلي
     */
    protected function fullResidentialAddress(): Attribute
    {
        return Attribute::get(function (): string {
            $parts = array_filter([
                $this->location?->full_path,
                $this->building?->building_number,
                $this->floor?->label,
                $this->detailed_address,
            ], fn ($part) => filled($part));

            return implode(', ', $parts);
        });
    }
}
