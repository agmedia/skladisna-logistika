<div class="modal fade" id="payment-modal-bank" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="block block-rounded block-transparent mb-0 bg-pattern" style="background-image: url({{ asset('media/images/bg-pattern.png') }});">
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
                            <div class="col-md-10 col-lg-10">
                                <h3 class="font-size-h2 font-w300 mb-2">Bankovna transakcija</h3>
                                <p>Način plaćanja internet bankarstvom. Plaćanje na račun.</p>
                                <hr class="mb-30 mt-10">

                                <h6 class="font-w300 mb-2">Naslov načina plaćanja</h6>
                                <input type="text" class="form-control form-control-lg py-20 mb-30" id="bank-name" name="name">

                                <h6 class="font-w300 mb-2">Instrukcije za način plaćanja</h6>
                                <textarea class="js-summernote" id="bank-description" name="description"></textarea>

                                <h6 class="font-w300 mb-2 mt-30">Ukupna svota u košarici prije odobrenja plaćanja</h6>
                                <input type="text" class="form-control form-control-lg py-20 mb-30" id="bank-total" name="data['total']">

                                <h6 class="font-w300 mb-2">Status narudžbe</h6>
                                <select class="js-select2 form-control mb-30" id="bank-order-status-select" name="data['order_status']" style="width: 100%;">
                                    @foreach ($order_statuses as $order_status)
                                        <option value="{{ $order_status->id }}">{{ $order_status->name }}</option>
                                    @endforeach
                                </select>

                                <h6 class="font-w300 mb-2 mt-30">Poredak</h6>
                                <div class="row items-push">
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control form-control-lg py-20" id="bank-sort-order" name="sort_order" placeholder="Poredak u listi..">
                                    </div>
                                    <div class="col-lg-6 text-center" style="padding-top: 5px;">
                                        <label class="css-control css-control-sm css-control-success css-switch res">
                                            <input type="checkbox" class="css-control-input" id="bank-status" name="status">
                                            <span class="css-control-indicator"></span> Status
                                        </label>
                                    </div>
                                </div>

                                <input type="hidden" id="bank-pid" name="pid" value="0">
                                <input type="hidden" id="bank-code" name="code" value="cod">

                                <hr class="mb-30 mt-10">

                                <div class="text-center">
                                    <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary mb-10 mx-5" onclick="event.preventDefault(); create_bank();">
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
        $(() => {
            $('#bank-order-status-select').select2();

            $('.js-summernote').summernote({

                height: 180,
                minHeight: 126,
                placeholder: "Opiši način plaćanja...",
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']],

                ],
                styleTags: ['p', 'h3', 'h4'],
            });
        });
        /**
         *
         */
        function create_bank() {
            let item = {
                name: $('#bank-name').val(),
                code: $('#bank-code').val(),
                description: $('#bank-description').val(),
                data: {
                    total: $('#bank-total').val(),
                    order_status: $('#bank-order-status-select')[0].value,
                },
                status: $('#bank-status')[0].checked,
                sort_order: $('#bank-sort-order').val(),
                pid: $('#bank-pid').val()
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
        function edit_bank(item) {
            $('#bank-description').summernote('reset');
            $('#bank-description').summernote('code', item.description);

            $('#bank-order-status-select').val(item.data.order_status);
            $('#bank-order-status-select').trigger('change');

            $('#bank-name').val(item.name);
            $('#bank-total').val(item.data.total);
            $('#bank-sort-order').val(item.sort_order);
            $('#bank-status').checked = item.status;

            if (item.status) {
                $('#bank-status')[0].checked = item.status ? true : false;
            }

            $('#bank-pid').val(item.id);
        }
    </script>
@endpush