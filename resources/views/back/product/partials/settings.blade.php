@push('product_css')
@endpush

<div class="row items-push">
    <div class="col-lg-7">

        <h5 class="text-black mb-0 mt-20">Kategorije proizvoda @include('back.layouts.partials.popover', ['title' => 'Kategorije proizvoda', 'content' => 'Možete odabrati više kategorija za pojedini proizvod.'])</h5>
        <hr class="mb-20">
        <div class="form-group mb-50">
            <label for="categories">Odaberi kategorije</label>
            <select class="form-control" id="category-select" name="categories[]" style="width: 100%;" multiple>
                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}" {{ (isset($product) and (in_array($category['id'], $product_categories))) ? 'selected' : '' }}>{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>

        <h5 class="text-black mb-0">Akcija proizvoda @include('back.layouts.partials.popover', ['title' => 'Akcija proizvoda', 'content' => 'Ako želite da vaša akcija vrijedi samo preko kupon koda, upišite ga. Ograničite akciju datumima ili ostavite prazno da vrijedi stalno.'])</h5>
        <hr class="mb-20">
        <div class="form-group mb-30">
            <label for="discount">Ime Akcije</label>
            <input type="text" class="form-control" name="action_name" placeholder="Ime akcije..." value="{{ isset($product->all_actions) ? $product->all_actions->name : '' }}">
        </div>

        <div class="form-group mb-30">
            <label for="discount">Kupon Kod</label>
            <input type="text" class="form-control" name="action_code" placeholder="Kupon kod..." value="{{ isset($product->all_actions) ? $product->all_actions->coupon : '' }}">
        </div>

        <div class="form-group row mb-30">
            <div class="col-md-6">
                <label for="date_start">Početak</label>
                <input type="text" name="date_start" id="start-date-picker" class="form-control form-control-lg" value="{{ isset($product->all_actions->date_start) ? date_format(date_create($product->all_actions->date_start), 'd.m.Y. H:i') : '' }}">
            </div>
            <div class="col-md-6">
                <label for="date_end">Kraj</label>
                <input type="text" class="form-control form-control-lg" name="date_end" id="end-date-picker" value="{{ isset($product->all_actions->date_end) ? date_format(date_create($product->all_actions->date_end), 'd.m.Y. H:i') : '' }}">
            </div>
        </div>

        <div class="form-group row mb-50">
            <div class="col-md-6">
                <label for="discount">Popust</label>
                <input type="text" class="form-control" name="discount" placeholder="Popust izrazite u postotku...%" value="{{ isset($product->all_actions) ? $product->all_actions->discount : '' }}">
            </div>
            <div class="col-md-6">
                <label for="price">Cijena sa popustom</label>
                <input type="text" class="form-control" name="action_price" placeholder="Ili upišite akcijsku cijenu..." value="{{ isset($product->all_actions) ? $product->all_actions->price : '' }}">
            </div>
        </div>

    </div>

    <div class="col-lg-5">

        <h5 class="text-black mb-0 mt-20">Ostale postavke</h5>
        <hr class="mb-20">
        <div class="block">
            <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                <div class="form-group mb-20">
                    <label for="manufacturer">Porez</label>
                    <select class="js-select2 form-control" id="tax-select" name="tax" style="width: 100%;">
                        <option></option>
                        @foreach ($taxes as $tax)
                            <option value="{{ $tax->id }}" {{ (isset($product->tax_id) and $tax->id == $product->tax_id) ? 'selected="selected"' : '' }}>{{ strtoupper($tax->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <h5 class="text-black mb-0 mt-50">Uputstva proizvoda @include('back.layouts.partials.popover', ['title' => 'Uputstva proizvoda', 'content' => 'Učitaj ili odaberi postojeća uputstva iz liste. Učitaj samo PDF ili DOC datoteke...'])</h5>
        <hr class="mb-20">
        <div class="block">
            <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                <div class="form-group mb-30">
                    <label for="pdf">Odaberi Uputstva</label>
                    <select class="form-control" id="pdf-select" name="pdf" style="width: 100%;">
                        <option></option>
                        @foreach ($pdfs as $pdf)
                            <option value="{{ 'media/' . $pdf }}" {{ (isset($product) and (str_replace('media/', '', $product->pdf) == $pdf)) ? 'selected' : '' }}>{{ str_replace('pdf/', '', $pdf) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-group mb-20 fileContainer">
                            <label for="pdf-file" id="pdf-file-name">Učitaj Uputstva</label>
                            <input type="file" onchange="setFile(event)" id="pdf-file" name="file" accept="application/pdf">
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<!--<h5 class="text-black mb-0 mt-20">Blokovi</h5>
<hr class="mb-30">
<div class="row items-push" id="ag-product-block-app">
    <div class="col-lg-3">
        <p class="text-muted">Help blocks...</p>
    </div>
    <div class="col-lg-7 offset-lg-1 mb-50">
        <ag-block
            has-blocks="{{ (isset($product) && ! empty($product->blocks)) ? $product->blocks : '' }}"
            resource-id="{{ isset($product) ? $product->id : '' }}"
            block-size="12"
            image-size="3">
        </ag-block>
    </div>
</div>-->


@push('product_scripts')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="{{ asset('js/components/ag-product-block.js') }}"></script>
    <script>
      $(() => {
          $('#category-select').select2()
          $('#tax-select').select2({
              placeholder: 'Odaberite porez artikla...'
          })
          $('#pdf-select').select2({
              placeholder: 'Odaberite dokument iz liste...'
          })

        /* Datepickers */
        $('#start-date-picker').flatpickr({
          enableTime: true,
          dateFormat: "d.m.Y. H:i",
        })

        $('#end-date-picker').flatpickr({
          enableTime: true,
          dateFormat: "d.m.Y. H:i",
        })

      })
    </script>

    <script>
        function setFile(e) {
            let file = e.target.files[0]
            document.getElementById('pdf-file-name').innerHTML = file.name
        }
    </script>
@endpush
