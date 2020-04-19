@section('title', 'New Post')
@extends('layouts.app')

@section('content')

    <h1 class="title">{{__('posts.Create a new post')}}</h1>

    <form method="post" action="{{ route('posts.store') }}">

        @csrf
        @include('partials.errors')

        <div class="form-group">
            <label class="label">{{__('posts.Title')}}</label>
            <div>
                <input class="form-control" type="text" name="title" value="{{ old('title') }}" class="input" placeholder="{{__('posts.Title')}}" minlength="5" maxlength="100" required />
            </div>
        </div>

        <div class="field">
            <label class="label">{{__('posts.Content')}}</label>
            <div class="control">
                <textarea class="form-control" name="content" class="textarea" placeholder="Content" minlength="5" maxlength="2000" required rows="10">{{ old('content') }}</textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">{{__('posts.Category')}}</label>
            <div class="control">
                <div class="select">
                    <select class="form-control" name="category" required>
                       @foreach($categories as $category)
                           <option value="{{$category->id}}">{{$category->name}}</option>
                       @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="btn btn-primary">{{__('posts.Publish')}}</button>
            </div>
        </div>

    </form>

@endsection
