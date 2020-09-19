@extends('front.layouts.core')

@push('css_before')
@endpush

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ route('kosarica') }}">Košarica</a></li>
        </ul>
        <div class="row">
            <div id="content" class="col-sm-12 ">
                <h1 id="page-title">Naplata</h1>
                <form action="{{ route('napravi.narudzbu') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <!-- Shipping address -->
                            <div class="col-md-6 col-xs-12">
                                <div class="panel panel-default ">
                                    <div class="panel-heading"> <i class="fa fa-user"></i> Adresa Naplate</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <h4>Korisničke informacije o naplati</h4>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix  ">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Ime:</label>
                                                <input type="text" name="fname" class="form-control" value="{{ isset($user->details) ? $user->details->fname : '' }}">
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Prezime:</label>
                                                <input type="text" name="lname" class="form-control" value="{{ isset($user->details) ? $user->details->lname : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix ">
                                            <div class="col-md-12">
                                                <label>Adresa:</label>
                                                <input type="text" name="address" class="form-control" value="{{ isset($user->details) ? $user->details->address : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Poštanski broj:</label>
                                                <input type="text" name="zip" class="form-control" value="{{ isset($user->details) ? $user->details->zip : '' }}">
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Grad:</label>
                                                <input type="text" name="city" class="form-control" value="{{ isset($user->details) ? $user->details->city : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix  ">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Broj telefona:</label>
                                                <input type="text" name="phone" class="form-control" value="{{ isset($user->details) ? $user->details->phone : '' }}">
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Email Adresa:</label>
                                                <input type="text" name="email" class="form-control" value="{{ isset($user->details) ? $user->email : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment address -->
                            <div class="col-md-6 col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-truck"></i> Adresa Isporuke</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <h4>Korisničke informacije za isporuku</h4>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix ">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Ime:</label>
                                                <input type="text" name="ship_fname" class="form-control" value="{{ isset($user->details) ? $user->details->fname : '' }}">
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Prezime:</label>
                                                <input type="text" name="ship_lname" class="form-control" value="{{ isset($user->details) ? $user->details->lname : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix ">
                                            <div class="col-md-12">
                                                <label>Adresa:</label>
                                                <input type="text" name="ship_address" class="form-control" value="{{ isset($user->details) ? $user->details->address : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix ">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Poštanski broj:</label>
                                                <input type="text" name="ship_zip" class="form-control" value="{{ isset($user->details) ? $user->details->zip : '' }}">
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Grad:</label>
                                                <input type="text" name="ship_city" class="form-control" value="{{ isset($user->details) ? $user->details->city : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix ">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Broj telefona:</label>
                                                <input type="text" name="ship_phone" class="form-control" value="{{ isset($user->details) ? $user->details->phone : '' }}">
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Email Adresa:</label>
                                                <input type="text" name="ship_email" class="form-control" value="{{ isset($user->details) ? $user->email : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Payment info -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-lock"></i> Način plaćanja</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-md-12"><label>Način plaćanja:</label></div>
                                            <div class="col-md-12">
                                                <select id="CreditCardType" name="payment" class="form-control">
                                                    @foreach ($payments as $payment)
                                                        <option value="{{ $payment->code }}">{{ $payment->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{--<div class="form-group clearfix ">
                                            <div class="col-md-12">
                                                <label>Ovdje još neki info nakon odabira plaćanja...</label>
                                            </div>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <!-- Shipping info -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-lock"></i> Način dostave</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-md-12"><label>Način dostave:</label></div>
                                            <div class="col-md-12">
                                                <select id="CreditCardType" name="shipping" class="form-control">
                                                    <option value="shipping">Dostava</option>
                                                    {{--<option value="pickup">Osobno preuzimanje</option>--}}
                                                </select>
                                            </div>
                                        </div>
                                        {{--<div class="form-group clearfix ">
                                            <div class="col-md-12">
                                                <label>Ovdje još neki info o načinu dostave...</label>
                                            </div>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <!-- REVIEW ORDER -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-shopping-cart"></i> Pregled Narudžbe <div class="pull-right">{{--<small><a class="afix-1" href="#">Edit Cart</a></small>--}}</div>
                                    </div>
                                    <div class="panel-body">
                                        <cart-view continueurl="{{ route('index') }}" checkouturl="{{ route('naplata') }}" :buttons="false"></cart-view>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="text-uppercase  btn btn-primary" style="display: block; width: 100%;">Napravi narudžbu</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js_before')
@endpush
