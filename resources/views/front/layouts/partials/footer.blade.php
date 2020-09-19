<footer id="footer" >
    @if ( ! \Illuminate\Support\Facades\Request::is('access/vip/*'))
        <div class="container">
            <!-- Footer Widgets
            ============================================= -->
            <div class="footer-widgets-wrap clearfix">
                <div class="col_full nobottommargin">
                    <div class="widget clearfix">
                        <div class="row ">
                            <div class="col-md-4 col-xs-12  widget_links">
                                <h3>Odjel prodaje</h3>
                                <address><strong>Goran Kerečin - direktor postprodaje</strong><br>Tel.: <a href="tel:0038513374143">+385 1 3374 143</a><br>Mob.:&nbsp; <a href="tel:00385992286606">+385 99 2286 606</a><br>E-mail: <a href="mailto:goran.kerecin@skladisna-logistika.hr">goran.kerecin@skladisna-logistika.hr</a></address>
                            </div>
                            <div class="col-md-4 col-xs-12 widget_links">
                                <h3>Prijava kvarova - Servis</h3>
                                <address><strong>Goran Baković</strong> - voditelj terenskog servisa<br>Tel.: <a href="tel:0038516150409">+385 1 6150 409</a><br>Mob.: <a href="tel:00385994904641">+385 99 4904 641</a><br> E-mail: <a href="mailto:goran.bakovic@skladisna-logistika.hr">goran.bakovic@skladisna-logistika.hr</a></address>
                            </div>
                            <div class="col-md-4 col-xs-12  widget_links">
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
