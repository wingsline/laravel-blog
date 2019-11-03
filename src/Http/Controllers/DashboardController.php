<?php

namespace Wingsline\Blog\Http\Controllers;

use Wingsline\Blog\Posts\Post;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $latest_posts = Post::orderBy('publish_date', 'desc')->limit(10)->get();

        return view('blog::dashboard', compact('latest_posts'));
    }
}
