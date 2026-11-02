<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PastProject extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'sequence',
        'title',
        'sub_title',
        'slug',
        'description_eng',
        'description_ina',
        'user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sequence' => 'integer',
        ];
    }

    /**
     * Register media collections for the past project.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_image')
            ->singleFile();
    }

    /**
     * @return BelongsTo<User, PastProject>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
