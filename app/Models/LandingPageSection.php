<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * @property int $id
 * @property string $key
 * @property array<string, mixed> $content
 * @property bool $is_visible
 */
class LandingPageSection extends Model
{
    use LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        // Deliberately not ->dontLogEmptyChanges(): the tracked attribute is just
        // is_visible (the `content` blob is excluded to keep entries readable), so
        // most real edits only touch content and would show no diff on is_visible --
        // logging empty changes is what keeps those saves from being silently skipped.
        return LogOptions::defaults()
            ->logOnly(['is_visible'])
            ->logOnlyDirty()
            ->useLogName('landing-page')
            ->setDescriptionForEvent(fn (string $eventName) => "The \"{$this->key}\" section was {$eventName}");
    }
}
