<h5 class="text-black mb-0 mt-20">Detaljne informacije o proizvodu.</h5>
<hr class="mb-30">
<div class="row items-push">
    <div class="col-lg-12">
        <div class="form-group mb-20">
            <label for="engine">Vrsta motora</label>
            <select class="form-control" id="engine-select" name="engine" style="width: 100%;">
                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                @foreach (['electro', 'diesel', 'gas'] as $engine)
                    <option value="{{ $engine }}" {{ (isset($product->details) and ($product->details->engine == $engine)) ? 'selected' : '' }}>{{ $engine }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group row mb-20">
            <div class="col-12">
                <label for="application">Primjena viličara</label>
                <input type="text" class="form-control form-control-lg" name="application" value="{{ isset($product->details) ? $product->details->application : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-12">
                <label for="options">Garancija</label>
                <input type="text" class="form-control form-control-lg" name="options" value="{{ isset($product->details) ? $product->details->options : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-6">
                <label for="weight_capacity">Max.kapacitet nosivosti (kg)</label>
                <input type="text" class="form-control form-control-lg" name="weight_capacity" value="{{ isset($product->details) ? $product->details->weight_capacity : '' }}">
            </div>
            <div class="col-6">
                <label for="lift_height">Max. visina dizanja (m)</label>
                <input type="text" class="form-control form-control-lg" name="lift_height" value="{{ isset($product->details) ? $product->details->lift_height : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-6">
                <label for="commision_height">Max. visina komisiniranja (m)</label>
                <input type="text" class="form-control form-control-lg" name="commision_height" value="{{ isset($product->details) ? $product->details->commision_height : '' }}">
            </div>
            <div class="col-6">
                <label for="battery">Max. jačina baterije (Ah)</label>
                <input type="text" class="form-control form-control-lg" name="battery" value="{{ isset($product->details) ? $product->details->battery : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-6">
                <label for="speed">Max.brzina vožnje (km/h)</label>
                <input type="text" class="form-control form-control-lg" name="speed" value="{{ isset($product->details) ? $product->details->speed : '' }}">
            </div>
            <div class="col-6">
                <label for="radius">Okretni radius (mm)</label>
                <input type="text" class="form-control form-control-lg" name="radius" value="{{ isset($product->details) ? $product->details->radius : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-6">
                <label for="width">Radni hodnik (mm)</label>
                <input type="text" class="form-control form-control-lg" name="width" value="{{ isset($product->details) ? $product->details->width : '' }}">
            </div>
            <div class="col-6">
                <label for="center_mass">Težište (mm)</label>
                <input type="text" class="form-control form-control-lg" name="center_mass" value="{{ isset($product->details) ? $product->details->center_mass : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-6">
                <label for="tow_capacity">Vučni kapacitet (kg)</label>
                <input type="text" class="form-control form-control-lg" name="tow_capacity" value="{{ isset($product->details) ? $product->details->tow_capacity : '' }}">
            </div>
            <div class="col-6">
                <label for="wheels">Broj kotača</label>
                <input type="text" class="form-control form-control-lg" name="wheels" value="{{ isset($product->details) ? $product->details->wheels : '' }}">
            </div>
        </div>

        <div class="form-group row mb-30">
            <div class="col-6">
                <label for="tow_capacity">Voltaža (V)</label>
                <input type="text" class="form-control form-control-lg" name="voltage" value="{{ isset($product->details) ? $product->details->voltage : '' }}">
            </div>

        </div>
    </div>
</div>

@push('product_scripts')
    <!-- Select2 -->
    <script>
      $(() => {
        $('#unit-select').select2()
      })
    </script>
@endpush
