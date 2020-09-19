@extends('front.layouts.core')

@push('css')
@endpush
@section ( 'title', 'Toyota viličari')

@section('content')
    <section id="page-title" class="page-title-mini page-title-right">

        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item active" aria-current="page">Toyota Viličari</li>
            </ol>
        </div>

    </section>

    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">

                <div class="heading-block center ">
                    <h2 class="main-headline">Toyota viličari</h2>
                    <span class="d-none d-sm-block">Viličari proizvođača Toyota svojom kvalitetom pružaju siguran i produktivan rad. Viličari su proizvedeni u tvornicama u Europi i Japanu u koje su ugrađene komponente visoke kvalitete.</span>
                </div>

                <div id="portfolio" class="portfolio grid-container portfolio-1 clearfix">






                        @foreach($kategorije as $kategorija)

                        <article class="portfolio-item pf-media pf-icons">

                            <div class="portfolio-image">
                                <div class="fslider" data-arrows="false" data-speed="400" data-pause="4000">
                                    <div class="flexslider">
                                        <div class="slider-wrap ">
                                            <div class="slide ">
                                                <a href="{{URL::to('/')}}/toyota-vilicari/{{ $kategorija->slug }}">
                                                    <img src="{{asset('images/toyota-vilicari/'.$kategorija->id.'/1.jpg')}}"   alt="{{ $kategorija->name }}">
                                                </a>
                                            </div>
                                            <div class="slide ">
                                                <a href="{{URL::to('/')}}/toyota-vilicari/{{ $kategorija->slug }}">
                                                    <img src="{{asset('images/toyota-vilicari/'.$kategorija->id.'/2.jpg')}}"   alt="{{ $kategorija->name }}">
                                                </a>
                                            </div>
                                            <div class="slide ">
                                                <a href="{{URL::to('/')}}/toyota-vilicari/{{ $kategorija->slug }}">
                                                    <img src="{{asset('images/toyota-vilicari/'.$kategorija->id.'/3.jpg')}}"   alt="{{ $kategorija->name }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>









                                <div class="portfolio-desc">
                                    <h3><a href="{{URL::to('/')}}/toyota-vilicari/{{ $kategorija->slug }}">{{ $kategorija->name }} </a></h3>



                                    @if ($kategorija->meta_keyword != "")
                                        <ul class="features-list">

                                        @foreach(explode(',', $kategorija->meta_keyword) as $info)

                                            @if(substr($info, -2)=='kg')

                                                    <li class="features-item">
                                                        <figure class="features-img"><img src="{{asset('images/ProductLoadCapacity.png')}}"></figure>
                                                        <span>{{$info}}</span>
                                                    </li>

                                            @endif

                                                @if(substr($info, -1)=='m')

                                                    <li class="features-item">
                                                        <figure class="features-img"><img src="{{asset('images/ProductLiftHeight.png')}}"></figure>
                                                        <span>{{$info}}</span>
                                                    </li>

                                                @endif

                                                @if(substr($info, -2)=='Ah')

                                                    <li class="features-item">
                                                        <figure class="features-img"><img src="{{asset('images/ProductBatteryCapacity.png')}}"></figure>
                                                        <span>{{$info}}</span>
                                                    </li>

                                                @endif



                                                @if(substr($info, -4)=='km/h')

                                                    <li class="features-item">
                                                        <figure class="features-img"><img src="{{asset('images/ProductSpeed.png')}}"></figure>
                                                        <span>{{$info}}</span>
                                                    </li>

                                                @endif







                                        @endforeach
                                        </ul>
                                    @endif



                                    {!! $kategorija->description !!}


                                    <a href="{{URL::to('/')}}/toyota-vilicari/{{ $kategorija->slug }}" class="btn btn-red">Pogledajte viličare</a>


                                </div>

                        </article>


<div class="clearfix"></div>


                        @endforeach





                </div>

            </div>

        </div>

    </section>
@endsection


@push('js_after')

@endpush
