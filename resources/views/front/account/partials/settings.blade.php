@extends('front.account.index')

@push('partial_css')
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">
    <style>
        .slim {
            border-radius: 50%;
        }
    </style>
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('moj') }}">Moj račun</a></li>
    <li class="breadcrumb-item">Postavke</li>
@endsection

@section('partial')
    <div class="row clearfix">
        <div class="col-lg-12">

            <div class="fancy-title notopmargin title-border">
                <h4>Postavke</h4>
            </div>

            <div class="form-widget">
                <form class="nobottommargin" action="{{ route('moj.postavke.promijeni') }}" method="post">
                    @csrf
                    <h4>Generalne informacije računa</h4>

                    <div class="col_half">
                        <label for="name">Korisničko ime <strong class="text-danger">*</strong></label>
                        <input type="text" id="name" name="name" value="{{ $customer->name }}" class="sm-form-control">
                    </div>
                    <div class="col_half col_last">
                        <label for="email">Email <strong class="text-danger">*</strong></label>
                        <input type="text" id="email" name="email" value="{{ $customer->email }}" class="sm-form-control">
                    </div>

                    <div class="clear"></div>
                    <hr class="bottommargin">
                    <h4>Profilni podaci korisnika</h4>

                    <div class="col_half">
                        <label for="fname">Ime</label>
                        <input type="text" id="fname" name="fname" value="{{ $customer->details->fname }}" class="sm-form-control">
                    </div>
                    <div class="col_half col_last">
                        <label for="lname">Prezime</label>
                        <input type="text" id="lname" name="lname" value="{{ $customer->details->lname }}" class="sm-form-control">
                    </div>

                    <div class="clear"></div>

                    <div class="col_half">
                        <label for="company">Poduzeće</label>
                        <input type="text" id="company" name="company" value="{{ $customer->details->company }}" class="sm-form-control">
                    </div>
                    <div class="col_half col_last">
                        <label for="oib">OIB</label>
                        <input type="text" id="oib" name="oib" value="{{ $customer->details->oib }}" class="sm-form-control">
                    </div>

                    <div class="clear"></div>

                    <div class="col_full">
                        <label for="address">Adresa</label>
                        <input type="text" id="address" name="address" value="{{ $customer->details->address }}" class="sm-form-control">
                    </div>

                    <div class="clear"></div>

                    <div class="col_one_third">
                        <label for="zip">Poštanski broj</label>
                        <input type="text" id="zip" name="zip" value="{{ $customer->details->zip }}" class="sm-form-control">
                    </div>
                    <div class="col_one_third">
                        <label for="city">Grad</label>
                        <input type="text" id="city" name="city" value="{{ $customer->details->city }}" class="sm-form-control">
                    </div>
                    <div class="col_one_third col_last">
                        <label for="phone">Telefon</label>
                        <input type="text" id="phone" name="phone" value="{{ $customer->details->phone }}" class="sm-form-control">
                    </div>

                    <div class="clear"></div>
                    <hr class="bottommargin">
                    <h4>Promijeni korisničku fotografiju</h4>

                    <div class="row text-center">
                        <div class="col_one_fourth">
                            <div class="slim leftmargin-sm"
                                 data-ratio="1:1"
                                 data-size="360,360"
                                 data-max-file-size="2">
                                <img src="{{ isset($customer->details) && isset($customer->details->avatar) ? asset($customer->details->avatar) : asset('media/images/avatar.jpg') }}" alt=""/>
                                <input type="file" name="user_image"/>
                            </div>
                        </div>
                        <div class="col_three_fourth col_last"></div>
                    </div>

                    <div class="clear"></div>

                    <div class="col_full">
                        <label for="bio">Kratka biografija</label>
                        <textarea class="sm-form-control" id="bio" name="bio" rows="6" cols="30" placeholder="Čime se bavite..."></textarea>
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">
                    <div class="col_full">
                        <button class="btn btn-red nomargin" type="submit">Snimi promjene</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection

@section('sidebar')
@endsection

@push('partial_js')
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>
    @include('front.layouts.partials.recaptcha-js')
@endpush
