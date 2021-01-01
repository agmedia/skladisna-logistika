@extends('front.layouts.core')
@push('css')
@endpush
@section ( 'title', (( ! $cat && ! $subcat) ? $group : $subcat) ? $subcat->name : $cat->name )
@section('content')
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('gcp_route', ['group' => \Illuminate\Support\Str::slug($cat->group)]) }}">{{ \Illuminate\Support\Str::title($cat->group) }}</a></li>
                @if (isset($cat))
                    <li class="breadcrumb-item"><a href="{{ route('gcp_route', ['group' => $group, 'cat' => $cat->slug]) }}">{{ \Illuminate\Support\Str::title($cat->name) }}</a></li>
                @endif
                @if (isset($subcat))
                    <li class="breadcrumb-item">{{ $subcat->name }}</li>
                @endif
            </ol>
        </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="heading-block center ">
                    <h2 class="main-headline">{{ (( ! $cat && ! $subcat) ? $group : $subcat) ? $subcat->name : $cat->name }}</h2>
                    <!--   <span>Viličari proizvođača Toyota svojom kvalitetom pružaju siguran i produktivan rad. Viličari su proizvedeni u tvornicama u Europi i Japanu u koje su ugrađene komponente visoke kvalitete.</span>-->
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
                {{ $products->links('front.layouts.partials.paginate') }}
            </div>
        </div>
    </section><!-- #content end -->
@endsection
@push('js_after')
@endpush
