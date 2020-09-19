<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets -->
    @stack('css_before')
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/sl-core.css') }}" type="text/css" />

    @stack('css')
    <link rel="stylesheet" href="{{ asset('css/sl-theme.css') }}" type="text/css" />

    <!-- Revolution Slider Stylesheets -->
    <link rel="stylesheet" href="{{ asset('plugins/rs-plugin/css/ag-rev-slider.css') }}" type="text/css" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title -->
    <title>{{ config('app.name') }}</title>

    <style>

        .revo-slider-emphasis-text {
            font-size: 58px;
            font-weight: 700;
            letter-spacing: 1px;
            font-family: 'Raleway', sans-serif;
            padding: 15px 20px;
            border-top: 2px solid #FFF;
            border-bottom: 2px solid #FFF;
        }

        .revo-slider-desc-text {
            font-size: 20px;
            font-family: 'Lato', sans-serif;
            width: 650px;
            text-align: center;
            line-height: 1.5;
        }

        .revo-slider-caps-text {
            font-size: 16px;
            font-weight: 400;
            letter-spacing: 3px;
            font-family: 'Raleway', sans-serif;
        }

        .tp-video-play-button { display: none !important; }

        .tp-caption { white-space: nowrap; }

    </style>

</head>

<body class="stretched">

<!-- Document Wrapper -->
<div id="wrapper" class="clearfix">
    <!-- Topbar -->
    @include('front.layouts.partials.topbar')
    <!-- Header -->
    @include('front.layouts.partials.navbar')

    <!-- Slider -->
    @include('front.layouts.partials.slider')

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    @include('front.layouts.partials.footer')

</div><!-- #wrapper end -->

<!-- Go To Top -->
<div id="gotoTop" class="icon-angle-up"></div>

<script src="{{ asset('js/sl-core.js') }}"></script>

<!-- Revolution Slider Scripts -->
<script src="{{ asset('plugins/rs-plugin/js/ag.jquery.rev.js') }}"></script>
<script src="{{ asset('plugins/rs-plugin/js/extensions/ag.rev.slider.js') }}"></script>

<script>

  var tpj=jQuery;
  tpj.noConflict();

  tpj(document).ready(function() {

    var apiRevoSlider = tpj('#rev_slider_ishop').show().revolution(
      {
        sliderType:"standard",
        jsFileLocation:"include/rs-plugin/js/",
        sliderLayout:"fullwidth",
        dottedOverlay:"none",
        delay:9000,
        navigation: {},
        responsiveLevels:[1200,992,768,480,320],
        gridwidth:1140,
        gridheight:500,
        lazyType:"none",
        shadow:0,
        spinner:"off",
        autoHeight:"off",
        disableProgressBar:"on",
        hideThumbsOnMobile:"off",
        hideSliderAtLimit:0,
        hideCaptionAtLimit:0,
        hideAllCaptionAtLilmit:0,
        debugMode:false,
        fallbacks: {
          simplifyAll:"off",
          disableFocusListener:false,
        },
        navigation: {
          keyboardNavigation:"off",
          keyboard_direction: "horizontal",
          mouseScrollNavigation:"off",
          onHoverStop:"off",
          touch:{
            touchenabled:"on",
            swipe_threshold: 75,
            swipe_min_touches: 1,
            swipe_direction: "horizontal",
            drag_block_vertical: false
          },
          arrows: {
            style: "ares",
            enable: true,
            hide_onmobile: false,
            hide_onleave: false,
            tmp: '<div class="tp-title-wrap">	<span class="tp-arr-titleholder">@{{title}}</span> </div>',
            left: {
              h_align: "left",
              v_align: "center",
              h_offset: 10,
              v_offset: 0
            },
            right: {
              h_align: "right",
              v_align: "center",
              h_offset: 10,
              v_offset: 0
            }
          }
        }
      });

    apiRevoSlider.bind("revolution.slide.onloaded",function (e) {
      SEMICOLON.slider.sliderParallaxDimensions();
    });

  }); //ready

</script>

@stack('js')

<script>
  jQuery(function() {
    jQuery( "#side-navigation" ).tabs({ show: { effect: "fade", duration: 400 } });
  });
</script>



</body>
</html>
