@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Proizvođači
            <small>
                <span class="float-right">
                    <a href="{{ route('manufacturer.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="Novi Proizvođač">
                        <i class="si si-plus"></i> Novi Proizvođač
                    </a>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block black">
            <div class="block-content">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 30px;">#</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 12%;">Poredak</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 100px;">Akcija</th>
                    </tr>
                    </thead>
                    @foreach($manufacturers as $key => $manufacturer)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $manufacturer->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600">
                                <a href="{{ route('manufacturer.edit', ['id' => $manufacturer->id]) }}" class="js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi Proizvođača">{{ $manufacturer->name }}</a>
                            </td>
                            <td class="text-center">{{ $manufacturer->sort_order }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger" onclick="event.preventDefault(); shouldDeleteItem({{ json_encode($manufacturer) }});">
                                    <i class="fa fa-times"></i>
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
      function shouldDeleteItem(item) {
        console.log(item)

        confirmPopUp.fire({
          title: 'Jeste li sigurni!?',
          text: 'Potvrdi brisanje proizvođača ' + item.name,
          type: 'warning',
          confirmButtonText: 'Da, obriši!',
        }).then((result) => {
          if (result.value) {
            deleteItem(item)
          }
        })
      }

      function deleteItem(item) {
        axios.post("{{ route('manufacturer.destroy') }}", {data: item})
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
