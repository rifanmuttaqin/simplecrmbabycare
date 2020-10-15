<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Redirect;

use App\Model\User\User;
use App\Model\User\UserAttempt;

use Auth;

use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
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
     * menampilkan Login Form.
     *
     * @return void
     */
    public function showLoginForm()
    {
        return view('auth.content');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|max:255',
            'password'  => 'required',
        ]);

        // simpan dalam variabel array
        $crendentials   = [ 'email' => $request->email , 'password' => $request->password ];

        // Proses Login
        if(Auth::attempt($crendentials,$request->remember))
        { 
            $user       = User::getByEmail($request->email);

            if($user->status != User::USER_STATUS_NOT_ACTIVE)
            {
                //--- Hapus User Attempt
                UserAttempt::clearAttempt($user->id);
                return redirect('/');
            }
            else
            {
                Auth::logout();
                return Redirect::back()->withErrors(['Akun Anda Terkunci, Tunggu 15 Menit Untuk dapat login kembali', 'error_login']);
            }
        }
        else
        {
            $email  = $request->email;
            $user   = User::getByEmail($email);

            if( $user != null)
            {
                if(UserAttempt::countUser(($user->id)) >= 2 )
                {
                    $user->status = User::USER_STATUS_NOT_ACTIVE;
                    $user->save();

                    return Redirect::back()->withErrors(['Akun Anda Terkunci, Tunggu 15 Menit Untuk dapat login kembali', 'error_login']);
                }
                else
                {
                    $user_fail_login = new UserAttempt();
                    $user_fail_login->user_id = $user->id;
                    
                    $user_fail_login->save();
                }

                return Redirect::back()->withErrors(['username dan password tidak sesuai', 'error_login']);
            }
            else
            {
                return Redirect::back()->withErrors(['username dan password tidak sesuai', 'error_login']);
            }           
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/auth/login');
    }

}
