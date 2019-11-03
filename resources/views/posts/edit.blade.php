@extends('blog::layouts.master')

@section('content')
    @include("blog::layouts.partials.header")

    @include("blog::layouts.partials.flash")

    {{-- posts --}}
    <div class="container">
        <form action="{{ route('admin.posts.update', $post) }}" method="post" class="my-6 p-3 sm:p-6 flex flex-wrap mb-4 bg-white-90 shadow-lg border-t">
            <div class="flex items-center justify-between w-full mb-6">
                <h1 class="text-xl text-gray-500">{{ __('Edit Post') }}</h1>
            </div>

            @csrf
            @method('PATCH')
            @include('blog::posts.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
@endsection
