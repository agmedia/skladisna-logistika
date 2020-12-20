@extends('front.layouts.core')
@section ( 'title', 'Naplata')
@push('css_before')
    <style>
        .bcont {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 0 10px 10px 10px;
            background-color: #f7f7f7;
        }
    </style>
@endpush
@section('content')
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kosarica') }}">Košarica</a></li>
                <li class="breadcrumb-item active" aria-current="page">Naplata</li>
            </ol>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row col-mb-50 gutter-50">
                    @include('front.layouts.partials.alert')
                    <form id="billing-form" name="billing-form" class="row mb-0" action="{{ route('napravi.narudzbu') }}" method="post">
                        @csrf
                        <div class="col-lg-6">
                            <div class="bcont">
                                <div class="col-md-12">
                                    <h3>Korisničke informacije o naplati</h3>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="billing-form-name">Ime: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="fname" name="fname" value="{{ isset($user->details) ? $user->details->fname : '' }}" class="sm-form-control" />
                                    @error('fname')
                                    <div class="text-danger">Ime je obvezno...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="billing-form-lname">Prezime: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="lname" name="lname" value="{{ isset($user->details) ? $user->details->lname : '' }}" class="sm-form-control" />
                                    @error('lname')
                                    <div class="text-danger">Prezime je obvezno...</div>
                                    @enderror
                                </div>
                                <div class="col-12 form-group">
                                    <label for="billing-form-address">Adresa: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="address" name="address" value="{{ isset($user->details) ? $user->details->address : '' }}" class="sm-form-control" />
                                    @error('address')
                                    <div class="text-danger">Adresa je obvezno...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="billing-form-zip">Poštanski broj: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="zip" name="zip" value="{{ isset($user->details) ? $user->details->zip : '' }}" class="sm-form-control" />
                                    @error('zip')
                                    <div class="text-danger">Poštanski broj je obvezan...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="billing-form-city">Grad: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="city" name="city" value="{{ isset($user->details) ? $user->details->city : '' }}" class="sm-form-control" />
                                    @error('city')
                                    <div class="text-danger">Grad je obvezan...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="billing-form-email">Email Adresa: @include('back.layouts.partials.required-star')</label>
                                    <input type="email" id="email" name="email" value="{{ isset($user->details) ? $user->email : '' }}" class="sm-form-control" />
                                    @error('email')
                                    <div class="text-danger">Email je obvezan...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="billing-form-phone">Telefon: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="phone" name="phone" value="{{ isset($user->details) ? $user->details->phone : '' }}" class="sm-form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="bcont">
                                <div class="col-md-12">
                                    <h3 class="nobottommargin">Korisničke informacije za isporuku</h3>
                                    <label class="pull-right fr"><input type="checkbox" id="same-as-pay-cb" value=""> Ista kao adresa naplate</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="shipping-form-name">Ime: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="ship-fname" name="ship_fname" value="{{ isset($user->details) ? $user->details->fname : '' }}" class="sm-form-control" />
                                    @error('ship_fname')
                                    <div class="text-danger">Ime je obvezno...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="shipping-form-lname">Prezime: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="ship-lname" name="ship_lname" value="{{ isset($user->details) ? $user->details->lname : '' }}" class="sm-form-control" />
                                    @error('ship_lname')
                                    <div class="text-danger">Prezime je obvezno...</div>
                                    @enderror
                                </div>
                                <div class="w-100"></div>
                                <div class="col-12 form-group">
                                    <label for="shipping-form-address">Adresa: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="ship-address" name="ship_address" value="{{ isset($user->details) ? $user->details->address : '' }}" class="sm-form-control" />
                                    @error('ship_address')
                                    <div class="text-danger">Adresa je obvezno...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="shipping-form-zip">Poštanski broj: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="ship-zip" name="ship_zip" value="{{ isset($user->details) ? $user->details->zip : '' }}" class="sm-form-control" />
                                    @error('ship_zip')
                                    <div class="text-danger">Poštanski broj je obvezan...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="shipping-form-city">Grad: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="ship-city" name="ship_city" value="{{ isset($user->details) ? $user->details->city : '' }}" class="sm-form-control" />
                                    @error('ship_city')
                                    <div class="text-danger">Grad je obvezan...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="shipping-form-email">Email Adresa: @include('back.layouts.partials.required-star')</label>
                                    <input type="email" id="ship-email" name="ship_email" value="{{ isset($user->details) ? $user->email : '' }}" class="sm-form-control" />
                                    @error('ship_email')
                                    <div class="text-danger">Email je obvezan...</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="shipping-form-phone">Telefon: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" id="ship-phone" name="ship_phone" value="{{ isset($user->details) ? $user->details->phone : '' }}" class="sm-form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="bcont " style="margin-top:20px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="leftmargin-xs">Podaci o tvrtci</h3>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-md-6 form-group">
                                        <div class="col-md-12">
                                            <label for="billing-form-companyname">Naziv tvrtke:</label>
                                            <input type="text" id="billing-form-companyname" name="company" value="{{ isset($user->details) ? $user->details->company : '' }}" class="sm-form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <div class="col-md-12">
                                            <label for="oib">OIB:</label>
                                            <input type="text" id="billing-form-oib" name="oib" value="{{ isset($user->details) ? $user->details->oib : '' }}" class="sm-form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="bcont " style="margin-top:20px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="leftmargin-xs">Plaćanje i isporuka</h3>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="col-md-12"><label>Način plaćanja:</label></div>
                                            <div class="col-md-12">
                                                <select id="payment-type" name="payment" class="form-control">
                                                    @foreach ($payments as $code => $payment)
                                                        <option value="{{ $code }}">{{ $payment }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="col-md-12"><label>Način dostave:</label></div>
                                            <div class="col-md-12">
                                                <select id="shipping-type" name="shipping" class="form-control">
                                                    @foreach ($shipments as $code => $shipment)
                                                        <option value="{{ $code }}">{{ $shipment }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 topmargin-sm">
                                        <div class="col-lg-12">
                                            <div class="style-msg infomsg ">
                                                <div class="sb-msg "><i class="icon-info-sign"></i>Plaćanje možete izvršiti direktnom uplatom na žiro račun: <strong>HR2824840081103360295</strong> - RBA d.d. Zagreb </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <h3 class="nobottommargin topmargin-sm">Pregled narudžbe</h3>
                            </div>
                            <cart-view continueurl="{{ route('index') }}" checkouturl="{{ route('naplata') }}" :buttons="false"></cart-view>
                            <div class="col-md-6 fright">
                                <button type="submit" class="btn btn-green float-right" style=" width: 100%;">Napravi narudžbu</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(() => {

            $('#payment-type').on('change', e => {
                console.log(e.currentTarget.value)
            });


            const checkbox = document.getElementById('same-as-pay-cb')
            checkbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    $('#ship-fname').val($('#fname').val());
                    $('#ship-lname').val($('#lname').val());
                    $('#ship-address').val($('#address').val());
                    $('#ship-zip').val($('#zip').val());
                    $('#ship-city').val($('#city').val());
                    $('#ship-phone').val($('#phone').val());
                    $('#ship-email').val($('#email').val());
                } else {
                    $('#ship-fname').val('');
                    $('#ship-lname').val('');
                    $('#ship-address').val('');
                    $('#ship-zip').val('');
                    $('#ship-city').val('');
                    $('#ship-phone').val('');
                    $('#ship-email').val('');
                }
            })
        })
    </script>
@endpush
