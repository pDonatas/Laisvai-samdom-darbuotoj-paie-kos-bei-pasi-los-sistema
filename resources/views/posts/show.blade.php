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
            </div>
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
        </div>
    </div>
@endsection
