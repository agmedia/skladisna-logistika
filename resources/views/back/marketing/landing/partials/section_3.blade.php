@push('page_css')
    <style>

    </style>
@endpush

<div class="block block-rounded block-shadow">
    <div class="block-header block-header-default">
        <h3 class="block-title">Sekcija 3</h3>
        {{--<div class="block-options">
            <button type="button" id="new-section" class="btn btn-sm btn-secondary"><i class="fa fa-plus mr-2"></i>Novi Stupac</button>
        </div>--}}
    </div>
    <div class="block-content">
        <div class="row items-push py-4 px-30" id="section-container">
            {{--@if (isset($sections) && isset($sections[3]))
                @foreach ($sections[3] as $key => $section)
                    <div class="col-lg-12 mb-0">
                        @include('back.marketing.landing.partials.section_3_1', ['tag' => $original_tag . '[' . $key . ']', 'title' => 'Stupac 1', 'section' => $section])
                    </div>
                @endforeach
            @endif--}}
            <div class="col-lg-12 mb-0">
                @include('back.marketing.landing.partials.section_3_1', ['tag' => $original_tag . '[0]', 'title' => 'Stupac 1', 'section' => isset($sections) ? $sections[3][0] : null])
            </div>
            <div class="col-lg-12 mb-0">
                @include('back.marketing.landing.partials.section_3_1', ['tag' => $original_tag . '[1]', 'title' => 'Stupac 2', 'section' => isset($sections) ? $sections[3][1] : null])
            </div>
            <div class="col-lg-12 mb-0">
                @include('back.marketing.landing.partials.section_3_1', ['tag' => $original_tag . '[2]', 'title' => 'Stupac 3', 'section' => isset($sections) ? $sections[3][2] : null])
            </div>
            <div class="col-lg-12 mb-0">
                @include('back.marketing.landing.partials.section_3_1', ['tag' => $original_tag . '[3]', 'title' => 'Stupac 4', 'section' => isset($sections) ? $sections[3][3] : null])
            </div>
            <div class="col-lg-12 mb-0">
                @include('back.marketing.landing.partials.section_3_1', ['tag' => $original_tag . '[4]', 'title' => 'Stupac 5', 'section' => isset($sections) ? $sections[3][4] : null])
            </div>
            <div class="col-lg-12 mb-0">
                @include('back.marketing.landing.partials.section_3_1', ['tag' => $original_tag . '[5]', 'title' => 'Stupac 6', 'section' => isset($sections) ? $sections[3][5] : null])
            </div>
        </div>
    </div>
</div>

@push('page_js')
    <script>
        var summernote_config = {
            height: 333,
            minHeight: 126,
            placeholder: "Upiši sadržaj...",
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['picture', 'video', 'link', 'tabel', 'hr']],
                ['view', ['codeview', 'help']]
            ],
            styleTags: ['p', 'h4', 'blockquote'],
        };

        $('.js-summernote').summernote(summernote_config);

        var elem_id = 0;
        $('#new-section').on('click', e => {
            console.log(e)

            elem_id++;

            var parent = document.getElementById('section-container');
            var new_element = document.createElement('div');
            new_element.setAttribute('id', 'column_' + elem_id);
            new_element.setAttribute('class', 'col-lg-12 mb-0')

            axios.get("{{ route('landing.get.section3') }}" + '?tag=' + "{{ $original_tag }}" + '[' + (elem_id + 100) + ']&title=Stupac+' + elem_id)
                .then((response) => {
                    console.log(response)

                    new_element.innerHTML = response.data;
                    parent.appendChild(new_element)

                    $('.js-summernote').summernote(summernote_config, 'focus');

                    var cropper = new Slim(document.getElementsByClassName('slim'));
                    cropper.load("{{ asset('media/images/bcllanding.jpg') }}");
                })
                .catch((error) => {
                    console.log(error)
                })
        })
    </script>
@endpush
