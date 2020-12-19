@extends('layouts.full')
@section('title', $user->name)
@section('content')

<div class="page-title-area item-bg1 jarallax" data-jarallax='{"speed": 0.3}'>
    <div class="container">
        <div class="page-title-content">
            <ul>
                <li><a href="{{route('home')}}">{{__('page.home')}}</a></li>
                <li>{{__('user.my_account')}}</li>
            </ul>
            <h2>{{__('user.my_account')}}</h2>
        </div>
    </div>
</div>


<section class="my-account-area ptb-100">
    <div class="container">
        <div class="myAccount-profile">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-5">
                    <div class="profile-image">
                        <img src="{{$user->photo}}" alt="image">
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="profile-content">
                        <h3>{{$user->name}}</h3>
                        <ul class="contact-info">
                            <li><i class='bx bx-envelope'></i> <a href="mailto:{{$user->email}}">{{$user->email}}</a></li>
                            <li><i class='bx bx-phone'></i> <a href="tel:{{$user->phone}}">{{$user->phone}}</a></li>
                            <li><i class='bx bx-world'></i> <a href="{{$user->web}}" target="_blank">{{$user->web}}</a></li>
                        </ul>
                        <a href="{{route('logout')}}" class="myAccount-logout">{{__('user.logout')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="myAccount-navigation">
            <ul>
                <li><a href="{{route('user.show', Auth::id())}}" class="active"><i class="bx bx-edit"></i> {{__('user.my_account')}}</a></li>
                <li><a href="{{route('user.edit', Auth::id())}}"><i class="bx bx-edit"></i> {{__('user.edit')}}</a></li>
                <li><a href="{{route('orders')}}"><i class="bx bx-cart"></i> {{__('orders.orders_tab')}}</a></li>
            </ul>
        </div>
        <div class="myAccount-content">
            <p>{{__('user.hello')}} <strong>{{$user->name}}</strong> ({{__('user.not')}} <strong>{{$user->name}}</strong>? <a href="{{route('logout')}}">{{__('user.logout')}}</a>)</p>
        </div>
    </div>
</section>
@endsection
