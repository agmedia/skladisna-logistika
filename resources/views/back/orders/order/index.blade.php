@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Narudžbe
            <small>
                <span class="pl-2">({{ $orders->total() }})</span>
                <span class="float-right">{{--{{ $count }}--}}
                    <a href="{{ route('order.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                        <i class="si si-plus"></i> Nova Narudžba
                    </a>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block" id="ag-order-filter-app">
            <div class="block-content bg-body-light">
                <div class="row items-push">
                    @if (Bouncer::is(auth()->user())->an('admin'))
                        <div class="col-12 col-md-3">
                            <input type="text" name="date_start" id="start-date-picker" class="form-control " placeholder="Od..."
                                   value="{{ request()->input('from') ? date_format(date_create(request()->input('from')), 'd.m.Y.') : '' }}" style="height: 34px;">
                        </div>
                        <div class="col-12 col-md-3">
                            <input type="text" name="date_end" id="end-date-picker" class="form-control " placeholder="Do..."
                                   value="{{ request()->input('to') ? date_format(date_create(request()->input('to')), 'd.m.Y.') : '' }}" style="height: 34px;">
                        </div>
                        <div class="col-12 col-md-6">
                            <select class="form-control" id="payment-select">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment['code'] }}" {{ ($payment['code'] == request()->input('payment')) ? 'selected' : '' }}>{{ $payment['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>

            <div class="block-content">
                <div class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 63px;">#</th>
                        <th class="text-center" style="width: 108px;">Status</th>
                        <th>Kupac</th>
                        <th class="text-center" style="width: 81px;">Plačanje</th>
                        <th class="text-center" style="width: 81px;">Poštarina</th>
                        <th class="text-right" style="width: 120px;">Total</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 120px;">Akcije</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key => $order)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route('order.edit', ['id' => $order->id]) }}">
                                    {{ $order->id }}
                                </a>
                            </td>
                            <td class="text-center">
                                @if ($order->status->id == 1)
                                    <span class="badge badge-pill badge-primary">{{ $order->status->name }}</span>
                                @elseif ($order->status->id == 4)
                                    <span class="badge badge-pill badge-success">{{ $order->status->name }}</span>
                                @elseif ($order->status->id == 2 or $order->status->id == 3)
                                    <span class="badge badge-pill badge-warning">{{ $order->status->name }}</span>
                                @elseif ($order->status->id == 5 or $order->status->id == 6)
                                    <span class="badge badge-pill badge-secondary">{{ $order->status->name }}</span>
                                @endif
                            </td>
                            <td class="font-w600 pl-3">{{ $order->shipping_fname }} {{ $order->shipping_lname }}</td>
                            <td class="text-center">{{ $order->payment_method }}</td>
                            <td class="text-center">{{ $order->shipping_method }}</td>
                            <td class="text-right font-size-sm">
                                <strong>{{ number_format($order->total, 2, ',', '.') }}</strong> <span class="text-muted">kn</span>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <a href="{{ route('order.edit', ['id' => $order->id]) }}" class="btn btn-sm btn-outline-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi">
                                    <i class="fa fa-pencil"></i> Uredi
                                </a>
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger" onclick="event.preventDefault(); shouldDelete({{ $order }});">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                {{ $orders->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(() => {
            /* Datepickers */
            $('#start-date-picker').flatpickr({
                enableTime: false,
                dateFormat: "d.m.Y.",
            })
            $('#end-date-picker').flatpickr({
                enableTime: false,
                dateFormat: "d.m.Y.",
            })
            // Select2
            $('#payment-select').select2({
                placeholder: "Odaberi Način Plačanja...",
                allowClear: true
            })

            $('#payment-select').on('change', (e) => {
                let search = e.currentTarget.selectedOptions[0]
                let url = new URL(location.href)
                let params = new URLSearchParams(url.search)
                let keys = []

                for(var key of params.keys()) {
                    if (key === 'payment') {
                        keys.push(key)
                    }
                }

                keys.forEach((value) => {
                    if (params.has(value)) {
                        params.delete(value)
                    }
                })

                if (search.value) {
                    params.append('payment', search.value)
                }

                url.search = params
                location.href = url
            })

            $('#start-date-picker').on('change', (e) => {
                let search = e.currentTarget.value
                let url = new URL(location.href)
                let params = new URLSearchParams(url.search)
                let keys = []

                for(var key of params.keys()) {
                    if (key === 'from') {
                        keys.push(key)
                    }
                }

                keys.forEach((value) => {
                    if (params.has(value)) {
                        params.delete(value)
                    }
                })

                if (search) {
                    params.append('from', search)
                }

                url.search = params
                location.href = url
            })

            $('#end-date-picker').on('change', (e) => {
                let search = e.currentTarget.value
                let url = new URL(location.href)
                let params = new URLSearchParams(url.search)
                let keys = []

                for(var key of params.keys()) {
                    if (key === 'to') {
                        keys.push(key)
                    }
                }

                keys.forEach((value) => {
                    if (params.has(value)) {
                        params.delete(value)
                    }
                })

                if (search) {
                    params.append('to', search)
                }

                url.search = params
                location.href = url
            })
        })

        function shouldDelete(item) {
            console.log(item)

            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Potvrdite brisanje narudžbe br.' + item.id,
                type: 'warning',
                confirmButtonText: 'Da, Obriši!',
            }).then((result) => {
                if (result.value) {
                    deleteItem(item.id)
                }
            })
        }

        function deleteItem(id) {
            axios.post("{{ route('order.destroy') }}", {id: id})
                .then(r => {
                    console.log(r)
                    if (r.data) {
                        successToast.fire({
                            text: 'Narudžbe uspješno obrisana!',
                        })

                        location.reload()
                    }
                })
                .catch(e => {
                    errorToast.fire({
                        text: e,
                    })
                })
        }
    </script>
@endpush
