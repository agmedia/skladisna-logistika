@extends('back.layouts.backend')

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
    <div class="content" id="pages-app">

        @include('back.layouts.partials.session')

        @if (isset($page))
            <form action="{{ route('page.update', ['page' => $page]) }}" method="post" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @else
                    <form action="{{ route('page.store') }}" method="post" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <h2 class="content-heading"> <a href="{{ route('pages') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                            @if (isset($page))
                                Uredi Info Stranicu <small class="text-primary pl-4">{{ $page->name }}</small>
                            @else
                                Napravi Novu Info Stranicu
                            @endif
                            <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Snimi Info Stranicu</button>
                        </h2>

                        <div class="block block-rounded block-shadow">
                            <div class="block-content">
                                <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
                                <hr class="mb-30">
                                <div class="row items-push">

                                    <div class="col-lg-12">
                                        @if (Bouncer::is(auth()->user())->an('admin'))
                                            <div class="form-group mb-30">
                                                <label for="group">Odaberi Grupu Stranice @include('back.layouts.partials.required-star')</label>
                                                <select class="form-control" id="page-select" name="group" style="width: 100%;">
                                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                    @foreach (['informacije', 'o nama', 'TAL'] as $group)
                                                        <option value="{{ $group }}" {{ (isset($page) and ($page->group == $group)) ? 'selected' : '' }}>{{ \Illuminate\Support\Str::upper($group) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        <div class="form-group mb-30">
                                            <label for="name">Ime Stranice @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control form-control-lg" name="name" placeholder="Upišite naslov stranice..." value="{{ isset($page) ? $page->name : '' }}">
                                            @error('name')
                                            <span class="text-danger font-italic">Naslov stranice je obvezan...</span>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="block">


                                            <div class="row mt-20">
                                                <div class="col-6">
                                                    <label class="form-group mb-20 fileContainer">
                                                        @if (isset($page))
                                                            <label for="page-image" id="page-image-name">Change Main Blog Image</label>
                                                        @else
                                                            <label for="page-image" id="page-image-name">Upload Main Blog Image</label>
                                                        @endif
                                                        <input type="file" onchange="setImage(event)" id="page-image" name="image" accept="image/*">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row mt-10">
                                                <div class="col-6">
                                                    <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                                                        <img class="img-thumbnail options-item" src="{{ asset(isset($page) ? $page->image : '#') }}" alt="" id="page-image-thumb">
                                                        <div class="options-overlay bg-primary-dark-op">
                                                            <div class="options-overlay-content">
                                                                <h3 class="h4 text-white mb-5" id="page-image-name"></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="block">
                                            <div class="block-content  overflow-hidden px-0">
                                                <label for="description">Sadržaj stranice @include('back.layouts.partials.required-star')</label>

                                                    <div class="form-group mb-30">
                                                        <textarea class="js-summernote" name="description">
                                                            @if (isset($page))
                                                                {!! $page->description !!}
                                                            @endif
                                                        </textarea>
                                                        @error('description')
                                                        <span class="text-danger font-italic">Unesite opis stranice ili sadržaj...</span>
                                                        @enderror
                                                    </div>

                                            </div>
                                        </div>

                                        <div class="form-group mb-50">
                                            <label class="css-control css-control css-control-success css-switch">
                                                <input type="checkbox" class="css-control-input" name="status" @if (isset($page) and $page->status) checked @endif>
                                                <span class="css-control-indicator"></span> Online Status Stranice
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-black mb-0 mt-20">Page SEO Detalji</h5>
                                <hr class="mb-30">
                                <div class="row items-push">

                                    <div class="col-lg-12">
                                        <div class="form-group mb-30">
                                            <label for="slug">SEO URL</label>
                                            <input type="text" class="js-maxlength form-control" name="slug" id="seo-url" maxlength="100" placeholder="Type short SEO Url..." data-always-show="true" value="{{ isset($page) ? $page->slug : '' }}" onkeyup="SetSEOPreview()">
                                        </div>
                                        <div class="form-group mb-30">
                                            <label for="seo_title">SEO Naslov</label>
                                            <input type="text" class="js-maxlength form-control" name="seo_title" id="seo-title" maxlength="100" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($page) ? $page->seo_title : '' }}" onkeyup="SetSEOPreview()">
                                        </div>
                                        <div class="form-group mb-30">
                                            <label for="meta_description">Meta opis</label>
                                            <input type="text" class="js-maxlength form-control" name="meta_description" id="seo-description" maxlength="160" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($page) ? $page->meta_description : '' }}" onkeyup="SetSEOPreview()">
                                        </div>
                                        <div class="form-group mb-50">
                                            <label for="meta_keywords">Meta ključne riječi</label>
                                            <input type="text" class="js-tags-input form-control" data-height="34px" name="meta_keywords" value="{{ isset($page) ? $page->meta_keywords : '' }}">
                                        </div>

                                        <div class="form-group mb-50 mt-20">
                                            <label for="meta_keywords">Google Pregled</label>
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

                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save mr-5"></i> Snimi Info Stranicu
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
        $('#page-select').select2({
          tags: true
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
          document.getElementById('page-image-name').innerHTML = file.name

          let reader = new FileReader()
          let cx = this

          reader.onload = event => {
              document.getElementById('page-image-thumb').src = event.target.result
          }

          reader.readAsDataURL(file)
      }

      function SetSEOPreview() {
        let seo_title = document.getElementById('seo-title').value
        document.getElementById('seo-title-value').innerHTML = seo_title

        let seo_url = document.getElementById('seo-url').value
        document.getElementById('seo-url-value').innerHTML = 'https://{{ request()->getHost() }}/' + seo_url

        let seo_description = document.getElementById('seo-description').value
        document.getElementById('seo-description-value').innerHTML = seo_description
      }
    </script>

@endpush
