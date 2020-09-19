@push('slider_css')
    <style>
        /* The total progress gets shown by event listeners */
        #total-progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the progress bar when finished */
        #previews .file-row.dz-success .progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the delete button initially */
        #previews .file-row .delete {
            display: none;
        }

        /* Hide the start and cancel buttons and show the delete button */

        #previews .file-row.dz-success .start,
        #previews .file-row.dz-success .cancel {
            display: none;
        }
        #previews .file-row.dz-success .delete {
            display: block;
        }
    </style>
@endpush

<div class="container">
    <div class="row">
        <div class="col-3">
            <h5 class="text-black mb-0 mt-20">Slider Images</h5>
        </div>
        <div class="col-9 text-right">
            <a href="#" onclick="event.preventDefault();" class="btn btn-success fileinput-button dz-clickable mt-10">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Add files...</span>
            </a>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>
    <div class="row items-push">
        <div class="col-lg-3">
            <p class="text-muted">Add nice and clean photos to better showcase your intentions to the world...</p>
        </div>
        <div class="col-lg-8 offset-lg-1">
            <div class="form-group">
                <div class="files" id="previews">
                    <div id="template" class="file-row dz-image-preview">
                        <table class="table table-striped table-vcenter">
                            <tr>
                                <td>
                                    <span class="preview" style="width: 120px;"><img data-dz-thumbnail style="width: 120px;"></span>
                                </td>
                                <td>
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 100%">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>
                                    <span class="name" data-dz-name></span>, <span class="size" data-dz-size></span>
                                    <br>
                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#{{--{{ route('apartments.edit.image', ['path' => 'media/images/gallery/apartments/', 'type' => 'apartments', 'id' => $apartment->id]) }}--}}"
                                           class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button data-dz-remove type="button" class="btn btn-sm btn-danger js-tooltip-enabled delete" data-toggle="tooltip" title="" data-original-title="Delete">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            @if (isset($slider) and ! empty($slider->images))
                <div id="sortable" class="row">
                    @foreach($slider->images as $key => $image)
                        <div class="col-md-4 animated fadeIn mb-30 ribbon ribbon-left ribbon-bookmark ribbon-crystal" id="{{ 'image_' . $image->id }}">
                            <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                                <img class="img-thumbnail options-item" src="{{ asset($image->image) }}" alt="">
                                <div class="options-overlay bg-primary-dark-op">
                                    <div class="options-overlay-content">
                                        <h3 class="h4 text-white mb-5">Image</h3>
                                        <h4 class="h6 text-white-op mb-15">More Details</h4>
                                        <a class="btn btn-sm btn-rounded btn-primary min-width-75" href="{{ route('slider.edit.image', ['path' => $image->image, 'type' => 'slider', 'id' => $slider->id]) }}">
                                            <i class="fa fa-thumbs-up"></i> Uredi
                                        </a>
                                        <a href="#" class="btn btn-sm btn-rounded btn-danger min-width-75" onclick="ShouldDeleteImage('{{ json_encode(['id' => $image->id, 'path' => $image->image, 'type' => 'slider', 'type_id' => $slider->id]) }}')">
                                            <i class="fa fa-thumbs-up"></i> Obriši
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="images_order" id="images-order">
            @endif

        </div>
    </div>
</div>

@push('slider_scripts')

    <script>
      // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
      let previewNode = document.querySelector("#template");
      previewNode.id = "";
      let previewTemplate = previewNode.parentNode.innerHTML;
      previewNode.parentNode.removeChild(previewNode);

      let existing_images = JSON.parse(("{{ isset($slider) ? json_encode($slider->images) : '{}' }}").replace(/&quot;/g,'"'))
      console.log(existing_images)

      let productDropzone = new Dropzone(".container", {
        url: "{{ isset($slider) ? route('images.upload') : route('images.upload') }}",
        params: {
          type: 'slider',
          type_id: 1
        },
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        maxFiles: 1,
        maxFilesize: 2, // MB
        uploadMultiple: false,
        parallelUploads: 10,
        previewTemplate: previewTemplate,
        acceptedFiles: 'image/*',
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
      });

      /*for (let i = 0; i < existing_images.length; i++) {
        let mockFile = { name: existing_images[i].name, size: existing_images[i].size };

        apartmentDropzone.emit("addedfile", mockFile);
        apartmentDropzone.emit("thumbnail", mockFile, existing_images[i].path);
        apartmentDropzone.emit("complete", mockFile)
      }*/

      productDropzone.on("error", function(file, errorMessage) {
        console.log('Neka greška.!')
        console.log(errorMessage)
      });

      productDropzone.on("success", function(file, response) {
        console.log('Samo je jedna slika.')
        console.log(response)
      });

      productDropzone.on("successmultiple", function(file, response) {
        console.log('Više slika.')
        console.log(response)
      });

    </script>

    <script>
      $(() => {
        $('#sortable').sortable({
          revert: true,
          update: (e, ui) => {
            if (!ui.sender) {
              let sort_order = $('#sortable').sortable('toArray')

              document.getElementById('images-order').value = sort_order

              for (let i = 0; i < sort_order.length; i++) {
                console.log(sort_order[i])
              }
            }
          }
        });
        $( "#draggable" ).draggable({
          connectToSortable: "#sortable",
          helper: "clone",
          revert: "invalid"
        });
      })
    </script>

    <script>
      function ShouldDeleteImage(images_data) {
        confirmPopUp.fire({
          title: 'Jeste li sigurni',
          text: 'Nakon brisanja slici više nećete moći pristupiti!',
          type: 'warning',
          confirmButtonText: 'Da, obiši je!',
        }).then((result) => {
          if (result.value) {
            DeleteImage(images_data)
          }
        })
      }

      function DeleteImage(images_data) {
        let images = JSON.parse(images_data)

        axios.post("{{ route('images.destroy') }}", images)
          .then((response) => {
            successToast.fire({
              text: response.data.success,
            })

            $('#image_' + images.id).hide()
          })
          .catch((error) => {
            errorToast.fire({
              text: error.data.message,
            })
          })
      }
    </script>

@endpush
