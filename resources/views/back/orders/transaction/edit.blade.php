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
                                Edit Blog <small class="text-primary pl-4">{{ $blog->title }}</small>
                            @else
                                Create New Blog
                            @endif
                            <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i> Save Blog</button>
                        </h2>

                        <div class="block block-rounded block-shadow">
                            <div class="block-content">
                                <h5 class="text-black mb-0 mt-20">General information</h5>
                                <hr class="mb-30">
                                <div class="row items-push">
                                    <div class="col-lg-3">
                                        <p class="text-muted">General information about website information blogs...</p>
                                        <hr>
                                        <div class="row mt-20">
                                            <div class="col-12">
                                                <label class="form-group mb-20 fileContainer">
                                                    @if (isset($blog))
                                                        <label for="blog-image" id="blog-image-name">Change Main Blog Image</label>
                                                    @else
                                                        <label for="blog-image" id="blog-image-name">Upload Main Blog Image</label>
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
                                    <div class="col-lg-7 offset-lg-1">

                                        <div class="form-group mb-50">
                                            <label for="title">Blog Title @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control form-control-lg" name="title" id="blog-title" placeholder="Name of the product..." value="{{ isset($blog) ? $blog->title : '' }}" onkeyup="SetSEOPreview()">
                                            @error('name')
                                            <span class="text-danger font-italic">Please insert blog title...</span>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="block">
                                            <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#tab-hr"><span class="flag-icon flag-icon-hr mr-10"></span> HR</a>
                                                </li>
                                                <li class="nav-item ml-auto">
                                                    <div class="block-options mr-15 mt-10">
                                                        <button type="button" class="btn-block-option ml-10"
                                                                data-toggle="popover" data-placement="top" data-html="true"
                                                                title="Languages"
                                                                data-content="Insert description content in appropriate languages tabs.">
                                                            <i class="si si-question ml-5"></i>
                                                        </button>
                                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="block-content tab-content overflow-hidden px-0">
                                                <label for="content">Blog content @include('back.layouts.partials.required-star')</label>
                                                <div class="tab-pane fade fade-right show active" id="tab-hr" role="tabpanel">
                                                    <div class="form-group mb-30">
                                                        <textarea class="js-summernote" name="content">
                                                            @if (isset($blog))
                                                                {!! $blog->content !!}
                                                            @endif
                                                        </textarea>
                                                        @error('description')
                                                        <span class="text-danger font-italic">Please insert blog content...</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="mt-30 mb-20">

                                        <div class="form-group mb-50">
                                            <label class="css-control css-control css-control-success css-switch">
                                                <input type="checkbox" class="css-control-input" name="status" @if (isset($blog) and $blog->is_published) checked @endif>
                                                <span class="css-control-indicator"></span> Blog Online Publish Status
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <h5 class="text-black mb-0 mt-20">Blog SEO Details</h5>
                                <hr class="mb-30">
                                <div class="row items-push">
                                    <div class="col-lg-3">
                                        <p class="text-muted"></p>
                                    </div>
                                    <div class="col-lg-7 offset-lg-1">
                                        <div class="form-group mb-50">
                                            <label for="tags">Blog Tags @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control form-control-lg text-primary" id="tags-input" name="tags" value="{{ isset($blog->tags) ? collect($blog->tags)->implode('name', ',') : '' }}">
                                        </div>

                                        <div class="form-group mb-50">
                                            <label for="meta_description">Meta description</label>
                                            <input type="text" class="js-maxlength form-control" name="meta_description" id="blog-meta-description" maxlength="180" placeholder="Type short blog description..." data-always-show="true" value="{{ isset($blog) ? $blog->meta_description : '' }}" onkeyup="SetSEOPreview()">
                                        </div>

                                        <div class="form-group mb-50 mt-20">
                                            <label for="meta_keywords">Google Preview</label>
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
                                    <i class="fa fa-save mr-5"></i> Save Blog
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
          defaultText: 'Insert tag...',
          removeWithBackspace: true,
          delimiter: [',']
        })

        $('.js-summernote').summernote({
          height: 333,
          minHeight: 126,
          placeholder: "Write some description about the product...",
          toolbar: [
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol']],
            ['insert', ['link', 'tabel', 'hr']],
            ['view', ['help']]
          ],
          styleTags: ['p', 'h4', 'blockquote'],
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

@endpush
