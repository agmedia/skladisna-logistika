@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css_after')
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ isset($action) ? route('action.update', ['action' => $action]) : route('action.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('actions') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($action))
                    {{ method_field('PATCH') }}
                    Uredi Akciju <small class="text-primary pl-4">{{ $action->product->name }}</small>
                @else
                    Napravi Novu Akciju
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">
                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">
                            <div class="form-group mb-50">
                                <label for="products">Odaberi akcijske proizvode</label>
                                <select class="form-control" id="product-select" name="products[]" style="width: 100%;" multiple>
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($products as $product)
                                        <option value="{{ $product['id'] }}" {{ ((isset($action)) and ($product['id'] == $action->product->id)) ? 'selected' : '' }}>{{ $product['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group row mb-50">
                                <div class="col-md-6">
                                    <label for="date_start">Početak akcije</label>
                                    <input type="text" name="date_start" id="start-date-picker" class="form-control form-control-lg" value="{{ isset($action) ? date_format(date_create($action->date_start), 'd.m.Y. H:m') : '' }}" style="height: 34px; background-color: white;">
                                </div>
                                <div class="col-md-6">
                                    <label for="date_end">Kraj akcije</label>
                                    <input type="text" class="form-control form-control-lg" name="date_end" id="end-date-picker" value="{{ isset($action) ? date_format(date_create($action->date_end), 'd.m.Y. H:m') : '' }}" style="height: 34px; background-color: white;">
                                </div>
                            </div>

                            <div class="form-group row mb-50">
                                <div class="col-md-12">
                                    <label for="discount">Popust</label>
                                    <input type="text" class="form-control" name="discount" placeholder="Type discount percent..." value="{{ isset($action) ? $action->discount : '' }}">
                                </div>
                                {{--<div class="col-md-6">
                                    <label for="price">Cijena sa popustom</label>
                                    <input type="text" class="form-control" name="price" placeholder="Type special price..." value="{{ isset($action) ? $action->price : '' }}">
                                </div>--}}
                            </div>
                        </div>

                        <div class="col-lg-5">

                        </div>
                    </div>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-5"></i> Snimi
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
      $(() => {
        $('#product-select').select2()

        $('#start-date-picker').flatpickr({
          enableTime: true,
          dateFormat: "d.m.Y. H:i",
        })

        $('#end-date-picker').flatpickr({
          enableTime: true,
          dateFormat: "d.m.Y. H:i",
        })
      })
    </script>

@endpush
