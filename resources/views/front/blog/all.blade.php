@extends('front.layouts.core')

@push('css')
@endpush

@section ( 'title', 'Novosti')
@section('content')

    <section id="page-title" class="page-title-right page-title-mini">

        <div class="container clearfix">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>

                <li class="breadcrumb-item active" aria-current="page">Novosti</li>
            </ol>
        </div>

    </section>


    <section  class="page-title-dark" style="position:relative;background-image: url('http://sl.selectpo.lin48.host25.com/media/images/gallery/page/54/onama.jpg'); background-size: cover; padding: 160px 0;background-position:center" >

        <div class="bckd" >
            <div class="container clearfix">
                <h1 class="hbwhite" style="padding: 120px 0">Novosti</h1>
            </div>

        </div>


    </section><!-- #page-title end -->


    <!-- Content
============================================= -->
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">

                <!-- Posts
                ============================================= -->
                <div id="posts" class="small-thumbs">


                        @foreach($blogs as $blog)


                        <div class="entry clearfix">
                            @if($blog->image)
                            <div class="entry-image">
                                <a href="{{ asset($blog->image) }}" data-lightbox="image"><img class="image_fade" src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"></a>
                            </div>
                            @endif
                            <div class="entry-c">
                                <div class="entry-title">
                                    @if (isset($blog->subcat))
                                        <h2><a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->subcat->slug, 'blog' => $blog->slug]) }}">{{ $blog->title }}</a></h2>
                                    @else
                                        <h2><a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->slug]) }}">{{ $blog->title }}</a></h2>
                                    @endif
                                </div>
                                <ul class="entry-meta clearfix">
                                    <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make($blog->publish_date)->locale('hr')->format('d.m.Y.') }}</li>
                                    <li><a href="#"><i class="icon-user"></i> {{ isset($blog->user->name) ? $blog->user->name : 'Nepoznat' }}</a></li>
                                </ul>
                                <div class="entry-content">
                                    <p>{{ $blog->meta_description }}</p>
                                    <a href="{{ route('blogovi', ['blog' => $blog]) }}"class="more-link">Opširnije</a>
                                </div>
                            </div>
                        </div>

                    @endforeach



                    {{ $blogs->links('front.layouts.partials.paginate') }}



                </div>

            </div>

        </div>

    </section><!-- #content end -->

@endsection

@push('js_after')

@endpush
