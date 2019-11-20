@extends('blog::layouts.master')

@section('content')

    <div class="flex items-center bg-gray-100 px-4 sm:px-6 mb-4 sm:mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
             class="text-4xl sm:text-5xl text-indigo-300">
            <path
                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path
                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>
        <div class="my-2 sm:my-4 ml-2 sm:ml-4">
            <h1 class="text-lg sm:text-2xl text-gray-700">{{ __('New Post') }}</h1>
            <p class="text-xs sm:text-sm text-gray-500">{{ __('Create a new blog post.') }}</p>
        </div>
    </div>

    @include("blog::layouts.partials.flash")

    {{-- form --}}
    <form action="{{ route('admin.posts.store') }}" method="post"
          class="flex flex-wrap mb-4">
        @csrf
        @include('blog::posts.partials.form', ['submitText' => 'Create'])
    </form>
@endsection
