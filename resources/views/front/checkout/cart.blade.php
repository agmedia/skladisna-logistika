@extends('front.layouts.core')
@section ( 'title', 'Košarica')
@push('css_before')
@endpush

@section('content')

    <section id="page-title" class="page-title-mini page-title-right">
        <div class="container clearfix">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item active" aria-current="page">Košarica</li>
            </ol>
        </div>
    </section>

    <cart-view continueurl="{{ route('index') }}" checkouturl="{{ route('naplata') }}"></cart-view>
@endsection

@push('js_before')
@endpush
