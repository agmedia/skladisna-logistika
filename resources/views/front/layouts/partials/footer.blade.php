<footer id="footer" >
    @if ( ! \Illuminate\Support\Facades\Request::is('access/vip/*'))
        <div class="container">
            <!-- Footer Widgets
            ============================================= -->
            <div class="footer-widgets-wrap clearfix">
                <div class="col_full nobottommargin">
                    <div class="widget clearfix">
                        <div class="row ">
                            <div class="col-md-12 col-xs-12 divcenter bottommargin-lg">
                                <div class="heading-block center bottommargin-sm"><h2>Newsletter</h2>
                                    <span class="notopmargin">Prijavi se i budi u tijeku sa najboljim akcijama i najnovijom ponudom.</span>
                                </div>
                                <div class="input-group divcenter" style="max-width:500px;">
                                    <input type="email" id="newsletter-input" name="subscribe_email" class="form-control required email" placeholder="Upišite vaš email...">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="submit" id="validate_newsletter">Prijavi se</button>
                                    </div>
                                </div>
                                <p class="text-center nobottommargin" style="margin-top:10px"><input type="checkbox" class="chk2" id="newsletter-cb"> Dajem <a href="https://www.skladisna-logistika.hr/info/izjava-o-davanju-suglasnosti-za-obradu-osobnih-podataka" target="_blank">privolu</a> za primanje Newsletter-a.</p>
                            </div>
                            <div class="col-md-3 col-xs-12 widget_links">
                                <h3>Odjel prodaje</h3>
                                <address><strong>Goran Kerečin - voditelj prodaje</strong><br>Tel.: <a href="tel:0038513374143">+385 1 3374 143</a><br>Mob.:&nbsp; <a href="tel:00385992286606">+385 99 2286 606</a><br>E-mail: <a href="mailto:goran.kerecin@skladisna-logistika.hr">goran.kerecin@skladisna-logistika.hr</a></address>
                            </div>
                            <div class="col-md-3 col-xs-12 widget_links">
                                <h3>Prijava kvarova - Servis</h3>
                                <address><strong>Goran Ivančan</strong> - direktor postprodaje<br>Tel.: <a href="tel:+385 1 6150 409">+385 1 6150 409</a><br>Mob.: <a href="tel:+385992409962">+385 99 240 99 62</a><br> E-mail: <a href="mailto:goran.ivancan@skladisna-logistika.hr">goran.ivancan@skladisna-logistika.hr</a></address>
                            </div>
                            <div class="col-md-3 col-xs-12 widget_links">
                                <h3>Voditelj odjela za najam i prodaju rabljenih viličara</h3>
                                <address><strong>Ivan Ratković</strong><br>Mob.: <a href="tel:00385992935474"> +385 (0) 99 2935 474</a><br> E-mail: <a href="mailto:ivan.ratkovic@skladisna-logistika.hr">ivan.ratkovic@skladisna-logistika.hr</a></address>
                            </div>
                            <div class="col-md-3 col-xs-12 widget_links">
                                <h3>Skladišna logistika d.o.o.</h3>
                                <address>Ventilatorska cesta 5a<br>10251 Hrvatski Leskovac - Zagreb<br>Tel.: <a href="tel:0038516536026">+385 1 6536 026</a> - Fax.: +385 1 6536027<br> E-mail: <a href="mailto:info@skladisna-logistika.hr">info@skladisna-logistika.hr</a></address>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .footer-widgets-wrap end -->
        </div>
@endif
<!-- Copyrights
    ============================================= -->
    <div id="copyrights">
        <div class="container clearfix">
            <div class="col_half">
                Copyrights © {{ date('Y') }}. Skladišna logistika d.o.o. Web by: <a target="_blank" href="https://www.agmedia.hr">AG media</a><br>
            </div>
            <div class="col_half col_last tright">
                <div class="fright clearfix">
                    <a href="https://www.facebook.com/SkladisnaLogistikaToyotaVilicari/" class="social-icon si-small si-borderless si-facebook">
                        <i class="icon-facebook"></i>
                        <i class="icon-facebook"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/skladi%C5%A1na-logistika-toyota-bt-vili%C4%8Dari/" class="social-icon si-small si-borderless si-linkedin">
                        <i class="icon-linkedin"></i>
                        <i class="icon-linkedin"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCpvmTZmvTCeQW7rKO-YFuHQ" class="social-icon si-small si-borderless si-youtube">
                        <i class="icon-youtube"></i>
                        <i class="icon-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div><!-- #copyrights end -->
</footer><!-- #footer end -->

@push('js')
    <script>
        $("#validate_newsletter").on("click", validate);

        function validate() {
            let result = $("#newsletter-input");
            let email = result.val();

            let cb = document.getElementById('newsletter-cb').checked

            if(validateEmail(email) && cb) {
                result.removeClass('bg-danger');
                axios.get('{{ route('newsletter.subscribe') }}?email=' + email)
                    .then((res) => {
                        return window.ToastSuccess.fire('Korisnik je upisan..!');
                    })
                    .catch((err) => {
                        console.log(err)
                        window.ToastWarning.fire('Nešto je pošlo krivo! Molimo pokušajte kasnije.');
                    })
            } else {
                result.addClass('bg-danger');
            }
            return false;
        }

        function validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    </script>
@endpush
