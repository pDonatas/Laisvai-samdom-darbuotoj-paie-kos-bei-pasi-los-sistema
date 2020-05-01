@extends('layouts.app')
@section('title', 'Pagrindinis')
@section('content')
    <div class="card">
        <div class="card-header">
            {{__('posts.title')}}
        </div>
        <div class="card-body">
            <div class="row">
                @if(Count($posts) > 0)
                    @foreach($posts as $post)
                    <div class="col-md-4">
                        <a href="{{ route('posts.show', [$post->slug]) }}">
                            <h1 class="title">{{ $post->title }}</h1>
                        </a>
                        <div>
                            <p><b>{{__('posts.posted')}}:</b> {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                            <p><b>{{__('posts.Category')}}:</b> {{ \App\Category::find($post->category)->first()->name }}</p>
                            <p>{!! nl2br(e($post->content)) !!}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                {{__('posts.none')}}
                @endif
            </div>
        </div>
    </div>
@endsection
