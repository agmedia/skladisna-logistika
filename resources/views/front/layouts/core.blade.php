<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Skladišna Logistika" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>  @yield ('title' ) - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('temp/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/swiper.css') }}" type="text/css" />
    <!-- shop Demo Specific Stylesheet -->
    <link rel="stylesheet" href="{{ asset('demos/shop/shop.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('demos/shop/css/fonts.css') }}" type="text/css" />
    <!-- / -->
    <link rel="stylesheet" href="{{ asset('temp/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/magnific-popup.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/responsive.css') }}" type="text/css" />
    <!-- Include mmenu files -->
    <link href="{{ asset('dist/mmenu.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/mburger.css') }}" rel="stylesheet" />
    <script src="{{ asset('dist/mmenu.js') }}"></script>

    <script>
        /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-87575803-1', 'auto');
        ga('send', 'pageview');*/
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        /*!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1420754107945696'); // Insert your pixel ID here.
        fbq('track', 'PageView');*/
    </script>
    {{--<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1420754107945696&ev=PageView&noscript=1"/></noscript>--}}
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->
    <!-- Fire the plugin -->
    <script>
        document.addEventListener(
            "DOMContentLoaded", () => {
                new Mmenu( "#menu", {
                    "extensions": [
                        "pagedim-black",
                        "border-full"
                    ],
                    "navbars": [
                        {
                            "position": "bottom",
                            "content": [
                                "<a class='fa fa-envelope' href='#/'></a>",
                                "<a class='fa fa-twitter' href='#/'></a>",
                                "<a class='fa fa-facebook' href='#/'></a>"
                            ]
                        }
                    ]
                });
            }
        );
    </script>
    @stack('css_before')
    @stack('css')
</head>
<body class="stretched side-panel-left" data-loader="9" data-loader-color="#C11226" data-animation-in="fadeIn" data-speed-in="1500" data-animation-out="fadeOut" data-speed-out="800">
<!-- Document Wrapper -->

<div id="wrapper" class="clearfix">

    <div id="agapp">
        <!-- Topbar -->
    @include('front.layouts.partials.topbar')

    <!-- Header -->
    @include('front.layouts.partials.navbar')
    <!-- Slider -->
    {{-- @include('front.layouts.partials.slider') --}}
    <!-- Content -->
    @yield('content')

    <!-- Footer -->
        @include('front.layouts.partials.footer')
    </div>
@include('front.layouts.partials.sidenav')
</div><!-- #wrapper end -->


<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>
<!-- External JavaScripts
============================================= -->
<script src="{{ asset('temp/js/jquery.js') }}"></script>
<script src="{{ asset('js/cart_v2.js') }}"></script>
<script src="{{ asset('temp/js/plugins.js') }}"></script>
<!-- Footer Scripts
============================================= -->
<script src="{{ asset('temp/js/functions.js') }}"></script>

@stack('js')
<script>
    //webSettings.setDomStorageEnabled(true);
    jQuery(function() {
        jQuery( "#side-navigation" ).tabs({ show: { effect: "fade", duration: 400 } });
    });
</script>
<script>
    window.addEventListener('DOMContentLoaded', function() {

        $(window).on('scroll', function () {
            let scrollAmount = window.scrollY;
            if (scrollAmount == 0) {
                $('#header').removeClass('sticky-header')
               }
        });

        $('#top-cart').click(() => {
            $('#top-cart').toggleClass('top-cart-open');
        })

    });
</script>
<script>
    /* var bLazy = new Blazy({
         container: '.flexslider' // Default is window
     });
     $('.flexslider').on('afterChange', function(event, slick, direction){
         bLazy.revalidate();
         // left
     });*/
</script>
</body>
</html>
