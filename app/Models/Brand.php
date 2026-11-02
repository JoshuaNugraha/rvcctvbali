<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'picture',
        'user_id',
    ];

    /**
     * Register media collections for the brand.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brand_logo')
            ->singleFile();
    }

    /**
     * @return BelongsTo<User, Brand>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
