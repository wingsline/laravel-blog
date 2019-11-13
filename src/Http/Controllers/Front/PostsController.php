<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Wingsline\Blog\Posts\Post;

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
