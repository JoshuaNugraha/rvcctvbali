<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutUs extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'about_us';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'sub_title_eng',
        'sub_title_ina',
        'headline_eng',
        'headline_ina',
        'description_eng',
        'description_ina',
        'user_id',
    ];

    /**
     * Backward-compatible alias accessor for sub_title.
     */
    public function getSubTitleAttribute(): ?string
    {
        return $this->sub_title_eng ?: $this->sub_title_ina;
    }

    /**
     * Backward-compatible alias mutator for sub_title.
     */
    public function setSubTitleAttribute(?string $value): void
    {
        $this->attributes['sub_title_eng'] = $value;
    }

    /**
     * Alias accessor for heading_eng.
     */
    public function getHeadingEngAttribute(): ?string
    {
        return $this->headline_eng;
    }

    /**
     * Alias mutator for heading_eng.
     */
    public function setHeadingEngAttribute(?string $value): void
    {
        $this->attributes['headline_eng'] = $value;
    }

    /**
     * Alias accessor for heading_ina.
     */
    public function getHeadingInaAttribute(): ?string
    {
        return $this->headline_ina;
    }

    /**
     * Alias mutator for heading_ina.
     */
    public function setHeadingInaAttribute(?string $value): void
    {
        $this->attributes['headline_ina'] = $value;
    }

    /**
     * Register media collections for the About Us record.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('about_image')
            ->singleFile();
    }

    /**
     * @return BelongsTo<User, AboutUs>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<AboutFeature>
     */
    public function features(): HasMany
    {
        return $this->hasMany(AboutFeature::class, 'about_us_id')->orderBy('sequence');
    }
}
