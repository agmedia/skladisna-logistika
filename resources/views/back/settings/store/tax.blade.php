@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Porezi
            <small>
                <span class="pl-2">({{ $taxes->total() }})</span>
                <span class="float-right">
                    <button class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New" onclick="event.preventDefault(); jQuery('#tax-modal').modal('show');">
                        <i class="si si-plus"></i> Novi Porez
                    </button>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block black">
            <div class="block-content">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">#</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 15%;">Stopa</th>
                        <th class="text-center" style="width: 15%;">Poredak</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 10%;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($taxes as $key => $tax)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $tax->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td>{{ $tax->name }}</td>
                            <td class="text-center">{{ number_format($tax->rate, 2) }}</td>
                            <td class="text-center">{{ $tax->sort_order }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-info" data-toggle="tooltip" title="Uredi" onclick="event.preventDefault(); edit({{ json_encode($tax) }});">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger ml-2" data-toggle="tooltip" title="Obriši" onclick="event.preventDefault(); shouldDeleteItem({{ json_encode($tax) }});">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>

                {{ $taxes->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('modals')
    <!-- Onboarding Modal functionality is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _es6/pages/be_pages_dashboard.js -->
    <div class="modal fade" id="tax-modal" tabindex="-1" role="dialog" aria-labelledby="modal-order-status" aria-hidden="true">
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
                                    <h3 class="font-size-h2 font-w300 mb-5">Porez</h3>
                                    <p class="text-muted">
                                        Upišite naziv poreza te njegovu poreznu stopu. Ako ne odaberete geo zonu porez će se odnositi na sve zone.
                                    </p>

                                    <hr class="mb-30 mt-10">

                                    <h6 class="font-w300 mb-2">Naziv poreza</h6>
                                    <input type="text" class="form-control form-control-lg py-20 mb-30" id="name" name="name" placeholder="Upiši naslov poreza..">

                                    <h6 class="font-w300 mb-2">Porezna stopa</h6>
                                    <input type="text" class="form-control form-control-lg py-20 mb-30" id="rate" name="rate" placeholder="Upiši poreznu stopu..">

                                    <h6 class="font-w300 mb-2">Geo zona</h6>
                                    <select class="js-select2 form-control" id="zone-select" name="data['zone']" style="width: 100%;">
                                        <option></option>
                                        @foreach ($zones as $zone)
                                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                        @endforeach
                                    </select>

                                    <h6 class="font-w300 mb-2 mt-30">Poredak</h6>
                                    <div class="row items-push">
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control form-control-lg py-20" id="sort-order" name="sort_order" placeholder="Poredak u listi..">
                                        </div>
                                        <div class="col-lg-6 text-center" style="padding-top: 5px;">
                                            <label class="css-control css-control-sm css-control-success css-switch res">
                                                <input type="checkbox" class="css-control-input" id="status" name="status">
                                                <span class="css-control-indicator"></span> Status
                                            </label>
                                        </div>
                                    </div>

                                    <input type="hidden" id="tid" name="tid" value="0">
                                    <hr class="mb-30 mt-30">

                                    <div class="text-center">
                                        <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary mb-10 mx-5" onclick="event.preventDefault(); create();">
                                            Snimi Porez <i class="fa fa-arrow-right ml-5"></i>
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
    <!-- END Onboarding Modal -->
@endpush

@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script>
        $(() => {
            $('#zone-select').select2({
                placeholder: "Odaberi geo zonu...",
                allowClear: true
            });
        });
        /**
         *
         * @param item
         */
        function shouldDeleteItem(item) {
            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Izbriši: ' + item.name,
                type: 'warning',
                confirmButtonText: 'Da, Obriši..!',
            }).then((result) => {
                if (result.value) {
                    deleteItem(item)
                }
            })
        }

        /**
         *
         * @param item
         */
        function deleteItem(item) {
            axios.post("{{ route('taxes.destroy') }}", {data: item})
            .then(r => {
                if (r.data) {
                    location.reload()
                }
            })
            .catch(e => {
                errorToast.fire({
                    text: e,
                })
            })
        }

        /**
         *
         */
        function create() {
            let item = {
                name: $('#name').val(),
                rate: $('#rate').val(),
                data: {
                    zone: $('#zone-select')[0].value
                },
                status: $('#status')[0].checked,
                sort_order: $('#sort-order').val(),
                tid: $('#tid').val()
            };

            axios.post("{{ route('taxes.store') }}", {data: item})
            .then(response => {
                if (response.data.success) {
                    location.reload();
                } else {
                    return errorToast.fire({
                        text: response.data.success,
                    });
                }
            });
        }

        /**
         *
         * @param item
         */
        function edit(item) {
            $('#tax-modal').modal('show');

            $('#name').val(item.name);
            $('#rate').val(item.rate);
            $('#tid').val(item.id);

            $('#sort-order').val(item.sort_order);

            $('#zone-select').val(item.data.zone);
            $('#zone-select').trigger('change');

            if (item.status) {
                $('#status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush
