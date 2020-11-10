@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css_after')
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        @if (isset($order))
            <form action="{{ route('order.update', ['id' => $order->id]) }}" method="post" id="order-form" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @else
                    <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <h2 class="content-heading"> <a href="{{ route('orders') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                            @if (isset($order))
                                Uredi Narudžbu <small class="text-primary pl-4">br.{{ $order->id }}</small>
                            @else
                                Napravi Novu Narudžbu
                            @endif
                            {{--<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i>Snimi Narudžbu</button>--}}
                        </h2>

                        <div id="order-wizard" class="block block-rounded block-shadow">
                            <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#general" data-toggle="tab">1. Generalne Informacije</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#user" data-toggle="tab">2. Kupac</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#products" data-toggle="tab">3. Proizvodi i Total</a>
                                </li>
                            </ul>

                            <div class="block-content block-content-full tab-content" style="min-height: 265px;">
                                <!-- Step 1 -->
                                <div class="tab-pane active" id="general" role="tabpanel">
                                    <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                                    <hr class="mb-30">
                                    <div class="row items-push">
                                        <div class="col-lg-3">
                                            <p class="text-muted">Generalne informacije o narudžbi...</p>
                                        </div>
                                        <div class="col-lg-7 offset-lg-1">
                                            <div class="form-group mb-50">
                                                <label for="order_status">Status Narudžbe @include('back.layouts.partials.required-star')</label>
                                                <select class="form-control" id="order-status-select" name="order_status" style="width: 100%;">
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status->id }}" {{ (isset($order) and ($order->order_status_id == $status->id)) ? 'selected' : '' }}>{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-50">
                                                <label for="payment_method">Način Plačanja @include('back.layouts.partials.required-star')</label>
                                                <select class="form-control" id="order-payment-select" name="payment_method" style="width: 100%;">
                                                    @foreach (config('settings.payments') as $key => $payment)
                                                        <option value="{{ $key }}" {{ (isset($order) and ($order->payment_method == $key)) ? 'selected' : '' }}>{{ $payment }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-50">
                                                <label for="shipping_method">Način Isporuke @include('back.layouts.partials.required-star')</label>
                                                <select class="form-control" id="order-shipping-select" name="shipping_method" style="width: 100%;">
                                                    @foreach (config('settings.shipping') as $key => $ship)
                                                        <option value="{{ $key }}" {{ (isset($order) and ($order->shipping_method == $key)) ? 'selected' : '' }}>{{ $ship }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="tab-pane" id="user" role="tabpanel">
                                    <h5 class="text-black mb-0 mt-20">Informacije o Kupcu - Tvrtka</h5>
                                    <hr class="mb-30">
                                    <div class="row items-push">
                                        <div class="col-lg-3">
                                            <p class="text-muted">...</p>
                                        </div>
                                        <div class="col-lg-7 offset-lg-1">
                                            <div class="form-group row mb-50">
                                                <div class="col-md-6">
                                                    <label for="fname">Tvrtka</label>
                                                    <input type="text" class="form-control form-control-lg" name="company" value="{{ isset($order) ? $order->company : '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="lname">OIB</label>
                                                    <input type="text" class="form-control form-control-lg" name="oib" value="{{ isset($order) ? $order->oib : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-black mb-0 mt-20">Informacije o Kupcu - Naplata</h5>
                                    <hr class="mb-30">
                                    <div class="row items-push">
                                        <div class="col-lg-3">
                                            <p class="text-muted">...</p>
                                        </div>
                                        <div class="col-lg-7 offset-lg-1">
                                            <div class="form-group row mb-50">
                                                <div class="col-md-6">
                                                    <label for="fname">Ime @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="fname" value="{{ isset($order) ? $order->payment_fname : '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="lname">Prezime @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="lname" value="{{ isset($order) ? $order->payment_lname : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group mb-50">
                                                <label for="address">Adresa @include('back.layouts.partials.required-star')</label>
                                                <input type="text" class="form-control form-control-lg" name="address" value="{{ isset($order) ? $order->payment_address : '' }}">
                                            </div>
                                            <div class="form-group row mb-50">
                                                <div class="col-md-6">
                                                    <label for="zip">Poštanski broj @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="zip" value="{{ isset($order) ? $order->payment_zip : '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="city">Grad @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="city" value="{{ isset($order) ? $order->payment_city : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-50">
                                                <div class="col-md-6">
                                                    <label for="phone">Telefon</label>
                                                    <input type="text" class="form-control form-control-lg" name="phone" value="{{ isset($order) ? $order->payment_phone : '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email">Email @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="email" value="{{ isset($order) ? $order->payment_email : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-black mb-0 mt-20">Informacije o Kupcu - Dostava</h5>
                                    <hr class="mb-30">
                                    <div class="row items-push">
                                        <div class="col-lg-3">
                                            <p class="text-muted">...</p>
                                        </div>
                                        <div class="col-lg-7 offset-lg-1">
                                            <div class="form-group row mb-50">
                                                <div class="col-md-6">
                                                    <label for="fname">Ime @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="ship_fname" value="{{ isset($order) ? $order->shipping_fname : '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="lname">Prezime @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="ship_lname" value="{{ isset($order) ? $order->shipping_lname : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group mb-50">
                                                <label for="address">Adresa @include('back.layouts.partials.required-star')</label>
                                                <input type="text" class="form-control form-control-lg" name="ship_address" value="{{ isset($order) ? $order->shipping_address : '' }}">
                                            </div>
                                            <div class="form-group row mb-50">
                                                <div class="col-md-6">
                                                    <label for="zip">Poštanski broj @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="ship_zip" value="{{ isset($order) ? $order->shipping_zip : '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="city">Grad @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="ship_city" value="{{ isset($order) ? $order->shipping_city : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-50">
                                                <div class="col-md-6">
                                                    <label for="phone">Telefon</label>
                                                    <input type="text" class="form-control form-control-lg" name="ship_phone" value="{{ isset($order) ? $order->shipping_phone : '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email">Email @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control form-control-lg" name="ship_email" value="{{ isset($order) ? $order->shipping_email : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="tab-pane" id="products" role="tabpanel">
                                    <h5 class="text-black mb-0 mt-20">Proizvodi i Total narudžbe</h5>
                                    <hr class="mb-30">
                                    <div class="row items-push" id="ag-order-products-app">
                                        <div class="col-lg-10 offset-lg-1">

                                            <ag-order-products
                                                products="{{ isset($order) ? json_encode($order->products) : '' }}"
                                                totals="{{ isset($order) ? json_encode($order->totals) : '' }}"
                                                products_autocomplete_url="{{ route('products.autocomplete') }}">
                                            </ag-order-products>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Steps Content -->

                            <!-- Steps Navigation -->
                            <div class="block-content block-content-sm block-content-full bg-body-light">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-alt-secondary" data-wizard="prev">
                                            <i class="fa fa-angle-left mr-5"></i> Prethodna
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                                            Sljedeča <i class="fa fa-angle-right ml-5"></i>
                                        </button>
                                        <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish">
                                            <i class="fa fa-check mr-5"></i> Snimi Narudžbu
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- END Steps Navigation -->

                        </div>

                    </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/bootstrap.wizard.js') }}"></script>
    <script src="{{ asset('js/components/ag-order-products.js') }}"></script>

    <script>
        $.fn.bootstrapWizard.defaults.tabClass         = 'nav nav-tabs';
        $.fn.bootstrapWizard.defaults.nextSelector     = '[data-wizard="next"]';
        $.fn.bootstrapWizard.defaults.previousSelector = '[data-wizard="prev"]';
        $.fn.bootstrapWizard.defaults.firstSelector    = '[data-wizard="first"]';
        $.fn.bootstrapWizard.defaults.lastSelector     = '[data-wizard="lsat"]';
        $.fn.bootstrapWizard.defaults.finishSelector   = '[data-wizard="finish"]';
        $.fn.bootstrapWizard.defaults.backSelector     = '[data-wizard="back"]';

        $(() => {

            $('#order-wizard').bootstrapWizard()

            $('#order-status-select').select2()
            $('#order-payment-select').select2()
            $('#order-shipping-select').select2()

        })
    </script>

@endpush
