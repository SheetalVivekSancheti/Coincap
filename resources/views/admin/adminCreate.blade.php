@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row topNavbar">
            <div class="coincapLogo col-md-2">
                <img src="/images/logo.jpg">
            </div>
        </div>

        <div class="adminCreate col-md-8 col-md-push-2">
            <form id="createAdminForm" method="post">
                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="fname" class="col-md-2">First Name:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="fname" name="fname">
                        @if ($errors->has('fname'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lname" class="col-md-2">Last Name:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="lname" name="lname">
                        @if ($errors->has('lname'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-2">Email ID:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="email" name="email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-2">Password:</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" id="pwd" name="pwd">
                        @if ($errors->has('pwd'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('pwd') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
@endsection
