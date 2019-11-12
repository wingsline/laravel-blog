<li>
    <a href="{{ $post->url }}">
        {{ $post->formatted_title }}
    </a>
    <div>
        <time datetime="{{ $post->publish_date->format(DateTime::ATOM) }}">
            {{ $post->publish_date->format('F d, Y') }}
        </time>

        @if ($post->tags->count())
            <span>&nbsp; | &nbsp;</span>
        @endif

        @include('posts.partials.tags')
    </div>

    <div>
        {!! $post->excerpt !!}
    </div>

</li>
