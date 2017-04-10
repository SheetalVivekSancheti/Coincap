@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row topNavbar">
            <div class="coincapLogo col-md-2">
                <img src="/images/logo.jpg">
            </div>
            <div class="searchSection col-md-10">
                <div class="col-md-10" style="padding-top: 8px;">

                </div>

            </div>
        </div>
        <div class="coinChartDiv">
            <form id="frm-example" method="POST">
                {{csrf_field()}}
                <div class="table-responsive">
                <table id="example" class="display select table table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><input name="select_all" value="1" type="checkbox"></th>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Symbol</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        @foreach($coins as $i=>$coin)
                        <td><input type="hidden" name="selectedRow" value= {{$coin->is_show}}> </td>
                        <td> {{ $coin->id }} </td>
                        <td> <a href="{{url("/$coin->symbol")}}">{{ $coin->name }} </a></td>
                        <td>{{ $coin->symbol }}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <p><button onclick="submitFunction()" id="submitBtn">Submit</button></p>
            </form>
        </div>
    </div>
@endsection
