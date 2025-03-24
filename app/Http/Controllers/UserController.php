<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class UserController
{
   // User Controller
   public function showSignUpForm()									
   {									   
       return view('users.signUp');									
   }	

   public function register(Request $request)
   {
    $input = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'c_password' => 'required|same:password'
    ]);

    $input['password'] = bcrypt($input['password']);
    User::create($input);

    echo '
    <script>
        alert("Đăng ký thành công. Vui lòng đăng nhập.");
        window.location.assign("login-form");
    </script>
    ';
    }

   public function showLogInForm()									
   {									   
       return view('users.logIn');									
   }	
   public function Login(Request $request)
   {
       $login = [
           'email' => $request->input('email'),
           'password' => $request->input('pw')
       ];
   
       if (Auth::attempt($login)) {
           $user = Auth::user();
           Session::put('user', $user);
           echo '<script>alert("Đăng nhập thành công."); window.location.assign("/");</script>';
       } else {
           echo '<script>alert("Đăng nhập thất bại."); window.location.assign("sign-up-form");</script>';
       }
   }
   
   public function Logout()
   {
       Session::forget('user');
       Session::forget('cart');
       return redirect('/');
   }
}