@push('page_css')
    <style>

    </style>
@endpush

<div class="block block-rounded block-shadow">
    <div class="block-header block-header-default">
        <h3 class="block-title">Sekcija 6 - Footer Imena</h3>
    </div>
    <div class="block-content">
        <div class="row items-push">
            <div class="col-lg-6">
                @include('back.marketing.landing.partials.section_6_1', ['tag' => $original_tag . '[1]', 'title' => 'Stupac 1', 'section' => isset($sections[6]) ? $sections[6][0] : null])
            </div>

            <div class="col-lg-6">
                @include('back.marketing.landing.partials.section_6_1', ['tag' => $original_tag . '[2]', 'title' => 'Stupac 2', 'section' => isset($sections[6]) ? $sections[6][1] : null])
            </div>
        </div>
    </div>
</div>

@push('page_js')

@endpush
