@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
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
    <div class="content" id="pages-app">

        @include('back.layouts.partials.session')

        <form action="{{ isset($manufacturer) ? route('manufacturer.update', ['manufacturer' => $manufacturer]) : route('manufacturer.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('manufacturers') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($manufacturer))
                    {{ method_field('PATCH') }}
                    Uredi Proizvođača <small class="text-primary pl-4">{{ $manufacturer->name }}</small>
                @else
                    Napravi Novog Proizvođača
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">
                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">
                            <div class="block {{ isset($manufacturer) && isset($manufacturer->image) ? '' : 'block-mode-hidden' }}">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Glavna Fotografija Proizvođača</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" style="padding: 10px 0 20px 0;">
                                    <div class="row">
                                        <dov class="col-md-10 offset-md-1">
                                            <div class="slim"
                                                 data-force-size="400,100"
                                                 data-max-file-size="1">
                                                <img src="{{ isset($manufacturer) && isset($manufacturer->image) ? asset($manufacturer->image) : '' }}" alt=""/>
                                                <input type="file" name="image"/>
                                            </div>
                                        </dov>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-50">
                                <label for="name">Ime</label>
                                <input type="text" class="form-control" name="name" id="category-name-input" value="{{ isset($manufacturer->name) ? $manufacturer->name : '' }}" placeholder="" onkeyup="SetSEOPreview()">
                            </div>
                            <div class="form-group mb-30">
                                <label for="slug">Svojevoljni SEO URL <span class="text-gray">Nije preporučljivo!</span></label>
                                <input type="text" class="form-control" name="slug" id="slug-input" value="{{ isset($manufacturer->slug) ? $manufacturer->slug : '' }}" placeholder="">
                            </div>

                            <div class="block block-mode-hidden mb-30 mt-20 d-none d-md-block">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Google pregled</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="form-group">
                                        <div class="block border">
                                            <div class="block-content pt-10">
                                                <p id="category-title-value" class="lead font-w400 mb-0" style="color: blue;"></p>
                                                <p id="category-url-value" class="mb-0 font-w300" style="color: green;"></p>
                                                <p id="category-content-value" class=""></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-20">Detalji Stranice</h5>
                            <hr class="mb-30">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-20 mt-20">
                                        <label class="css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" {{ (isset($manufacturer->status) and $manufacturer->status) ? 'checked' : '' }} name="status">
                                            <span class="css-control-indicator"></span> Online Status Proizvođača
                                        </label>
                                    </div>
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control-info css-switch">
                                            <input type="checkbox" class="css-control-input" {{ (isset($manufacturer->carousel) and $manufacturer->carousel) ? 'checked' : '' }} name="carousel">
                                            <span class="css-control-indicator"></span> Prikaži u traci
                                        </label>
                                    </div>
                                    <div class="form-group mb-30">
                                        <label for="sort_order">Redosljed Sortiranja</label>
                                        <input type="text" class="js-maxlength form-control" name="sort_order" maxlength="3" placeholder="Samo brojevi..." data-always-show="true" value="{{ isset($manufacturer) ? $manufacturer->sort_order : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-12">
                            <div class="block">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Opis Proizvođača</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option ml-10" data-toggle="popover" data-placement="top" data-html="true" title="Languages" data-content="Insert description content in appropriate languages tabs.">
                                            <i class="si si-question ml-5"></i>
                                        </button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" style="padding: 10px 0;">
                                    <div class="form-group mb-30">
                                        <textarea class="js-summernote" name="description">
                                            @if (isset($manufacturer))
                                                {!! $manufacturer->description !!}
                                            @endif
                                        </textarea>
                                        @error('description')
                                        <span class="text-danger font-italic">Unesite opis proizvođača ako je potreban...</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
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
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>

    <script>
        $(() => {
            $('.js-summernote').summernote({
                height: 333,
                minHeight: 126,
                placeholder: "Možda kratki opis proizvođača...",
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link', 'tabel', 'hr']],
                    ['view', ['codeview', 'help']]
                ],
                styleTags: ['p', 'h4', 'blockquote'],
            })

            SetSEOPreview()
        })


        function setImage(e) {
            let file = e.target.files[0]
            document.getElementById('category-image-name').innerHTML = file.name

            let reader = new FileReader()
            let cx = this

            reader.onload = event => {
                document.getElementById('category-image-thumb').src = event.target.result
            }

            reader.readAsDataURL(file)
        }


        function SetSEOPreview() {
            let title = document.getElementById('category-name-input').value
            document.getElementById('slug-input').value = slugify(title)

            if (title) {
                document.getElementById('category-title-value').innerHTML = title
                document.getElementById('category-url-value').innerHTML = 'https://{{ request()->getHost() }}/' + slugify(title)
            }

            let category_meta_description = document.getElementById('category-meta-description').value
            if (category_meta_description) {
                document.getElementById('category-content-value').innerHTML = category_meta_description
            }
        }

    </script>

@endpush
