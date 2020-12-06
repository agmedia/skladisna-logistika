@extends('front.account.index')

@push('partial_css')
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('moj') }}">Moj račun</a></li>
    <li class="breadcrumb-item"><a href="{{ route('moj.poruke') }}">Poruke</a></li>
    @if(isset($messages))
        <li class="breadcrumb-item">Poruka: {{ $messages->first()->subject }}</li>
    @else
        <li class="breadcrumb-item">Nova</li>
    @endif
@endsection

@section('partial')
    <div class="row clearfix">
        <div class="col-lg-12">
            @if(isset($messages))
                <div class="row clearfix">
                    <div class="col-md-12 text-right bottommargin-sm">
                        <a href="#message-input-anchor" class="button button-border button-border-thin"><i class="icon-comment1"></i> Napiši novi komentar</a>
                    </div>
                </div>
            @endif
            <!-- Ako postoje poruke u istoj grupi... -->
            @if(isset($messages))
                <ol class="commentlist border-0 m-0 p-0 clearfix bottommargin-lg">
                    @foreach($messages as $message)
                        <li class="comment even thread-even depth-1" id="li-comment-1">
                            <!-- Poruka od kupca (sender) / Kupac gleda ovaj view... -->
                            @if($message->from_user_id == $customer->id)
                                <div id="comment-1" class="comment-wrap clearfix">
                                    <div class="comment-meta">
                                        <div class="comment-author vcard">
                                    <span class="comment-avatar clearfix">
                                        <img alt='Image' src='{{ asset($customer->details->avatar) }}' class='avatar avatar-60 photo avatar-default' height='60' width='60' />
                                    </span>
                                        </div>
                                    </div>
                                    <div class="comment-content clearfix">
                                        <div class="comment-author">{{ $customer->name }}<span><a href="#" title="Permalink to this comment">{{ \Carbon\Carbon::make($message->created_at)->format('d.m.Y. - H:m') }}h</a></span></div>
                                        <p>{!! $message->message_content !!}</p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            @else
                            <!-- Poruka od admina (recipient) -->
                                <ul class='children'>
                                    <li class="comment byuser comment-author-_smcl_admin odd alt depth-2" id="li-comment-3">
                                        <div id="comment-3" class="comment-wrap clearfix">
                                            <div class="comment-meta">
                                                <div class="comment-author vcard">
                                            <span class="comment-avatar clearfix">
                                                <img alt='Image' src='{{ asset($message->sender->details->avatar) }}' class='avatar avatar-40 photo' height='40' width='40' />
                                            </span>
                                                </div>
                                            </div>
                                            <div class="comment-content clearfix">
                                                <div class="comment-author"><a href='#' rel='external nofollow' class='url'>Admin</a><span><a href="#" title="Permalink to this comment">{{ \Carbon\Carbon::make($message->created_at)->format('d.m.Y. - H:m') }}h</a></span></div>
                                                <p>{!! $message->message_content !!}</p>
                                                <a class='comment-reply-link' href='#message-input-anchor' style="width: 100px;"><i class="icon-reply"></i> Odgovorite</a>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif

            <div class="fancy-title notopmargin title-border" id="message-input-anchor">
                @if(isset($messages))
                    <h4 class="nobottommargin">Odgovorite na poruku</h4>
                @else
                    <h4 class="nobottommargin">Pošaljite upit putem obrasca</h4>
                @endif
            </div>
            <p>Na upite odgovaramo u roku od 24 sata. Svi upite tretiraju se povjerljivo u skladu s našim <a href="{{ route('info.page', ['page' => 'pravila-privatnosti-i-kolacici']) }}">Pravilima o privatnosti.</a></p>

            <div class="form-widget">
                <form class="nobottommargin" action="{{ route('moj.poruka.salji') }}" method="post">
                    @csrf
                    @if(isset($messages))
                        <div class="col_full">
                            <label for="template-contactform-subject">Predmet: <span class="italic">{{ $message->subject }}</span></label>
                            <input type="hidden" name="group_id" value="{{ $message->group_id }}">
                            <input type="hidden" name="subject" value="{{ $message->subject }}">
                        </div>
                    @else
                        <div class="col_full">
                            <label for="template-contactform-subject">Predmet <strong class="text-danger">*</strong></label>
                            <input type="text" id="subject" name="subject" value="{{ $subject ? $subject : '' }}" class="sm-form-control">
                        </div>
                    @endif
                    <div class="clear"></div>
                    <div class="col_full">
                        <label for="message">Poruka <strong class="text-danger">*</strong></label>
                        <textarea class="required sm-form-control" id="message" name="message" rows="6" cols="30"></textarea>
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">
                    <div class="col_full">
                        <button class="btn btn-red nomargin" type="submit">Pošalji poruku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('partial_js')
    @include('front.layouts.partials.recaptcha-js')
@endpush
