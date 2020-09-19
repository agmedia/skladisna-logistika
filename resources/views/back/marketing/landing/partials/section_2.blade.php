@push('page_css')
    <style>

    </style>
@endpush

<div class="block block-rounded block-shadow">
    <div class="block-header block-header-default">
        <h3 class="block-title">Sekcija 2</h3>
    </div>
    <div class="block-content">
        <div class="row items-push">
            <div class="col-lg-4">
                @include('back.marketing.landing.partials.section_2_1', ['tag' => $original_tag . '[1]', 'title' => 'Stupac 1', 'section' => isset($sections) ? $sections[2][0] : null])
            </div>

            <div class="col-lg-4">
                @include('back.marketing.landing.partials.section_2_1', ['tag' => $original_tag . '[2]', 'title' => 'Stupac 2', 'section' => isset($sections) ? $sections[2][1] : null])
            </div>

            <div class="col-lg-4">
                @include('back.marketing.landing.partials.section_2_1', ['tag' => $original_tag . '[3]', 'title' => 'Stupac 3', 'section' => isset($sections) ? $sections[2][2] : null])
            </div>
        </div>
    </div>
</div>

@push('page_js')

@endpush
