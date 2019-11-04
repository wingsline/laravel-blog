<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Spatie\Tags\Tag;
use Wingsline\Blog\Posts\Post;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaggedPostsController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __invoke(Tag $tag)
    {
        $posts = Post::published()
            ->public()
            ->orderBy('publish_date', 'desc')
            ->withAllTags([$tag])
            ->simplePaginate(50);

        return view('taggedPosts.index', compact('tag', 'posts'));
    }
}
