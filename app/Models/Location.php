<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    /**
     * All locations keyed by id with full path labels (for select dropdowns).
     *
     * @return array<int, string>
     */
    public static function optionsWithFullPath(): array
    {
        $all = static::query()->orderBy('name')->get(['id', 'name', 'parent_id']);
        $byId = $all->keyBy('id');
        $options = [];

        foreach ($all as $location) {
            $segments = [];
            $node = $location;

            while ($node) {
                array_unshift($segments, $node->name);
                $node = $node->parent_id ? $byId->get($node->parent_id) : null;
            }

            $options[$location->id] = implode(' / ', $segments);
        }

        return $options;
    }

    /**
     * IDs of the given location plus all of its descendants.
     *
     * @return array<int, int>
     */
    public static function subtreeIds(int $rootId): array
    {
        $byParent = static::query()
            ->get(['id', 'parent_id'])
            ->groupBy('parent_id');

        $ids = [];
        $stack = [$rootId];

        while ($stack) {
            $id = array_pop($stack);
            $ids[] = $id;

            foreach ($byParent->get($id, collect()) as $child) {
                $stack[] = $child->id;
            }
        }

        return $ids;
    }

    /**
     * Full hierarchical path, e.g. "Main Area / Sub Area / Block".
     */
    public function getFullPathAttribute(): string
    {
        $segments = [$this->name];
        $node = $this->parent;

        while ($node) {
            array_unshift($segments, $node->name);
            $node = $node->parent;
        }

        return implode(' / ', $segments);
    }
}
