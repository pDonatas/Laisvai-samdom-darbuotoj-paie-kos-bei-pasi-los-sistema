@extends('layouts.app')
@section('title', 'Pagrindinis')
@section('content')
    <section class="about-area pt-100">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="about-content left-content">
                        <span class="sub-title">{{__('page.about_us')}}</span>
                        <h2>{{__('page.intro')}}</h2>
                        <h6>{{__('page.intro_subtext')}}</h6>
                        <p>{{__('page.intro_text')}}</p>
                        <div class="signature">
                            <img src="/assets/img/signature.png" alt="image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="about-right-image">
                        <img src="/assets/img/about/4.jpg" alt="image">
                        <img src="/assets/img/about/3.jpg" alt="image">
                        <div class="text-box">
                            <div class="inner">
                                {{__('page.trusted')}}
                                <span>75K+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="particles-js-circle-bubble-4"></div>
    </section>
    <section class="courses-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-left">
                <span class="sub-title">{{__('page.courses')}}</span>
            </div>
            <div class="shorting-menu">
                <button class="filter" data-filter="all">{{__('page.all')}} ({{count($posts)}})</button>
                @foreach($categories as $category)
                    <button class="filter" data-filter=".{{$category->slug}}">{{$category->name}} ({{App\Post::where('category', $category->id)->count()}})</button>
                @endforeach
            </div>
            <div class="shorting">
                <div class="row">
                    @if(Count($posts) > 0)
                        @foreach($posts as $post)
                            <div class="col-lg-4 col-md-6 mix {{\App\Category::find($post->category)->slug}}">
                                <div class="single-courses-item mb-30">
                                    <div class="courses-image">
                                        <a href="{{ route('posts.show', [$post->slug]) }}" class="d-block"><img src="{{$post->img}}" alt="image"></a>
                                    </div>
                                    <div class="courses-content">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="course-author d-flex align-items-center">
                                                <img src="{{App\User::find($post->user_id)->photo}}" class="shadow" alt="image">
                                                <span>{{App\User::find($post->user_id)->name}}</span>
                                            </div>
                                            <div class="courses-rating">
                                                @if(App\Rating::where('post', $post->id)->exists())
                                                <div class="review-stars-rated">
                                                    @for($i = 0; $i < (int)\App\Http\Helpers::getRating($post->id); $i++)
                                                        <i class='bx bxs-star'></i>
                                                    @endfor
                                                    @if ((int)\App\Http\Helpers::getRating($post->id) < \App\Http\Helpers::getRating($post->id))
                                                            <i class='bx bxs-star-half'></i>
                                                    @endif
                                                </div>
                                                <div class="rating-total">
                                                    {{round(\App\Http\Helpers::getRating($post->id), 2)}}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <h3><a href="{{ route('posts.show', [$post->slug]) }}" class="d-inline-block">{{$post->title}}</a></h3>
                                        <p>{{trim($post->content, 50)}}...</p>
                                    </div>
                                    <div class="courses-box-footer">
                                        <ul>
                                            <li class="students-number">
                                                <i class='bx bx-user'></i> {{App\Order::where('service', $post->id)->count()}} students
                                            </li>
                                            <li class="courses-price">
                                                {{$post->price}} &euro;
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{__('posts.none')}}
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
