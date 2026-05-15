<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Facades\view;  // use for check view exits or not
use Illuminate\support\Facades\Auth;


class UserController extends Controller
{
    function getUser(){
        return "rahul dangi";
    }

    function getUserName($name , $age ){
        return "this is " . $name  . "   " .   "mohit age " . $age;
    }

    function user(){
        return view('user');   // call view from controller
    }

    function admin(){
        if(view::exists('admin.login')){
            return view('admin.login');
        }else{
            echo "no view foundd";
        }
     
    }
    function home(){

    return view('home');

}


    function main(){
        if(view::exists('admin.signup')){
            return view('admin.signup');
        }else{
            echo "  sorry no view found";
        }
     
    }

    function submit(Request $req){
       $req->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|confirmed'
       ]);

       User::create([
        'name'=> $req->name,
        'email'=>$req->email,
        'password'=>Hash::make($req->password)
       ]);

      return redirect('/userlogin');
    }


    function login(Request $req){
        $cerdentails = $req->validate([
          'email'=>'required|email',
          'password' =>'required'
        ]);
        if(Auth::attempt($cerdentails)){
            return redirect('/dashboard');
        }else {
            return "Email or Password Incorrect";
        }
    }


    function logout (){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
          return  redirect('/userlogin');
    }



  

}; 
