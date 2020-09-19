@extends('front.layouts.core')

@push('css_before')
@endpush

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li>Košarica</li>
        </ul>
        <h1 id="page-title">Košarica</h1>

        <cart-view continueurl="{{ route('index') }}" checkouturl="{{ route('naplata') }}"></cart-view>
    </div>
@endsection

@push('js_before')
@endpush
