@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Geo Zone
            <small>
                <span class="pl-2">({{ $zones->total() }})</span>
                <span class="float-right">
                    <button class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New" onclick="event.preventDefault(); newZone();">
                        <i class="si si-plus"></i> Nova Geo Zona
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
                        <th class="d-none d-sm-table-cell text-right" style="width: 10%;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($zones as $key => $zone)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $zone->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td>{{ $zone->name }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-info" data-toggle="tooltip" title="Uredi" onclick="event.preventDefault(); edit({{ json_encode($zone) }});">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger ml-2" data-toggle="tooltip" title="Obriši" onclick="event.preventDefault(); shouldDeleteItem({{ json_encode($zone) }});">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>

                {{ $zones->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('modals')
    <div class="modal fade" id="geo-zone-modal" tabindex="-1" role="dialog" aria-labelledby="modal-geo-zone" aria-hidden="true">
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
                                    <h3 class="font-size-h2 font-w300 mb-5">Geo zona</h3>
                                    <p class="text-muted">
                                        Upišite naziv geo zone te odaberite države i zone na koje se primjenjuje. Možete odabrati jednu ili više država i zona.
                                    </p>
                                    <hr class="mb-30 mt-10">

                                    <h6 class="font-w300 mb-2">Naziv geo zone</h6>
                                    <input type="text" class="form-control form-control-lg py-20 mb-30" id="name" name="name" placeholder="Upiši naslov geo zone..">

                                    <div class="row items-push mb-30">
                                        <div class="col-lg-5">
                                            <h6 class="font-w300 mb-2">Država</h6>
                                            <select class="js-select2 form-control mb-30" id="state-select" name="state" style="width: 100%;">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-7">
                                            <h6 class="font-w300 mb-2">Zone</h6>
                                            <select class="js-select2 form-control mb-30" id="zone-select" name="zone" style="width: 100%;">
                                                <option value="0">Sva područja</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!--                                    <div class="text-right">
                                                                            <button type="button" class="btn btn-sm btn-noborder btn-info mb-10" onclick="event.preventDefault(); add();">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </div>-->

                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="zone-status" name="status">
                                        <span class="css-control-indicator"></span> Status
                                    </label>

                                    <input type="hidden" id="gzid" name="gzid" value="0">
                                    <hr class="mb-30 mt-30">

                                    <div class="text-center">
                                        <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary mb-10 mx-5" onclick="event.preventDefault(); create();">
                                            Snimi Geo Zonu <i class="fa fa-arrow-right ml-5"></i>
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
            let state = $('#state-select').select2();

            setZones($('#state-select')[0].value);

            state.on('change', (e) => {
                setZones(e.currentTarget.value);
            });
        });

        /**
         *
         * @param item
         */
        function shouldDeleteItem(item) {
            confirmPopUp.fire({
                title:             'Jeste li sigurni?',
                text:              'Izbriši: ' + item.name,
                type:              'warning',
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
            axios.post("{{ route('geo-zone.destroy') }}", {data: item})
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


        function newZone() {
            $('#zone-select').empty().trigger('change');
            $('#name').val('');
            $('#gzid').val('0');
            $('#zone-status')[0].checked = false;

            $('#geo-zone-modal').modal('show');
        }

        /**
         *
         */
        function create() {
            let item = {
                name:   $('#name').val(),
                state:  $('#state-select')[0].value,
                zone:   $('#zone-select')[0].value,
                status: $('#zone-status')[0].checked,
                gzid:   $('#gzid').val()
            };

            axios.post("{{ route('geo-zone.store') }}", {data: item})
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
            $('#geo-zone-modal').modal('show');

            $('#name').val(item.name);
            $('#state-select').val(item.state);
            $('#state-select').trigger('change');
            $('#gzid').val(item.id);
            setZones(item.state, item.zone);

            if (item.status) {
                $('#zone-status')[0].checked = item.status ? true : false;
            }
        }


        function add() {
            // Implement add more states and zones per geo zone.
        }


        /**
         *
         * @param country
         * @param zone
         */
        function setZones(country, zone = null) {
            $('#zone-select').empty().trigger('change');

            axios.post("{{ route('geo-zone.get-state-zones') }}", {country: country})
            .then(response => {
                let data = [{
                    id:   0,
                    text: 'Sva Područja'
                }];

                for (let item in response.data) {
                    data.push({
                        id:   response.data[item].id,
                        text: response.data[item].name
                    });
                }

                $('#zone-select').select2({data: data});

                if (zone) {
                    setZone(zone);
                }
            });
        }


        /**
         *
         * @param zone
         */
        function setZone(zone) {
            $('#zone-select').val(zone);
            $('#zone-select').trigger('change');
        }
    </script>
@endpush
