@extends('front.layouts.core')

@push('css_before')
@endpush

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li>ERROR!</li>
        </ul>
        <h1 id="page-title">ERROR</h1>
    </div>
@endsection

@push('js_before')
@endpush
