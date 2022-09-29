<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Field extends Model
{
    use HasFactory;
    use HasSlug;

    public static array $types = [
            'string' => 'Text',
            'text' => 'Long Text',
            'number' => 'Number',
            'date' => 'Date',
            'file' => 'File',
        ];

    protected $fillable = [
        'name',
        'type',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
