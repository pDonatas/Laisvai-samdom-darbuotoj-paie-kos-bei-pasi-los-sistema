<div class="content">
    <div href="{{ route('posts.show', [$post->slug]) }}">
        <h1 class="title">{{ $post->title }}</h1>
    </div>
    <div>
    <p><b>Posted:</b> {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
        <p><b>Category:</b> {{ $post->category }}</p>
        <p>{!! nl2br(e($post->content)) !!}</p> </div></div>

    <form method="post" action="{{ route('posts.destroy', [$post->slug]) }}">
        @csrf @method('delete')
        <div class="field is-grouped">
            <div class="control">
                <a
                    href="{{ route('posts.edit', [$post->slug])}}"
                    class="button is-info is-outlined"
                >
                    Edit
                </a>
            </div>
            <div class="control">
                <button type="submit" class="button is-danger is-outlined">
                    Delete
                </button>
            </div>
        </div>
    </form>
</div>
