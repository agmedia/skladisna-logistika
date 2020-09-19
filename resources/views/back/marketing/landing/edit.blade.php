@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
    </style>
@endpush

@stack('page_css')


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ isset($landing) ? route('landing.update', ['landing' => $landing]) : route('landing.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('landings') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($landing))
                    {{ method_field('PATCH') }}
                    Uredi Landing Stranicu <small class="text-primary pl-4">{{ $landing->title }}</small>
                @else
                    Napravi Landing Stranicu
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Sekcija 1 i Generalne informacije</h3>
                </div>
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">

                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">

                            <div class="block {{ isset($landing) && isset($landing->image) ? '' : 'block-mode-hidden' }}">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Glavna slika landing stranice</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" style="padding: 10px 0 20px 0;">
                                    <div class="slim"
                                         {{--data-service="async.php"
                                         data-fetcher="fetch.php"--}}
                                         data-ratio="16:9"
                                         data-size="600,360"
                                         data-max-file-size="2">
                                        <img src="{{ isset($landing) && isset($landing->image) ? asset($landing->image) : asset('media/images/bcllanding.jpg') }}" alt=""/>
                                        <input type="file" name="main_image"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-30 mt-50">
                                <label for="client">Naslov Landing Stranice ili Klijenta @include('back.layouts.partials.required-star')</label>
                                <input type="text" class="form-control" name="client" id="client" placeholder="Upišite klijenta za landing..." value="{{ isset($landing) ? $landing->client : '' }}" onkeyup="SetSEOPreview()">
                                @error('title')
                                <span class="text-danger font-italic">Ime Klijenta je obvezno...</span>
                                @enderror
                            </div>
                            <div class="form-group mb-30">
                                <label for="content">Kratki Opis</label>
                                <textarea class="form-control" id="content" name="content_1" rows="4" placeholder="Kratki opis za glavni banner...">{{ isset($landing) ? $landing->content_1 : '' }}</textarea>
                            </div>

                            {{--<div class="block block-mode-hidden mb-30 mt-20 d-none d-md-block">
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
                                                <p id="seo-title-value" class="lead font-w400 mb-0" style="color: blue;"></p>
                                                <p id="seo-url-value" class="mb-0 font-w300" style="color: green;"></p>
                                                <p id="seo-description-value" class=""></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-30">Status Landing Stranice</h5>
                            <hr class="mb-20">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="is_published" @if (isset($landing) and $landing->is_published) checked @endif>
                                            <span class="css-control-indicator"></span> Objavi Landing Stranicu
                                        </label>
                                    </div>

                                    <div class="form-group mb-20">
                                        <label>Ili objavi u određeno vrijeme</label>
                                        <input type="text" name="date_start" id="date-start-date-picker" class="form-control " placeholder="Od..."
                                               value="{{ (isset($landing) and $landing->date_start) ? date_format(date_create($landing->date_start), 'd.m.Y.') : '' }}" style="height: 34px; background-color: white;">
                                    </div>
                                    <div class="form-group mt-20">
                                        <input type="text" name="date_end" id="date-end-date-picker" class="form-control " placeholder="Do..."
                                               value="{{ (isset($landing) and $landing->date_end) ? date_format(date_create($landing->date_end), 'd.m.Y.') : '' }}" style="height: 34px; background-color: white;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('back.marketing.landing.partials.section_2', [ 'original_tag' => 'section[2]' ])

            @include('back.marketing.landing.partials.section_3', [ 'original_tag' => 'section[3]' ])

            @include('back.marketing.landing.partials.section_4')

            @include('back.marketing.landing.partials.section_5')

            @include('back.marketing.landing.partials.section_6', [ 'original_tag' => 'section[6]' ])

            @include('back.marketing.landing.partials.section_7')

            <div class="block block-rounded block-shadow">
                <div class="block-content block-content-full block-content-sm font-size-sm text-right">
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{--<script src="{{ asset('js/components/ag-product-block.js') }}"></script>--}}
    {{--<script src="{{ asset('vendors~pdfjsWorker.js') }}"></script>--}}

    <script>
        $(() => {
            $('#blog-select').select2({
                tags: false
            })

            /* Datepickers */
            $('#date-start-date-picker').flatpickr({
                enableTime: false,
                dateFormat: "d.m.Y.",
            })
            $('#date-end-date-picker').flatpickr({
                enableTime: false,
                dateFormat: "d.m.Y.",
            })

            $('#tags-input').tagsInput({
                height: '38px',
                width: '100%',
                defaultText: 'Insert tag...',
                removeWithBackspace: true,
                delimiter: [',']
            })



            SetSEOPreview()
        })

        function SetSEOPreview() {
            let title = document.getElementById('title-input').value
            document.getElementById('seo-url').value = slugify(title)

            if (title) {
                document.getElementById('seo-title-value').innerHTML = title
                document.getElementById('seo-url-value').innerHTML = 'https://{{ request()->getHost() }}/' + slugify(title)
            }

            let category_meta_description = document.getElementById('seo-description').value
            if (category_meta_description) {
                document.getElementById('seo-description-value').innerHTML = category_meta_description
            }

        }
    </script>

    @stack('page_js')

@endpush
