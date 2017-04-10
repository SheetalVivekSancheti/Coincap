<?php

namespace App\Http\Controllers;

use App\Coin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Toastr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = Coin::where('is_show',1)->get();
        return view('home',compact('coins'));
    }

    public function changePassword()
    {
        return view('changePassword');
    }

    public function updatePassword(Request $request)
    {
        $rules = array(
            'current_password' => 'required',
            'new_password' => 'required|between:6,20|confirmed|alpha_num',
            'new_password_confirmation' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            if (!Hash::check($request->input('current_password'), Auth::user()->password)) {
                $validator->errors()->add('current_password', 'Current Password is incorrect');
            } else {
                Auth::user()->update(['password' => Hash::make($request->new_password)]);
                Toastr::success("Password changed successfully");
                return redirect('/home');
            }
        }
        return redirect()->back()->withErrors($validator);
    }
}
