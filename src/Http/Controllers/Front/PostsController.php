<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Wingsline\Blog\Posts\Post;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function detail(Post $post)
    {
        return view('posts.detail', compact('post'));
    }
}
