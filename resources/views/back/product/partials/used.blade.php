<h5 class="text-black mb-0 mt-20">Used Product Details</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-3">
        <p class="text-muted">Insert as much details info as you can. It will show better and sell better...</p>
    </div>
    <div class="col-lg-7 offset-lg-1">
        <div class="form-group row mb-30">
            <div class="col-4">
                <label for="serial">Serial Nb.</label>
                <input type="text" class="form-control form-control-lg" name="serial" value="{{ isset($product) ? $product->serial : '' }}">
            </div>
            <div class="col-4">
                <label for="year">Year of Manufacture</label>
                <input type="text" class="form-control form-control-lg" name="year" value="{{ isset($product) ? $product->year : '' }}">
            </div>
            <div class="col-4">
                <label for="hours">Working Hours</label>
                <input type="text" class="form-control form-control-lg" name="hours" value="{{ isset($product) ? $product->hours : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-6">
                <label for="price">Price</label>
                <input type="text" class="form-control form-control-lg" name="price" value="{{ isset($product) ? $product->price : '' }}">
            </div>
            <div class="col-6">
                <label for="charger">Charger</label>
                <input type="text" class="form-control form-control-lg" name="charger" value="{{ isset($product) ? $product->charger : '' }}">
            </div>
        </div>
    </div>
</div>

@push('product_scripts')

@endpush
