@section('title', 'Edit: '.$post->title)
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{__('posts.Edit')}}: {{ $post->title }}</div>
        <div class="card-body">
            <form method="post" action="{{ route('posts.update', $post->slug) }}">
                @csrf
                @method('patch')
                @include('partials.errors')

                <div class="field">
                    <label class="label">{{__('posts.Title')}}</label>
                    <div class="control">
                        <input type="text" class="form-control" name="title" value="{{ $post->title }}" class="input" placeholder="{{__('posts.Title')}}" minlength="5" maxlength="100" required />
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{__('posts.Content')}}</label>
                    <div class="control">
                        <textarea name="content" class="form-control" placeholder="{{__('posts.Content')}}" minlength="5" maxlength="2000" required rows="10">{{ $post->content }}</textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{__('posts.Category')}}</label>
                    <div class="control">
                        <div class="select">
                            <select name="category" class="form-control" required>
                                <option value="" disabled>{{__('posts.Select category')}}</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"@if($category->id == $post->category) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="btn btn-primary">{{__('posts.Update')}}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
