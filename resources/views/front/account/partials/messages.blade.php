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

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="25%">Datum</th>
                    <th>Aktivnost</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>
                            <code>{{ \Carbon\Carbon::make($messages->first()->created_at)->format('d.m.Y') }}</code>
                        </td>
                        <td>
                            <span class="text-muted">Subjekt: </span>{{ $message->subject }}
                            <span class="float-right"><a href="{{ route('moj.poruka', ['message' => $message]) }}">Detalji...</a></span>
                        </td>
                    </tr>
                @endforeach
                @if( ! $messages->count())
                    <tr>
                        <td colspan="2" class="text-center">Trenutno nemate poruka..</td>
                    </tr>
                @endif
                </tbody>
            </table>

            <div class="row clearfix">
                <div class="col-md-12">
                    <a href="{{ route('moj.poruka.nova') }}" class="button button-border button-border-thin"><i class="icon-comment1"></i> Kontaktirajte nas</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    {{ $messages->links('front.layouts.partials.paginate') }}
@endsection

@push('partial_js')
@endpush
