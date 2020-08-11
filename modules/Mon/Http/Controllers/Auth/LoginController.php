<?php

namespace Modules\Mon\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\WebController;
use Modules\Mon\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;

class LoginController extends WebController
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
    protected $redirectTo = '/admin';

    public function username()
    {
        return 'username';
    }
    /**
     * Create a new controller instance.
     *
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        parent::__construct($authentication);
        $this->middleware('guest')->except('logout');
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $gUser = Socialite::driver('google')->user();
        $user = $this->user->findByAttributes(['google_id' => $gUser->id]);
        if (!$user) {
            $data = [
                'facebook_id' => $gUser->getId(),
                'name' => $gUser->getName(),
                'email' => $gUser->getEmail(),
                'password' => \Hash::make(str_random(12))
            ];
            $user = $this->user->create($data);
            event(new Registered($user));
        }
        $this->guard()->login($user);
        app(UserRepository::class)->update($user, ['last_login' => date('Y-m-d H:i:s')]);
        return redirect()->intended($this->redirectPath());
    }

    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();
        $user = $this->user->findByAttributes(['facebook_id' => $fbUser->id]);
        if (!$user) {
            $email = $fbUser->getEmail();
            if (!$email) {
                $email = $fbUser->getId().'@webgiasu.net';
            }
            $data = [
                'facebook_id' => $fbUser->getId(),
                'name' => $fbUser->getName(),
                'email' => $email,
                'gender' => $fbUser->getGender(),
                'password' => Hash::make(str_random(12))
            ];
            $user = $this->user->create($data);
            event(new Registered($user));
        }
        $this->guard()->login($user);
        app(UserRepository::class)->update($user, ['last_login' => date('Y-m-d H:i:s')]);
        return redirect()->intended($this->redirectPath());
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status != User::STATUS_ACTIVE || $user->type != User::TYPE_ADMIN) {
            $this->guard()->logout();

            $request->session()->invalidate();
            return $this->sendFailedLoginResponse($request);
        }
        $userRepository = app(UserRepository::class);
        $userRepository->update($user, ['last_login' => date('Y-m-d H:i:s')]);
        $userRepository->generateTokenFor($user);
        return redirect()->intended($this->redirectPath());
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            return response()->json(['msg' => 'Logout successful!']);
        }
        $previousPath = url()->previous();

        if (in_array('admin',explode('/', $previousPath))) {
            return redirect($previousPath)->withSuccess(__('Logout successful!'));
        }
        return redirect()->route('home')->withSuccess(__('Logout successful!'));
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $this->seo()->setTitle(__('Login'));
        return $this->view('auth.login');
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminLoginForm()
    {
        $this->seo()->setTitle(__('Login'));

        return view('backend::login');
    }
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],
            [
                $this->username().'.required' => 'Please enter your user',
                'password.required'            => 'Please enter your password'
            ]);
    }
}
