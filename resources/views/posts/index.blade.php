@section('title', 'Home')
@extends('layout')

@section('content')

    @foreach ($posts as $post)
        <div>
        @include('partials.summary')
        </div>
    @endforeach

@endsection
