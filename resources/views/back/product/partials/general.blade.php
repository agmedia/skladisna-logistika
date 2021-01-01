<div class="row items-push">
    <div class="col-lg-7">
        <h5 class="text-black mb-0 mt-20">Generalne Informacije</h5>
        <hr class="mb-30">

        <div class="form-group mb-30">
            <label for="name">Ime proizvoda @include('back.layouts.partials.required-star')</label>
            <input type="text" class="form-control form-control-lg" name="name" placeholder="Name of the product..." value="{{ isset($product) ? $product->name : '' }}">
            @error('name')
            <span class="text-danger font-italic">Molimo upišite Ime proizvoda...</span>
            @enderror
        </div>
        <div class="form-group mb-50">
            <label for="sku">SKU - Šifra @include('back.layouts.partials.required-star')</label>
            <input type="text" name="sku" class="form-control form-control-lg" value="{{ isset($product) ? $product->sku : '' }}">
        </div>

        <h5 class="text-black mb-0">SEO Detalji</h5>
        <hr class="mb-30">

        <div class="form-group mb-30">
            <label for="seo_title">SEO Naslov</label>
            <input type="text" class="js-maxlength form-control" name="seo_title" id="seo-title" maxlength="100" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($product) ? $product->seo_title : '' }}" onkeyup="SetSEOPreview()">
        </div>
        <div class="form-group mb-30">
            <label for="meta_description">Meta Opis</label>
            <input type="text" class="js-maxlength form-control" name="meta_description" id="seo-description" maxlength="160" placeholder="Type short SEO Title..." data-always-show="true" value="{{ isset($product) ? $product->meta_description : '' }}" onkeyup="SetSEOPreview()">
        </div>
        <div class="form-group mb-50">
            <label for="meta_keywords">Meta Ključne riječi</label>
            <input type="text" class="js-tags-input form-control" data-height="34px" name="meta_keywords" value="{{ isset($product) ? $product->meta_keywords : '' }}">
        </div>
<!--        <div class="block block-mode-hidden mb-30 mt-20 d-none d-md-block">
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
        </div>-->

    </div>

    <div class="col-lg-5">
        <h5 class="text-black mb-0 mt-20">Status Proizvoda</h5>
        <hr class="mb-20">

        <div class="block mb-30">
            <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-20">
                            <label class="css-control css-control-sm css-control-success css-switch res">
                                <input type="checkbox" class="css-control-input" name="status" @if (isset($product) and $product->status) checked @endif>
                                <span class="css-control-indicator"></span> Online Status
                            </label>
                        </div>
                        <div class="form-group mb-30">
                            <label class="css-control css-control-sm css-control-success css-switch res">
                                <input type="checkbox" class="css-control-input" name="topponuda" @if (isset($product) and $product->topponuda) checked @endif>
                                <span class="css-control-indicator"></span> Top Ponuda
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-20">
                            <label class="css-control css-control-sm css-control-success css-switch res">
                                <input type="checkbox" class="css-control-input" name="used" @if (isset($product) and $product->used) checked @endif>
                                <span class="css-control-indicator"></span> Rabljeno
                            </label>
                        </div>
                        <div class="form-group mb-30">
                            <label class="css-control css-control-sm css-control-success css-switch res">
                                <input type="checkbox" class="css-control-input" name="rent" @if (isset($product) and $product->rent) checked @endif>
                                <span class="css-control-indicator"></span> Najam
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-10">
                    <label for="sort_order">Poredak</label>
                    <input type="text" class="form-control form-control-lg" name="sort_order" value="{{ isset($product) ? $product->sort_order : '' }}">
                </div>
            </div>
        </div>

        <h5 class="text-black mb-0 mt-50">Info Proizvoda</h5>
        <hr class="mb-20">

        <div class="block">
            <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                {{--<div class="col-md-3">
                    <label for="squares">EAN</label>
                    <input type="text" class="form-control form-control-lg" name="ean" value="{{ isset($product) ? $product->ean : '' }}">
                </div>--}}
                <div class="form-group mb-30">
                    <label for="manufacturer">Proizvođač</label>
                    <select class="js-select2 form-control" id="manufacturer-select" name="manufacturer" style="width: 100%;">
                        <option value="0">Odaberite proizvođača...</option>
                        @foreach ($manufacturers as $key => $manufacturer)
                            <option value="{{ $key }}" {{ (isset($product->manufacturer_id) and $key == $product->manufacturer_id) ? 'selected="selected"' : '' }}>{{ strtoupper($manufacturer) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-30">
                    <label for="quantity">Količina</label>
                    <input type="text" class="form-control form-control-lg" name="quantity" value="{{ isset($product) ? $product->quantity : '' }}">
                </div>

                <div class="form-group mb-10">
                    <label for="price">Cijena</label>
                    <input type="text" class="form-control form-control-lg" name="price" value="{{ isset($product) ? $product->price : '' }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row items-push">
    <div class="col-12">
        <div class="block">
            <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                <h3 class="block-title">Opis proizvoda</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option ml-10" data-toggle="popover" data-placement="top" data-html="true" title="Languages" data-content="Insert description content in appropriate languages tabs.">
                        <i class="si si-question ml-5"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                </div>
            </div>
            <div class="block-content" style="padding: 10px 0;">
                <textarea class="js-summernote" name="description">@if (isset($product)) {!! $product->description !!} @endif</textarea>
            </div>
        </div>
    </div>
</div>


@push('product_scripts')
    <!-- Summernote -->
    <script>
        $(() => {

            $('#manufacturer-select').select2()

            $('.js-summernote').summernote({

                height: 333,
                minHeight: 126,
                placeholder: "Opiši proizvod...",
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

            // Init Bootstrap Maxlength (with .js-maxlength class)
            $('.js-maxlength:not(.js-maxlength-enabled)').each((index, element) => {
                let el = $(element);

                // Add .js-maxlength-enabled class to tag it as activated and init it
                el.addClass('js-maxlength-enabled').maxlength({
                    alwaysShow: el.data('always-show') ? true : false,
                    threshold: el.data('threshold') || 10,
                    warningClass: el.data('warning-class') || 'badge badge-warning',
                    limitReachedClass: el.data('limit-reached-class') || 'badge badge-danger',
                    placement: el.data('placement') || 'bottom',
                    preText: el.data('pre-text') || '',
                    separator: el.data('separator') || '/',
                    postText: el.data('post-text') || ''
                });
            })

            // Init Tags Inputs (with .js-tags-input class)
            $('.js-tags-input:not(.js-tags-input-enabled)').each((index, element) => {
                var el = $(element);

                // Add .js-tags-input-enabled class to tag it as activated and init it
                el.addClass('js-tags-input-enabled').tagsInput({
                    height: el.data('height') || false,
                    width: el.data('width') || '100%',
                    defaultText: el.data('default-text') || 'Add tag',
                    removeWithBackspace: el.data('remove-with-backspace') || true,
                    delimiter: [',']
                });
            });

            SetSEOPreview()
        })

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
