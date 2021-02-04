@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Najmovi
            <small>
                <span class="pl-2">({{ $rents->total() }})</span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block" id="ag-order-filter-app">
            <div class="block-content">
                <div class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 63px;">#</th>
                        <th class="text-center">Email</th>
                        <th>Viličar</th>
                        <th class="text-center" style="width: 81px;">Datum</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 120px;">Akcije</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rents as $key => $rent)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route('rent.show', ['id' => $rent->id]) }}">
                                    {{ $rent->id }}
                                </a>
                            </td>
                            <td class="text-center">{{ $rent->email }}</td>
                            <td class="font-w600 pl-3">{{ $rent->type }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::make($rent->rent_start_date)->format('d.m.Y') }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <a href="{{ route('rent.show', ['id' => $rent->id]) }}" class="btn btn-sm btn-circle btn-alt-info js-tooltip-enabled" data-toggle="tooltip" data-title="Pogledaj">
                                    <i class="fa fa-eye"></i>
                                </a>
<!--                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger js-tooltip-enabled" data-toggle="tooltip" data-title="Obriši" onclick="event.preventDefault(); shouldDelete({{ $rent }});">
                                    <i class="fa fa-times"></i>
                                </button>-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                {{ $rents->links('back.layouts.partials.paginate') }}
            </div>
        </div>

    </div>

@endsection

@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(() => {});

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
