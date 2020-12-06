@extends('front.layouts.core')
@push('css')
    @stack('partial_css')
@endpush
@section ( 'title', 'Toyota viličari - Prodaja i najam')
@section('content')
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                @yield('partials_breadcrumbs')
            </ol>
        </div>
    </section>

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-md-9">
                        <img src="{{ isset($customer->details) && isset($customer->details->avatar) ? asset($customer->details->avatar) : asset('media/images/avatar.jpg') }}" class="alignleft img-circle img-thumbnail my-0" alt="Avatar" style="max-width: 84px;">
                        <div class="bottommargin">
                            <h2 style="margin: 5px 0;">{{ $customer->name }}</h2>
                            <span>Moj račun</span>
                        </div>
                        <div class="clear"></div>
                        @include('front.layouts.partials.alert')
                        @yield('partial')
                    </div>

                    <div class="w-100 line d-block d-md-none"></div>

                    <div class="col-md-3">
                        <div class="fancy-title notopmargin title-border">
                            <h4>Izbornik</h4>
                        </div>
                        <div class="list-group">
                            <a href="{{ route('moj.narudzbe') }}" class="list-group-item list-group-item-action d-flex justify-content-between"><div>Narudžbe</div><i class="icon-credit-cards"></i></a>
                            <a href="{{ route('moj.servis') }}" class="list-group-item list-group-item-action d-flex justify-content-between"><div>Servis</div><i class="icon-line2-wrench"></i></a>
                            <a href="{{ route('moj.poruke') }}" class="list-group-item list-group-item-action d-flex justify-content-between"><div>Poruke</div><i class="icon-comment1"></i></a>
                            <a href="{{ route('moj.postavke') }}" class="list-group-item list-group-item-action d-flex justify-content-between"><div>Postavke</div><i class="icon-settings"></i></a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="list-group-item list-group-item-action d-flex justify-content-between"><div>Odjava</div><i class="icon-line2-logout"></i></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        @yield('sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    @stack('partial_js')
@endpush
