<!-- Header -->
<header id="header" class=" clearfix">
    <div id="header-wrap">
        <div class="container clearfix">
            <span id="hamburger" >
                <a href="#menu" class="mburger mburger--collapse">
                    <b></b>
                    <b></b>
                    <b></b>
                </a>
            </span>
            <div id="logo">
                <a href="{{ route('index') }}" class="standard-logo"><img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}"></a>
                <a href="{{ route('index') }}" class="retina-logo"><img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}"></a>
            </div>
            <nav id="primary-menu" class="d-lg-flex d-xl-flex justify-content-xl-between justify-content-lg-between fnone style-2 with-arrows">
                <ul class="align-self-start"></ul>
                <ul class="align-self-center">
                    <li class="mega-menu"><a href="{{ route('gcp_route', ['group' => 'toyota-vilicari']) }}"><div>Toyota viličari</div></a>
                        <div class="mega-menu-content style-2 clearfix" >
                            <ul class="mega-menu-column col-lg-4">
                                @foreach ($categories['list']['TOYOTA VILIČARI'] as $category)
                                    @if($category->id <= 3)
                                        <li>
                                            <div class="widget clearfix">
                                                <div class="widget-last-view">
                                                    <a href="{{URL::to('/')}}/toyota-vilicari/{{ $category->slug }}">
                                                        <div class="spost clearfix">
                                                            <div class="entry-image">
                                                                <img src="{{ asset($category->image) }}" alt="Image">
                                                            </div>
                                                            <div class="entry-c">
                                                                <div class="entry-title">
                                                                    <h4>{{ $category->name }} </h4>
                                                                </div>
                                                                <div class="entry-meta">
                                                                    <p >{{$category->meta_description}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <ul class="mega-menu-column col-lg-4">
                                @foreach ($categories['list']['TOYOTA VILIČARI'] as $category)
                                    @if($category->id > 3 && $category->id <= 6 )
                                        <li>
                                            <div class="widget clearfix">
                                                <div class="widget-last-view">
                                                    <a href="{{URL::to('/')}}/toyota-vilicari/{{ $category->slug }}">
                                                        <div class="spost clearfix">
                                                            <div class="entry-image">
                                                                <img src="{{ asset($category->image) }}" alt="Image">
                                                            </div>
                                                            <div class="entry-c">
                                                                <div class="entry-title">
                                                                    <h4>{{ $category->name }} </h4>
                                                                </div>
                                                                <div class="entry-meta">
                                                                    <p >{{$category->meta_description}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <ul class="mega-menu-column col-lg-4">
                                @foreach ($categories['list']['TOYOTA VILIČARI'] as $category)
                                    @if($category->id > 6 )
                                        <li>
                                            <div class="widget clearfix">
                                                <div class="widget-last-view">
                                                    <a href="{{URL::to('/')}}/toyota-vilicari/{{ $category->slug }}">
                                                        <div class="spost clearfix">
                                                            <div class="entry-image">
                                                                <img src="{{ asset($category->image) }}" alt="Image">
                                                            </div>
                                                            <div class="entry-c">
                                                                <div class="entry-title">
                                                                    <h4>{{ $category->name }} </h4>
                                                                </div>
                                                                <div class="entry-meta">
                                                                    <p >{{$category->meta_description}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li><!-- .mega-menu end -->
                    <li ><a href="{{ route('tal') }}"><div>TAL (Toyota advanced Logistics)</div></a></li>
                    <li ><a href="{{ route('o-nama') }}"><div>O nama</div></a></li>
                    <li class="last"><a href="{{ route('kontakt') }}"><div>Kontakt</div></a></li>
                </ul>
                <ul class="align-self-end"></ul>

                <!-- cart -->
                <cart-nav-icon carturl="{{ route('kosarica') }}" checkouturl="{{ route('naplata') }}"></cart-nav-icon>

                <!-- Top Search -->
                <div id="top-search">
                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
                    <div class="container-fluid clearfix">
                        <form action="{{ route('search.all') }}" method="get">
                            <input type="text" name="q" class="form-control" value="" placeholder="Upišite pojam pretrage">
                            <button type="submit" class="srch"><i class="icon-search3"></i></button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
