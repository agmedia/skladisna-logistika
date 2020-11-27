@extends('front.layouts.core')
@section ( 'title', $prod->name)
@push('css_before')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ $prod->name }}"/>
    <meta property="og:image" content="{{ asset($prod->image) }}"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta property="og:url" content="{{ route('proizvod', [
                                        'cat' => $cat->slug,
                                        'subcat' => $subcat->slug ? $subcat->slug : '',
                                        'prod' => $prod->slug
                                    ]) }}"/>
    <meta property="og:description" content="{{ $prod->meta_description  }}"/>
    <meta property="product:price:amount" content="{{ number_format($prod->price, 2) }}">
    <meta property="product:price:currency" content="Kn">
@endpush
@section('content')
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('kategorija', ['group' => \Illuminate\Support\Str::slug($cat->group)]) }}">{{ \Illuminate\Support\Str::title($cat->group) }}</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('kategorija', ['group' => \Illuminate\Support\Str::slug($cat->group), 'cat' => $cat->slug]) }}">{{ \Illuminate\Support\Str::title($cat->name) }}</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('kategorija', ['group' => \Illuminate\Support\Str::slug($cat->group), 'cat' => $cat->slug, 'subcat' => $subcat->slug]) }}">{{ \Illuminate\Support\Str::title($subcat->name) }}</a></li>
                <li class="breadcrumb-item">{{ $prod->name }}</li>
            </ol>
        </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                @include('front.layouts.partials.alert')
                <div class="single-product">
                    <div class="product">
                        <div class="col_half">
                            <!-- Product Single -
                            ============================================= -->
                            <div class="product-image">
                                <div class="fslider" data-pagi="false" data-animation="fade" data-arrows="false" data-thumbs="true">
                                    <div class="flexslider">
                                        <div class="slider-wrap" data-lightbox="gallery">
                                            <div class="slide " data-thumb="{{ asset($prod->image) }}">
                                                <a href="{{ asset($prod->image) }}" title="{{ $prod->name }}" data-lightbox="gallery-item">
                                                    <img  src="{{ asset($prod->image)}}" alt="{{ $prod->name }}">
                                                </a>
                                            </div>
                                            @if ( ! empty($prod->images))
                                                @foreach($prod->images as $img)
                                                    @if($img->image!=$prod->image)
                                                    <div class="slide" data-thumb="{{ asset($img->image) }}">
                                                        <a href="{{ asset($img->image) }}" title="{{ $prod->name }}" data-lightbox="gallery-item">
                                                            <img  src="{{ asset($img->image)  }}" alt="{{ $prod->name }}">
                                                        </a>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if ($prod->topponuda)
                                    <div class="sale-flash">Top Ponuda</div>
                                @endif
                                <div class="clear"></div>
                            </div><!-- Product Single - Gallery End -->
                        </div>
                        <div class="col_half col_last product-desc">
                            <h1 class="nobottommargin">{{ $prod->name }}</h1>
                            <strong class="color sku">{{ $prod->sku }}</strong>
                            <p class="lead nobottommargin">{{ $prod->seo_title }}</p>
                            <ul class="features-list">
                                @if ( ! empty($prod->details->weight_capacity))
                                <li class="features-item">
                                    <figure class="features-img"><img src="{{ asset('images/ProductLoadCapacity.png') }}"></figure>
                                    <span><!-- react-text: 388 -->{{ $prod->details->weight_capacity  }}kg</span>
                                </li>
                                @endif
                                @if ( ! empty($prod->details->lift_height))
                                        <li class="features-item">
                                            <figure class="features-img"><img src="{{ asset('images/ProductLiftHeight.png') }}"></figure>
                                            <span><!-- react-text: 388 -->{{ $prod->details->lift_height  }}m</span>
                                        </li>
                                 @endif
                                    @if ( ! empty($prod->details->battery))
                                        <li class="features-item">
                                            <figure class="features-img"><img src="{{ asset('images/ProductBatteryCapacity.png') }}"></figure>
                                            <span><!-- react-text: 388 -->{{ $prod->details->battery  }}Ah</span>
                                        </li>
                                    @endif
                                    @if ( ! empty($prod->details->voltage))
                                        <li class="features-item">
                                            <figure class="features-img"><img src="{{ asset('images/ProductBatteryVoltage.png') }}"></figure>
                                            <span><!-- react-text: 388 -->{{ $prod->details->voltage  }}<!-- /react-text --><!-- react-text: 389 -->V<!-- /react-text --></span>
                                        </li>
                                    @endif
                                    @if ( ! empty($prod->details->speed))
                                        <li class="features-item">
                                            <figure class="features-img"><img src="{{ asset('images/ProductSpeed.png') }}"></figure>
                                            <span><!-- react-text: 388 -->{{ $prod->details->speed  }}<!-- /react-text --><!-- react-text: 389 -->km/h<!-- /react-text --></span>
                                        </li>
                                    @endif
                            </ul>
                            <p class="lead spec nobottommargin one-page-menu"><a href="#" data-offset="70" data-href="#specifikacija">Tehnička specifikacija</a></p>
                            <!-- Product Single - Price
                            ============================================= -->
                            @if ($prod->price != 0)
                                <div class="line"></div>
                                @if ( ! empty($prod->action))
                                    @if ( ! empty($prod->action->price))
                                        <div class="product-price">
                                            <del>{{ number_format($prod->price, 2) }}kn</del> <ins> {{ number_format($prod->action->price, 2) }}kn</ins>
                                        </div><!-- .price -->
                                    @else
                                        <div class="product-price">
                                            <del>{{ number_format($prod->price, 2) }}kn</del> <ins> {{ number_format(($prod->price - ($prod->price * ($prod->action->discount / 100))), 2) }}kn</ins>
                                        </div><!-- .price -->
                                    @endif
                                @else
                                    <div class="product-price">
                                        <ins>{{ number_format($prod->price, 2) }}kn</ins>
                                    </div><!-- .price -->
                                @endif
                                <div class="clear"></div>
                                <!-- Product Single - Quantity & Cart Button -->
                                @include('front.product.partials.add-to-cart-btn', ['product' => $prod])
                                {{--<form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                                    <div class="quantity clearfix">
                                        <input type="button" value="-" class="minus">
                                        <input type="text" step="1" min="1"  name="quantity" value="1" title="Količina" class="qty" size="4" />
                                        <input type="button" value="+" class="plus">
                                    </div>
                                    <button type="submit" class="btn btn-green nomargin">U košaricu</button>
                                </form>--}}
                                <div class="clear"></div>
                                <div class="line"></div>
                            @else
                                <div class="clear"></div>
                                <div class="line"></div>
                                <div class="product-price one-page-menu">
                                    <a href="#" data-href="#ponuda" data-offset="70" class="btn btn-green">Zatraži ponudu</a>
                                </div>
                                <div class="clear"></div>
                                <div class="line"></div>
                            @endif
                            <div class="feature-box fbox-plain fbox-dark fbox-small">
                                <div class="fbox-icon">
                                    <i class="icon-truck2"></i>
                                </div>
                                <h3>Termin isporuke prema dogovoru</h3>
                            </div>
                            @if ( ! empty($prod->details->options))
                            <div class="feature-box fbox-plain fbox-dark fbox-small">
                                <div class="fbox-icon">
                                    <i class="icon-thumbs-up2"></i>
                                </div>
                                <h3>Garancija</h3>
                                <p class="notopmargin">{{ $prod->details->options }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="container clearfix">
                <div class="col_full bottommargin topmargin-sm prod-desc">
                    <div class="heading-block sm left ">
                        <h3 class="main-headline">Značajke proizvoda</h3>
                    </div>
                    {!! $prod->description !!}
                </div>
            </div>
            <div class="section bottommargin noborder hidden-xs">
                <div class="container clearfix">
                    <div class="col_two_third bottommargin">
                        <a id="specifikacija" name="specifikacija"></a>
                        <div class="heading-block sm left ">
                            <h3 class="main-headline">Tehnička specifikacija</h3>
                        </div>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>Naziv</td>
                                <td>{{ $prod->name }}</td>
                            </tr>
                            @if ( ! empty($prod->sku))
                                <tr>
                                    <td>Model</td>
                                    <td>{{ $prod->sku }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->application))
                                <tr>
                                    <td>Primjena viličara</td>
                                    <td>{{ $prod->details->application }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->engine))
                                <tr>
                                    <td>Vrsta motora</td>
                                    <td>{{ $prod->details->engine }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->weight_capacity))
                                <tr>
                                    <td>Max.kapacitet nosivosti (kg)</td>
                                    <td>{{ $prod->details->weight_capacity }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->lift_height))
                                <tr>
                                    <td>Max. visina dizanja (m)</td>
                                    <td>{{ $prod->details->lift_height }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->center_mass))
                                <tr>
                                    <td>Težište</td>
                                    <td>{{ $prod->details->center_mass }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->commision_height))
                                <tr>
                                    <td>Max. visina komisiniranja (m)</td>
                                    <td>{{ $prod->details->commision_height }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->battery))
                                <tr>
                                    <td>Max. jačina baterije (Ah)</td>
                                    <td>{{ $prod->details->battery }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->voltage))
                                <tr>
                                    <td>Voltaža (V)</td>
                                    <td>{{ $prod->details->voltage }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->speed))
                                <tr>
                                    <td>Max.brzina vožnje (km/h)</td>
                                    <td>{{ $prod->details->speed }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->radius))
                                <tr>
                                    <td>Okretni radius (mm)</td>
                                    <td>{{ $prod->details->radius }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->width))
                                <tr>
                                    <td>Radni hodnik (mm)</td>
                                    <td>{{ $prod->details->width }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->tow_capacity))
                                <tr>
                                    <td>Vučni kapacitet (kg)</td>
                                    <td>{{ $prod->details->tow_capacity }}</td>
                                </tr>
                            @endif
                            @if ( ! empty($prod->details->tow_capacity))
                                <tr>
                                    <td>Broj kotača</td>
                                    <td>{{ $prod->details->wheels }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{-- dd($prod->details) --}}
                    </div>
                    @if ( ! empty($prod->pdf))
                        <div class="col_one_third col_last bottommargin">
                            <div class="heading-block sm left ">
                                <h3 class="main-headline">PDF dokumenti</h3>
                            </div>
                            <ul class="product-quote__documentsList documents-list">
                                <li><a target="_blank" href="{{ asset($prod->pdf) }}" data-code="2701">{{ $prod->name }} - specifikacije</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="container clearfix">
                <div class="col_full bottommargin">
                    <a id="ponuda" name="ponuda"></a>
                    <div class="heading-block sm left ">
                        <h3 class="main-headline">Zatraži ponudu</h3>
                    </div>
                    <div class="col_two_third">
                        <div class="form-widget">
                            <h3 class="nobottommargin">Pošaljite upit putem obrasca</h3>
                            <p>Na upite odgovaramo u roku od 24 sata. Svi upite tretiraju se povjerljivo u skladu s našim <a href="{{ route('info.page', ['page' => 'pravila-privatnosti-i-kolacici']) }}">Pravilima o privatnosti.</a></p>
                            <div class="form-result"></div>
                            <form class="nobottommargin" action="{{ route('kontakt.form') }}" method="POST">
                                @csrf
                                <div class="col_one_third">
                                    <label for="name">Ime <small>*</small></label>
                                    <input type="text" id="name" name="name" value="" class="sm-form-control required">
                                </div>
                                <div class="col_one_third">
                                    <label for="email">Email <small>*</small></label>
                                    <input type="email" id="email" name="email" value="" class="required email sm-form-control">
                                </div>
                                <div class="col_one_third col_last">
                                    <label for="phone">Telefon</label>
                                    <input type="text" id="phone" name="phone" value="" class="sm-form-control">
                                </div>
                                <div class="clear"></div>
                                <div class="col_one_third">
                                    <label for="template-contactform-tvrtka">Naziv tvrtke </label>
                                    <input type="text" id="tvrtka" name="tvrtka" value="" class=" sm-form-control">
                                </div>
                                <div class="col_one_third">
                                    <label for="template-contactform-oib">OIB </label>
                                    <input type="text" id="oib" name="oib" value="" class=" sm-form-control">
                                </div>
                                <div class="col_one_third col_last">
                                    <label for="template-contactform-subject">Predmet </label>
                                    <input type="text" id="subject" name="subject" value="{{ $prod->name }}" class="sm-form-control">
                                </div>
                                <div class="clear"></div>
                                <div class="col_full">
                                    <label for="message">Poruka <small>*</small></label>
                                    <textarea class="required sm-form-control" id="message" name="message" rows="6" cols="30"></textarea>
                                </div>
                                <div class="col_full">
                                    <input type="checkbox" name="consent" value="da"> Pročitao sam i slažem se s <a href="{{ route('info.page', ['page' => 'pravila-privatnosti-i-kolacici']) }}"> Politikom o zaštiti privatnosti i kolačićima</a>
                                </div>
                                <input type="hidden" name="interest_id" value="{{ $prod->id }}">
                                <input type="hidden" name="recaptcha" id="recaptcha">
                                <div class="col_full">
                                    <button class="btn btn-red nomargin" type="submit">Pošalji poruku</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- Contact Form End -->
                </div>
                @if(count($related))
                <div class="col_full nobottommargin">
                    <div class="heading-block left ">
                        <h3 class="main-headline">Povezani proizvodi</h3>
                    </div>
                    <div id="shop" class="shop cat product-3 clearfix" data-layout="fitRows">
                    @foreach($related as $prod)
                        @include('front.product.partials.product-category', [
                                  'product' => $prod,
                                  'link' => route('proizvod', [
                                      'cat' => isset($prod->category()->slug) ? $prod->category()->slug : '',
                                      'subcat' => $prod->subcategory() ? $prod->subcategory()->slug : '',
                                      'prod' => $prod->slug
                                  ])
                              ])
                        <!-- .single-product ends -->
                        @endforeach
                    </div>
                </div>
                 @endif
            </div>
        </div>
    </section><!-- #content end -->
@endsection

@push('js_before')
@endpush

@push('js')
    @include('front.layouts.partials.recaptcha-js')
@endpush
