@extends('back.layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <h2 class="content-heading">Testing area</h2>

        @include('back.layouts.partials.session')


        <div class="row invisible" data-toggle="appear">

            <div class="col-md-8">
                <div class="block mb-30">
                    <div class="block-header">
                        <h3 class="block-title">
                            Block
                            <small>- 1
                                <span class="float-right">
                                    <a href="#" class="btn btn-sm btn-square btn-outline-secondary">Button</a>
                                </span>
                            </small>
                        </h3>
                    </div>
                    <div class="block-content" id="order-list-canvas">

                        <pre class="codeview">{{ $result }}</pre>

                        {{--<div class="table-responsive">
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
                                    @if (Bouncer::is(auth()->user())->an('admin'))
                                        <td class="text-center font-size-sm">{!! isset($order->client) ? $order->client->name : '<span class="badge badge-pill badge-info">Mix</span>' !!}</td>
                                    @endif
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
                        </div>--}}
                    </div>
                    <div class="block-content"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="block mb-30">
                    <div class="block-header">
                        <h3 class="block-title">Block
                        </h3>
                    </div>
                    <div class="block-content" id="users-list-canvas">

                    </div>
                    <div class="block-content"></div>
                </div>
            </div>
        </div>

    </div>
    <!-- END Page Content -->
@endsection

@push('js_after')
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

    <script>
        $(() => {
            $('#order-list-canvas').slimScroll({
                height: '300px'
            });
            $('#users-list-canvas').slimScroll({
                height: '300px'
            });
        })
    </script>
@endpush
