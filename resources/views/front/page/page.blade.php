@extends('front.layouts.core')
@push('css')
@endpush
@section ( 'title', $page->name)
@section('content')
    @if (\Illuminate\Support\Facades\Route::currentRouteName() == 'tal')
        <section id="page-title" class="page-title-right page-title-mini">
            <div class="container clearfix">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                    @if (\Illuminate\Support\Facades\Route::currentRouteName() == 'tal')
                        <li class="breadcrumb-item"><a href="{{ url('/tal') }}">TAL</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->name }}</li>
                </ol>
            </div>
        </section>
        <section id="slider" class="slider-element slider-parallax" style="background: url({{ asset($page->image) }}) center center; background-size: cover;"  data-height-xl="500" data-height-lg="350" data-height-md="300" data-height-sm="220" data-height-xs="180">
            <div class="slider-parallax-inner">
                <div class="container clearfix">
                    <div class="vertical-middle center">
                    </div>
                </div>
            </div>
        </section>
    @else
        <section id="page-title" class="page-title-right page-title-mini">
            <div class="container clearfix">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                    @if (\Illuminate\Support\Facades\Route::currentRouteName() == 'tal')
                        <li class="breadcrumb-item"><a href="{{ url('/tal') }}">TAL</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->name }}</li>
                </ol>
            </div>
        </section>
        @if($page->image)
            <section  class="page-title-dark pad1" style="position:relative;background-image: url('{{ asset($page->image) }}'); background-size: cover; background-position:center" >
                <div class="bckd" >
                    <div class="container clearfix">
                        <h1 class="hbwhite pad2" >{{ $page->name }}</h1>
                    </div>
                </div>
            </section><!-- #page-title end -->
        @endif
    @endif
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="col_full page">
                    {!! $page->description !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
@endpush
