<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Permissons;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Users;
use App\roles;

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

    public function username()
    {
        return 'username';
    }
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function login(Request $request)
    {
        //Werkte eerst niet vanwege data die niet bestond
        $this->validateLogin($request);
        // Nou hebben we hier een error ? Waarom:
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();
	    $userwithperm = Users::leftjoin('permissons', 'permissons.role_Id', '=', 'users.roleId')->where('username', '=', $user->username)->first();
	    $userRoles = Users::with('getPermissions')->where('roleId', $userwithperm->roleId)->get();
            return response()->json($userwithperm, 200);
        } else {
            return response()->json([
                'data' => 'Monkeys broke the api :('], 500);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->remember_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [ 'error' => trans('auth.failed') ];
        return response()->json($errors, 422);
    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
