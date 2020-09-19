@push('page_css')
    <style>

    </style>
@endpush
<div class="col-lg-12 col-lg-offset-1 mb-0">

</div>
<div class="block block-mode-hidden">
    <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
        <h3 class="block-title">{{ isset($section) && $section['title'] != '' ? $section['title'] : $title }}</h3>
        <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
        </div>
    </div>
    <div class="block-content" style="padding: 10px 0 20px 0;">
        <div class="row p-4">
            <div class="col-lg-12">
                <div class="block {{ isset($section) && isset($section['image']) ? '' : 'block-mode-hidden' }}">
                    <div class="block-header block-header-default" style="border: 1px solid #e9e9e9;">
                        <h3 class="block-title">Fotografija i/ili Video <span class="small">{{ $section['title'] }}</span></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                        </div>
                    </div>
                    <div class="block-content" style="padding: 10px 0 20px 0;">
                        <div class="slim"
                             {{--data-service="async.php"
                             data-fetcher="fetch.php"--}}
                             data-ratio="16:9"
                             data-size="600,360"
                             data-max-file-size="2">
                            <img src="{{ isset($section) && isset($section['image']) ? asset($section['image']) : asset('media/images/bcllanding.jpg') }}" alt=""/>
                            <input type="file" name="{{ $tag }}[image]"/>
                        </div>

                        <div class="form-group mt-30">
                            <label for="">i/ili Video</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-secondary">
                                        <i class="fa fa-youtube-play"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control" name="{{ $tag }}[video]" placeholder="Video embed URL" value="{{ isset($section) ? $section['video'] : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-30">
                    <label for="">Naslov</label>
                    <input type="text" class="js-maxlength form-control" name="{{ $tag }}[title]" data-always-show="true" value="{{ isset($section['title']) ? $section['title'] : '' }}">
                </div>
                <div class="form-group mb-20">
                    <label for="">Opis</label>
                    <textarea class="js-summernote" name="{{ $tag }}[content_1]" rows="6">{{ isset($section) ? $section['content_1'] : '' }}</textarea>
                </div>
                <div class="form-group row text-right">
                    <label class="col-lg-9 col-form-label" for="">Poredak</label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="{{ $tag }}[sort]" value="{{ isset($section) ? $section['sort'] : '' }}">
                    </div>
                </div>
                @if (isset($section))
                    <input type="hidden" class="form-control" name="{{ $tag }}[id]" value="{{ $section['id'] }}">
                @endif
            </div>
        </div>
    </div>
</div>

@push('page_js')

@endpush
