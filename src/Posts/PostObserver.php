<?php

namespace Wingsline\Blog\Posts;

use Spatie\ResponseCache\Facades\ResponseCache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @return void
     */
    public function created(Post $post)
    {
        $this->clearResponseCache($post);
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @return void
     */
    public function deleted(Post $post)
    {
        $this->clearResponseCache($post);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @return void
     */
    public function updated(Post $post)
    {
        $this->clearResponseCache($post);
    }

    /**
     * Clears the respoonse cache.
     */
    protected function clearResponseCache(Post $post)
    {
        ResponseCache::clear();
    }
}
