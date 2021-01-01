<div class="product clearfix">
    <div class="product-inner">
        <div class="product-image">
            <a href="{{ $link }}"><img loading="lazy" src="{{ asset($product->image) ?? 'media/images/sl-logo.png' }}"
                                       data-src-small="{{ asset($product->image) ?? 'media/images/sl-logo.png' }}"
                                       alt="{{ $product->sku }}"></a>
            @if ($product->topponuda)
                <div class="sale-flash">Top Ponuda</div>
            @endif
        </div>
        <div class="product-desc">
            <div class="product-title"><h3><a href="{{ $link }}">{{ $product->sku }}</a></h3></div>
            <div class="product-description"><ul><li>{{ $product->seo_title }}</li></ul> </div>
            <ul class="features-list">
                @if ( ! empty($product->details->weight_capacity))
                    <li class="features-item">
                        <figure class="features-img"><img src="{{ asset('images/ProductLoadCapacity.png') }}"></figure>
                        <span><!-- react-text: 388 -->{{ $product->details->weight_capacity  }}kg</span>
                    </li>
                @endif
                @if ( ! empty($product->details->lift_height))
                    <li class="features-item">
                        <figure class="features-img"><img src="{{ asset('images/ProductLiftHeight.png') }}"></figure>
                        <span><!-- react-text: 388 -->{{ $product->details->lift_height  }}m</span>
                    </li>
                @endif
                @if ( ! empty($product->details->battery))
                    <li class="features-item">
                        <figure class="features-img"><img src="{{ asset('images/ProductBatteryCapacity.png') }}"></figure>
                        <span><!-- react-text: 388 -->{{ $product->details->battery  }}Ah</span>
                    </li>
                @endif
                @if ( ! empty($product->details->voltage))
                    <li class="features-item">
                        <figure class="features-img"><img src="{{ asset('images/ProductBatteryVoltage.png') }}"></figure>
                        <span><!-- react-text: 388 -->{{ $product->details->voltage  }}<!-- /react-text --><!-- react-text: 389 -->V<!-- /react-text --></span>
                    </li>
                @endif
                @if ( ! empty($product->details->speed))
                    <li class="features-item">
                        <figure class="features-img"><img src="{{ asset('images/ProductSpeed.png') }}"></figure>
                        <span><!-- react-text: 388 -->{{ $product->details->speed  }}<!-- /react-text --><!-- react-text: 389 -->km/h<!-- /react-text --></span>
                    </li>
                @endif
            </ul>
            @include('front.product.partials.product-price', ['product' => $product])
            <a href="{{ $link }}" class="btn btn-green">Opširnije</a>
        </div>
    </div>
</div>
