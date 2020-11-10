@extends('back.layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <h2 class="content-heading">Nadzorna Ploča
            <small>
                @if (auth()->user()->email == 'filip@agmedia.hr' || auth()->user()->email == 'tomislav@agmedia.hr')
                    <span class="float-right">
                    <a href="{{ route('dashboard.test') }}" class="btn btn-square btn-outline-secondary">Test</a>
                    <a href="{{ route('dashboard.test2') }}" class="btn btn-square btn-outline-secondary">Test 2</a>
                </span>
                @endif
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div id="ag-stats-total-app">
            <ag-stats-total column="col-sm-12 col-md-4" uri="{{ route('stats.total') }}" appear="true"></ag-stats-total>
        </div>

        <div class="row invisible" data-toggle="appear">
            <div class="col-md-4">
                <div class="block mb-30" id="users-list-canvas">
                    <div id="ag-pie-chart-app">
                        <ag-pie-chart uri="{{ route('chart.pie.order.status') }}" title="Statusi Narudžbi"></ag-pie-chart>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="block mb-30">
                    <div class="block-header">
                        <h3 class="block-title">
                            Narudžbe
                            <small>- Zadnje
                                <span class="float-right">
                                    <a href="{{ route('orders') }}" class="btn btn-sm btn-square btn-outline-secondary">Pogledaj Sve Narudžbe</a>
                                </span>
                            </small>
                        </h3>
                    </div>
                    <div class="block-content" id="order-list-canvas">
                        <div class="table-responsive">
                        <table class="table table-striped table-vcenter">
                            <tbody>
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td class="text-center" style="width: 63px;">
                                        <a href="{{ route('order.edit', ['id' => $order->id]) }}">
                                            {{ $order->id }}
                                        </a>
                                    </td>
                                    <td class="text-center" style="width: 108px;">
                                        <span class="badge badge-pill badge-light">{{ $order->status->name }}</span>
                                    </td>
                                    <td class="font-w600 pl-3">{{ $order->shipping_fname }} {{ $order->shipping_lname }}</td>
                                    <td class="text-right font-size-sm" style="width: 120px;">
                                        <strong>{{ number_format($order->total, 2, ',', '.') }}</strong> <span class="text-muted">kn</span>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-right" style="width: 120px;">
                                        <a href="{{ route('order.edit', ['id' => $order->id]) }}" class="btn btn-sm btn-outline-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi">
                                            <i class="fa fa-pencil"></i> Uredi
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="block-content"></div>
                </div>
            </div>
        </div>

        <div class="row invisible" data-toggle="appear">
            <!-- Row #2 -->
            <div class="col-md-6" id="ag-chart-app">
                <ag-bar-chart uri="{{ route('chart.bar.orders') }}" title="Narudžbe"></ag-bar-chart>
            </div>
            <div class="col-md-6" id="ag-horizontal-chart-app">
                <ag-horizontal-bar-chart uri="{{ route('chart.bar.products') }}" title="Proizvodi"></ag-horizontal-bar-chart>
            </div>
            <!-- END Row #2 -->
        </div>

        <div class="row invisible" data-toggle="appear">
            <div class="col-md-9" id="ag-chart-app">

            </div>

            <div class="col-md-3" id="ag-chart-app">

            </div>
        </div>

    </div>
    <!-- END Page Content -->
@endsection

@push('js_after')
    <script src="{{ asset('js/components/ag-bar-chart.js') }}"></script>
    <script src="{{ asset('js/components/ag-bar-horizontal-chart.js') }}"></script>
    <script src="{{ asset('js/components/ag-stats-total.js') }}"></script>
    <script src="{{ asset('js/components/ag-pie-chart.js') }}"></script>

    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

    <script>
        $(() => {
            $('#order-list-canvas').slimScroll({
                height: '300px'
            });
            $('#users-list-canvas').slimScroll({
                height: '376px'
            });
        })
    </script>
@endpush
