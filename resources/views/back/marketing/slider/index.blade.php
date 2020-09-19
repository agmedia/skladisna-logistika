@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Slideri <small class="text-muted ml-30">Lista grupa</small>
            <small>
                <span class="float-right">
                    @if (Bouncer::is(auth()->user())->an('editor') && $sliders->count() < 1)
                        <a href="{{ route('slider.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                            <i class="si si-plus"></i> Novi Slider
                        </a>
                    @endif
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-content">

                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 15%;">Količina</th>
                        <th class="text-center" style="width: 15%;">Status</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 30%;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($sliders as $key => $slider)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="font-w600">{{ $slider->name }}</td>
                            <td class="text-center pl-3">{{ count($slider->sliders) }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $slider->status ? 'success' : 'default' }}">{{ $slider->status ? 'Aktivirano' : 'Deaktivirano' }}</span>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <a href="{{ route('slider.edit', ['id' => $slider->id]) }}" class="btn btn-sm btn-outline-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="{{ route('slider.edit.sliders', ['id' => $slider->id]) }}" class="btn btn-sm btn-outline-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi">
                                    <i class="fa fa-film mr-5"></i> Slideri
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="event.preventDefault(); shouldDeleteSlider({{ json_encode($slider) }});">
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
        function shouldDeleteSlider(slider) {
            console.log(slider)

            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Potvrdi brisanje Slidera: ' + slider.name,
                type: 'warning',
                confirmButtonText: 'Da, Obriši ga!',
            }).then((result) => {
                if (result.value) {
                    deleteSlider(slider)
                }
            })
        }

        function deleteSlider(slider) {
            axios.post("{{ route('slider.destroy') }}", {data: slider})
                .then(r => {
                    successToast.fire({
                        text: '',
                    })

                    location.reload()
                })
                .catch(e => {
                    errorToast.fire({
                        text: e,
                    })
                })
        }
    </script>
@endpush
