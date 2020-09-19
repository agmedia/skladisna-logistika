@extends('front.layouts.core')

@push('css_before')
@endpush

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li>Narudžba je uspješno dovršena</li>
        </ul>
        <div class="row">
            <div id="content" >
                <h1 id="page-title">Vaša narudžba je dovršena</h1>

                <div class="col-md-12">

        <!--success -->
        <div class="alert alert-success"> <p> <i class="fa fa-check-circle"></i>Vaša narudžba je uspješno zaprimljena i obrađena!</p><p>Možete pogledati pregled Vaših narudžbi na stranici <a href="#">moj korisnički račun</a> ili kliknuvši na <a href="#">povijest narudžbi</a>.</p><p>Molimo Vas da ukoliko imate nekih pitanja ista uputite <a href="#">vlasniku web trgovine</a>.</p><p>Zahvaljujemo se što ste kupovali online kod nas!</p>

        </div>




                </div></div></div>

    </div>
@endsection

@push('js_before')
@endpush
