@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row topNavbar">
            <div class="coincapLogo col-md-2">
                <img src="/images/logo.jpg">
            </div>
            <div class="rightButton">
                <a class="btn btn-default pull-right" href="{{url("/admin/create")}}"><b>Add New Admin</b></a>
            </div>
        </div>

        <div class="adminList table-responsive">
            <table id="adminTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Name</th>
                        <th>Email id</th>
                    </tr>
                    @foreach($users as $key=>$user)

                    <tr>
                        <td> {{$key+1}} </td>
                        <td> {{ $user->fname.' '.$user->lname }} </td>
                        <td> {{ $user->email }} </td>
                </tr>
                        @endforeach
                </thead>
            </table>
        </div>
    </div>
@endsection
