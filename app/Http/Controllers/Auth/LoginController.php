<?php

  

namespace App\Http\Controllers\Auth;

  

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

  

class LoginController extends Controller

{

  

    use AuthenticatesUsers;

    

    protected $redirectTo = '/';

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest')->except('logout');

    }

  

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    // Show Login form
    public function showLoginForm(){
        if(isset($_COOKIE['language']))
            \App::setLocale($_COOKIE['language']);
        else
            \App::setLocale('en');
        //getting theme
        if(isset($_COOKIE['theme']))
            $theme = $_COOKIE['theme'];
        else
            $theme = 'light';
        //get general setting value 
        $general_setting = \App\GeneralSetting::latest()->first();
        if(!$general_setting) {
            \DB::unprepared(file_get_contents('public/tenant_necessary.sql'));
            $general_setting = \App\GeneralSetting::latest()->first();
        }
        return view('backend.auth.login', compact('theme', 'general_setting'));
    }

    public function login(Request $request)
    { 

        $input = $request->all();

        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if(auth()->attempt(array($fieldType => $input['name'], 'password' => $input['password'])))
        {
            return redirect('/');
        }
        else {
            return redirect()->route('login')->with('error','Username And Password Are Wrong.');
        }
    }
}