<div class="modal fade" id="payment-modal-cod" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="block block-rounded block-transparent mb-0 bg-pattern" style="background-image: url({{ asset('assets/media/various/bg-pattern-inverse.png') }});">
                <div class="block-header justify-content-end">
                    <div class="block-options">
                        <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="pb-50">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <h6 class="text-muted mb-1">Način plaćanja</h6>
                                <h3 class="font-size-h2 font-w300">Plaćanje pouzećem</h3>
                                <hr class="mb-30 mt-10">

                                <h6 class="font-w300 mb-2">Naslov načina plaćanja</h6>
                                <input type="text" class="form-control form-control-lg py-20 mb-30" id="cod-name" name="name">

                                <h6 class="font-w300 mb-2">Ukupna svota u košarici prije odobrenja plaćanja</h6>
                                <input type="text" class="form-control form-control-lg py-20 mb-30" id="cod-total" name="data['total']">

                                <h6 class="font-w300 mb-2">Status narudžbe</h6>
                                <select class="form-control mb-30" id="cod-order-status-select" name="data['order_status']">
                                    <option></option>
                                    @foreach ($order_statuses as $order_status)
                                        <option value="{{ $order_status->id }}">{{ $order_status->name }}</option>
                                    @endforeach
                                </select>

                                <h6 class="font-w300 mb-2 mt-30">Poredak</h6>
                                <div class="row items-push">
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control form-control-lg py-20" id="cod-sort-order" name="sort_order" placeholder="Poredak u listi..">
                                    </div>
                                    <div class="col-lg-6 text-center" style="padding-top: 5px;">
                                        <label class="css-control css-control-sm css-control-success css-switch res">
                                            <input type="checkbox" class="css-control-input" id="cod-status" name="status">
                                            <span class="css-control-indicator"></span> Status
                                        </label>
                                    </div>
                                </div>

                                <input type="hidden" id="cod-pid" name="pid" value="0">
                                <input type="hidden" id="cod-code" name="code" value="cod">

                                <hr class="mb-30 mt-10">

                                <div class="text-center">
                                    <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary mb-10 mx-5" onclick="event.preventDefault(); create_cod();">
                                        Snimi Način Plaćanja <i class="fa fa-arrow-right ml-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('payment-modal-js')
    <script>
        /**
         *
         */
        function create_cod() {
            let item = {
                name: $('#cod-name').val(),
                code: $('#cod-code').val(),
                data: {
                    total: $('#cod-total').val(),
                    order_status: $('#cod-order-status-select')[0].value,
                },
                status: $('#cod-status')[0].checked,
                sort_order: $('#cod-sort-order').val(),
                pid: $('#cod-pid').val()
            };

            axios.post("{{ route('payment.store') }}", {data: item})
            .then(response => {
                if (response.data.success) {
                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }

        /**
         *
         * @param item
         */
        function edit_cod(item) {
            $('#cod-name').val(item.name);
            $('#cod-total').val(item.data.total);
            $('#cod-order-status-select').val(item.data.order_status);
            $('#cod-sort-order').val(item.sort_order);
            $('#cod-pid').val(item.id);

            if (item.status) {
                $('#bank-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush