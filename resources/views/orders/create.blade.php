@section('title', __('orders.order').' '.$post->title)
@extends('layouts.app')

@section('content')

    <h1 class="title">{{__('orders.order')}} {{$post->title}}</h1>

    <form method="post" action="{{ route('orders.store', $post->slug) }}">

        @csrf
        @include('partials.errors')

        <div class="form-group">
            <label class="label">{{__('orders.service_title')}}</label>
            <div>
                <input class="form-control" type="text" name="title" value="{{$post->title}}" disabled/>
            </div>
        </div>

        <div class="form-group">
            <label class="label">{{__('orders.service_price')}}</label>
            <div>
                <input class="form-control" type="text" name="price" value="{{$post->price/100}} &euro;" disabled/>
            </div>
        </div>

        <div class="form-group">
            <label class="label">{{__('orders.requirements')}}</label>
            <div>
                <input class="form-control" type="text" name="requirements"/>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="btn btn-primary">{{__('orders.order')}}</button>
            </div>
        </div>

    </form>

@endsection
