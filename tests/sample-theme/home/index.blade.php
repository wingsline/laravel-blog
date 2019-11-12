@if($onFirstPage)
    <h1>Recent blog entries</h1>
@else
    <div>
        {{ $posts->links() }}
    </div>
@endif

@include('posts.partials.list')

{{ $posts->links() }}
