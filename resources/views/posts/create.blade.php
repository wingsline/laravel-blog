@extends('blog::layouts.master')

@section('content')
    @include("blog::layouts.partials.header")

    @include("blog::layouts.partials.flash")

    {{-- posts --}}
    <div class="container">


        <form action="{{ route('admin.posts.store') }}" method="post" class="my-6 p-3 sm:p-6 flex flex-wrap mb-4 bg-white-90 shadow-lg border-t">
            <h1 class="text-xl text-gray-500 mb-6">{{ __('New Post') }}</h1>
            @csrf
            @include('blog::posts.partials.form', ['submitText' => 'Create'])
        </form>
    </div>
@endsection
