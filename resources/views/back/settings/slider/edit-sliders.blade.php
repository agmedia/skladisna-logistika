@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/sl.edit.core.css') }}">
@endpush

@push('css_after')
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <h2 class="content-heading">
            <a href="{{ route('sliders') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
            <a href="{{ route('slider.edit', ['id' => $slider->id]) }}" class="mr-10 text-muted font-size-h4"><i class="si si-action-undo"></i></a>
            Edit Sliders for Group <small class="text-primary pl-4">{{ $slider->name }}</small>
        </h2>

        <div class="block block-rounded block-shadow" id="actions-app">
            <div class="block-content" id="ag-slider-app">
                <ag-slider-images upload_url="{{ route('api.sliders.store') }}" get_url="{{ route('api.sliders.get', ['group' => $slider->id]) }}" group="{{ $slider->id }}"></ag-slider-images>
            </div>
        </div>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/sl.edit.core.js') }}"></script>
    <script src="{{ asset('js/ag-slider-images.js') }}"></script>
@endpush
