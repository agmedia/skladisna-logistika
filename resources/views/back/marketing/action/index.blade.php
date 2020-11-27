@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Akcije
            <small>
                <span class="float-right">{{--{{ $count }}--}}
                    <a href="{{ route('action.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                        <i class="si si-plus"></i> Nova Akcija
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
                        <th style="width: 30px;">#</th>
                        <th>Ime Proizvoda</th>
                        <th class="text-center" style="width: 15%;">Od</th>
                        <th class="text-center" style="width: 15%;">Do</th>
                        <th class="text-center" style="width: 10%;">Popust</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 90px;">Akcija</th>
                    </tr>
                    </thead>
                    @foreach($actions as $key => $action)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="font-w600">
                                <a href="{{ route('action.edit', ['id' => $action->id]) }}" class="js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi">{{ $action->product ? $action->product->name : '' }}</a>
                            </td>
                            <td class="text-center font-size-sm">{{ $action->date_start ? date_format(date_create($action->date_start), 'd.m.Y. H:m') : '' }}</td>
                            <td class="text-center font-size-sm">{{ $action->date_end ? date_format(date_create($action->date_end), 'd.m.Y. H:m') : '' }}</td>
                            <td class="text-center"><strong>{{ $action->discount }}</strong>%</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger" onclick="event.preventDefault(); shouldDeleteAction({{ json_encode($action) }});">
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
      function shouldDeleteAction(action) {
        console.log(action)

        confirmPopUp.fire({
          title: 'Are you sure?',
          text: 'Confirm deleting action for product ' + action.product.name,
          type: 'warning',
          confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
          if (result.value) {
            deleteAction(action)
          }
        })
      }

      function deleteAction(action) {
        axios.post("{{ route('action.destroy') }}", {data: action})
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
