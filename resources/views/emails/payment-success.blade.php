@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px 0; text-align: center">
                <img src="http://optimatransfer.selectpo.lin48.host25.com/media/accepted.png" width="60" alt="alt_text" border="0" style="height: auto;">
            </td>
        </tr>
        {{--<tr>
            <td class="ag-mail-tableset">
                {{ __('mail.transfer.title') }}
            </td>
        </tr>--}}
        <tr>
            <td class="ag-mail-tableset">{!! __('mail.transfer.text', ['name' => $transaction->fname]) !!}</td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                @include('emails.layouts.partials.transaction-details', ['transaction' => $transaction])
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                @include('emails.layouts.partials.transaction-price-table', ['transaction' => $transaction])
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                {{ __('mail.selected_payment') }}:
                @if ($transaction->order->payment == 'ponuda')
                    <b>{{ __('mail.ponuda') }}</b>
                @elseif ($transaction->order->payment == 'cash')
                    <b>{{ __('mail.cash') }}</b>
                @elseif ($transaction->order->payment == 'card')
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
    </table>
@endsection
