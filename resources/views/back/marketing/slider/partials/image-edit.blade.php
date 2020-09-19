@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">
@endpush

@section('content')
    <div class="content">
        <!-- Form -->
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"><a href="{{ route('product.edit', ['id' => $id]) }}" class="js-tooltip mr-10 text-gray font-size-h4" title="Back to Product"><i class="si si-action-undo"></i></a> Uredi fotografiju
                {{--<button type="submit" class="btn btn-primary btn-sm float-right">
                    <i class="fa fa-save mr-5"></i>
                    {{ __('base.form.save') }}
                </button>--}}
            </h2>

            @include('back.layouts.partials.session')

            <!-- Toolbar -->
            <div class="block mb-10">
                <div class="block-content">
                    <div class="btn-group push">
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="setDragMode" data-option="move" title="Set drag mode to move">
                            <i class="fa fa-arrows"></i>
                        </button>
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="setDragMode" data-option="crop" title="Set drag mode to crop">
                            <i class="fa fa-crop"></i>
                        </button>
                    </div>
                    <div class="btn-group push">
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="zoom" data-option="0.1" title="Zoom In">
                            <i class="fa fa-search-plus"></i>
                        </button>
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="zoom" data-option="-0.1" title="Zoom Out">
                            <i class="fa fa-search-minus"></i>
                        </button>
                    </div>
                    <div class="btn-group push">
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="rotate" data-option="-11.25" title="Rotate Left">
                            <i class="fa fa-rotate-left"></i>
                        </button>
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="rotate" data-option="11.25" title="Rotate Right">
                            <i class="fa fa-rotate-right"></i>
                        </button>
                    </div>
                    <div class="btn-group push">
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                            <i class="fa fa-arrows-h"></i>
                        </button>
                        <button type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="scaleY" data-option="-1" title="Flip Vertical">
                            <i class="fa fa-arrows-v"></i>
                        </button>
                    </div>
                    <div class="btn-group push">
                        <button id="save-croped" type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="save" title="Save Croped Image">
                            <i class="fa fa-save"></i> Snimi
                        </button>
                    </div>
                </div>
            </div>
            <!-- END Toolbar -->

            <!-- Image Cropper -->
            <div class="block">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-xl-8">
                            <div>
                                <img id="js-img-cropper" class="img-fluid" src="{{ asset($image->dirname . '/' . $image->basename) }}" alt="photo">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="overflow-hidden mb-10">
                                <div class="js-img-cropper-preview center-block overflow-hidden" style="height: 200px;"></div>
                            </div>
                            <div class="overflow-hidden mb-10">
                                <p>
                                    <strong>{{ $image->basename }}</strong><br>
                                    @if (($image->filesize() / 1000) < 999)
                                        <strong>{{ number_format($image->filesize() / 1000) }}</strong> KB<br>
                                    @else
                                        <strong>{{ number_format($image->filesize() / 1000000, 1) }}</strong> MB<br>
                                    @endif
                                    {{ $image->width() . 'x' . $image->height() }} px<br>
                                </p>
                            </div>
                            <div class="overflow-hidden mb-10">
                                <button id="save-croped" type="button" class="js-tooltip btn btn-alt-primary" data-toggle="cropper" data-method="saveAsSlider" title="Save as Default Image!">
                                    <i class="fa fa-save"></i> Postavi kao glavnu fotografiju
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <!-- END Form -->
    </div>
@stop

@push('js_after')
    <script src="{{ asset('js/cropper.min.js') }}"></script>

    <script>
      // Get Image Container
      let image = document.getElementById('js-img-cropper');
      let aspect_ratio = 16/9

      let type = "{{ $type }}"
      let type_id = "{{ $id }}"

      console.log(type)

      if (type == 'products') {
        aspect_ratio = 4/4
      }

      // Set Options
      Cropper.setDefaults({
        aspectRatio: aspect_ratio,
        preview: '.js-img-cropper-preview',
      });

      // Init Image Cropper
      let cropper = new Cropper(image, {
        crop: function (e) {
          // e.detail contains all data required to crop the image server side
          // You will have to send it to your custom server side script and crop the image there
          // Since this event is fired each time you set the crop section, you could also use getData()
          // method on demand. Please check out https://fengyuanchen.github.io/cropperjs/ for more info
          //console.log(e.detail);
        }
      });

      // Mini Cropper API
      jQuery('[data-toggle="cropper"]').on('click', e => {
        let btn     = jQuery(e.currentTarget);
        let method  = btn.data('method') || false;
        let option  = btn.data('option') || false;

        // Method selection with object literals
        let cropperAPI = {
          zoom: () => {
            cropper.zoom(option);
          },
          setDragMode: () => {
            cropper.setDragMode(option);
          },
          rotate: () => {
            cropper.rotate(option);
          },
          scaleX: () => {
            cropper.scaleX(option);
            btn.data('option', -(option));
          },
          scaleY: () => {
            cropper.scaleY(option);
            btn.data('option', -(option));
          },
          save: () => {
            let croppedImage = cropper.getCroppedCanvas()

            croppedImage.toBlob((blob) => {
              //console.log(blob)
              let formdata = new FormData()

              formdata.append('image', blob);
              formdata.append('type', type);
              formdata.append('type_id', type_id);
              formdata.append('name', "{{ $image->basename }}");

              axios.post("{{ route('images.upload.edited') }}", formdata, { 'Content-Type': 'multipart/form-data' })
                .then((response) => {
                  successToast.fire({
                    text: response.data.success,
                  })
                })
                .catch((error) => {
                  errorToast.fire({
                    text: error.data.message,
                  })
                })
            })
          },
          saveAsSlider: () => {
            let request = {
              type: type,
              type_id: type_id,
              name: "{{ $image->basename }}",
            }

            axios.post("{{ route('images.set.default') }}", request)
              .then((response) => {
                successToast.fire({
                  text: response.data.success,
                })
              })
              .catch((error) => {
                errorToast.fire({
                  text: error.data.message,
                })
              })
          }
        }

        // If method exists, execute it
        if (cropperAPI[method]) {
          cropperAPI[method]();
        }
      });
    </script>

@endpush
