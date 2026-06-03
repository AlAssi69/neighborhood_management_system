<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $fillable = [
        'national_id',
        'first_name',
        'father_name',
        'last_name',
        'phone',
        'family_id',
    ];

    protected static function booted(): void
    {
        // Keep referential integrity: when a person who heads a family is
        // removed, clear the family's head reference (DB also enforces this
        // via nullOnDelete, this guards in-memory/edge cases).
        static::deleting(function (Person $person): void {
            Family::where('head_person_id', $person->id)
                ->update(['head_person_id' => null]);
        });
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('relation_type')
            ->withTimestamps();
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class, 'owner_person_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ArchivedDocument::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->father_name,
            $this->last_name,
        ])));
    }
}
