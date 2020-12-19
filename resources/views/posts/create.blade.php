@section('title', __('posts.Create a new post'))
@extends('layouts.full')

@section('content')
    <div class="page-title-area item-bg1 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="{{route('home')}}">{{__('page.home')}}</a></li>
                    <li>{{__('posts.Create a new post')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <section class="courses-details-area pt-100 pb-70">
        <div class="container">
    <h1 class="title">{{__('posts.Create a new post')}}</h1>

    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">

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
                <textarea class="form-control" name="content" class="textarea" placeholder="{{__('posts.Content')}}" minlength="5" maxlength="2000" required rows="10">{{ old('content') }}</textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">{{__('posts.price')}}</label>
            <div class="control">
                <input class="form-control" name="price" placeholder="{{__('posts.price')}}" type="number">
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

        <div class="form-group">
            <label class="label">{{__('tags.tags')}} {{__('tags.delimiter')}}</label>
            <div>
                <input class="form-control" type="text" name="tags"/>
            </div>
        </div>

        <div class="form-group">
            <label class="label">{{__('posts.image')}}</label>
            <div>
                <input class="form-control" type="file" name="img" required/>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="btn btn-primary">{{__('posts.Publish')}}</button>
            </div>
        </div>

    </form>
        </div>
    </section>

@endsection
