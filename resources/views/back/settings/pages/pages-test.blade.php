@extends('back.layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="my-50 text-center">
            <h2 class="font-w700 text-black mb-10">Pages</h2>
            <h3 class="h5 text-muted mb-0">Kako izraditi jednostavan Page Builder i Admin Editor?</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-8">
                <div class="block">
                    <div class="block-content">
                        <p class="text-muted">
                            Treba nam u bazi osnovna tablica za Page + tablica za PageSegment
                        </p>
                        <h4>Page tablica <small>npr...</small></h4>
                        <ul>
                            <li>id</li>
                            <li>title</li>
                            <li>description</li>
                            <li>meta_title</li>
                            <li>meta_description</li>
                            <li>base_theme</li>
                            <li>top_menu <small> - 0/1</small></li>
                            <li>...</li>
                            <li>sort_order</li>
                        </ul>
                        <h4>PageSegment tablica <small>npr...</small></h4>
                        <ul>
                            <li>id</li>
                            <li>page_id</li>
                            <li>title</li>
                            <li>title_align</li>
                            <li>description</li>
                            <li>description_align</li>
                            <li>image</li>
                            <li>image_align</li>
                            <li>segment <small> - 'slider', 'carusel', 'rich_text', 'call_to_action',</small></li>
                            <li>...</li>
                            <li>sort_order</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
