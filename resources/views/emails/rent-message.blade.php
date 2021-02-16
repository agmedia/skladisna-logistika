@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px 20px 10px 20px; font-family: sans-serif; font-size: 18px; font-weight: bold; line-height: 20px; color: #555555; text-align: center;">
                Poruka s Web kontakt forme.<br>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 20px 0 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                Dobili ste poruku za najam s Web kontakt forme.<br>
                <br>
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="width: 26%">Email:</td>
                        <td style="width: 74%"><b>{{ $rent['email'] }}</b></td>
                    </tr>
                    <tr>
                        <td>Mobile:</td>
                        <td><b>{{ $rent['mobile'] }}</b></td>
                    </tr>
                    <tr>
                        <td>OIB:</td>
                        <td><b>{{ $rent['oib'] }}</b></td>
                    </tr>
                    <tr><td><br></td><td></td></tr>
                    @if ( ! empty($rent['location']))
                        <tr>
                            <td>Lokacija:</td>
                            <td><b>{{ $rent['location'] }}</b></td>
                        </tr>
                    @endif
                    @if ( ! empty($rent['location_address']))
                        <tr>
                            <td>Druga adresa:</td>
                            <td><b>{{ $rent['location_address'] }}</b></td>
                        </tr>
                    @endif
                    <tr><td><br></td><td></td></tr>
                    @if ( ! empty($rent['type']))
                        <tr>
                            <td>Viličar:</td>
                            <td><b>{{ $rent['type'] }}</b></td>
                        </tr>
                    @endif
                    @if ( ! empty($rent['weight']))
                        <tr>
                            <td>Nosivost:</td>
                            <td><b>DO {{ $rent['weight'] }} T</b></td>
                        </tr>
                    @endif
                    @if ( ! empty($rent['height']))
                        <tr>
                            <td>Visina dizanja:</td>
                            <td><b>DO {{ $rent['height'] }} m</b></td>
                        </tr>
                    @endif
                    <tr><td><br></td><td></td></tr>
                    @if ( ! empty($rent['rent_start_date']))
                        <tr>
                            <td>Početak najma:</td>
                            <td><b>{{ \Carbon\Carbon::make($rent['rent_start_date'])->format('d.m.Y') }}</b></td>
                        </tr>
                    @endif
                    @if ( ! empty($rent['rent_end_date']))
                        <tr>
                            <td>Kraj najma:</td>
                            <td><b>{{ \Carbon\Carbon::make($rent['rent_end_date'])->format('d.m.Y') }}</b></td>
                        </tr>
                    @endif
                    @if ( ! empty($rent['on_location']))
                        <tr>
                            <td>Dostava na lokaciju:</td>
                            <td><b>{{ $rent['on_location'] ? 'DA' : 'NE' }}</b></td>
                        </tr>
                    @endif
                    @if ( ! empty($rent['has_ramp']))
                        <tr>
                            <td>Ima rampu:</td>
                            <td><b>{{ $rent['has_ramp'] ? 'DA' : 'NE' }}</b></td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 0 20px 0; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: center;">
                <a href="{{ route('index') }}" style="display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px; background-color: #a50000; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none; -webkit-text-size-adjust: none;">
                    Idi na stranicu
                </a>
            </td>
        </tr>
    </table>
@endsection
