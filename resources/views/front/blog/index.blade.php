@extends('front.layouts.core')
@push('css')
@endpush
@section ( 'title', $blog->title)
@section('content')
    <!-- Page Title
		============================================= -->
    <section id="page-title" class="page-title-right page-title-mini">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blogovi', ['cat' => $blog->cat->slug]) }}">Novosti</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
            </ol>
        </div>
    </section>
    <!-- Content
    ============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <!-- Post Content
                ============================================= -->
                <div class="postcontent nobottommargin clearfix">
                    <div class="single-post nobottommargin">
                        <!-- Single Post
                        ============================================= -->
                        <div class="entry clearfix">
                            <!-- Entry Title
                            ============================================= -->
                            <div class="entry-title">
                                <h1>{{ $blog->title }}</h1>
                            </div><!-- .entry-title end -->
                            <!-- Entry Meta
                            ============================================= -->
                            <ul class="entry-meta clearfix">
                                <li><i class="icon-calendar3"></i>{{ \Carbon\Carbon::make(isset($blog->publish_date) ? $blog->publish_date : $blog->updated_at)->locale('hr')->format('d.m.Y') }}</li>
                            </ul><!-- .entry-meta end -->
                        @if($blog->image)
                            <!-- Entry Image
                            ============================================= -->
                            <div class="entry-image">
                                <a href="#"><img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"></a>
                            </div><!-- .entry-image end -->
                        @endif
                            <!-- Entry Content
                            ============================================= -->
                            <div class="entry-content notopmargin">
                            {!! $blog->description !!}
                                <!-- Post Single - Content End -->
                                <!-- Tag Cloud
                                ============================================= -->
                            </div>

                            @if ($blog->blocks)
                                @if (isset($blog->blocks->groupBy('type')['image']))
                                    <div class="fancy-title title-double-border topmargin-sm">
                                        <h3 class="font-weight-light">Galerija fotografija</h3>
                                    </div>
                                    <div class="col_full bim bottommargin-sm">
                                        <div class="fslider flex-thumb-grid grid-6" data-animation="fade" data-arrows="true" data-thumbs="true">
                                            <div class="flexslider">
                                                <div class="slider-wrap">
                                                    @foreach ($blog->blocks->groupBy('type')['image'] as $block)
                                                        <div class="slide imb" data-thumb="{{ asset($block->path) }}">
                                                            <a href="#">
                                                                <img src="{{ asset($block->path) }}" alt="">
                                                                <div class="overlay">
                                                                    <div class="text-overlay">
                                                                        <div class="text-overlay-title">
                                                                            <h3>{{ isset($block->title) && $block->title != '' ? $block->title : $blog->name }}</h3>
                                                                        </div>
                                                                        <div class="text-overlay-meta">
                                                                            <span>{{ config('app.longname') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (isset($blog->blocks->groupBy('type')['pdf']))
                                    <div class="fancy-title title-double-border topmargin-sm">
                                        <h3 class="font-weight-light">Povezani dokumenti</h3>
                                    </div>
                                    <div class="coll_full topmargin clearfix">
                                        @foreach ($blog->blocks->groupBy('type')['pdf'] as $doc)
                                            <div class="ipost clearfix">
                                                <div class="col_one_fifth bottommargin-sm">
                                                    <div class="text-center">
                                                        <a href="{{ asset($doc->path) }}"><img class="image_fade" src="{{ asset($doc->thumb) }}" alt="Image" style="width: 90px; margin-top: 10px;"></a>
                                                    </div>
                                                </div>
                                                <div class="col_four_fifth bottommargin-sm col_last">
                                                    <div class="entry-title">
                                                        <h3><a href="{{ asset($doc->path) }}">{{ $doc->title }}</a></h3>
                                                    </div>
                                                    <ul class="entry-meta clearfix">
                                                        <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make($doc->created_at)->locale('hr')->format('d.m.Y - H:i') }}h</li>
                                                        <li><a href="{{ asset($doc->path) }}"><i class="icon-download"></i> Skini</a></li>
                                                        {{--<li><i class="icon-eye"></i> Pogledaj</li>--}}
                                                    </ul>
                                                    <div class="entry-content">
                                                        <p>{{ $doc->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                        </div><!-- .entry end -->
                        <div class="clear"></div>
                        <!-- Post Single - Share
                        ============================================= -->
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-title="Skladišna logistika" data-a2a-icon-color="#bb001e">
                            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                            <a class="a2a_button_email"></a>
                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                </div><!-- .postcontent end -->
                <!-- Sidebar
                ============================================= -->
                <div class="sidebar nobottommargin col_last clearfix">
                    <div class="sidebar-widgets-wrap">
                  @include('front.blog.partials.latest')
                    </div>
                </div><!-- .sidebar end -->
            </div>
        </div>
    </section><!-- #content end -->
@endsection
@push('js_after')
@endpush
