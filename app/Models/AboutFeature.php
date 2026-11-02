<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutFeature extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'about_features';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'about_us_id',
        'sequence',
        'title_eng',
        'title_ina',
        'description_eng',
        'description_ina',
    ];

    /**
     * @return BelongsTo<AboutUs, AboutFeature>
     */
    public function aboutUs(): BelongsTo
    {
        return $this->belongsTo(AboutUs::class, 'about_us_id');
    }
}
