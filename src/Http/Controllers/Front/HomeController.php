<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Wingsline\Blog\Posts\Post;

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
