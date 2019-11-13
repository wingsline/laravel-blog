<?php

namespace Wingsline\Blog\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Wingsline\Blog\Posts\Post;

class DashboardController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

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
