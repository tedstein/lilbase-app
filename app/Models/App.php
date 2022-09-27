<?php

namespace App\Models;

use App\Events\AppCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class App extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
    ];

    protected $dispatchesEvents = [
        'created' => AppCreated::class,
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

    public function fields(): HasManyThrough
    {
        return $this->hasManyThrough(Field::class, Table::class);
    }

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
