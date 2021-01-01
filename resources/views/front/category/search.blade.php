@extends('front.layouts.core')
@push('css')
@endpush
@section ( 'title', 'Rezultati pretrage')
@section('content')
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item">Pretraga</li>
            </ol>
        </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="heading-block center ">
                    <h2 class="main-headline">Rezultati pretrage za upit <span>{{ $term }}</span></h2>
                </div>
                <div id="shop" class="shop cat product-3 clearfix" data-layout="fitRows">
                    @foreach($products as $product)
                        @include('front.product.partials.product-category', [
                                  'product' => $product,
                                  'link' => route('gcp_route', [
                                      'group' => \Illuminate\Support\Str::slug($product->category()->group),
                                      'cat' => isset($product->category()->slug) ? $product->category()->slug : '',
                                      'subcat' => $product->subcategory() ? $product->subcategory()->slug : 'ikoi',
                                      'prod' => $product->slug
                                  ])
                              ])
                    @endforeach
                </div><!-- #portfolio end -->
                <div class="clearfix"></div>
                {{ $products->appends(request()->query())->links('front.layouts.partials.paginate') }}
            </div>
        </div>
    </section><!-- #content end -->
@endsection
@push('js_after')
@endpush
