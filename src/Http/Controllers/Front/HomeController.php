<?php

namespace Wingsline\Blog\Http\Controllers\Front;

use Wingsline\Blog\Posts\Post;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
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
