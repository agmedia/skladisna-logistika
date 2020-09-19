<add-to-cart-btn
    id="{{ $product->id }}"
    image="{{ asset($product->image) }}"
    name="{{ $product->name }}"
    price="{{ ( ! empty($product->action) ? number_format(($product->price - ($product->price * ($product->action->discount / 100))), 2) : number_format($product->price, 2)) }}"
></add-to-cart-btn>
