@extends('front.layouts.core')
@push('css')
@endpush
@section ( 'title', 'Toyota viličari - Prodaja i najam')
@section('content')
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="si si-logout mr-5"></i> Odjava
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
@endpush
