@push('page_css')
    <style>

    </style>
@endpush

<div class="block block-rounded block-shadow">
    <div class="block-header block-header-default">
        <h3 class="block-title">Sekcija 4</h3>
    </div>
    <div class="block-content">
        <div class="row py-4">
            <div class="col-lg-12">
                <div class="form-group mb-30">
                    <label for="products">Odaberi proizvode za ponudu</label>
                    <select class="form-control" id="product-select" name="products[]" style="width: 100%;" multiple>
                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                        @foreach ($products as $product)
                            <option value="{{ $product['id'] }}" {{ ((isset($landing)) and (in_array($product['id'], $landing->product_ids()))) ? 'selected' : '' }}>{{ $product['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_js')
    <script>
        $('#product-select').select2()
    </script>
@endpush
