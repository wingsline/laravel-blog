@if($post->tags)

    <ul>
        @foreach($post->tags->sortBy->name as $tag)

            <li>
                <a href="{{ route('posts.tagged', $tag->slug) }}">{{ $tag->name }}</a>
            </li>
        @endforeach

    </ul>

@endif
