@if ($product->price!=0)
    @if ( ! empty($product->action) && empty($product->action->coupon))
        @if ($product->action->discount)
            <div class="product-price">
                <del>{{ number_format($product->price, 2) }}kn</del> <ins> {{ number_format(($product->price - ($product->price * ($product->action->discount / 100))), 2) }}kn</ins>
            </div>
        @else
            <div class="product-price">
                <del>{{ number_format($product->price, 2) }}kn</del> <ins> {{ number_format($product->action->price, 2) }}kn</ins>
            </div>
        @endif
    @else
        <div class="product-price">
            <ins>{{ number_format($product->price, 2) }}kn</ins>
        </div><!-- .price -->
    @endif
@else
    <div class="product-price">
        <ins>Zatraži ponudu</ins>
    </div>
@endif