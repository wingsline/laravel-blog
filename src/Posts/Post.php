<?php

namespace Wingsline\Blog\Posts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Wingsline\Blog\Markdown\Markdown;

class Post extends Model implements Feedable, HasMedia
{
    use HasSlug;
    use HasTags;
    use InteractsWithMedia;
    use PostPresenter;

    public $casts = [
        'text' => '',
        'published' => 'boolean',
        'original_content' => 'boolean',
    ];

    public $dates = ['publish_date'];
    public $with = ['tags'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    public static function getFeedItems()
    {
        return static::published()
            ->public()
            ->orderBy('publish_date', 'desc')
            ->limit(100)
            ->get();
    }

    /**
     * Markdown accessor.
     *
     * @return string
     */
    public function getMarkdownAttribute()
    {
        return $this->getRawOriginal('text');
    }

    /**
     * Slug options.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Text accessor.
     *
     * @param string $original
     *
     * @return string
     */
    public function getTextAttribute($original)
    {
        return Markdown::convertWithParser($original);
    }

    public function scopePublic(Builder $query)
    {
        $query->where('publish_date', '<=', now());
    }

    public function scopePublished(Builder $query)
    {
        $query->where('published', true);
    }

    /**
     * @return array|\Spatie\Feed\FeedItem
     */
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->formatted_title)
            ->summary($this->text)
            ->updated($this->publish_date)
            ->link($this->url)
            ->author($this->author);
    }

    /**
     * Update model attributes from the form.
     *
     * @return static
     */
    public function updateAttributes(array $attributes)
    {
        $this->title = $attributes['title'];
        $this->text = $attributes['text'];
        $this->publish_date = $attributes['publish_date'];
        $this->published = $attributes['published'] ?? false;
        $this->original_content = $attributes['original_content'] ?? false;
        $this->external_url = $attributes['external_url'];
        $this->author = Auth::user()->name;

        $this->save();

        if ($attributes['tags_text']) {
            $tags = array_map(function (string $tag) {
                return trim(strtolower($tag));
            }, explode(',', $attributes['tags_text']));

            $this->syncTags($tags);
        }

        return $this;
    }
}
