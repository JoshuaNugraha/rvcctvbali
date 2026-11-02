<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Promotion extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'sequence',
        'name',
        'slug',
        'description_eng',
        'description_ina',
        'price',
        'user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'float',
            'sequence' => 'integer',
        ];
    }

    /**
     * Register media collections for the promotion.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('promotion_image')
            ->singleFile();
    }

    /**
     * @return BelongsTo<User, Promotion>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
