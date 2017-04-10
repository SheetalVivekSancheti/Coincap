<?php

namespace App\Http\Controllers;

use App\Coin;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Toastr;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    public function index()
    {
        $coins = Coin::all();
        return view('admin.dashboard',compact('coins'));
    }

    public function storeCoin(Request $request)
    {

        $selected_coins = $request->get('selected_coins');
//        dd($selected_coins);
        $coins = Coin::whereIn('name',$selected_coins)->update(['is_show'=>1]);
        $coins = Coin::whereNotIn('name',$selected_coins)->update(['is_show'=>0]);
        return redirect()->back();
    }

    public function listAdmin(Request $request)
    {

      $users = User::where('role',1)->select('fname','lname','email')->get();
        return view('admin/adminList',compact('users'));
    }

    public function createAdmin(Request $request)
    {
        return view('admin/adminCreate');
    }

    public function insertAdmin( Request $request)
    {
        $rules = array(
            'fname' => 'required',
            'lname' => 'required',
            'pwd' => 'required',
            'email' => 'required|unique:users'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
        $user = new User();
        $user->fname = $request->get("fname");
        $user->lname = $request->get("lname");
        $user->email = $request->get("email");
        $user->role=1;
        $user->password = Hash::make($request->get("pwd"));
        $user->save();
            Toastr::success("New admin created!");
        return redirect('admin');
        }
        return redirect()->back()->withErrors($validator);
    }
}
