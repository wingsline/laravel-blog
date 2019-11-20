@extends('blog::layouts.master')

@section('content')

    <div class="flex items-center bg-gray-100 px-4 sm:px-6">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
             class="text-4xl sm:text-5xl text-indigo-300">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <div class="my-2 sm:my-4 ml-2 sm:ml-4">
            <h1 class="text-lg sm:text-2xl text-gray-700">{{ __('Profile') }}</h1>
            <p class="text-xs sm:text-sm text-gray-500">Edit or update your account
                information.</p>
        </div>
    </div>

    @include("blog::layouts.partials.flash")

    {{-- posts --}}
    <form action="{{ route('admin.account.update') }}" method="post"
          class="my-6 flex flex-wrap mb-4">

        @csrf
        @method('PATCH')
        <div class="w-full sm:w-1/2">
            @include('blog::account.partials.form', ['submitText' => 'Update'])
        </div>
    </form>
@endsection
