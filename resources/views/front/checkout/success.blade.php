@extends('front.layouts.core')
@section ( 'title', 'Narudžba uspješno dovršena')
@push('css_before')
@endpush
@section('content')
    <section id="page-title" class="page-title-mini page-title-right">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item active" aria-current="page">Narudžba  uspješno dovršena</li>
            </ol>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="col_full page">
                    <div class="heading-block  nobottomborder">
                        <h1>Vaša narudžba je dovršena</h1>
                    </div>
                    <div class="style-msg successmsg">
                        <div class="sb-msg">
                            <p><i class="icon-thumbs-up"></i><strong>Vaša narudžba je uspješno zaprimljena i obrađena!</strong></p>
                            <p>Putem mail su vam poslane instrukcije za plaćanje i dostavu.</p>
                            <p>Molimo Vas da ukoliko imate nekih pitanja ista uputite <a href="https://www.skladisna-logistika.hr/kontakt">vlasniku web trgovine</a>.</p>
                            <p>Zahvaljujemo se što ste kupovali online kod nas!</p>
                            <p>Skladišna logistika d.o.o.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('js_before')
@endpush
