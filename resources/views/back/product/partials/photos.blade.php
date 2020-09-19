@push('product_css')
    <style>
        .file-drop-area label {
            display: block;
            padding: 2em;
            border: 1px solid #CCCCCC;
            background-color: #eee;
            text-align: center;
            cursor: pointer;
        }
    </style>
@endpush

<div>
    <div class="row">
        <div class="col-3">
            <h5 class="text-black mb-0 mt-20">Fotografije proizvoda</h5>
        </div>
        <div class="col-9 text-right">
            <div class="file-drop-area">
                <label for="files">Drop your files here</label>
                <input name="files[][image]" id="files" type="file" multiple>
            </div>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>
    <div class="row items-push" id="sortable">
        @if (isset($product))
            @if (! empty($product->image))
                <div class="col-lg-4 col-md-4 animated fadeIn mb-30 p-20 ribbon ribbon-left ribbon-bookmark ribbon-crystal" id="{{ 'image_0' }}">
                    <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                        <div class="ribbon-box" style="background-color: #c3c3c3">
                            <i class="fa fa-check"></i> Glavna Slika
                        </div>
                        <div class="slim"
                             {{--data-service="{{ route('images.upload') }}"--}}
                             data-ratio="1:1"
                             data-size="800,800"
                             data-max-file-size="2"
                             data-meta-type="products"
                             data-meta-type_id="{{ $product->id }}"
                             data-will-remove="removeImage"
                            {{--data-will-request="handleXHRRequest"--}}>
                            <img src="{{ asset($product->image) }}" alt="{{ 'image_' . $product->id }}"/>
                            <input type="file" name="slim[0][image]"/>
                        </div>
                    </div>
                    <div class="row form-group mt-10">
                        <div class="col-sm-12">
                            <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input" name="slim[default]" checked>
                                Default Image <span class="css-control-indicator"></span>
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-8 col-md-8">
                <div class="row items-push" id="new-images">
                    @if (! empty($product->images))
                        @foreach($product->images as $key => $image)
                            <div class="col-lg-3 col-md-4 animated fadeIn mb-30 p-20 ribbon ribbon-left ribbon-bookmark ribbon-crystal" id="{{ 'image_id_' . $image->id }}">
                                <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                                    <div class="slim"
                                         {{--data-service="{{ route('images.ajax.upload') }}"--}}
                                         data-ratio="1:1"
                                         data-size="800,800"
                                         data-max-file-size="2"
                                         data-meta-type="products"
                                         data-meta-type_id="{{ $product->id }}"
                                         data-meta-image_id="{{ $image->id }}"
                                         data-will-remove="removeImage"
                                    >
                                        <img src="{{ asset($image->image) }}" alt="{{ 'image_' . $image->id }}"/>
                                        <input type="file" name="slim[{{ $image->id }}][image]"/>
                                    </div>
                                </div>
                                <div class="row form-group mt-10">
                                    <div class="col-sm-4" style="padding-right: 0;">
                                        <input type="text" class="form-control js-tooltip-enabled" name="slim[{{ $image->id }}][sort_order]" value="{{ $image->sort_order }}" data-toggle="tooltip" data-placement="top" title="Sort Order">
                                    </div>
                                    <div class="col-sm-8 text-right">
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="slim[default]" value="{{ $image->id }}">
                                            <span class="mr-5">Default</span> <span class="css-control-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <input type="hidden" name="images_order" id="images-order">
                    @endif
                </div>
            </div>
        @else
            <div class="row items-push" id="new-images"></div>
        @endif
    </div>

</div>

@push('product_scripts')
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>
    <script src="{{ asset('js/components/ag-product-image-block.js') }}"></script>

    <script>
        //
        let blocks = "{{ (isset($product) && isset($product->images)) ? count($product->images) : 0 }}";
        let created_id = 0;
        // get a reference to the file drop area and the file input
        var fileDropArea = document.querySelector('.file-drop-area');
        var fileInput = fileDropArea.querySelector('input');
        var fileInputName = fileInput.name;

        // listen to events for dragging and dropping
        fileDropArea.addEventListener('dragover', handleDragOver);
        fileDropArea.addEventListener('drop', handleDrop);
        fileInput.addEventListener('change', handleFileSelect);

        function handleDragOver(e) {
            e.preventDefault();
        }
        function handleDrop(e) {
            e.preventDefault();
            handleFileItems(e.dataTransfer.items || e.dataTransfer.files);
        }
        function handleFileSelect(e) {
            handleFileItems(e.target.files);
        }

        // loops over a list of items
        function handleFileItems(items) {
            let l = items.length;
            for (let i=0; i<l; i++) {
                handleItem(items[i]);
            }
        }

        function handleItem(item) {
            // get file from item
            let file = item;
            if (item.getAsFile && item.kind == 'file') {
                file = item.getAsFile();
            }

            handleFile(file);
        }

        // now we're sure each item is a file
        function handleFile(file) {
            createCropper(file);
        }

        // create an Image Cropper for each passed file
        function createCropper(file) {
            // create container element for cropper
            let holder = document.getElementById('new-images');

            let col = document.createElement('div');
            col.className = 'col-lg-3 col-md-4 animated fadeIn mb-30 p-20 ribbon ribbon-left ribbon-bookmark ribbon-crystal';

            let cropper = document.createElement('div');

            // insert this element after the file drop area
            col.insertAdjacentElement('afterbegin', cropper);
            col.insertAdjacentHTML('beforeend', '<div class="row form-group mt-10">\n' +
                '                                    <div class="col-sm-4" style="padding-right: 0;">\n' +
                '                                        <input type="text" class="form-control js-tooltip-enabled" name="files[' + created_id + '][sort_order]" value="' + blocks + '" data-toggle="tooltip" data-placement="top" title="Sort Order">\n' +
                '                                    </div>\n' +
                '                                    <div class="col-sm-8 text-right">\n' +
                '                                        <label class="css-control css-control-primary css-radio">\n' +
                '                                            <input type="radio" class="css-control-input" name="slim[default]" value="image/' + file.name + '">\n' +
                '                                            <span class="mr-5">Default</span> <span class="css-control-indicator"></span>\n' +
                '                                        </label>\n' +
                '                                    </div>\n' +
                '                                </div>');

            holder.insertAdjacentElement('beforeend', col);

            // create a Slim Cropper
            Slim.create(cropper, {
                ratio: '1:1',
                size: '800,800',
                maxFileSize: '2',
                service: false,
                meta: {
                    type: 'products',
                    type_id: "{{ isset($product) ? $product->id : '' }}",
                    image_id: 0
                },
                defaultInputName: fileInputName,
                didInit: function() {
                    // load the file to our slim cropper
                    this.load(file);

                },
                didRemove: function(data, slim) {
                    col.parentNode.removeChild(col)
                    // destroy the slim cropper
                    this.destroy();

                }
            });

            blocks++;
            created_id++;
        }

        function handleXHRRequest(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");

            console.log(fileInput)
        }

        function removeImage(data, slim) {
            if (data.meta.hasOwnProperty('image_id')) {
                axios.post("{{ route('product.destroy.image') }}", { data: data.meta.image_id })
                    .then((response) => {
                        successToast.fire({
                            text: 'Fotografija je uspješno izbrisana',
                        })

                        let elem = document.getElementById('image_id_' + data.meta.image_id);

                        elem.parentNode.removeChild(elem);
                    })
                    .catch((error) => {
                        errorToast.fire({
                            text: 'Greška u brisanju fotografije..! Molimo pokušajte ponovo.',
                        })
                    })
            } else {
                errorToast.fire({
                    text: 'Glavna slika se ne može izbrisati..!',
                })
            }

            //slim.destroy();
        }

        // hide file input, we can now upload with JavaScript
        fileInput.style.display = 'none';

        // remove file input name so it's value is
        // not posted to the server
        fileInput.removeAttribute('name');
    </script>

@endpush
