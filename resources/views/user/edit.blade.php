@section('title', $user->name)
@extends('layouts.full')

@section('content')
    <div class="page-title-area item-bg4 jarallax" data-jarallax='{"speed": 0.3}'>
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
            <div class="myAccount-navigation">
                <ul>
                    <li><a href="{{route('user.show', Auth::id())}}"><i class="bx bx-edit"></i> {{__('user.my_account')}}</a></li>
                    <li><a href="{{route('user.edit', Auth::id())}}" class="active"><i class="bx bx-edit"></i> {{__('user.edit')}}</a></li>
                    <li><a href="{{route('orders')}}"><i class="bx bx-cart"></i> {{__('orders.orders_tab')}}</a></li>
                </ul>
            </div>
            <div class="myAccount-content">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success')}}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error')}}
                    </div>
                @endif
                <form class="edit-account" method="post" action="{{route('user.update', $user->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('user.name')}} <span class="required">*</span></label>
                                <input name="name" type="text" class="form-control" value="{{$user->name}}" required>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('user.email')}} <span class="required">*</span></label>
                                <input name="email" type="email" class="form-control" value="{{$user->email}}" required>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('user.photo')}}</label>
                                <input name="photo" type="file" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <legend>{{__('user.password_change')}}</legend>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label>{{__('user.password')}}</label>
                                <input name="password" type="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label>{{__('user.new_password')}}</label>
                                <input name="new_password" type="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('user.confirm_new_password')}}</label>
                                <input name="confirm_password" type="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="default-btn"><i class='bx bx-save icon-arrow before'></i><span class="label">{{__('user.save')}}</span><i class="bx bx-save icon-arrow after"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
