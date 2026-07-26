<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property array<string, mixed> $content
 * @property bool $is_visible
 */
class LandingPageSection extends Model
{
    protected $fillable = ['key', 'content', 'is_visible'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    /**
     * @param  Builder<LandingPageSection>  $query
     * @return Builder<LandingPageSection>
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }
}
