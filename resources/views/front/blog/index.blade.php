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
