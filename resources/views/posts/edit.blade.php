@extends('blog::layouts.master')

@section('content')
    <div class="flex items-center bg-gray-100 px-4 sm:px-6 mb-4 sm:mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
             class="text-4xl sm:text-5xl text-indigo-300">
            <path
                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
        <div class="my-2 sm:my-4 ml-2 sm:ml-4">
            <h1 class="text-lg sm:text-2xl text-gray-700">{{ __('Edit Post') }}</h1>
            <p class="text-xs sm:text-sm text-gray-500">{{ __('Edit an existing blog post.') }}</p>
        </div>
    </div>

    @include("blog::layouts.partials.flash")

    {{-- posts --}}
    <form action="{{ route('admin.posts.update', $post) }}" method="post"
          class="flex flex-wrap mb-4">
        @csrf
        @method('PATCH')
        @include('blog::posts.partials.form', ['submitText' => 'Update'])
    </form>
@endsection
