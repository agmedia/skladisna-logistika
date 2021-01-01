@extends('front.layouts.core')
@push('css')
@endpush
@section ( 'title', 'Toyota viličari - Prodaja i najam')

@push('css_before')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Skladišna logistika - Toyota viličari - Prodaja i najam"/>
    <meta property="og:image" content="https://www.skladisna-logistika.hr/images/banners/banner_i_site-01.jpg"/>
    <meta property="og:site_name" content="Skladišna logistika - Toyota viličari"/>
    <meta property="og:url" content="https://www.skladisna-logistika.hr/"/>
    <meta property="og:description" content="Prodaja Toyotinih viličara u Hrvatskoj. Servis za 24 sata. Ručni viličari, niskopodizni, visokopodizni, regalni, električni viličari za Vas. Novi viličari. Rabljeni viličari. Najam viličara. Modeli: Ručni paletni viličari, Regalni viličari, Električni niskopodizni, Plinski i diesel viličari."/>

@endpush


@section('content')
    <section id="content">
        <div class="content-wrap notoppadding">
            <!-- MANUFACTURERS CAROUSEL -->
            <div class="container clearfix">
                <div id="oc-clients" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="30" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false"
                     data-items-xs="{{ ($manufacturers->count() > 3) ? 3 : $manufacturers->count() }}"
                     data-items-sm="{{ ($manufacturers->count() > 3) ? 3 : $manufacturers->count() }}"
                     data-items-md="{{ ($manufacturers->count() > 4) ? 4 : $manufacturers->count() }}"
                     data-items-lg="{{ ($manufacturers->count() > 5) ? 5 : $manufacturers->count() }}"
                     data-items-xl="{{ ($manufacturers->count() > 6) ? 6 : $manufacturers->count() }}">
                    @foreach($manufacturers as $manufacturer)
                        <div class="oc-item">
                            <a href="{{ route('partner', ['manufacturer' => $manufacturer]) }}">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{ asset($manufacturer->image) }}" alt="{{ $manufacturer->name }}">
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- WIDGETS - HOMEPAGE -->
            <div class="container clearfix">
                <div class="row">
                    @if(isset($widgets))
                        @foreach($widgets as $widget)
                            <div class="col-lg-{{ $widget->width }} mb-4">
                                <a href="{{ $widget->url }}">
                                    <div class=" text-center ">
                                        <div class="flip-card-front dark" style="background-image: url({{ asset($widget->image) }}">
                                            @if( ! empty($widget->badge))
                                                <div class="sale-flash">{{ $widget->badge }}</div>
                                            @endif
                                            <div class="flip-card-inner">
                                                <div class="card nobg noborder text-center">
                                                    <div class="card-body">
                                                        @if(empty($widget->subtitle))
                                                            <h2 class="card-title">{{ $widget->title }}</h2>
                                                        @else
                                                            <h2 class="card-title nobottommargin">{{ $widget->title }}</h2>
                                                            <p style="color: #fff; font-size: 1rem;" class="d-none d-lg-block">{{ $widget->subtitle }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="container clearfix topmargin bottommargin-sm">
                <div class="heading-block center ">
                    <h2 >Dodatna ponuda i usluge</h2>
                    <span>Velika ponuda <strong>rabljenih viličara</strong>, <strong>najam viličara</strong> svih tipova, te <strong>servis viličara</strong> na terenu ili mobilni servis.</span>
                </div>
                <div class="col_one_third ">
                    <div class="feature-box media-box">
                        <div class="fbox-media">
                            <img src="{{ asset('images/banners/rabljeni-vilicari-bw.jpg') }}" title="Rabljeni viličari" alt="Rabljeni viličari">
                        </div>
                        <div class="fbox-desc">
                            <h3 class="color">Rabljeni viličari<span class="subtitle">Velika ponuda rabljenih viličara.</span></h3>
                            <p>Ovdje bismo htjeli izdvojiti ponudu naših izvrsnih <strong>rabljenih viličara</strong> koji su u potpunosti servisirani i obnovljeni po najvišim standardima Toyota Material Handling Europe. Fokusirani smo na Toyota brand rabljenih viličara koji u radu pokazuju iznimnu kvalitetu i izdržljivost.  </p>
                        </div>
                    </div>
                </div>
                <div class="col_one_third ">
                    <div class="feature-box media-box">
                        <div class="fbox-media">
                            <img src="{{ asset('images/banners/najam-vilicara-bw.jpg') }}" alt="Najam viličara" title="Najam viličara">
                        </div>
                        <div class="fbox-desc">
                            <h3 class="color">Najam viličara<span class="subtitle">Najam viličara svih tipova. </span></h3>
                            <p>Kod najma viličara možete računati na kvalitetu, pouzdanost i izvrsne performanse stroja unajmljivali ga na samo jedan dan ili nekoliko godina.
                               Najam pruža korisniku fleksibilnost koju njegov posao zahtjeva kojom može izbjeći inicijalno ulaganje kupovinom viličara i promjenu specifikacije viličara sukladno potrebi u radu.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col_one_third  col_last">
                    <div class="feature-box media-box">
                        <div class="fbox-media">
                            <a href="servis-vilicara/"><img src="{{ asset('images/banners/servis-vilicara-bw.jpg') }}" alt="Servis viličara" title="Servis viličara"></a>
                        </div>
                        <div class="fbox-desc">
                            <h3 class="color">Servis viličara<span class="subtitle">Servis viličara na terenu ili mobilni servis.</span></h3>
                            <p>Naš cilj je pružiti Vam uslugu <strong>servisa viličara</strong> kojom bismo izvukli maksimum iz Vaših viličara, te Vam pritom omogućiti da radite najbolje što znate - da vodite Vaš posao. Bez obzira na okolnosti možete biti sigurni da ćemo pažljivo saslušati Vaše individualne potrebe te ćemo Vam, oslonjeni na naše stručno znanje...</p>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="section nomargin noborder hidden-xs" style="padding: 60px 0;background-color:#eee">
                <div class="container clear-bottommargin clearfix">
                    <div class="container clearfix bottommargin">
                        <div class="heading-block center nomargin">
                            <h2>IZDVOJENO IZ PONUDE</h2>
                        </div>
                    </div>
                    <div id="shop" class="owl-carousel products-carousel carousel-widget shop bottommargin" data-margin="20" data-nav="true" data-pagi="false" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4" data-items-xl="4">
                    @foreach($top_products as $product)
                        @include('front.product.partials.product-category-front', [
                                  'product' => $product,
                                  'link' => route('gcp_route', [
                                      'group' => \Illuminate\Support\Str::slug($product->category()->group),
                                      'cat' => isset($product->category()->slug) ? $product->category()->slug : '',
                                      'subcat' => $product->subcategory() ? $product->subcategory()->slug : 'ikoi',
                                      'prod' => $product->slug
                                  ])
                              ])
                        <!-- .single-product ends -->
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container clear-bottommargin topmargin nobottommargin clearfix">
                <div class="container clearfix bottommargin">
                    <div class="heading-block center nomargin">
                        <h2>Zadnje novosti</h2>
                    </div>
                </div>
                <div id="oc-posts" class="owl-carousel posts-carousel carousel-widget" data-margin="20" data-nav="false" data-pagi="true" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="3" data-items-xl="3">
                    @if (isset($blogs))
                        @foreach($blogs as $blog)
                            <div class="oc-item">
                                <div class="ipost clearfix">
                                    @if (isset($blog->image))
                                        <div class="entry-image">
                                            @if (isset($blog->subcat))
                                                <a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->subcat->slug, 'blog' => $blog->slug]) }}"><img class="image_fade" src="{{ isset($blog->image) ? asset($blog->image) : asset('media/images/blog.jpg') }}" alt="{{ $blog->name }}" style="opacity: 1;"></a>
                                            @else
                                                <a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->slug]) }}"><img class="image_fade" src="{{ asset($blog->image) }}" alt="{{ isset($blog->image) ? asset($blog->image) : asset('media/images/blog.jpg') }}" style="opacity: 1;"></a>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="entry-title">
                                        <h3>
                                            @if (isset($blog->subcat))
                                                <a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->subcat->slug, 'blog' => $blog->slug]) }}">{{ \Illuminate\Support\Str::limit($blog->title, 125) }}</a>
                                            @else
                                                <a href="{{ route('blogovi', ['cat' => $blog->cat->slug, 'subcat' => $blog->slug]) }}">{{ \Illuminate\Support\Str::limit($blog->title, 125) }}</a>
                                            @endif
                                        </h3>
                                    </div>
                                    <ul class="entry-meta clearfix">
                                        <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make($blog->publish_date)->locale('hr')->format('d.m.Y.') }}</li>
                                    </ul>
                                    <div class="entry-content">
                                        <p>{{ $blog->meta_description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
@endpush
