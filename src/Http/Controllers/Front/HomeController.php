<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Wingsline\Blog\Posts\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HomeController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __invoke()
    {
        /** @var Paginator $posts */
        $posts = Post::published()
            ->public()
            ->orderBy('publish_date', 'desc')
            ->simplePaginate(20);

        $onFirstPage = $posts->onFirstPage();

        return view('home.index', compact('posts', 'onFirstPage'));
    }
}
