@extends('layouts.master')

@section('title', $post->formatted_title )

@section('content')

    <div class="flex justify-between items-center mb-1">
        <h1 class="text-4xl text-blue-500">{{ $post->formatted_title }}</h1>

        @auth
            <div>
                <a target="_blank" href="{{ route('admin.posts.edit', $post) }}" class="text-xs bg-gray-200 px-3 py-1 rounded">Edit</a>
            </div>
        @endauth
    </div>


    <div class="text-xs text-gray-500">
        Posted on <time datetime="{{ $post->publish_date->format(DateTime::ATOM) }}" class="text-xs text-gray-500">{{ $post->publish_date }}</time> | {{ $post->author }}
    </div>

    <div class="py-4">
        {!! $post->text !!}
    </div>

    <div>
        @include('posts.partials.tags')
    </div>

@endsection

@section('seo')

    <meta property="og:title" content="{{ $post->title }} | {{ config('app.name') }}"/>
    <meta property="og:description" content="{{ $post->excerpt }}"/>

    @foreach($post->tags as $tag)
<meta property="article:tag" content="{{ $tag->name }}"/>
    @endforeach

    <meta property="article:published_time" content="{{ $post->publish_date->toIso8601String() }}"/>
    <meta property="og:updated_time" content="{{ $post->updated_at->toIso8601String() }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="{{ $post->excerpt }}"/>
    <meta name="twitter:title" content="{{ $post->title }} | {{ config('app.name') }}"/>

    <meta name="twitter:image" content="{{ asset('images/logo.png') }}"/>
@endsection
