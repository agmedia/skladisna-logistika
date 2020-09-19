@extends('front.layouts.core')

@push('css')
@endpush

@section ( 'title', 'TAL (Toyota advanced Logistics)')

@section('content')



    <section id="slider" class="slider-element slider-parallax" style="background: url({{ asset('images/banners/banner_i_site-01.jpg') }}) center center; background-size: cover;"  data-height-xl="500" data-height-lg="350" data-height-md="300" data-height-sm="220" data-height-xs="180">
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

                <div class="container clearfix bottommargin-sm">
                    <div class="heading-block center nomargin">
                        <h3>Osigurajte kontrolu i uštede pametnim povezivanjem svojih viličara</h3>
                    </div>
                </div>

                <div class="col_full">

                    <p class="leading text-center">Da biste ostali konkurentni i odgovorili izazovima današnjih skladišnih procesa trebate biti fleksibilni i učinkoviti prema promjenama Vaših poslovnih operacija. Toyota I_Site program za upravljanje flotom koristi online podatke Vaših viličara ažurirane u stvarnom vremenu kako bi mjerili, analizirali i poboljšali izvedbu svakog povezanog viličara. Povezivanjem Vaše flote moći ćete povećati svoju dugoročnu profitabilnost.</p>

                </div>

                <div class="col_full text-center">



                <ul class="nav nav-pills one-page-menu navga" style="display:inline-flex" data-easing="easeInOutExpo" data-speed="1500">
                    <li class="nav-item"><a class="nav-link" href="#" data-href="#paketi" data-offset="50">I_Site paketi </a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-href="#prednosti" data-offset="50">I_Site prednosti</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-href="#zabava" data-offset="50">Zabavna strana</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-href="#faq" data-offset="50">Pitanja i odgovori</a></li>
                </ul>
                </div>

            </div>

            <div class="section nomargin noborder " id="paketi" style="padding: 60px 0 0px 0;background-color:#f2f2f2">
            <div class="container clearfix bottommargin">

                <div class="container clearfix bottommargin">
                    <div class="heading-block center nomargin">
                        <h2>Pronađite I_Site paket prilagođen Vama</h2>
                    </div>
                </div>
                <div class="col_one_fourth">
                    <h3 class="m10">Pronađite I_Site paket</h3>
                    <p>Od osnovnih informacija o floti do potpune izvedbe uz stručnu pomoć, naša tri paketa su vam tu da vam pomognu potpuno optimizirati Vašu povezanost flote viličara.</p>


                </div>
                <div class="col_one_fourth">
                    <h3>I_Site Starter</h3>
                    <p>Dolazi besplatno uz pametne Toyota viličare te pruža analitičke podatke rada flote Vaših viličara u svakom trenutku.</p>
                    <p>Paket sadrži:</p>
                    <ul class="list">
                        <li>Pregled flote</li>
                        <li>Osnovne podatke viličara</li>
                        <li>Sustav za prijavu servisa s Android uređaja</li>
                    </ul>

                    <a href="tal/i-site-starter" class="btn btn-red">Opširnije</a>

                </div>
                <div class="col_one_fourth">
                    <h3>I_Site Explorer</h3>
                    <p>Savršena opcija za voditelje logistike koji žele poboljšati sigurnost, učinak i efikasnost prateći rad viličara i vozača.</p>
                    <p>Neke od pogodnosti paketa:</p>
                    <ul class="list">


                        <li> I_Site Starter (i sve njegove pogodnosti)</li>
                        <li> jednostavno WEB sučelje za pregled rada viličara i vozača</li>
                        <li> sustav zaštite od neautoriziranog korištenja</li>
                        <li> mogućnost detaljnog pregleda nastalih udaraca viličarem</li>
                        <li> mogućnost praćenja lokacije viličara</li>
                        <li> jednostavan pristup viličaru preko ID kartice</li>

                    </ul>

                    <a href="tal/i-site-explorer" class="btn btn-red">Opširnije</a>

                </div>
                <div class="col_one_fourth col_last">
                    <h3>I_Site Premium</h3>
                    <p>Najnapredniji sustav praćenja koji uključuje savjetovanje Toyota menadžmenta.</p>
                    <p>Paket sadrži:</p>
                    <ul class="list">
                        <li> I_Site Explorer (i sve njegove pogodnosti)</li>
                        <li> praćenje i savjetovanje od strane Toyota menadžmenta </li>

                    </ul>



                </div>

            </div>
            </div>

            <div class="section nomargin noborder " id="prednosti" style="padding: 60px 0 0px 0;background-color:#fff">
            <div class="container clearfix">

                <div class="container clearfix bottommargin">
                    <div class="heading-block center nomargin">
                        <h2>I_Site prednosti</h2>
                    </div>
                </div>


                <div class="col_half">

                    <p>Toyota je bila prva kompanija u industriji koja je uvela hardversku tehnologiju kao standardnu dodatnu opremu na električnim viličarima još 2018. godine. Danas ima preko 130,000 pametnih viličara.<br>I_Site može koristiti svaki ponosni vlasnik pametnog viličara. Također dobivate pristup svim informacijama kako bi osigurali potpunu kontrolu nad svojim viličarom kao i mogućnost da reagirate samo jednim klikom ako je potrebna servisna usluga ili neki podatak o radu viličara kao i vozača. I-Site možete koristiti bez obzira jeste li vlasnik samo jednog viličara ili imate veliku flotu viličara raspoređenu na više lokacija.</p>
                    <a href="tal/i-site-prednosti" class="button button-border button-rounded button-red">Opširnije</a>

                </div>

                <div class="col_half col_last ">

                    <iframe width="560" height="315" src="https://www.youtube.com/embed/Tf_YiW7c3v0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="clearfix bottommargin"></div>


                <div class="col_one_fourth ">
                    <span class="pret">Sigurnost</span>
                    <h3>Stvorite sigurnije radno okruženje</h3>

                    <p>Držite na oku Vaše vozače i viličare uz pomoć I_Site sustava za pregled flote. Kontroliranjem nastalih udaraca, ograničenjem pristupa vozilu i kontrolom viličara prije same upotrebe osigurajte sigurnije radno okruženje.</p>
                   <p> Ciljevi:</p>
                    <ul class="list">
                        <li> Kontrola brzine viličara</li>
                        <li> Nadgledanje nastalih udaraca</li>
                        <li> Predoperativna provjera viličara</li>
                    </ul>
                   <p> <a class="red" href="tal/sigurnost">OPŠIRNIJE > </a></p>
                </div>

                <div class="col_one_fourth ">
                    <span class="pret">Produktivnost</span>
                    <h3>Dosegnite viši nivo produktivnosti</h3>

                    <p>Od maksimalnog iskorištavanja viličara do Google pozicioniranja Vašeg viličara, I_Site koristi povezivanje čija je svrha poboljšati cjelokupnu produktivnost svih procesa koji se odvijaju u skladištu.</p>
                    <p> Ciljevi:</p>
                    <ul class="list">
                        <li> Optimizirati korištenje viličara</li>
                        <li> Uvid u status o licenci vozača</li>
                        <li>  Pametan proces mjerenja i uspoređivanja svih radnih procesa viličara</li>
                        <li>  Produženi životni ciklus viličara</li>

                    </ul>
                    <p> <a class="red" href="tal/produktivnost">OPŠIRNIJE > </a></p>
                </div>

                <div class="col_one_fourth ">
                    <span class="pret">Kontrola troškova</span>
                    <h3>Kontrolirajte svoje troškove i produžite vijek trajanja svoje flote</h3>

                    <p>Mjerite i reagirajte na način korištenja viličara  kako bi izbjegli neželjena financijska iznenađenja. – I_Site pomaže u potpunoj kontroli troškova i time osigurava bolju dugoročnu profitabilnost.</p>
                    <p> Ciljevi:</p>
                    <ul class="list">
                        <li> Smanjiti troškove i težiti pametnim ulaganjima </li>
                        <li>    Prevencija štete i troškova osiguranja
                        </li>

                    </ul>
                    <p> <a class="red" href="tal/kontrola-troskova">OPŠIRNIJE > </a></p>
                </div>

                <div class="col_one_fourth col_last">
                    <span class="pret"> Okoliš</span>
                    <h3>Krenite putem ekološko prihvatljivog poslovanja</h3>

                    <p>I_Site će Vam pomoći da koristite svoje viličare na najisplativiji  održivi način. Kao rezultat dobivate duži životni vijek svojih vozila te smanjene emisije CO2.</p>
                    <p> Ciljevi:</p>
                    <ul class="list">
                        <li> Duže trajanje baterija u viličarima </li>
                        <li>   Produženi životni vijek viličara
                        </li>

                    </ul>
                    <p> <a class="red" href="tal/okolis">OPŠIRNIJE > </a></p>
                </div>

                <div class="clearfix bottommargin"></div>








            </div>

            </div>

            <div class="section nomargin noborder " id="zabava" style="padding: 60px 0 30px 0;background-color:#f2f2f2">

            <div class="container ">
                <div class="container clearfix bottommargin">
                    <div class="heading-block center ">
                        <h2>Zabavna strana </h2>
                    </div>
                </div>


                <div class="col_half">

                    <p>Izazovite svoje vozače na uzbudljivo natjecanje koje ima svrhu napraviti radno okruženje skladišta sigurnijim, a istovremeno i zabavnijim. I_Site timski izazovi poboljšavaju ponašanje vozača i povećava sveukupnu sigurnost, dok u isto vrijeme potiče bolje radne odnose i budi timski duh.</p>
                    <ul class="list">
                        <li>	Zabavan sadržaj i za vrijeme radnoga vremena</li>
                        <li>	1 do 9 tjedana konstantnog natjecanja</li>
                        <li>	Ostvarenje postignuća na osobnoj kao i na timskoj razini</li>
                        <li>	Tjedni sažetci i korisni rezultati sigurnosti </li>
                    </ul>
                    <a href="tal/zabavna-strana-l-site-a" class="button button-border button-rounded button-red">Opširnije</a>

                </div>

                <div class="col_half col_last ">

                    <img src="{{ asset('images/zabavna-strana.jpg') }}" alt="Zabavna strana I_Site-a"/>
                </div>
             </div>
            </div>

            <div class="section nomargin noborder " id="faq" style="padding: 60px 0 0px 0;background-color:#fff">
                <div class="container clearfix">

                    <div class="container clearfix bottommargin">
                        <div class="heading-block center nomargin">
                            <h2>Pitanja i odgovori</h2>
                        </div>
                    </div>


                    <div class="col_half">

                        <div class="accordion accordion-bg clearfix">
             <div class="acctitle acctitlec"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i> Što je zapravo Toyotin pametni viličar?</div>
                            <div class="acc_content clearfix" style="display: block;"><p>Pametni viličari su viličari opremljeni s hardverskim uređajem, koji komunicira online u stvarnom vremenu sa I_Site sustavom, Toyotinim sustavom  kontroliranja flote te tako korisniku daje važne informacije o tome kako njihovi viličari izvode svoje zadatke.</p></div>

                            <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i> Što je I-Site sustav kontroliranja flote?</div>
                            <div class="acc_content clearfix" style="display: none;"><p>Sustav kontroliranja flote u logističkom pogledu je operacija koja omogućuje tvrtkama koje se bave skladištenjem i protokom robe da minimiziraju ili čak potpuno otklone rizike povezane s ulaganjima u viličare. Uz to glavni cilj je poboljšanje efikasnosti, produktivnosti i smanjenje sveukupnih operativnih i troškova osoblja.</p> </div>

                            <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i> Što je sve uključeno u Toyotin I_Site sustav za kontroliranje flote?</div>
                            <div class="acc_content clearfix" style="display: none;"><p>Uključen je I_Site hardver koji se sastoji od telekomunikacijske jedinice i dodatno ugrađenih senzora udaraca na viličarima. Time je Vaša flota povezana i sinkronizirana s Vašim odjelom za poslovnu podršku pomoću poslovnog softvera ERP, kao i s Toyotinim odjelom za podršku kako bi se osiguralo da sve teće glatko.</p></div>
                            <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i> Može li se I_Site ugraditi i u moje viličare?</div>
                            <div class="acc_content clearfix" style="display: none;"><p>Naravno da može. Skladišni viličari naručeni nakon 2018. godine kao standard u sebi imaju I_Site hardver i time omogućuju pristup I_Site Starter paketu potpuno besplatno. Drugi viličari, bili oni skladišni ili čeoni viličari, mogu u sebe bez problema ugraditi I_Site upravljačku jedinicu pomoću koje odmah možete početi koristiti prednosti naših I_Site Starter, I_Site Explorer, I_Site Premium paketa.</p></div>

                            <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i> Koji I_Site paket najbolje odgovara potrebama mojeg poslovanja?</div>
                            <div class="acc_content clearfix" style="display: none;"><p>I_Site je prilagodljiv bilo kakvoj vrsti poslovanja, u rasponu od malih pa do velikih flota viličara. Povezanost viličara Vam pomaže poboljšati efektivnosti i i omogućava prilagodbu na mnoge promjenjive okolnosti.</p>
                                <p>Potpuno besplatno možete dobiti naš I_Site Starter paket uz kupnju naših Toyota viličara koji Vam nudi ključne uvide u trenutno stanje i korisne informacije o poboljšanju.</p>

                                <p>Ako Vam je potrebna veća količina podataka o svojem viličaru, uvijek se možete nadograditi na pogodnosti I_Site Explorer paketa koji Vam pored opsega I_Site Startera nudi i širok skup značajki za mjerenje i poboljšanje sigurnosti i performansi Vaše flote.</p>
                                <p> Ili ako se odlučite za naš I_Site Premium paket koji omogućava sve pogodnosti I_Site Explorera te praćenje i personalizirano savjetovanje od strane Toyota menadžmenta koji će Vas najbržim i najjednostavnijim putem uz predočenje praćenih podataka uputiti u potrebne radnje kako bi ostvarili znatne uštede i poboljšali radne procese.
                                </p></div>

                        </div>



                    </div>

                    <div class="col_half col_last">
                        <img src="{{ asset('images/faq1.jpg') }}" alt="Pitanja i odgovori"/>

                    </div>


                    <div class="clearfix bottommargin"></div>












                </div>

            </div>




        </div>










    </section><!-- #content end -->


@endsection

@push('js')
@endpush
