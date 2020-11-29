@extends('front.account.index')

@push('partial_css')
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('moj') }}">Moj račun</a></li>
    <li class="breadcrumb-item">Narudžbe</li>
@endsection

@section('partial')
    <div class="row clearfix">

        <div class="col-lg-12">

            <div class="fancy-title notopmargin title-border">
                <h4>Moje narudžbe</h4>
            </div>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium harum ea quo! Nulla fugiat earum, sed corporis amet iste non, id facilis dolorum, suscipit, deleniti ea.
               Nobis, temporibus magnam doloribus. Reprehenderit necessitatibus esse dolor tempora ea unde, itaque odit. Quos.</p>

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Time</th>
                    <th>Activity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <code>5/23/2021</code>
                    </td>
                    <td>Payment for VPS2 completed</td>
                </tr>
                <tr>
                    <td>
                        <code>5/23/2021</code>
                    </td>
                    <td>Logged in to the Account at 16:33:01</td>
                </tr>
                <tr>
                    <td>
                        <code>5/22/2021</code>
                    </td>
                    <td>Logged in to the Account at 09:41:58</td>
                </tr>
                <tr>
                    <td>
                        <code>5/21/2021</code>
                    </td>
                    <td>Logged in to the Account at 17:16:32</td>
                </tr>
                <tr>
                    <td>
                        <code>5/18/2021</code>
                    </td>
                    <td>Logged in to the Account at 22:53:41</td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>
@endsection

@push('partial_js')
@endpush
