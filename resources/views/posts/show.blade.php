@section('title', $post->title)
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ $post->title }}</div>
        <div class="card-body">
            <div>
                <p><b>{{__('posts.posted')}}</b> {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                <p><b>{{__('posts.Category')}}</b> {{ App\Category::find($post->category)->first()->name}}</p>
                <p>{!! nl2br(e($post->content)) !!}</p>
                @if(\App\Http\Services\TagsService::hasTags($post->id))
                    <div class="text-right">
                        {{__('posts.price')}}: {{($post->price/100)}} &euro;
                        {{__('tags.tags')}}: {{\App\Http\Services\TagsService::showTags($post->id)}}
                    </div>
                @endif
            </div>
            @if(Auth::id() == $post->user_id)
            <form method="post" action="{{ route('posts.destroy', $post->slug) }}">
                @csrf @method('delete')
                <div class="field is-grouped">
                    <div class="control">
                        <a
                            href="{{ route('posts.edit', $post->slug)}}"
                            class="btn btn-primary"
                        >
                            {{__('posts.Edit')}}
                        </a>
                    </div>
                    <div class="control">
                        <button type="submit" class="btn btn-danger">
                            {{__('posts.Delete')}}
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
        <div class="card-footer">
            <!—- ShareThis BEGIN -—>
            <script async src="https://platform-api.sharethis.com/js/sharethis.js#property=5eac0d0e3c3da40012262fdb&product=sticky-share-buttons"></script>
            <!—- ShareThis END -—>
            <div class="row">
                <div class="col-md-6">
                    {{__('ratings.title')}}: {{$rate}}
                    @if(!\App\Http\Services\RatingsService::voted(Auth::id(), $post->id))
                        <form method="post" action="{{route('vote', $post->id)}}">
                            @csrf
                            <select name="vote" class="form-control" required>
                                <option selected disabled>{{__('ratings.choose_vote')}}</option>
                                <?php
                                for($i = 1; $i <= 10; $i++)
                                    echo '<option value="'.$i.'">'.$i.' '.trans('ratings.votes').'</option>';
                                ?>
                            </select>
                            <input type="text" name="comment" class="form-control" placeholder="{{__('ratings.comment')}}"/>
                            <input type="submit" class="form-control btn btn-primary" value="{{__('ratings.vote')}}"/>
                        </form>
                    @endif
                </div>
                <div class="col-md-6 text-right">
                    @if(!\App\Http\Services\BookmarksService::isBookmarked($post->id))
                        <a href="{{route('bookmark', $post->id)}}">{{__('favorites.add')}}</a>
                    @else
                        <a href="{{route('bookmark', $post->id)}}">{{__('favorites.remove')}}</a>
                    @endif
                    @if($post->user_id != Auth::id())
                        <a href="{{route('order', $post->slug)}}">{{__('orders.order')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{ App::make('App\Http\Controllers\RatingController')->show(['post' => $post->id]) }}
@endsection
