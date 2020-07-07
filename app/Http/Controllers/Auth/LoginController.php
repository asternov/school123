<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewToken;
use App\Providers\RouteServiceProvider;
use App\Token;
use http\Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $hash = \Illuminate\Support\Facades\Cookie::get('device_hash');

        if ($hash != null) {
            $token = Token::query()->where('hash', $hash)->get();
            if ($token->count() > 0) {
                return (auth()->attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 1]));
            }
        }

        Mail::to($request->post('email'))->send(new NewToken($request->post('email')));
        throw ValidationException::withMessages([
           "Ваше устройство не зарегистрированно в системе.",
            "пожалуйста, перейдите по ссылку, высланной Вам на почту."
        ]);
    }
}
