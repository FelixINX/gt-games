<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Socialite;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->with(['hd' => 'monithq.ca'])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        // Check if they're an existing user
        $existingUser = User::where('google_id', $user->getId())->first();
        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $newUser = User::create([
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'google_id' => $user->getId(),
                'avatar' => $user->getAvatar(),
                'api_token' => Str::random(60)
            ]);

            auth()->login($newUser, true);
        }

        return redirect($this->redirectTo);
    }
}
