@section('title', __('orders.order').' '.$post->title)
@extends('layouts.full')

@section('content')

    <div class="page-title-area item-bg1 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="{{route('home')}}">{{__('page.home')}}</a></li>
                    <li>{{$post->title}}</li>
                    <li>{{__('orders.order_details')}}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="checkout-area ptb-100">
        <div class="container">
            <form method="post" action="{{ route('orders.store', $post->slug) }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="billing-details">
                            <h3 class="title">{{__('orders.requirements')}}</h3>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea @if(isset($order)) disabled @endif name="requirements" id="notes" cols="30" rows="5" placeholder="{{__('orders.requirements')}}" class="form-control">@if(isset($order)) {{$order->requirement}} @endif</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="order-details">
                            <h3 class="title">{{__('orders.order_details')}}</h3>
                            <div class="order-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('orders.service_title')}}</th>
                                        <th scope="col">{{__('page.total')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="product-name">
                                            <a href="{{ route('posts.show', [$post->slug]) }}">{{$post->title}}</a>
                                        </td>
                                        <td class="product-total">
                                            <span class="subtotal-amount">{{$post->price}} &euro;</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="total-price">
                                            <span>{{__('orders.total')}}</span>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="subtotal-amount">{{$post->price}} &euro;</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if (!isset($order))
                            <div class="payment-box">
                                <button type="submit" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">{{__('orders.order')}}</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
