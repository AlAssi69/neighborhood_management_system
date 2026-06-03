<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    protected $fillable = [
        'family_card_number',
        'head_person_id',
        'total_member_count',
        'notes',
    ];

    protected $casts = [
        'total_member_count' => 'integer',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'head_person_id');
    }
}
