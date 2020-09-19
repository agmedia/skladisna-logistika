@extends('front.layouts.core')

@push('css')
@endpush


@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ route('klijent') }}">Prodavači</a></li>
            <li> <a href="{{ route('klijent', ['client' => $client->slug]) }}">{{ \Illuminate\Support\Str::title($client->name) }}</a></li>
            <li>Blogs</li>
        </ul>
        <div class="row">
            <div id="column-left" class="column col-sm-4 col-md-3">
                <div class="inner">
                    @include('front.product.partials.top-products', ['products' => $client->topItems()])
                    @include('front.marketing.partials.top-blogs-sidebar', ['blogs' => $client->blogs()->limit(3)->get(), 'client' => $client])
                    @include('front.page.partials.info-pages', ['pages' => $client_info_pages, 'client' => $client])
                </div>
            </div>
            <div id="content" class="col-md-9 col-sm-8">
                <h1 id="page-title">{{ strtoupper($client->name) }}</h1>
                <div class="blog">
                    <div class="grid-holder grid2">
                        @foreach($blogs as $blog)
                            <div class="item single-blog">
                                @if($blog->image)
                                    <div class="banner_wrap hover-zoom hover-darken">
                                        <img class="zoom_image" src="{{ Image::cache(function ($image) use ($blog) { $image->make(asset($blog->image))->fit(600,300)->encode('data-url'); }, env('CACHE_LIFETIME')) }}" alt="{{ $blog->title }}" title="{{ $blog->title }}">
                                        @if (isset($blog->subcat))
                                            <a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->subcat->slug, 'blog' => $blog->slug]) }}" class="effect-holder"></a>
                                        @else
                                            <a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->slug]) }}" class="effect-holder"></a>
                                        @endif
                                        <div class="date_added">
                                            <span class="day">{{ \Carbon\Carbon::make($blog->updated_at)->day }}</span>
                                            <b class="month">{{ \Carbon\Carbon::make($blog->updated_at)->locale('hr')->isoFormat('MMM') }}</b>
                                        </div>
                                    </div>
                                @endif
                                <div class="summary">
                                    @if (isset($blog->subcat))
                                        <h3 class="blog-title"><a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->subcat->slug, 'blog' => $blog->slug]) }}">{{ $blog->title }}</a></h3>
                                    @else
                                        <h3 class="blog-title"><a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->slug]) }}">{{ $blog->title }}</a></h3>
                                    @endif

                                    <div class="blog_stats">
                                        <i>Autor: {{ $blog->user->name }}</i>
                                    </div>
                                    <p class="short-description">{{ $blog->meta_description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_after')
    <script>
        $('.plain-menu.cat > li').bind().click(function(e) {
            $(this).toggleClass("open").find('>ul').stop(true, true).slideToggle(350)
                .end().siblings().find('>ul').slideUp().parent().removeClass("open");
            e.stopPropagation();
        });
        $('.plain-menu.cat li a').click(function(e) {
            e.stopPropagation();
        });

        $('.plain-menu.cat > li > ul > li').bind().click(function(e) {
            $(this).toggleClass("open").find('>ul').stop(true, true).slideToggle(350)
                .end().siblings().find('>ul').slideUp().parent().removeClass("open");
            e.stopPropagation();
        });

        $('.plain-menu.cat li ul li a').click(function(e) {
            e.stopPropagation();
        });
    </script>
@endpush
