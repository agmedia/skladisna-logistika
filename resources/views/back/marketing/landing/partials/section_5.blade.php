@push('page_css')
    <style>

    </style>
@endpush

<div class="block block-rounded block-shadow">
    <div class="block-header block-header-default">
        <h3 class="block-title">Sekcija 5</h3>
    </div>
    <div class="block-content">
        <div class="row py-4">
            <div class="col-lg-12">
                <div class="form-group mb-20">
                    <label for="">Zaključna poruka</label>
                    <textarea class="form-control" name="statement" rows="6">{{ isset($landing) ? $landing->statement : '' }}</textarea>
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
