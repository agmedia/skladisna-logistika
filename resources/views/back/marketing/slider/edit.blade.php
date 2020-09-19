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

        @if (isset($slider))
            <form action="{{ route('slider.update', ['id' => $slider->id]) }}" method="post" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @else
                    <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <h2 class="content-heading"> <a href="{{ route('sliders') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                            @if (isset($slider))
                                Uredi Grupu Slidera <small class="text-primary pl-4">{{ $slider->name }}</small>
                            @else
                                Stvori Novu Slider Grupu
                            @endif
                            <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi Slider Grupu</button>
                        </h2>

                        <div class="block block-rounded block-shadow" id="actions-app">
                            <div class="block-content" id="ag-slider-app">
                                <h5 class="text-black mb-0 mt-20">Slider Grupa
                                    @if (isset($slider))
                                        <a href="{{ route('slider.edit.sliders', ['id' => $slider->id]) }}" class="btn btn-outline-primary btn-sm float-right"><i class="fa fa-film mr-5"></i> Slideri</a>
                                    @endif
                                </h5>
                                <hr class="mb-30">
                                <div class="row items-push">
                                    <div class="col-lg-3">
                                        <p class="text-muted">Generalne informacije o Slider Grupi...</p>
                                    </div>
                                    <div class="col-lg-7 offset-lg-1">

                                        <div class="form-group mb-50">
                                            <label for="name">Ime Grupe</label>
                                            <input type="text" class="form-control" name="name" placeholder="Type slider group name..." value="{{ isset($slider) ? $slider->name : '' }}">
                                        </div>

                                        {{--<div class="form-group mb-50">
                                            <label for="name">Select where you want to show the slider group?</label>
                                            <table class="table table-borderless table-vcenter">
                                                <tbody>
                                                <tr>
                                                    <td style="width: 15%"><label for="products">Product</label></td>
                                                    <td--}}{{-- class="d-none d-sm-table-cell"--}}{{-->
                                                        <select class="form-control" id="products-select" name="products" style="width: 100%;">
                                                            <option></option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product['id'] }}" {{ (isset($slider) and ($product['id'] == $slider->product_id)) ? 'selected' : '' }}>{{ $product['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="categories">Category</label></td>
                                                    <td--}}{{-- class="d-none d-sm-table-cell"--}}{{-->
                                                        <select class="form-control" id="categories-select" name="categories" style="width: 100%;">
                                                            <option></option>
                                                            @foreach ($categories['admin_list'] as $category)
                                                                <option value="{{ $category->id }}" {{ (isset($slider) and ($category->id == $slider->category_id)) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="pages">Page</label></td>
                                                    <td--}}{{-- class="d-none d-sm-table-cell"--}}{{-->
                                                        <select class="form-control" id="pages-select" name="pages" style="width: 100%;">
                                                            <option></option>
                                                            <option value="home" {{ (isset($slider) and ('home' == $slider->page_id)) ? 'selected' : '' }}>Home page</option>
                                                            <option value="contact" {{ (isset($slider) and ('contact' == $slider->page_id)) ? 'selected' : '' }}>Contact page</option>
                                                            @foreach ($pages as $page)
                                                                <option value="{{ $page['id'] }}" {{ (isset($slider) and ($page['id'] == $slider->page_id)) ? 'selected' : '' }}>{{ $page['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group row mb-50">
                                            <div class="col-md-6">
                                                <label for="date_start">Start date</label>
                                                <input type="text" name="date_start" id="start-date-picker" class="form-control form-control-lg" value="{{ isset($slider) ? date_format(date_create($slider->date_start), 'd.m.Y. H:m') : '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="date_end">End date</label>
                                                <input type="text" class="form-control form-control-lg" name="date_end" id="end-date-picker" value="{{ isset($slider) ? date_format(date_create($slider->date_end), 'd.m.Y. H:m') : '' }}">
                                            </div>
                                        </div>--}}

                                        <div class="form-group mb-30">
                                            <label class="css-control css-control css-control-success css-switch">
                                                <input type="checkbox" class="css-control-input" name="status" @if (isset($slider) and $slider->status) checked @endif>
                                                <span class="css-control-indicator"></span> Online Status Slider Grupe
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                {{--@include('back.settings.slider.partials.photos')--}}
                                {{--<ag-slider-images></ag-slider-images>--}}

                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save mr-5"></i> Snimi Slider Grupu
                                </button>
                            </div>
                        </div>
                    </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    {{--<script src="{{ asset('js/ag-slider-images.js') }}"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
      $(() => {
        $('#products-select').select2()
        $('#categories-select').select2()
        $('#pages-select').select2()

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

    @stack('slider_scripts')

@endpush
