@section('title', __('orders.orders_tab'))
@extends('layouts.full')

@section('content')

    <div class="page-title-area item-bg2 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="{{route('home')}}">{{__('page.home')}}</a></li>
                    <li>{{__('user.my_account')}}</li>
                    <li>{{__('orders.orders_tab')}}</li>
                </ul>
            </div>
        </div>
    </div>


    <section class="my-account-area ptb-100">
        <div class="container">
            <div class="myAccount-navigation">
                <ul>
                    <li><a href="{{route('user.show', Auth::id())}}"><i class="bx bx-edit"></i> {{__('user.my_account')}}</a></li>
                    <li><a href="{{route('orders')}}" class="active"><i class="bx bx-cart"></i> {{__('orders.orders_tab')}}</a></li>
                </ul>
            </div>
            <div class="myAccount-content">
                <div class="orders-table table-responsive">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs pull-right"  id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="true">{{__('orders.orders_tab')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="service-tab" data-toggle="tab" href="#service" role="tab" aria-controls="service" aria-selected="false">{{__('orders.services_tab')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <table class="table">
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('posts.Title')}}</th>
                                            <th>{{__('orders.order_details')}}</th>
                                        </tr>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>
                                                    {{$order->id}}
                                                </td>
                                                <td>
                                                    {{$order->title}}
                                                </td>
                                                <td>
                                                    <a href="{{route('orders.view', $order->id)}}"><button class="btn btn-primary">{{__('orders.order_details')}}</button></a>
                                                </td>
                                            </tr>
                                        @empty
                                            {{__('orders.no_orders')}}
                                        @endforelse
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                                    <table class="table">
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('posts.Title')}}</th>
                                        </tr>
                                        @forelse ($services as $order)
                                            <tr>
                                                <td>
                                                    {{$order->id}}
                                                </td>
                                                <td>
                                                    {{$order->title}}
                                                </td>
                                            </tr>
                                        @empty
                                            {{__('orders.no_services')}}
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
