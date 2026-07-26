<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

test('get returns the default when a setting does not exist', function () {
    expect(Setting::get('does_not_exist', 'fallback'))->toBe('fallback');
});

test('put stores a setting and get reflects it immediately', function () {
    Setting::put('site_tagline', 'Ship faster');

    expect(Setting::get('site_tagline'))->toBe('Ship faster');

    $this->assertDatabaseHas('settings', [
        'key' => 'site_tagline',
        'value' => 'Ship faster',
    ]);
});

test('put overwrites an existing setting and invalidates the cache', function () {
    Setting::put('site_tagline', 'First');
    expect(Setting::get('site_tagline'))->toBe('First');

    Setting::put('site_tagline', 'Second');
    expect(Setting::get('site_tagline'))->toBe('Second');
});

test('get survives a real serialize/unserialize round trip through the database cache store', function () {
    // The default "array" cache store used in tests holds values in memory without ever
    // serializing them, so it can't catch bugs where a cached value fails to survive
    // Laravel's config('cache.serializable_classes') restriction on unserialize(). Force
    // the real "database" store here to exercise that round trip.
    config(['cache.default' => 'database']);
    Cache::forget('settings');

    Setting::put('site_tagline', 'Ship faster');

    expect(Setting::get('site_tagline'))->toBe('Ship faster');
});
