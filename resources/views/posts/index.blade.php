@section('title', 'Home')
@extends('layouts.app')

@section('content')

    @foreach ($posts as $post)
        <div>
        @include('partials.summary')
        </div>
    @endforeach

@endsection
