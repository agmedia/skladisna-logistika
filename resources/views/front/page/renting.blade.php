@extends('front.layouts.core')

@push('css')
    <link rel="stylesheet" href="{{ asset('temp/css/components/datepicker.css') }}" type="text/css"/>
@endpush

@section ( 'title', 'Rabljeni viličari')

@section('content')
    <section id="slider" class="slider-element slider-parallax" style="background: url({{ asset('images/banners/rabljeno.jpg') }}) center center; background-size: cover;" data-height-xl="500" data-height-lg="350" data-height-md="300" data-height-sm="220"
             data-height-xs="180">
        <div class="slider-parallax-inner">
            <div class="container clearfix">
                <div class="vertical-middle center">
                </div>
            </div>
        </div>
    </section>
    <section class="  ">
        <div class="clearfix"></div>
    </section>
    <div class="clearfix"></div>
    <!-- Content
    ============================================= -->
    <section id="content" class="spad">
        <div class="content-wrap">
            <div class="container clearfix">
                @include('front.layouts.partials.alert')
                <div class="container clearfix bottommargin-sm">
                    <div class="heading-block center nomargin">
                        <h3>Upit za najam u 10 koraka u trajanju manje od 1 minute i 30 sekundi</h3>
                    </div>
                </div>

                <div class="col_full bottommargin">
                    <div class="form-widget">
                        <div class="col_full">
                            <p>Odgovor Vam stiže odmah!. Svi upiti tretiraju se povjerljivo u skladu s našim <a href="{{ route('info.page', ['page' => 'pravila-privatnosti-i-kolacici']) }}">Pravilima o privatnosti.</a></p>
                        </div>
                        <form class="nobottommargin" action="{{ route('rabljeno.forma') }}" method="POST">
                            @csrf
                            <div class="col_full">
                                <label for="email">Email <small>*</small></label>
                                <input type="email" id="email" name="email" value="" class="form-control email required">
                                @error('email')
                                <span class="text-danger font-size-sm">Email je obvezan!</span>
                                @enderror
                            </div>
                            <div class="clear"></div>
                            <div class="col_full">
                                <label for="mobile">Broj mobitela <small>*</small></label>
                                <input type="text" id="mobile" name="mobile" value="" class="form-control required">
                                @error('mobile')
                                <span class="text-danger font-size-sm">Mobitel je obvezan!</span>
                                @enderror
                            </div>
                            <div class="clear"></div>
                            <div class="col_full">
                                <label for="oib">OIB firme ili obrta <small>*</small></label>
                                <input type="text" id="oib" name="oib" value="" class="form-control required">
                                @error('oib')
                                <span class="text-danger font-size-sm">OIB je obvezan!</span>
                                @enderror
                            </div>
                            <div class="clear"></div>
                            <div class="col_full">
                                <hr>
                            </div>
                            <div class="clear"></div>

                            <div class="col_full">
                                <label for="location">Lokacija gdje će viličar raditi</label>
                                <select class="form-control" name="location" id="location" aria-invalid="false">
                                    <option value="0">--- Odaberite jednu od opcija ---</option>
                                    <option value="hc">Na adresu sjedišta firme</option>
                                    <option value="other">Za slučaj druge lokacije unijeti točnu adresu, grad</option>
                                </select>
                            </div>
                            <div class="col_full hidden" id="location-address-div">
                                <label for="location-address">Adresa lokacije</label>
                                <input type="text" id="location-address" name="location_address" value="" class="form-control">
                            </div>
                            <div class="clear"></div>
                            <div class="col_full">
                                <hr>
                            </div>
                            <div class="clear"></div>

                            <div class="col_full">
                                <label style="margin-bottom: 30px;">Vrsta viličara</label>
                                <div class="row car-list btn-group">
                                    <label class="car-image px-0 col-6 col-md-3 col-lg-2">
                                        <div class="img-form">
                                            <input type="radio" name="type" id="car-rental-cars-creta" value="ce"> ČEONI ELEKTRIČNI<br><br>
                                            <img src="{{ asset('media/images/gallery/category/elektricni-ceoni-vilicari.jpg') }}" alt="Image">
                                        </div>
                                    </label>

                                    <label class="car-image px-0 col-6 col-md-3 col-lg-2">
                                        <div class="img-form">
                                            <input type="radio" name="type" id="car-rental-cars-creta" value="cp"> ČEONI PLINSKI<br><br>
                                            <img src="{{ asset('media/images/gallery/category/plinski-i-diesel-ceoni-vilicari.jpg') }}" alt="Image">
                                        </div>
                                    </label>

                                    <label class="car-image px-0 col-6 col-md-3 col-lg-2">
                                        <div class="img-form">
                                            <input type="radio" name="type" id="car-rental-cars-creta" value="cd"> ČEONI DIESEL<br><br>
                                            <img src="{{ asset('media/images/gallery/category/plinski-i-diesel-ceoni-vilicari.jpg') }}" alt="Image">
                                        </div>
                                    </label>

                                    <label class="car-image px-0 col-6 col-md-3 col-lg-2">
                                        <div class="img-form">
                                            <input type="radio" name="type" id="car-rental-cars-creta" value="rv"> RUČNI BATERIJSKI SA KRANOM (VISOKOPODIZNI)
                                            <img src="{{ asset('media/images/gallery/category/elektricni-visokopodizni-vilicari.jpg') }}" alt="Image">
                                        </div>
                                    </label>
                                    <label class="car-image px-0 col-6 col-md-3 col-lg-2">
                                        <div class="img-form">
                                            <input type="radio" name="type" id="car-rental-cars-creta" value="rn"> RUČNI BATERIJSKI BEZ KRANA (NISKOPODIZNI)
                                            <img src="{{ asset('media/images/gallery/category/elektricni-niskopodizni-paletni-vilicari.jpg') }}" alt="Image">
                                        </div>
                                    </label>
                                    <label class="car-image px-0 col-6 col-md-3 col-lg-2">
                                        <div class="img-form">
                                            <input type="radio" name="type" id="car-rental-cars-creta" value="rg"> REGALNI<br><br>
                                            <img src="{{ asset('media/images/gallery/category/elektricni-regalni-vilicari.jpg') }}" alt="Image">
                                        </div>
                                    </label>
                                </div>
                            </div>

<!--                            <div class="col_full">
                                <label for="type">Vrsta viličara</label>
                                <select class="form-control" name="type" id="type" aria-invalid="false">
                                    <option value="0">-&#45;&#45; Odaberite jednu od opcija -&#45;&#45;</option>
                                    <option value="ce">ČEONI ELEKTRIČNI</option>
                                    <option value="cp">ČEONI PLINSKI</option>
                                    <option value="cd">ČEONI DIESEL</option>
                                    <option value="rv">RUČNI BATERIJSKI SA KRANOM (VISOKOPODIZNI)</option>
                                    <option value="rn">RUČNI BATERIJSKI BEZ KRANA (NISKOPODIZNI)</option>
                                    <option value="rg">REGALNI</option>
                                </select>
                            </div>-->
                            <div class="col_full">
                                <label for="weight">Nosivost <small style="color: #bcbcbc;">*Odaberite vrstu viličara prije odabira nosivosti.</small></label>
                                <select class="form-control" name="weight" id="weight-fork">
                                    <option value="0">--- Odaberite jednu od opcija ---</option>
                                </select>
                            </div>
                            <div class="col_full">
                                <label for="type" id="height-label">Visina dozanja</label>
                                <select class="form-control" name="height" id="height-fork" aria-invalid="false">
                                    <option value="">--- Odaberite jednu od opcija ---</option>
                                    <option value="2">DO 2 m</option>
                                    <option value="3">DO 3 m</option>
                                    <option value="4">DO 4 m</option>
                                    <option value="5">DO 5 m</option>
                                    <option value="6">DO 6 m</option>
                                    <option value="7">VIŠE OD 7 m</option>
                                </select>
                            </div>

                            <div class="clear"></div>
                            <div class="col_full">
                                <hr>
                            </div>
                            <div class="clear"></div>

                            <div class="col_full">
                                <label for="rent-date-start">Početak najma</label>
                                <input type="text" name="rent_start_date" id="rent-date-start" class="form-control input-datepicker text-left" value="" placeholder="Odaberite početak trajanja najma viličara">
                            </div>
                            <div class="col_full input-daterange">
                                <label for="rent-date-end">Kraj najma</label>
                                <input type="text" name="rent_end_date" id="rent-date-end" class="form-control input-datepicker text-left" value="" placeholder="Odaberite kraj trajanja najma viličara">
                            </div>

                            <div class="clear"></div>
                            <div class="col_full">
                                <hr>
                            </div>
                            <div class="clear"></div>

                            <div class="col_full">
                                <label for="on-location">
                                    <input type="checkbox" name="on_location" id="on-location" class="mr-2" value="1">
                                    TREBAM DA SE VILIČAR DOSTAVI NA LOKACIJU
                                </label>
                            </div>
                            <div class="col_full">
                                <label for="has-ramp">
                                    <input type="checkbox" name="has_ramp" id="has-ramp" class="mr-2" value="1">
                                    IMAM ISTOVARNU RAMPU
                                </label>
                            </div>

                            <div class="clear"></div>
                            <div class="col_full">
                                <hr>
                            </div>
                            <div class="clear"></div>

                            <div class="col_full">
                                <input type="checkbox" name="consent" value="da"> Pročitao sam i slažem se s <a href="{{ route('info.page', ['page' => 'pravila-privatnosti-i-kolacici']) }}"> Politikom o zaštiti privatnosti i kolačićima</a>
                                @error('consent')
                                <br><span class="text-danger font-size-sm">Prihvačanje politike privatnosti i kolačića je obvezno!</span>
                                @enderror
                            </div>
                            <div class="col_full">
                                <button class="btn btn-red nomargin" type="submit">Pošalji poruku</button>
                            </div>
                            <div class="clear"></div>
                            <input type="hidden" name="recaptcha" id="recaptcha">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- #content end -->
@endsection
@push('js')
    <script src="{{ asset('temp/js/components/datepicker.js') }}"></script>
    <script>
        $(() => {
            let ceoni = [
                {value: 1, label: 'DO 1 T'},
                {value: 1.5, label: 'DO 1,5 T'},
                {value: 2, label: 'DO 2 T'},
                {value: 2.5, label: 'DO 2,5 T'},
                {value: 3, label: 'DO 3 T'},
                {value: 3.5, label: 'DO 3,5 T'},
                {value: 5, label: 'DO 5 T'},
                {value: 6, label: 'VIŠE OD 5 T'}
            ];
            let sakranom = [
                {value: 1, label: 'DO 1 T'},
                {value: 1.2, label: 'DO 1,2 T'},
                {value: 1.4, label: 'DO 1,4 T'},
                {value: 1.45, label: 'DO 1,45 T'},
                {value: 1.6, label: 'DO 1,6 T'}
            ];
            let bezkrana = [
                {value: 1.6, label: 'DO 1,6 T'},
                {value: 1.8, label: 'DO 1,8 T'},
                {value: 2.0, label: 'DO 2,0 T'}
            ];
            let regalni = [
                {value: 1.4, label: 'DO 1,4 T'},
                {value: 1.6, label: 'DO 1,6 T'}
            ];

            let date_options = {
                autoclose:      true,
                startDate:      "today",
                todayHighlight: true
            };

            $('#rent-date-start').datepicker(date_options);
            $('#rent-date-end').datepicker(date_options);

            $('#location').on('change', (e) => {
                if (e.currentTarget.value == 'hc' || e.currentTarget.value == 0) {
                    $('#location-address-div').addClass('hidden');
                } else {
                    $('#location-address-div').removeClass('hidden');
                }
            });

            $('input[name="type"]').change((e) => {
                let type = e.currentTarget.value;
                let str = '<option value="0">--- Odaberite jednu od opcija ---</option>';

                if (type == 'ce' || type == 'cp' || type == 'cd') {
                    for (let item of ceoni) {
                        str += "<option value='" + item.value + "'>" + item.label + "</option>"
                    }
                    heightResolve();
                }

                if (type == 'rv') {
                    for (let item of sakranom) {
                        str += "<option value='" + item.value + "'>" + item.label + "</option>"
                    }
                    heightResolve();
                }

                if (type == 'rn') {
                    for (let item of bezkrana) {
                        str += "<option value='" + item.value + "'>" + item.label + "</option>"
                    }
                    heightResolve('remove');
                }

                if (type == 'rg') {
                    for (let item of regalni) {
                        str += "<option value='" + item.value + "'>" + item.label + "</option>"
                    }
                    heightResolve();
                }

                $('#weight-fork').empty();
                $('#weight-fork').append(str);
            });
        })

        function heightResolve(type = 'show') {
            $('#height-label').empty();
            if (type == 'remove') {
                $('#height-fork').addClass('hidden');
                $('#height-label').append('Odabrali ste viličar bez krana');
            } else {
                $('#height-fork').removeClass('hidden');
                $('#height-label').append('Visina dozanja');
            }
        }
    </script>
@endpush
