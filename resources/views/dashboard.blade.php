@extends('blog::layouts.master')

@section('content')

    @include("blog::layouts.partials.flash")

    {{-- latests posts --}}
    @include('blog::posts.partials.header', ['title' => 'Latest Posts', 'description' => 'Latest blog posts sorted by publish date.'])

    <ol class="my-8">
        @include('blog::posts.partials.list-header')
        @forelse ($latest_posts as $post)
            @include('blog::posts.partials.item', compact('post'))
        @empty
            <li>
                <p class="text-xs text-gray-800 text-center italic">
                    There are no posts. <a
                        href="{{ route('admin.posts.create') }}">Create
                        one</a>.
                </p>
            </li>

        @endforelse
    </ol>
    @include('blog::posts.partials.legend')
@endsection
