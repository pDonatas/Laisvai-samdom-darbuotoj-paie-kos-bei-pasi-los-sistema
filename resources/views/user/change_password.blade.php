@extends('layouts.app')
@section('content')
    @isset($danger)
        @if($danger == 1)
            <div class="alert alert-danger">
                {{__('user.wrong_pass')}}
            </div>
        @endif
    @endisset
    @isset($success)
        <div class="alert alert-success">
            {{__('user.pass_changed')}}
        </div>
    @endisset
    <form method="POST" action="{{route('store-password')}}">
        @csrf
        <label for="password">{{__('user.password')}}</label>
        <input type="password" id="password" name="password" class="form-control" required>
        <label for="new_password">{{__('user.new_password')}}</label>
        <input type="password" id="new_password" name="new_password" class="form-control" required>
        <input type="submit" class="btn btn-outline-dark" value="{{__('form.submit')}}">
    </form>
@endsection
