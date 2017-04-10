@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row topNavbar">
            <div class="coincapLogo col-md-2">
                <img src="/images/logo.jpg">
            </div>
        </div>

        <div class="changePwd col-md-8 col-md-push-2">
            <form id="changePwd" method="post">
                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="current_password" class="col-md-2">Current Password:</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        @if ($errors->has('current_password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>


                <div class="form-group row">
                    <label for="new_password" class="col-md-2">New Password:</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        @if ($errors->has('new_password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_password_confirmation" class="col-md-2">Confirm Password:</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                        @if ($errors->has('new_password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
@endsection
