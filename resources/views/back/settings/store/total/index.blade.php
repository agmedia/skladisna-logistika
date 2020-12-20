@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Sume na narudžbi
            <small>
                <span class="pl-2">({{ $totals->total() }})</span>
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
                        <th class="text-center" style="width: 18%;">Poredak</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 10%;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($totals as $key => $total)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $total->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td>{{ $total->name }}</td>
                            <td class="text-center">{{ $total->sort_order }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-info" data-toggle="tooltip" title="Uredi" onclick="event.preventDefault(); edit({{ json_encode($total) }}, '{{ $total->code }}');">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>

                {{ $totals->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('modals')
    @foreach($totals as $total)
        @include('back.settings.store.total.modals.' . $total->code)
    @endforeach
@endpush

@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script>
        /**
         *
         * @param item
         * @param type
         */
        function edit(item, type) {
            console.log(type)
            $('#total-modal-' + type).modal('show');
            window["edit_" + type](item);
        }
    </script>

    @stack('total-modal-js')
@endpush
