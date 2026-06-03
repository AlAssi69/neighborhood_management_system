<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ArchivedDocument extends Model
{
    protected $fillable = [
        'person_id',
        'document_type',
        'title',
        'file_path',
    ];

    protected static function booted(): void
    {
        // Remove the physical file when the record is deleted to avoid orphans.
        static::deleting(function (ArchivedDocument $document): void {
            if ($document->file_path && Storage::disk('documents')->exists($document->file_path)) {
                Storage::disk('documents')->delete($document->file_path);
            }
        });
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
