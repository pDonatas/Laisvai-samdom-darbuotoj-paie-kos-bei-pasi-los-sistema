@section('title', __('orders.orders_tab'))
@extends('layouts.full')

@section('content')

    <div class="page-title-area item-bg1 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="{{route('admin')}}">{{__('page.admin')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="myAccount-content">
    <div class="card ">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs pull-right"  id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="patvirtinti-tab" data-toggle="tab" href="#patvirtinti" role="tab" aria-controls="patvirtinti" aria-selected="true">Patvirtinti vartotojai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="nepatvirtinti-tab" data-toggle="tab" href="#nepatvirtinti" role="tab" aria-controls="nepatvirtinti" aria-selected="false">Nepatvirtinti vartotojai</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="patvirtinti" role="tabpanel" aria-labelledby="patvirtinti-tab">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Vardas</th>
                        </tr>
                        @forelse ($verified as $user)
                            <tr>
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                    {{$user->name}}
                                </td>
                            </tr>
                        @empty
                            Vartotojų šiuo metu nėra
                        @endforelse
                    </table>
                </div>
                <div class="tab-pane fade" id="nepatvirtinti" role="tabpanel" aria-labelledby="nepatvirtinti-tab">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Vardas</th>
                            <th>Veiksmas</th>
                        </tr>
                        @forelse ($waiting as $user)
                            <tr>
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    <a href="{{route('admin.verify.user', $user->id)}}">Patvirtinti</a>
                                </td>
                            </tr>
                        @empty
                            Vartotojų šiuo metu nėra
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
