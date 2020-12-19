@section('title',  __('posts.Edit').' '.$post->title)
@extends('layouts.full')

@section('content')
    <div class="page-title-area item-bg1 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="{{route('home')}}">{{__('page.home')}}</a></li>
                    <li>{{__('posts.Edit').' '.$post->title}}</li>
                </ul>
            </div>
        </div>
    </div>
    <section class="courses-details-area pt-100 pb-70">
        <div class="container">
    <div class="card">
        <div class="card-header">{{__('posts.Edit')}}: {{ $post->title }}</div>
        <div class="card-body">
            <form method="post" action="{{ route('posts.update', $post->slug) }}" enctype="multipart/form-data">
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
                    <label class="label">{{__('posts.price')}}</label>
                    <div class="control">
                        <input type="number" class="form-control" name="price" value="{{ $post->price }}" placeholder="{{__('posts.price')}}" required />
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

                <div class="form-group">
                    <label class="label">{{__('tags.tags')}} {{__('tags.delimiter')}}</label>
                    <div>
                        <input class="form-control" type="text" name="tags" value="{{\App\Http\Services\TagsService::showTags($post->id)}}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label">{{__('posts.image')}}</label>
                    <div>
                        <input class="form-control" type="file" name="img"/>
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
        </div>
    </section>
@endsection
