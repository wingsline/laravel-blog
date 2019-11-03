<?php

namespace Wingsline\Blog\Posts;

use Spatie\Tags\HasTags;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Michelf\MarkdownExtra;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements Feedable, HasMedia
{
    use HasMediaTrait;
    use HasSlug;
    use HasTags;
    use PostPresenter;

    public $casts = [
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

    public static function boot()
    {
        parent::boot();
        static::saved(function (self $post) {
            if ($post->published) {
//                static::withoutEvents(function () use ($post) {
//                    (new PublishPostAction())->execute($post);
//                });
                Cache::tags(config('responsecache.cache_tag'))->flush();
            }
        });
    }

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
        return $this->getOriginal('text');
    }

    /**
     * Slug options.
     *
     * @return SlugOptions
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
        return MarkdownExtra::defaultTransform($original);
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
     * @param array $attributes
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
