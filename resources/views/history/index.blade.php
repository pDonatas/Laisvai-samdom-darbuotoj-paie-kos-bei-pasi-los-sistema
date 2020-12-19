@section('title', __('user.history'))
@extends('layouts.full')

@section('content')
    <div class="page-title-area item-bg4 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="{{route('home')}}">{{__('page.home')}}</a></li>
                    <li>{{__('user.history')}}</li>
                </ul>
                <h2>{{__('user.history')}}</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">{{ __('user.history') }}</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <td>{{__('history.url')}}</td>
                    <td>{{__('history.date')}}</td>
                </tr>
                @foreach($history as $hs)
                    <tr>
                        <td>{{$hs->url}}</td>
                        <td>{{$hs->created_at}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
