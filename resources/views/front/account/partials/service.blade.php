@extends('front.account.index')

@push('partial_css')
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('moj') }}">Moj račun</a></li>
    <li class="breadcrumb-item">Servis</li>
@endsection

@section('partial')
    <div class="row clearfix">
        <div class="col-lg-12">

            <div class="fancy-title notopmargin title-border">
                <h4>Servis</h4>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <p>Molimo vas da u formularu navedete što više detalja o stroju i kvaru.</p>
                </div>
                <div class="col-md-12">
                    <a href="{{ route('moj.poruka.nova', ['subject' => 'Prijava servisa - HITNO']) }}" class="button button-border button-border-thin">Prijavite servis</a>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('partial_js')
@endpush
