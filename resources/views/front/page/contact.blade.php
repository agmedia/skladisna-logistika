@extends('front.layouts.core')
@push('css')
@endpush
@section ( 'title', 'Kontaktirajte nas')
@section('content')
    <section id="page-title" class="page-title-right page-title-mini">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kontakt</li>
            </ol>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">

                @include('front.layouts.partials.alert')

                <div class="col_full page">
                    <div class="heading-block  nobottomborder">
                        <h1>Kontaktirajte nas</h1>
                    </div>
                    <div class="card col_half">
                        <div class="card-body">
                            <h3>Odjel prodaje</h3>
                            <p><strong>Goran Kerečin - voditelj prodaje</strong>
                                <br>Tel.: <a href="tel:+38513374143">+385 1 3374 143</a>
                                <br>Mob.:&nbsp; <a href="tel:+385992286 606">+ 385 99 2286 606</a>
                                <br>e-mail: <a href="mailto:goran.kerecin@skladisna-logistika.hr">goran.kerecin@skladisna-logistika.hr</a></p>
                            <p><strong>Tomislav Benc - voditelj terenske prodaje</strong><br>Tel.: <a href="tel:+38516536028">+385 1 6536 028</a><br>Mob.:&nbsp; <a href="tel:+385954400400">+ 385 95 4400 400</a><br>e-mail: <a href="mailto:tomislav.benc@skladisna-logistika.hr">tomislav.benc@skladisna-logistika.hr</a></p>
                            <h3>Prijava kvarova</h3>
                            <p><strong>Goran Ivančan - direktor postprodaje</strong><br>Tel.: <a href="tel:+38516150409">+385 1 6150 409</a>
                                <br>Mob.: <a href="tel:+385992409962">+385 99 240 99 62</a><br>
                                e-mail: <a href="mailto:goran.ivancan@skladisna-logistika.hr">goran.ivancan@skladisna-logistika.hr</a></p>

                            <p><strong>Juro Katić – voditelj radione</strong><br>Tel.: <a href="tel:+38516150409">+385 1 6150 409</a>
                                <br>Mob.: <a href="tel:+385997370388">+385 99 7370 388</a><br>
                                e-mail: <a href="mailto:juro.katic@skladisna-logistika.hr">juro.katic@skladisna-logistika.hr</a></p>

                            <h3>Računovodstvo</h3>
                            <p><strong>Kristina Pucko</strong><br> Tel.: <a href="tel:+38516589151">+385 1 6589 151</a><br> e-mail: <a href="mailto:kristina.pucko@skladisna-logistika.hr">kristina.pucko@skladisna-logistika.hr</a></p>
                        </div>
                    </div>
                    <div class="col_half card col_last">
                        <div class="card-body">
                            <h3 >Skladišna logistika d.o.o.</h3>
                            <p>Ventilatorska cesta 5a<br> 10251 Hrvatski Leskovac, Zagreb, Hrvatska<br>Tel.: <a href="tel:+38516536026">+385 1 6536 026</a><br> Fax.: +385 1 6536 027<br> e-mail: <a href="mailto:info@skladisna-logistika.hr">info@skladisna-logistika.hr</a><br>OIB: 81060143905<br> Žiro račun: HR2824840081103360295 - RBA d.d. Zagreb </p>
                            <p>Temeljni kapital društva iznosi 920.000,00 kn i uplaćen je u cjelosti. Direktor i član uprave je Davor Pranić, zastupa društvo pojedinačno i samostalno.</p>
                            <h3 >Postprodaja i rezervni dijelovi</h3>
                              <p><strong>Goran Ivančan - direktor postprodaje</strong><br> Tel.: <a href="tel:+38513374144">+385 1 3374 144</a><br> Mob.: <a href="tel:+385992409962">+385 99 2409 962</a><br> e-mail: <a href="mailto:goran.ivancan@skladisna-logistika.hr">goran.ivancan@skladisna-logistika.hr</a></p>
                            <p><strong>Marijan Jandrić&nbsp;-&nbsp;voditelj rezervnih dijelova</strong><br> Mob.: <a href="tel:+ 385954841520">+ 385 95 4841 520</a><br> e-mail: <a href="mailto:marijan.jandric@skladisna-logistika.hr">marijan.jandric@skladisna-logistika.hr</a></p>

                        </div>
                    </div>
                </div>
                <div class="col_full bottommargin">
                    {{--<a id="ponuda" name="ponuda"></a>--}}
                    <div class="heading-block sm left ">
                        <h3 class="main-headline">Kontakt obrazac</h3>
                    </div>
                    <div class="form-widget">
                        <h3 class="nobottommargin">Pošaljite upit putem obrasca</h3>
                        <p>Na upite odgovaramo u roku od 24 sata. Svi upite tretiraju se povjerljivo u skladu s našim <a href="{{ route('info.page', ['page' => 'pravila-privatnosti-i-kolacici']) }}">Pravilima o privatnosti.</a></p>
                        <form class="nobottommargin" action="{{ route('kontakt.form') }}" method="POST">
                            @csrf
                            <div class="col_one_third">
                                <label for="name">Ime <small>*</small></label>
                                <input type="text" id="name" name="name" value="" class="sm-form-control required">
                                @error('name')
                                <span class="text-danger font-size-sm">Ime je obvezno!</span>
                                @enderror
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
                            <div class="col_half">
                                <label for="template-contactform-tvrtka">Naziv tvrtke </label>
                                <input type="text" id="tvrtka" name="tvrtka" value="" class=" sm-form-control">
                            </div>
                            <div class="col_half col_last">
                                <label for="template-contactform-oib">OIB </label>
                                <input type="text" id="oib" name="oib" value="" class=" sm-form-control">
                            </div>
                            <div class="clear"></div>
                            <div class="col_full">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="department" id="inlineRadio1" value="sale">
                                    <label class="form-check-label" for="inlineRadio1">Odjel prodaje</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="department" id="inlineRadio2" value="mailfunction">
                                    <label class="form-check-label" for="inlineRadio2">Prijava kvarova</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="department" id="inlineRadio3" value="spares">
                                    <label class="form-check-label" for="inlineRadio3">Postprodaja i rezervni dijelovi</label>
                                </div>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Odabir odjela kojeg želite kontaktirati.
                                </small>
                            </div>
                            <div class="clear"></div>
                            <div class="col_full">
                                <label for="message">Poruka <small>*</small></label>
                                <textarea class="required sm-form-control" name="message" rows="6" cols="30"></textarea>
                            </div>
                            <div class="col_full">
                                <input type="checkbox" name="consent" value="da"> Pročitao sam i slažem se s <a href="{{ route('info.page', ['page' => 'pravila-privatnosti-i-kolacici']) }}"> Politikom o zaštiti privatnosti i kolačićima</a>
                            </div>
                            <div class="col_full">
                                <button class="btn btn-red nomargin" type="submit">Pošalji poruku</button>
                            </div>

                            <input type="hidden" name="recaptcha" id="recaptcha">
                        </form>
                    </div>
                </div>
                <div class="col_full page">
                    <div class="heading-block sm left ">
                        <h3 class="main-headline">Lokacija</h3>
                    </div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2783.8347829356717!2d15.88472851611489!3d45.754458079105305!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d3849d8b26c7%3A0x76773c3ad8e974ad!2sVentilatorska%20cesta%205a%2C%2010251%2C%20Hrvatski%20Leskovac!5e0!3m2!1sen!2shr!4v1587040307640!5m2!1sen!2shr" width="1000" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    @include('front.layouts.partials.recaptcha-js')
@endpush
