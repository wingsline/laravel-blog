<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Spatie\Tags\Tag;
use App\Http\Controllers\Controller;
use Wingsline\Blog\Posts\Post;

class TaggedPostsController extends Controller
{
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
