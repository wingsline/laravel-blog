<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Wingsline\Blog\Posts\Post;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostsController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function detail(Post $post)
    {
        return view('posts.detail', compact('post'));
    }
}
