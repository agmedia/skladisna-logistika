@extends('front.account.index')

@push('partial_css')
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('moj') }}">Moj račun</a></li>
    <li class="breadcrumb-item">Poruke</li>
@endsection

@section('partial')
    <div class="row clearfix">
        <div class="col-lg-12">

            <div class="fancy-title notopmargin title-border">
                <h4>Poruke</h4>
            </div>

        </div>
    </div>
@endsection

@push('partial_js')
@endpush
