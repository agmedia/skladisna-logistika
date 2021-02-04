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
            <!-- Addresses -->
                <h2 class="content-heading">Adrese</h2>
                <div class="row row-deck gutters-tiny">
                    <!-- Billing Address -->
                    <div class="col-md-6">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Adresa naplate</h3>
                            </div>
                            <div class="block-content">
                                <div class="font-size-lg text-black mb-5">John Smith</div>
                                <address>
                                    5110 8th Ave<br>
                                    New York 11220<br>
                                    United States<br><br>
                                    <i class="fa fa-phone mr-5"></i> (999) 111-222222<br>
                                    <i class="fa fa-envelope-o mr-5"></i> <a href="javascript:void(0)">company@example.com</a>
                                </address>
                            </div>
                        </div>
                    </div>
                    <!-- END Billing Address -->

                    <!-- Shipping Address -->
                    <div class="col-md-6">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Shipping Address</h3>
                            </div>
                            <div class="block-content">
                                <div class="font-size-lg text-black mb-5">John Smith</div>
                                <address>
                                    5110 8th Ave<br>
                                    New York 11220<br>
                                    United States<br><br>
                                    <i class="fa fa-phone mr-5"></i> (999) 111-222222<br>
                                    <i class="fa fa-envelope-o mr-5"></i> <a href="javascript:void(0)">company@example.com</a>
                                </address>
                            </div>
                        </div>
                    </div>
                    <!-- END Shipping Address -->
                </div>
                <!-- END Addresses -->

                <!-- Products -->
                <h2 class="content-heading">Products (5)</h2>
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 100px;">ID</th>
                                    <th>Product</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-right" style="width: 10%;">UNIT</th>
                                    <th class="text-right" style="width: 10%;">PRICE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.258</a>
                                    </td>
                                    <td>
                                        <a href="be_pages_ecom_product_edit.html">Dark Souls III</a>
                                    </td>
                                    <td class="text-center">92</td>
                                    <td class="text-center font-w600">1</td>
                                    <td class="text-right">$69,00</td>
                                    <td class="text-right">$69,00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.263</a>
                                    </td>
                                    <td>
                                        <a href="be_pages_ecom_product_edit.html">Bloodborne</a>
                                    </td>
                                    <td class="text-center">32</td>
                                    <td class="text-center font-w600">1</td>
                                    <td class="text-right">$29,00</td>
                                    <td class="text-right">$29,00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.214</a>
                                    </td>
                                    <td>
                                        <a href="be_pages_ecom_product_edit.html">The Surge</a>
                                    </td>
                                    <td class="text-center">15</td>
                                    <td class="text-center font-w600">1</td>
                                    <td class="text-right">$59,00</td>
                                    <td class="text-right">$59,00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.358</a>
                                    </td>
                                    <td>
                                        <a href="be_pages_ecom_product_edit.html">Bioshock Collection</a>
                                    </td>
                                    <td class="text-center">77</td>
                                    <td class="text-center font-w600">1</td>
                                    <td class="text-right">$39,00</td>
                                    <td class="text-right">$39,00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.425</a>
                                    </td>
                                    <td>
                                        <a href="be_pages_ecom_product_edit.html">Until Dawn</a>
                                    </td>
                                    <td class="text-center">25</td>
                                    <td class="text-center font-w600">1</td>
                                    <td class="text-right">$49,00</td>
                                    <td class="text-right">$49,00</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right font-w600">Total Price:</td>
                                    <td class="text-right">$245,00</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right font-w600">Total Paid:</td>
                                    <td class="text-right">$245,00</td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="5" class="text-right font-w600 text-uppercase">Total Due:</td>
                                    <td class="text-right font-w600">$0,00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END Products -->
        @endif
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
