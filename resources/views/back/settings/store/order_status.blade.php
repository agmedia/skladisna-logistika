@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Statusi Narudžbe
            <small>
                <span class="pl-2">({{ $order_statuses->total() }})</span>
                <span class="float-right">
                    <button class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New" onclick="event.preventDefault(); jQuery('#order-status-modal').modal('show');">
                        <i class="si si-plus"></i> Novi Status Narudžbe
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
                        <th>Ime</th>
                        <th class="text-center" style="width: 18%;">Poredak</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 10%;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($order_statuses as $key => $order_status)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td>{{ $order_status->name }}</td>
                            <td class="text-center">{{ $order_status->sort_order }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-info" data-toggle="tooltip" title="Uredi" onclick="event.preventDefault(); edit({{ json_encode($order_status) }});">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger ml-2" data-toggle="tooltip" title="Obriši" onclick="event.preventDefault(); shouldDeleteItem({{ json_encode($order_status) }});">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>

                {{ $order_statuses->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('modals')
    <!-- Onboarding Modal functionality is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _es6/pages/be_pages_dashboard.js -->
    <div class="modal fade" id="order-status-modal" tabindex="-1" role="dialog" aria-labelledby="modal-order-status" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-rounded block-transparent mb-0 bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
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
                                    <h3 class="font-size-h2 font-w300 mb-5">Status narudžbe</h3>
                                    <p class="text-muted">
                                        Upišite naziv statusa narudžbe i njegov poredak u listi.
                                    </p>

                                    <input type="text" class="form-control form-control-lg py-20 mb-30" id="name" name="name" placeholder="Upiši naslov statusa..">
                                    <input type="text" class="form-control form-control-lg py-20 mb-50" id="sort-order" name="sort_order" placeholder="Poredak u listi..">
                                    <input type="hidden" id="osid" name="osid" value="0">

                                    <div class="text-center">
                                        <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary mb-10 mx-5" onclick="event.preventDefault(); create();">
                                            Snimi Status <i class="fa fa-arrow-right ml-5"></i>
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
    <script>
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
            axios.post("{{ route('order-status.destroy') }}", {data: item})
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
                sort_order: $('#sort-order').val(),
                osid: $('#osid').val()
            };

            axios.post("{{ route('order-status.store') }}", {data: item})
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
            $('#order-status-modal').modal('show');

            $('#name').val(item.name);
            $('#sort-order').val(item.sort_order);
            $('#osid').val(item.id);
        }
    </script>
@endpush
