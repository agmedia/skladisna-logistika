@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @stack('product_css')
    <style>
        .fileContainer {
            overflow: hidden;
            position: relative;
        }

        .fileContainer [type=file] {
            cursor: inherit;
            display: block;
            font-size: 999px;
            filter: alpha(opacity=0);
            min-height: 34px;
            min-width: 100%;
            opacity: 0;
            position: absolute;
            right: 0;
            text-align: right;
            top: 0;
        }

        .fileContainer {
            background: #E3E3E3;
            float: left;
            padding: .5em 1.5rem;
            height: 34px;
        }

        .fileContainer [type=file] {
            cursor: pointer;
        }


        img.preview {
            width: 200px;
            background-color: white;
            border: 1px solid #DDD;
            padding: 5px;
        }
    </style>
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ isset($product) ? route('product.update', ['product' => $product]) : route('product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('products') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($product))
                    {{ method_field('PATCH') }}
                    Uredi Proizvod <small class="text-primary pl-4">{{ $product->name }}</small>
                @else
                    Novi Proizvod
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-shadow">
                <ul class="nav nav-tabs nav-tabs-block nav-fill" data-toggle="tabs" role="tablist" style="width:100%">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tab-general"><i class="si si-home text-primary mr-2"></i>Generalne Informacije</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-details"><i class="si si-book-open text-primary mr-2"></i>Detalji</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-photo"><i class="si si-frame text-primary mr-2"></i>Fotografije</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-settings"><i class="si si-settings text-primary mr-2"></i>Postavke Proizvoda</a>
                    </li>
                </ul>

                <div class="block-content tab-content">
                    <div class="tab-pane active" id="tab-general" role="tabpanel">
                        @include('back.product.partials.general')
                    </div>
                    <div class="tab-pane" id="tab-details" role="tabpanel">
                        @include('back.product.partials.details')
                    </div>
                    <div class="tab-pane" id="tab-photo" role="tabpanel">
                        @include('back.product.partials.photos')
                    </div>
                    <div class="tab-pane" id="tab-settings" role="tabpanel">
                        @include('back.product.partials.settings')
                    </div>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-5"></i> Snimi Proizvod
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @stack('product_scripts')

@endpush
