@push('product_css')

@endpush

<h5 class="text-black mb-0 mt-20">Kategorije proizvoda</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-3">
        <p class="text-muted">Možete odabrati više kategorija. Samo one kojima vaš proizvod pripada.</p>
    </div>
    <div class="col-lg-7 offset-lg-1">
        <div class="form-group">
            <div class="form-group mb-50">
                <label for="categories">Odaberi kategorije</label>
                <select class="form-control" id="category-select" name="categories[]" style="width: 100%;" multiple>
                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}" {{ (isset($product) and (in_array($category['id'], $product_categories))) ? 'selected' : '' }}>{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<h5 class="text-black mb-0 mt-20">Akcija proizvoda</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-3">
        <p class="text-muted">Odaberite ime akcije, ako želite kupon kod da vaša akcija vrijedi samo preko kupon koda. Ograničite datumima ili ostavite prazno da vrijedi stalno...</p>
    </div>
    <div class="col-lg-7 offset-lg-1">

        <div class="form-group mb-50">
            <label for="discount">Ime Akcije</label>
            <input type="text" class="form-control" name="action_name" placeholder="Ime akcije..." value="{{ isset($product->all_actions) ? $product->all_actions->name : '' }}">
        </div>

        <div class="form-group mb-50">
            <label for="discount">Kupon Kod</label>
            <input type="text" class="form-control" name="action_code" placeholder="Kupon kod..." value="{{ isset($product->all_actions) ? $product->all_actions->coupon : '' }}">
        </div>

        <div class="form-group row mb-50">
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
                <label for="price">Cijena</label>
                <input type="text" class="form-control" name="action_price" placeholder="Ili upišite akcijsku cijenu..." value="{{ isset($product->all_actions) ? $product->all_actions->price : '' }}">
            </div>
        </div>
    </div>
</div>

<h5 class="text-black mb-0 mt-20">Uputstva proizvoda</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-3">
        <p class="text-muted">Učitaj ili odaberi uputstva. Učitaj samo PDF ili DOC datoteke...</p>
        <hr>
        <div class="row mt-20">
            <div class="col-12">
                <label class="form-group mb-20 fileContainer">
                    <label for="pdf-file" id="pdf-file-name">Učitaj Uputstva</label>
                    <input type="file" onchange="setFile(event)" id="pdf-file" name="file" accept="application/pdf">
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-7 offset-lg-1">
        <div class="form-group mb-50">
            <label for="pdf">Odaberi Uputstva</label>
            <select class="form-control" id="pdf-select" name="pdf" style="width: 100%;">
                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                @foreach ($pdfs as $pdf)
                    <option value="{{ 'media/' . $pdf }}" {{ (isset($product) and (str_replace('media/', '', $product->pdf) == $pdf)) ? 'selected' : '' }}>{{ str_replace('pdf/', '', $pdf) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<h5 class="text-black mb-0 mt-20">Blokovi</h5>
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
</div>


@push('product_scripts')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="{{ asset('js/components/ag-product-block.js') }}"></script>
    <script>
      $(() => {
          $('#category-select').select2()
          $('#pdf-select').select2()

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
