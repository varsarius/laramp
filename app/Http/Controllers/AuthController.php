<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Location;
use Auth;
class AuthController extends Controller
{
  public function loginPage()
  {
    return view('login');
  }
  public function logout()
  {
    Auth::logout();
    return redirect('/');
  }

  public function login(Request $request){
    $data = $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|string'
    ]);


    $auth = Auth::attempt($data, true);

    //--------------------------------------------
    if($auth) {
      return redirect('/');
    } else {
      return redirect('/login');
    }
    //----------------------------------------------
  }
}
