@extends('front.layouts.core')
@push('css')
    <style>
        .ag-tabs {
            line-height: 21px !important;
            padding: 12px !important;
        }
        .ag-video-container {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
        }
        .ag-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endpush
@section ('title', $landing->title)
@section('content')
    <section id="slider" class="slider-element slider-parallax" style="background: url('{{ !empty($landing->image) ? asset($landing->image) : asset('images/bcllanding.jpg') }}') center center; background-size: cover;" data-height-xl="670" data-height-lg="600" data-height-md="550" data-height-sm="550" data-height-xs="500">
        <div class="slider-parallax-inner">
            <div class="container clearfix">
                <div class="vertical-middle center">
                    <div class="heading-block nobottomborder center">
                        <h1 class="white lh1">{{ $landing->title }}</h1>
                        <span class="white lhspan">{!! $landing->content_1 !!}</span>
                        @if ( ! empty($landing->download_url))
                            <a href="{{ asset($landing->download_url) }}" download="{{ \Illuminate\Support\Str::slug($landing->client) }}-SkladisnaLogistikaPonuda" class="btn btn-lg btn-red nomargin">Pogledajte ponudu</a>
                        @endif
                    </div>
                </div>
            </div>
            <a href="#" class="scroll-down d-none d-lg-block" data-scrollto="#content" data-offset="0"><span class="scroll-mouse"><span class="scroll-wheel"></span></span></a>
        </div>
    </section>
    <section>
        <div class="clearfix"></div>
    </section>
    <div class="clearfix"></div>
    <!-- Content
    ============================================= -->
    <section id="content">
        <div class="content-wrap nobottompadding">
            <div class="container clearfix">
                @foreach ($sections[2] as $section)
                    <div class="col_one_third{{ $loop->last ? ' col_last' : '' }}">
                        <h3 class="color">{{ $section->title }}</h3>
                        <p class="notopmargin">{!! $section->content_1 !!}</p>
                    </div>
                @endforeach
                <div class="clearfix"></div>
            </div>

            @if($landing->has_tab_section)
                <div class="container clearfix bottommargin">
                    <div class="heading-block center nomargin">
                        <h2>Prikazi mogućih rješenja automatizacije</h2>
                    </div>
                </div>
                <div class="container clearfix" id="st">
                    <div class="tabs side-tabs nobottommargin clearfix" id="tab-6">
                        <ul class="tab-nav tab-nav2 clearfix">
                            @foreach ($sections[3] as $key => $section)
                                @if ($section->title != '' && $section->content_1 != '')
                                    <li><a href="#tabs-2{{ $key }}" class="ag-tabs">{{ $section->title }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="tab-container">
                            @foreach ($sections[3] as $key => $section)
                                @if ($section->title != '' && $section->content_1 != '')
                                    <div class="tab-content clearfix" id="tabs-2{{ $key }}">
                                        <h3 class="slred">{{ $section->title }}</h3>
                                        @if ($section->video == '')
                                            <div class="row" style="padding-left: 15px">
                                                <div class="col_half">
                                                    <img alt="{{ $section->title }}" src="{{ asset($section->image) }}" class="img-thumbnail" style="height: 230px; width: 100%; display: block;">
                                                </div>
                                                <div class="col_half col_last"><div></div></div>
                                            </div>
                                        @else
                                            <div class="row" style="padding-left: 15px">
                                                <div class="col_half">
                                                    <iframe width="560" height="315" src="{{ $section->video }}" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                                @if ($section->image == '')
                                                    <div class="col_half col_last"><div></div></div>
                                                @else
                                                    <div class="col_half col_last">
                                                        <img alt="{{ $section->title }}" src="{{ asset($section->image) }}" class="img-thumbnail" style="height: 230px; width: 100%; display: block;">
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        {!! $section->content_1 !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="divider"></div>
                </div>
            @endif

            @if ($landing->statement != '')
                <div class="section nomargin noborder bgcolor dark" style="padding: 40px 0;">
                    <div class="container clearfix">
                        <div class="heading-block center nobottomborder nobottommargin topmargin-sm" style="padding:0px 4%">
                            <h2>"{{ $landing->statement }}"</h2>
                            @if ( ! empty($landing->download_url))
                                <div class="container clearfix center bottommargin-sm topmargin-sm">
                                    <a href="{{ asset($landing->download_url) }}" download="{{ \Illuminate\Support\Str::slug($landing->client) }}-SkladisnaLogistikaPonuda" class="btn btn-lg btn-white">Pogledajte ponudu</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="container clearfix topmargin">
                <ul class="clients-grid grid-3 nobottommargin clearfix noborder">
                    <li><a href="https://www.youtube.com/watch?v=Cij91tKWVs0" target="_blank" ><img src="{{ asset('media/images/Vanderlande.jpg') }}" alt="Clients"></a></li>
                    <li><a href="https://www.youtube.com/watch?v=1QZeNYY9Fd8" target="_blank" ><img src="{{ asset('media/images/bastian.jpg') }}" alt="Clients"></a></li>
                    <li><a href="https://www.youtube.com/watch?v=QnIlmWOYsdo" target="_blank"><img src="{{ asset('media/images/tal.jpg') }}" alt="Clients"></a></li>
                </ul>
            </div>

            @if ($landing->has_map)
                <div class="section topmargin nobottommargin">
                    <div class="container clearfix notopmargin">
                        <div class="col_full nobottommargin notopmargin">
                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ asset('media/images/hrvatska-servisi.svg') }}" style="background-color:#fff;padding:20px" alt="Servisna lista">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="section notopmargin nobottommargin">
                <div class="container clearfix topmargin">
                    <div class="col_full nobottommargin">
                        <div class="widget clearfix">
                            <div class="row ">
                                @if (isset($sections[6]))
                                    @foreach ($sections[6] as $section)
                                        <div class="col-md-4 col-xs-12  widget_links">
                                            <h3>{{ $section->title }}</h3>
                                            <address>{!! $section->content_1 !!}</address>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-4 col-xs-12  widget_links">
                                        <h3>Boris Špiranec</h3>
                                        <address><strong>MD partner</strong>{{--<br>Tel.: <a href="tel:0038513374143">+385 1 3374 143</a>--}}<br>Mob.:&nbsp; <a href="tel:00385913496400">+385 91 34 96 400</a><br>E-mail: <a href="mailto:boris@skladisna-logistika.hr">boris@skladisna-logistika.hr</a></address>
                                    </div>
                                    <div class="col-md-4 col-xs-12 widget_links">
                                        <h3>Tomislav Gršić</h3>
                                        <address><strong>Senior consultant</strong>{{--<br>Tel.: <a href="tel:0038516150409">+385 1 6150 409</a>--}}<br>Mob.: <a href="tel:00385956328351">+385 95 63 28 351</a><br> E-mail: <a href="mailto:tomislav@skladisna-logistika.hr">tomislav@skladisna-logistika.hr</a></address>
                                    </div>
                                @endif
                                <div class="col-md-4 col-xs-12  widget_links">
                                    <h3>Skladišna logistika d.o.o.</h3>
                                    <address>Ventilatorska cesta 5a<br>10251 Hrvatski Leskovac - Zagreb<br>Tel.: <a href="tel:0038516536026">+385 1 6536 026</a> - Fax.: +385 1 6536027<br> E-mail: <a href="mailto:info@skladisna-logistika.hr">info@skladisna-logistika.hr</a></address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- #content end -->
@endsection
@push('js')
@endpush
