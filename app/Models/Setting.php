<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 */
class Setting extends Model
{
    use LogsActivity;

    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return self::cached()[$key] ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::forget('settings');
    }

    /**
     * Cached as a plain array, not a Collection -- Laravel's default cache config
     * (config/cache.php: serializable_classes => false) refuses to unserialize
     * objects from cache, so caching an Eloquent Collection silently comes back
     * as __PHP_Incomplete_Class. Arrays are unaffected by that restriction.
     *
     * @return array<string, string|null>
     */
    private static function cached(): array
    {
        return Cache::rememberForever('settings', fn () => static::query()->pluck('value', 'key')->all());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['key', 'value'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('settings')
            ->setDescriptionForEvent(fn (string $eventName) => "Setting \"{$this->key}\" was {$eventName}");
    }
}
