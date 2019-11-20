<?php

namespace Wingsline\Blog\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Wingsline\Blog\Http\Requests\ImageUploadRequest;
use Wingsline\Blog\Http\Requests\PostRequest;
use Wingsline\Blog\Posts\Post;

class PostsController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $post = new Post();

        $post->publish_date = now();

        return view('blog::posts.create', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     *
     */
    public function destroy(Post $post)
    {
        $post->delete();

        flash()->success('Post deleted.');

        return redirect()->route('admin.posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Post $post)
    {
        return view('blog::posts.edit', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::orderBy('publish_date',
            'desc')->paginate(config('blog.per_page'));

        return view('blog::posts.index', compact('posts'));
    }

    /**
     * Generates a markdown preview for the post.
     *
     * @return array
     */
    public function preview(Post $post)
    {
        $post->text = request('payload', '');

        return ['data' => ['html' => $post->text]];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {
        $post = (new Post())->updateAttributes($request->validated());

        flash()->success('Post saved.');

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->updateAttributes($request->validated());

        flash()->success('Post updated.');

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Upload an image.
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function upload(Post $post, ImageUploadRequest $request)
    {
        try {
            $media = $post->addMedia($request->file('image'))
                ->toMediaCollection('images');
        } catch (FileCannotBeAdded $exception) {
            return response()->json(['error' => $exception->getMessage()], 422);
        }

        return [
            'data' => [
                'filePath' => ltrim(
                    parse_url($media->getFullUrl(),
                    PHP_URL_PATH),
                    '/'
                )
            ],
        ];
    }
}
