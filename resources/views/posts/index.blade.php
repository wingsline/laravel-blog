@extends('blog::layouts.master')

@section('content')
    @include("blog::layouts.partials.header")

    @include("blog::layouts.partials.flash")

    {{-- posts --}}
    <div class="container">
        <div class="flex justify-between items-center px-3 sm:px-0">
            <h1 class="text-xl text-gray-500 my-4">{{ __('Posts') }}</h1>
            <a href="{{ route('admin.posts.create') }}" class="btn flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>New Post</span>
            </a>
        </div>
        <ol>
            @include('blog::posts.partials.header')
            @forelse ($posts as $post)
                @include('blog::posts.partials.item', compact('post'))
            @empty
                <li>
                    <p class="text-xs text-gray-800 text-center italic">
                        There are no posts. <a href="{{ route('admin.posts.create') }}">Create one</a>.
                    </p>
                </li>

            @endforelse
        </ol>
        {{ $posts->onEachSide(1)->links('blog::layouts.partials.pagination') }}
    </div>
@endsection
