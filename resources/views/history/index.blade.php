@section('title', __('user.history'))
@extends('layouts.app')

@section('content')
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
