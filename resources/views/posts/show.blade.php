@section('title', $post->title)
@extends('layouts.full')

@section('content')
    <div class="page-title-area item-bg1 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="{{route('home')}}">{{__('page.home')}}</a></li>
                    <li>{{$post->title}}</li>
                </ul>
            </div>
        </div>
    </div>


    <section class="courses-details-area pt-100 pb-70">
        <div class="container">
            <div class="courses-details-header">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="courses-title">
                            <h2>{{$post->title}}</h2>
                            <p>{{$post->content}}</p>
                        </div>
                        <div class="courses-meta">
                            <ul>
                                <li>
                                    <i class='bx bx-folder-open'></i>
                                    <span>{{__('orders.category')}}</span>
                                    <a href="#">{{\App\Category::find($post->category)->name}}</a>
                                </li>
                                <li>
                                    <i class='bx bx-group'></i>
                                    <span>{{__('orders.already_bought')}}</span>
                                    <a href="#">{{\App\Order::where('service', $post->id)->count()}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="courses-price">
                            <div class="courses-review">
                                @if(App\Rating::where('post', $post->id)->exists())
                                    <div class="review-stars">
                                        @for($i = 0; $i < (int)\App\Http\Helpers::getRating($post->id); $i++)
                                            <i class='bx bxs-star'></i>
                                        @endfor
                                        @if ((int)\App\Http\Helpers::getRating($post->id) < \App\Http\Helpers::getRating($post->id))
                                            <i class='bx bxs-star-half'></i>
                                        @endif
                                    </div>
                                    <span class="reviews-total d-inline-block">({{App\Rating::where('post', $post->id)->count()}} reviews)</span>

                                @endif
                            </div>
                            <div class="price">{{$post->price}} &euro;</div>
                            @if($post->user_id != Auth::id())
                                <a href="{{route('order', $post->slug)}}" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">{{__('orders.order')}}</span><i class="bx bx-paper-plane icon-arrow after"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="courses-details-image text-center">
                        <img src="{{$post->img}}" alt="image">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="courses-sidebar-information">
                        <ul>
                            <li>
                                <span><i class='bx bx-group'></i> {{__('orders.already_bought')}}</span>
                                {{\App\Order::where('service', $post->id)->count()}}
                            </li>
                            <li>
                                <span><i class='bx bxs-graduation'></i> {{__('orders.category')}}</span>
                                {{\App\Category::find($post->category)->name}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="courses-review-comments">
                <div class="row">
                    <div class="col-md-6">
                        @if(!\App\Http\Services\RatingsService::voted(Auth::id(), $post->id))
                            <form method="post" action="{{route('vote', $post->id)}}">
                                @csrf
                                <select name="vote" class="form-control" required>
                                    <option selected disabled>{{__('ratings.choose_vote')}}</option>
                                    <?php
                                    for($i = 1; $i <= 5; $i++)
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
                    </div>
                </div>
            </div>
            {{ App::make('App\Http\Controllers\RatingController')->show(['post' => $post->id]) }}
        </div>
    </section>
    <!—- ShareThis BEGIN -—>
    <script async src="https://platform-api.sharethis.com/js/sharethis.js#property=5eac0d0e3c3da40012262fdb&product=sticky-share-buttons"></script>
    <!—- ShareThis END -—>
@endsection
