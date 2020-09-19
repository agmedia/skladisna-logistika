@push('page_css')
    <style>

    </style>
@endpush

<h5 class="text-black mb-0 mt-30">{{ $title }}</h5>
<hr class="mb-20">

<div class="form-group mb-20">
    <label for="">Naslov</label>
    <input type="text" class="js-maxlength form-control" name="{{ $tag }}[title]" data-always-show="true" value="{{ isset($section) ? $section['title'] : '' }}">
</div>
<div class="form-group mb-20">
    <label for="">Opis</label>
    <textarea class="form-control" name="{{ $tag }}[content_1]" rows="7">{{ isset($section) ? $section['content_1'] : '' }}</textarea>
</div>
<div class="form-group row mb-30">
    <label class="col-lg-9 col-form-label" for="">Poredak</label>
    <div class="col-lg-3">
        <input type="number" class="form-control" name="{{ $tag }}[sort]" value="{{ isset($section) ? $section['sort'] : '' }}">
    </div>
</div>

@push('page_js')

@endpush
