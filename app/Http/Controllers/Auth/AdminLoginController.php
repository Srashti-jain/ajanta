<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;


class AdminLoginController extends Controller
{
    

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login( Request $request )
    {
        
        // Validate form data
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required|min:6'
        ]);
        // Attempt to authenticate user
        // If successful, redirect to their intended location
        if ( Auth::guard('auth')->attempt(['email' => $request->email, 'password' => $request->password, 'is_verified' => 1, 'status' => 1], $request->remember) ){

            if(!auth()->user()->can('login.can')){
                Auth::logout();
                $errors = new MessageBag(['email' => __('Login access blocked !')]);
                return back()->withErrors($errors)->withInput($request->except('password'));
            }

            return redirect()->intended( route('admin.main') );
        }
        // Authentication failed, redirect back to the login form
        return redirect()->back()->withErrors(['email' => __('These credentials do not match our records.')])->withInput( $request->only('email', 'remember') );
    }
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'admin.login' ));
    }
}