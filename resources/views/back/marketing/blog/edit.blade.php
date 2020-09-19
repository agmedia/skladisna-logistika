{{--@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
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

@push('css_after')
@endpush


@section('content')
    <div class="content" id="blogs-app">

        @include('back.layouts.partials.session')

        @if (isset($blog))
            <form action="{{ route('blog.update', ['blog' => $blog]) }}" method="post" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @else
                    <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <h2 class="content-heading"> <a href="{{ route('blogs') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                            @if (isset($blog))
                                Uredi novost <small class="text-primary pl-4">{{ $blog->title }}</small>
                            @else
                                Novi članak
                            @endif
                            <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi članak</button>
                        </h2>

                        <div class="block block-rounded block-shadow">
                            <div class="block-content">
                                <h5 class="text-black mb-0 mt-20">Informacije</h5>
                                <hr class="mb-30">
                                <div class="row items-push">
                                    <!-- left bar -->
                                    <div class="col-lg-3">

                                        <div class="row mt-20">
                                            <div class="col-12">
                                                <label class="form-group mb-20 fileContainer">
                                                    @if (isset($blog))
                                                        <label for="blog-image" id="blog-image-name">Promjeni sliku</label>
                                                    @else
                                                        <label for="blog-image" id="blog-image-name">Dodaj sliku</label>
                                                    @endif
                                                    <input type="file" onchange="setImage(event)" id="blog-image" name="image" accept="image/*">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row mt-10">
                                            <div class="col-12">
                                                <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                                                    <img class="img-thumbnail options-item" src="{{ asset(isset($blog) ? $blog->image : '#') }}" alt="" id="blog-image-thumb">
                                                    <div class="options-overlay bg-primary-dark-op">
                                                        <div class="options-overlay-content">
                                                            <h3 class="h4 text-white mb-5" id="blog-image-name"></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- content -->
                                    <div class="col-lg-8">

                                        <div class="form-group mb-50">
                                            <label for="title">Naslov @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control form-control-lg" name="title" id="blog-title" placeholder="Naslov članka..." value="{{ isset($blog) ? $blog->title : '' }}" onkeyup="SetSEOPreview()">
                                            @error('name')
                                            <span class="text-danger font-italic">Unesite naslov</span>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="block">

                                            <div class="block-content  overflow-hidden px-0">
                                                <label for="description">Sadržaj @include('back.layouts.partials.required-star')</label>

                                                    <div class="form-group mb-30">
                                                        <textarea class="js-summernote" name="description">
                                                            @if (isset($blog))
                                                                {!! $blog->description !!}
                                                            @endif
                                                        </textarea>
                                                        @error('description')
                                                        <span class="text-danger font-italic">Unestite sadržaj...</span>
                                                        @enderror
                                                    </div>

                                            </div>
                                        </div>

                                        <hr class="mt-30 mb-20">

                                        <div class="form-group mb-50">
                                            <label class="css-control css-control css-control-success css-switch">
                                                <input type="checkbox" class="css-control-input" name="status" @if (isset($blog) and $blog->is_published) checked @endif>
                                                <span class="css-control-indicator"></span> Status članka
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <h5 class="text-black mb-0 mt-20">SEO </h5>
                                <hr class="mb-30">
                                <div class="row items-push">
                                    <div class="col-lg-3">
                                        <p class="text-muted"></p>
                                    </div>
                                    <div class="col-lg-7 offset-lg-1">
                                        <div class="form-group mb-50">
                                            <label for="tags">Tagovi @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control form-control-lg text-primary" id="tags-input" name="tags" value="{{ isset($blog->tags) ? collect($blog->tags)->implode('name', ',') : '' }}">
                                        </div>

                                        <div class="form-group mb-50">
                                            <label for="meta_description">Meta opis</label>
                                            <input type="text" class="js-maxlength form-control" name="meta_description" id="blog-meta-description" maxlength="180" placeholder="Unesite kratki opis..." data-always-show="true" value="{{ isset($blog) ? $blog->meta_description : '' }}" onkeyup="SetSEOPreview()">
                                        </div>

                                        <div class="form-group mb-50 mt-20">
                                            <label for="meta_keywords">Google izgled</label>
                                            <div class="block border">
                                                <div class="block-content pt-10">
                                                    <p id="blog-title-value" class="lead font-w400 mb-0" style="color: blue;"></p>
                                                    <p id="blog-url-value" class="mb-0 font-w300" style="color: green;"></p>
                                                    <p id="blog-content-value" class=""></p>
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

    <script>
        $(() => {
            $('#blog-select').select2({
                tags: true
            })

            $('#tags-input').tagsInput({
                height: '38px',
                width: '100%',
                defaultText: 'Tagovi',
                removeWithBackspace: true,
                delimiter: [',']
            })

            $('.js-summernote').summernote({
                height: 333,
                minHeight: 126,
                placeholder: "Upiši sadržaj stranice...",
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                styleTags: ['p', 'h3', 'h4','blockquote'],
            })

            SetSEOPreview()
        })


        function setImage(e) {
            let file = e.target.files[0]
            document.getElementById('blog-image-name').innerHTML = file.name

            let reader = new FileReader()
            let cx = this

            reader.onload = event => {
                document.getElementById('blog-image-thumb').src = event.target.result
            }

            reader.readAsDataURL(file)
        }

        function SetSEOPreview() {
            let seo_title = document.getElementById('blog-title').value
            if (seo_title) {
                document.getElementById('blog-title-value').innerHTML = seo_title
                document.getElementById('blog-url-value').innerHTML = 'https://{{ request()->getHost() }}/blog/' + slugify(seo_title)
            }

            let blog_meta_description = document.getElementById('blog-meta-description').value
            if (blog_meta_description) {
                document.getElementById('blog-content-value').innerHTML = blog_meta_description
            }
        }
    </script>

@endpush--}}

@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@stack('page_css')


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ isset($blog) ? route('blog.update', ['blog' => $blog]) : route('blog.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('blogs') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($blog))
                    {{ method_field('PATCH') }}
                    Uredi Novost <small class="text-primary pl-4">{{ $blog->title }}</small>
                @else
                    Napravi Novu Novost
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-lg-7">

                            <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                            <hr class="mb-30">

                            <div class="block {{ isset($blog) && isset($blog->image) ? '' : 'block-mode-hidden' }}">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Glavna slika novosti</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" style="padding: 10px 0 20px 0;">
                                    <div class="slim"
                                         {{--data-service="async.php"
                                         data-fetcher="fetch.php"--}}
                                         data-ratio="16:9"
                                         data-size="1280,720"
                                         data-max-file-size="2">
                                        <img src="{{ isset($blog) && isset($blog->image) ? asset($blog->image) : asset('media/temp/slider/1.jpg') }}" alt=""/>
                                        <input type="file" name="main_image"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-50 mt-30">
                                <label for="name">Ime Novosti @include('back.layouts.partials.required-star')</label>
                                <input type="text" class="form-control form-control-lg" name="title" id="title-input" placeholder="Upišite naslov stranice..." value="{{ isset($blog) ? $blog->title : '' }}" onkeyup="SetSEOPreview()">
                                @error('name')
                                <span class="text-danger font-italic">Naslov novosti je obvezan...</span>
                                @enderror
                            </div>

                            <h5 class="text-black mb-0 mt-20">SEO Detalji</h5>
                            <hr class="mb-30">

                            <div class="form-group mb-30">
                                <label for="slug">Svojevoljni SEO URL <span class="text-gray">Nije preporučljivo!</span></label>
                                <input type="text" class="js-maxlength form-control" name="slug" id="seo-url" maxlength="100" placeholder="Type short SEO Url..." data-always-show="true" value="{{ isset($blog) ? $blog->slug : '' }}" onkeyup="SetSEOPreview()">
                            </div>
                            <div class="form-group mb-30">
                                <label for="seo_title">SEO Naslov</label>
                                <input type="text" class="js-maxlength form-control" name="seo_title" id="seo-title" maxlength="100" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($blog) ? $blog->seo_title : '' }}" onkeyup="SetSEOPreview()">
                            </div>
                            <div class="form-group mb-30">
                                <label for="seo-description">Meta opis</label>
                                <textarea class="form-control" id="seo-description" name="meta_description" rows="4" placeholder="Kratki SEO opis stranice..." onkeyup="SetSEOPreview()">{{ isset($blog) ? $blog->meta_description : '' }}</textarea>
                                {{--<input type="text" class="js-maxlength form-control" name="meta_description" id="seo-description" maxlength="100" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($blog) ? $blog->meta_description : '' }}" onkeyup="SetSEOPreview()">--}}
                            </div>
                            <div class="form-group mb-30">
                                <label for="meta_keywords">Meta ključne riječi</label>
                                <input type="text" class="js-tags-input form-control text-primary" id="tags-input" name="tags" value="{{ isset($blog) ? $blog->meta_keywords : '' }}">
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
                                                <p id="seo-title-value" class="lead font-w400 mb-0" style="color: blue;"></p>
                                                <p id="seo-url-value" class="mb-0 font-w300" style="color: green;"></p>
                                                <p id="seo-description-value" class=""></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-20">Detalji Novosti</h5>
                            <hr class="mb-30">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    @if (Bouncer::is(auth()->user())->an('admin'))
                                        <div class="form-group mb-20">
                                            <label for="group">Odaberi Pripadnost Novosti @include('back.layouts.partials.required-star')</label>
                                            <select class="form-control" id="blog-select" name="category_id" style="width: 100%;">
                                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                @foreach ($cats as $group)
                                                    <option value="{{ $group['id'] }}" {{ (isset($blog) and ($blog->category_id == $group['id'])) ? 'selected' : '' }}>{{ \Illuminate\Support\Str::upper($group['name']) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h5 class="text-black mb-0 mt-30">Status Novosti</h5>
                            <hr class="mb-20">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30">
                                        <label class="css-control css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" name="is_published" @if (isset($blog) and $blog->is_published) checked @endif>
                                            <span class="css-control-indicator"></span> Objavi Novost
                                        </label>
                                    </div>

                                    <div class="form-group mb-20">
                                        <label for="slug">Ili objavi novost određenog datuma</label>
                                        <input type="text" name="date_published" id="published-date-picker" class="form-control " placeholder="Od..."
                                               value="{{ (isset($blog) and $blog->publish_date) ? date_format(date_create($blog->publish_date), 'd.m.Y.') : '' }}" style="height: 34px; background-color: white;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-12">
                            <div class="block">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Sadržaj Novosti</h3>
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
                                            @if (isset($blog))
                                                {!! $blog->description !!}
                                            @endif
                                        </textarea>
                                        @error('description')
                                        <span class="text-danger font-italic">Unesite opis novosti ili sadržaj...</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <h5 class="text-black mb-0 mt-0">Dodaci na Stranici</h5>
                            <hr class="mb-30">

                            <div class="block block-mode-hidden">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Galerija fotografija</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    @include('back.marketing.blog.partials.gallery')
                                </div>
                            </div>

                            <div class="block block-mode-hidden">
                                <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                                    <h3 class="block-title">Dokumenti</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                    </div>
                                </div>
                                <div class="block-content" id="ag-doc-block-app">
                                    @include('back.marketing.blog.partials.documents')
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('js/components/ag-block.js') }}"></script>
    {{--<script src="{{ asset('vendors~pdfjsWorker.js') }}"></script>--}}

    <script>
        $(() => {
            $('#blog-select').select2({
                tags: false
            })

            /* Datepickers */
            $('#published-date-picker').flatpickr({
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

            $('.js-summernote').summernote({
                height: 333,
                minHeight: 126,
                placeholder: "Upiši sadržaj stranice...",
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['picture', 'video', 'link', 'tabel', 'hr']],
                    ['view', ['codeview', 'help']]
                ],
                styleTags: ['p', 'h4', 'blockquote'],
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
