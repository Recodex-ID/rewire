<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property int|null $author_id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $body
 * @property string|null $featured_image
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, HasSlug, LogsActivity;

    protected $fillable = ['author_id', 'title', 'slug', 'excerpt', 'body', 'featured_image', 'is_published'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function getSlugOptions(): SlugOptions
    {
        // Generated from the title on create only -- regenerating on every title edit
        // would silently change the post's public URL and break existing links, so an
        // admin who wants to change the slug after creation edits it explicitly instead.
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getActivitylogOptions(): LogOptions
    {
        // Deliberately not ->dontLogEmptyChanges(): only is_published is tracked (title/
        // excerpt/body are excluded to keep entries readable), so most real edits touch
        // those fields without touching is_published -- logging empty changes is what
        // keeps those saves from being silently skipped.
        return LogOptions::defaults()
            ->logOnly(['is_published'])
            ->logOnlyDirty()
            ->useLogName('blog')
            ->setDescriptionForEvent(fn (string $eventName) => "The post \"{$this->title}\" was {$eventName}");
    }
}
