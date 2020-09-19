@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Info Stranice
            <small>
                <span class="float-right">
                    @if (Bouncer::is(auth()->user())->an('editor') && $pages->count() < 5)
                        <a href="{{ route('page.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                            <i class="si si-plus"></i> Nova Stranica
                        </a>
                    @endif
                    @if (Bouncer::is(auth()->user())->an('admin'))
                        <a href="{{ route('page.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                                <i class="si si-plus"></i> Nova Stranica
                            </a>
                    @endif
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block black">
            <div class="block-content">

                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th>Ime</th>
                        {{--<th class="text-center" style="width: 15%;">Grupa</th>--}}
                        <th class="text-center" style="width: 15%;">Status</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 20%;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($pages as $key => $page)
                        <tbody>
                        <tr>
                            <td class="text-center" style="{{ $page->client_id == 0 ? 'background-color: #e7ffe9;' : '' }}">{{ $key + 1 }}.</td>
                            <td class="font-w600">{{ $page->name }}</td>
                            {{--<td class="text-center pl-3">{{ $page->group }}</td>--}}
                            <td class="text-center">
                                <span class="badge badge-{{ $page->status ? 'success' : 'default' }}">{{ $page->status ? 'Aktivirano' : 'Deaktivirano' }}</span>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <a href="{{ route('page.edit', ['id' => $page->id]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi">
                                    <i class="fa fa-pencil"></i> Uredi
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="event.preventDefault(); shouldDeletePage({{ json_encode($page) }});">
                                    <i class="si si-trash"></i> Obriši
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>

    </div>

@endsection

@push('js_after')
    <script>
        function shouldDeletePage(page) {
            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Izbriši info stranicu: ' + page.name,
                type: 'warning',
                confirmButtonText: 'Da, Obriši ju!',
            }).then((result) => {
                if (result.value) {
                    deletePage(page)
                }
            })
        }

        function deletePage(page) {
            axios.post("{{ route('page.destroy') }}", {data: page})
                .then(r => {
                    if (r.data) {
                        successToast.fire({
                            text: '',
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
