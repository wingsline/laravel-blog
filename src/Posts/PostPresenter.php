<?php

namespace Wingsline\Blog\Posts;

use Illuminate\Support\Str;

trait PostPresenter
{
    public function getExcerptAttribute(): string
    {
        // If we have an external url, we return the content, since we
        // do not have a block post, we rather have a linked content
        if ($this->external_url) {
            return $this->text;
        }

        $excerpt = trim($this->text);

        // before the 1st blockquote
        $excerpt = Str::before($excerpt, '<blockquote>');

        // after the h1, since we should have only one h1 on top of the article
        $excerpt = Str::after($excerpt, '</h1>');

        // remove html
        $excerpt = strip_tags($excerpt);

        // replace multiple spaces
        $excerpt = preg_replace('/\\s+/', ' ', $excerpt);

        if (0 == \strlen($excerpt)) {
            return '';
        }

        if (\strlen($excerpt) <= 150) {
            return $excerpt;
        }

        $ww = wordwrap($excerpt, 150, "\n");

        $excerpt = substr($ww, 0, strpos($ww, "\n")).'…';

        return $excerpt;
    }

    public function getFormattedTitleAttribute(): string
    {
        $prefix = $this->original_content
            ? '★ '
            : '';

        return $prefix.$this->title;
    }

    public function getTagsTextAttribute(): string
    {
        return $this
            ->tags
            ->pluck('name')
            ->implode(', ');
    }

    public function getUrlAttribute(): string
    {
        if ($this->external_url) {
            return $this->external_url;
        }

        return route('post', $this->slug);
    }
}
