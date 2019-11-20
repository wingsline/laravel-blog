@extends('blog::layouts.master')

@section('content')
    @include('blog::posts.partials.header', ['title' => 'Posts', 'description' => 'Blog posts sorted by publish date.'])

    @include("blog::layouts.partials.flash")

    {{-- posts --}}

    <ol class="mt-8">
        @include('blog::posts.partials.list-header')
        @forelse ($posts as $post)
            @include('blog::posts.partials.item', compact('post'))
        @empty
            <li>
                <p class="text-xs text-gray-800 text-center italic">
                    There are no posts. <a
                        href="{{ route('admin.posts.create') }}">Create one</a>.
                </p>
            </li>

        @endforelse
    </ol>
    {{ $posts->onEachSide(1)->links('blog::layouts.partials.pagination') }}

    <div class="mt-8">
        @include('blog::posts.partials.legend')
    </div>
@endsection
