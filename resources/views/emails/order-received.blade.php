@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="ag-mail-tableset">{!! __('mail.order.subject_admin') !!}</td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                @include('emails.layouts.partials.order-details', ['order' => $order])
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                @include('emails.layouts.partials.order-price-table', ['order' => $order])
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                {{ __('mail.selected_payment') }}:
                @if ($order->payment == 'ponuda')
                    <b>{{ __('mail.ponuda') }}</b>
                @elseif ($order->payment == 'cash')
                    <b>{{ __('mail.cash') }}</b>
                @elseif ($order->payment == 'card')
                    <b>{{ __('mail.card') }}</b>
                @else
                    <b>{{ __('mail.paypal') }}</b>
                @endif
                <br><br>
                {{ __('mail.regards') }},
            </td>
        </tr>
        <tr>
            <td style="padding: 0 20px 20px 18px;">
                <a href="{{ route('home') }}" style="display: block; display: inline-block;">
                    <img src="http://optimatransfer.selectpo.lin48.host25.com/media/mailsignaturelogo.png" width="180" alt="alt_text" border="0" style="height: auto;">
                </a>
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset" style="text-align: center;">
                <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="ag-btn">
                    {{ __('mail.btn_admin') }}
                </a>
            </td>
        </tr>
    </table>
@endsection
