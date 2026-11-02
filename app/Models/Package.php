<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'sequence',
        'name',
        'slug',
        'channel_id',
        'brands',
        'price',
        'cameras',
        'recorder_unit',
        'storage',
        'power_connectors',
        'cable',
        'service',
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
            'brands' => 'array',
            'price' => 'float',
            'sequence' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Channel, Package>
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return BelongsTo<User, Package>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
