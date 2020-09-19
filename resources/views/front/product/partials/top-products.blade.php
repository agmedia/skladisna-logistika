<div class="widget module0 " >
    <!-- Block Title -->
    <div class="widget-title">
        <p class="main-title"><span>Popularno</span></p>
        <p class="widget-title-separator"><i class="icon-line-cross"></i></p>
    </div>
    <div class="tab-content has-carousel overflow-hidden">
        <!-- Product Group(s) -->
        <div class="tab-pane active in fade" id="tab00">
            <div class="grid-holder gridlist prod_module0">
                @foreach($products as $top)
                    <div class="item single-product">
                        <div class="image" style="width:60px">
                            <a href="{{ route('proizvod', ['client' => $top->client->slug, 'cat' => $top->category()->slug, 'subcat' => $top->subcategory() ? $top->subcategory()->slug : 'ikoi', 'prod' => $top->slug]) }}">
                                <img src="{{ Image::cache(function ($image) use ($top) { $image->make(asset($top->image))->fit(100)->crop(70, 70, 10, 10)->encode('data-url'); }, env('CACHE_LIFETIME')) }}" alt="{{ $top->name }}" title="{{ $top->name }}" />
                            </a>
                            <div class="sale-counter id255"></div>
                            <span class="badge sale_badge"><i>-43%</i></span>
                            <span class="badge new_badge"><i>Novo</i></span>
                            <a class="img-overlay" href="{{ route('proizvod', ['client' => $top->client->slug, 'cat' => $top->category()->slug, 'subcat' => $top->subcategory() ? $top->subcategory()->slug : 'ikoi', 'prod' => $top->slug]) }}"></a>
                            <div class="btn-center catalog_hide"><a class="btn btn-light-outline btn-thin" href="{{ route('proizvod', ['client' => $top->client->slug, 'cat' => $top->category()->slug, 'subcat' => $top->subcategory() ? $top->subcategory()->slug : 'ikoi', 'prod' => $top->slug]) }}">Opšrnije</a></div>
                        </div><!-- .image ends -->
                        <div class="caption">
                            <a class="product-name" href="{{ route('proizvod', ['client' => $top->client->slug, 'cat' => $top->category()->slug, 'subcat' => $top->subcategory() ? $top->subcategory()->slug : 'ikoi', 'prod' => $top->slug]) }}">   {{ strtoupper($top->name) }}</a>
                            <div class="price-wrapper">
                                <div class="price">
                                    @if ( ! empty($product->action))
                                        <span class="price-old">{{ number_format($top->price, 2) }} kn</span><span class="price-new">{{ number_format(($top->price - ($top->price * ($top->action->discount / 100))), 2) }} kn</span>
                                    @else
                                        <span>{{ number_format($top->price, 2) }} kn</span>
                                    @endif
                                </div><!-- .price -->
                                <p class="description"></p>
                                <a class="btn catalog_hide btn-outline" href="{{ route('proizvod', ['client' => $top->client->slug, 'cat' => $top->category()->slug, 'subcat' => $top->subcategory() ? $top->subcategory()->slug : 'ikoi', 'prod' => $top->slug]) }}"><span class="global-cart"></span>Opšrnije</a>
                            </div><!-- .price-wrapper -->
                        </div><!-- .caption-->
                    </div><!-- .single-product ends -->
                @endforeach
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
