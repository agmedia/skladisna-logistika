<div class="modal fade" id="total-modal-shipping" tabindex="-1" role="dialog" aria-labelledby="modal-shipping" aria-hidden="true">
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
                            <div class="col-md-10 col-lg-8">
                                <h6 class="text-muted mb-1">Suma na narudžbi</h6>
                                <h3 class="font-size-h2 font-w300">Troškovi dostave</h3>
                                <hr class="mb-30 mt-10">

                                <h6 class="font-w300 mb-2">Naslov</h6>
                                <input type="text" class="form-control form-control-lg py-20 mb-30" id="shipping-name" name="name">

                                <h6 class="font-w300 mb-2 mt-30">Poredak</h6>
                                <div class="row items-push">
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control form-control-lg py-20" id="shipping-sort-order" name="sort_order" placeholder="Poredak u listi..">
                                    </div>
                                    <div class="col-lg-6 text-center" style="padding-top: 5px;">
                                        <label class="css-control css-control-sm css-control-success css-switch res">
                                            <input type="checkbox" class="css-control-input" id="shipping-status" name="status">
                                            <span class="css-control-indicator"></span> Status
                                        </label>
                                    </div>
                                </div>

                                <input type="hidden" id="shipping-tid" name="tid" value="0">
                                <input type="hidden" id="shipping-code" name="code" value="shipping">

                                <hr class="mb-30 mt-10">

                                <div class="text-center">
                                    <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary mb-10 mx-5" onclick="event.preventDefault(); create_shipping();">
                                        Snimi Sumu Na Narudžbi <i class="fa fa-arrow-right ml-5"></i>
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

@push('total-modal-js')
    <script>
        /**
         *
         */
        function create_shipping() {
            let item = {
                name: $('#shipping-name').val(),
                code: $('#shipping-code').val(),
                status: $('#shipping-status')[0].checked,
                sort_order: $('#shipping-sort-order').val(),
                pid: $('#shipping-tid').val()
            };

            axios.post("{{ route('totals.store') }}", {data: item})
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
        function edit_shipping(item) {
            $('#shipping-name').val(item.name);
            $('#shipping-sort-order').val(item.sort_order);
            $('#shipping-tid').val(item.id);

            if (item.status) {
                $('#shipping-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush