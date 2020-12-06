@extends('front.account.index')

@push('partial_css')
    <style>
        .button-red-ag {
            color: #9d9d9d;
            border: 1px solid #dfdfdf !important;
        }

        .button-red-ag:hover {
            background-color: #bb011f !important;
        }

        .button-red-ag span {
            color: #919191;
        }

        .button-red-ag:hover span {
            color: #ffffff;
        }
    </style>
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item">Moj račun</li>
@endsection

@section('partial')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="fancy-title notopmargin title-border">
                <h4>Moj račun</h4>
            </div>
        </div>

        <div class="col-md-11">
            <div class="row text-center">
                <div class="col-md-4">
                    <a href="{{ route('moj.narudzbe') }}" class="button button-desc button-border button-rounded button-red-ag center" style="width: 100%;">
                        <div>Narudžbe</div>
                        <span>Pogledajte vaše narudžbe</span></a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('moj.servis') }}" class="button button-desc button-border button-rounded button-red-ag center" style="width: 100%;">
                        <div>Pomoć</div>
                        <span>Obratite nam se</span></a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('moj.postavke') }}" class="button button-desc button-border button-rounded button-red-ag center" style="width: 100%;">
                        <div>Postavke</div>
                        <span>Uredite svoj račun</span></a>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('partial_js')
@endpush
