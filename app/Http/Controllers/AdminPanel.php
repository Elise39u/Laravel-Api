<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Users;
use App\Guests;
use App\roles;
use \Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
class AdminPanel extends Controller
{

	// Login controllers
	public function Login(){
		return view('login');
	}

	public function loginProcess(Request $request){
		$username = $request->input('username');
		$password = $request->input('password');

		$rules = array(
			'username' => 'required',
			'password' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Redirect()->back()->withInput()->withErrors($validator);
		}else{
			$user = Users::where('username', $username)->first();
			if($user != null) {
				if (Hash::check($password, $user->password)) {
					if ($user->roleId == 1) {
						$request->session()->put('username', $user->username);
						$request->session()->put('user_logged', 1);
						return redirect('users');
					} else {
						Session()->flash('message', 'You are not allowed to access this page!');
						return back();
					}
				} else {
					Session()->flash('message', 'oops your password is wrong');
					return back();
				}
			}else{
				Session()->flash('message', 'oops your username is wrong');
				return back();
			}
		}
	}
	public function logout(){
		Session()->flush();
		Session()->flash('message', 'You are now logged off!');
		return redirect('/');
	}








	// User / guest controllers
	public function Users(Request $request)
	{
		$userslogged = session()->get('user_logged');
		if($userslogged == 1){
			$roles = roles::where('roleId', '!=' , 5)->get();
			$users = Users::leftjoin('roles', 'roles.RoleId', '=', 'users.roleId')->where('role', '!=' , 5)->where('username', '!=' , 'KleynAdmin')->where('username', '!=' , session()->get('username'))->get();
			$guests = Guests::all();

			$toview = [
				'users' => $users,
				'roles' => $roles,
				'guests' => $guests
			];
			return view('users',$toview);
		}else{
			Session()->flash('message', 'You are not allowed to access this page!');
			return redirect('/');
		}
	}

	Public function InsertEmployee(Request $request)
	{
		$userslogged = session()->get('user_logged');
		if($userslogged == 1){
			$rules = array(
				'username' => 'required|unique:users',
				'email' => 'required|unique:users|email',
				'role' => 'required'
			);
			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{

				$request->session()->put('error_code', 5);
				return Redirect()->back()->withInput()->withErrors($validator);
			}
			else {
				function random_password()
				{
					$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					$password = array();
					$alpha_length = strlen($alphabet) - 1;
					for ($i = 0; $i < 8; $i++) {
						$n = rand(0, $alpha_length);
						$password[] = $alphabet[$n];
					}
					return implode($password);
				}

				$username = $request->input('username');
				$email = $request->input('email');
				$role = $request->input('role');

				$passwordmade = random_password();
				$passwordhash = bcrypt($passwordmade);

				$data = array(
					'username' => $username,
					'email' => $email,
					'role' => $role,
					'password' => $passwordhash,
					'IsFrozen' => 0
				);

				$maildata = array(
					'username' => $username,
					'password' => $passwordmade
				);

				Mail::send('email.employee', $maildata, function($message) {
					var_dump(Input::get('email'));
					$message->to(Input::get('email'), (Input::get('username')))
						->subject('KleynPark Services: Account created!');

				});
				DB::table('users')->insert($data);

				//pass back a variable when redirecting
				$request->session()->put('error_code', 0);
				return back();
			}
		}else{
			Session()->flash('message', 'You are not allowed to access this page!');
			return redirect('/');
		}
	}

	public function DeleteEmployee(Request $request)
	{
		$userslogged = session()->get('user_logged');
		if ($userslogged == 1) {
			$userRole = $request->input('userrole');
			if ($userRole == 5) {
				$username = $request->input('username');
				DB::table('guests')->where('username', $username)->delete();
			} else {
				$username = $request->input('username');
				DB::table('users')->where('username', $username)->delete();
			}
			return back();
		}else{
			Session()->flash('message', 'You are not allowed to access this page!');
			return redirect('/');
		}
	}

	public function FreezeUser(Request $request)
	{
		$userslogged = session()->get('user_logged');
		if ($userslogged == 1) {
			$userid = $request->input('userid');
			$userState = $request->input('userstate');
			$userRole = $request->input('userrole');
			if ($userState == 1) {
				if ($userRole == 5) { // Role 5 = Guest
					$guest = Guests::find($userid);
					$guest->IsFrozen = 0;
					$guest->save();
					return back();
				} else {
					$user = users::find($userid);
					$user->IsFrozen = 0;
					$user->save();
					return back();
				}
			} elseif ($userState == 0) {
				if ($userRole == 5) { // Role 5 = Guest
					$guest = Guests::find($userid);
					$guest->IsFrozen = 1;
					$guest->save();
					return back();
				} else {
					$user = users::find($userid);
					$user->IsFrozen = 1;
					$user->save();
					return back();
				}
			}
			return null;
		}else{
			Session()->flash('message', 'You are not allowed to access this page!');
			return redirect('/');
		}
	}
	public function EditUser(Request $request)
	{
		$userslogged = session()->get('user_logged');
		if ($userslogged == 1) {
			$userRole = $request->input('currentuserrole');
			$this->validate(
				$request, [
					'username' => 'required',
					'email' => 'required|email',
					'roleid' => 'required'
				]
			);
			if ($userRole == 5) { // Role 5 = Guest

			} else {
				$userid = $request->input('userid');
				$newusername = $request->input('username');
				$newemail = $request->input('email');
				$newrole = $request->input('roleid');
				$user = users::find($userid);
				$user->username = $newusername;
				$user->email = $newemail;
				$user->roleId = $newrole;
				$user->save();
				return back();
			}
		}else{
			Session()->flash('message', 'You are not allowed to access this page!');
			return redirect('/');
		}
	}

	Public function InsertGuest(Request $request)
	{
		$userslogged = session()->get('user_logged');
		if ($userslogged == 1) {
			$expireAt = $request->input('expiresAt');
			$rules = array(
				'username' => 'required|unique:users|unique:guests',
				'email' => 'required|unique:users|unique:guests|email',
				'expiresAt' => 'required|'
			);
			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {

				$request->session()->put('error_code', 4);
				return Redirect()->back()->withInput()->withErrors($validator);
			} else {
				if ($expireAt > Carbon::today()) {
					function random_password()
					{
						$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
						$password = array();
						$alpha_length = strlen($alphabet) - 1;
						for ($i = 0; $i < 8; $i++) {
							$n = rand(0, $alpha_length);
							$password[] = $alphabet[$n];
						}
						return implode($password);
					}

					$username = $request->input('username');
					$email = $request->input('email');
					$role = 5;

					$passwordmade = random_password();
					$passwordhash = password_hash($passwordmade, PASSWORD_BCRYPT);

					$data = array(
						'username' => $username,
						'email' => $email,
						'expiresAt' => $expireAt,
						'role' => 5,
						'password' => $passwordhash,
						'IsFrozen' => 0
					);
					$maildata = array(
						'username' => $username,
						'password' => $passwordmade,
						'ExpiresAt' => $expireAt
					);
					Mail::send('email.guest', $maildata, function($message) {
						var_dump(Input::get('email'));
						$message->to(Input::get('email'), (Input::get('username')))
							->subject('KleynPark Services: Account created!');

					});
					DB::table('guests')->insert($data);

					//pass back a variable when redirecting
					$request->session()->put('error_code', 0);
					return back();
				} else {
					$request->session()->put('error_code', 4);
					Session()->flash('message', 'Expire date is invalid!');
					return back();
				}
			}
		}else{
			Session()->flash('message', 'You are not allowed to access this page!');
			return redirect('/');
		}
	}







	//Role controllers
	public function Roles(Request $request){
		$userslogged = session()->get('user_logged');
		if ($userslogged == 1) {

			$roles = roles::all();
			return view('roles', ['roles' => $roles]);
		}else{
			Session()->flash('message', 'You are not allowed to access this page!');
			return redirect('/');
		}
	}
		public function AddRole(Request $request)
		{
			$userslogged = session()->get('user_logged');
			if ($userslogged == 1) {
				$roleName = $request->input('roleName');
				$IsAdmin = $request->input('IsAdmin');
				$AEL = $request->input('AllowEditLocation');
				$AES = $request->input('AllowEditSalesman');
				$AEB = $request->input('AllowEditBuyer');
				$AEV = $request->input('AllowEditVideo');
				$AEP = $request->input('AllowEditPhotos');

				$data = array(
					'roleName' => $roleName,
					'IsAdmin' => $IsAdmin,
					'ael' => $AEL,
					'aes' => $AES,
					'aeb' => $AEB,
					'aev' => $AEV,
					'aep' => $AEP,
					'IsDefault' => 0
				);

				$rules = array(
					'roleName' => 'required|unique:roles',
				);
				$validator = Validator::make(Input::all(), $rules);

				if ($validator->fails()) {

					$request->session()->put('error_code', 5);
					return Redirect()->back()->withInput()->withErrors($validator);
				} else {
					DB::table('roles')->insert($data);
					return back();
				}
			}else{
				Session()->flash('message', 'You are not allowed to access this page!');
				return redirect('/');
			}
		}
		public function DeleteRole(Request $request)
		{
			$userslogged = session()->get('user_logged');
			if ($userslogged == 1) {
				$roleid = $request->input('roleid');
				DB::table('roles')->where('roleId', $roleid)->delete();
				return back();
			}else{
				Session()->flash('message', 'You are not allowed to access this page!');
				return redirect('/');
			}
		}
		public function EditRole(Request $request){
			$userslogged = session()->get('user_logged');
			if ($userslogged == 1) {
				$roleName = $request->input('roleName');
				$roleid = $request->input('roleid');
				$IsAdmin = $request->input('IsAdmin');
				$AEL = $request->input('AllowEditLocation');
				$AES = $request->input('AllowEditSalesman');
				$AEB = $request->input('AllowEditBuyer');
				$AEV = $request->input('AllowEditVideo');
				$AEP = $request->input('AllowEditPhotos');
				$data = array(
					'IsAdmin' => $IsAdmin,
					'ael' => $AEL,
					'aes' => $AES,
					'aeb' => $AEB,
					'aev' => $AEV,
					'aep' => $AEP,
				);
				roles::Where('roleId', $roleid)->update($data);
				Session()->flash('message', 'The permissions of ' . $roleName . ' have been changed!');

				return back();
			}else{
				Session()->flash('message', 'You are not allowed to access this page!');
				return redirect('/');
			}
		}

		public function phpcheck(){
			$userslogged = session()->get('user_logged');
			if ($userslogged == 1) {
				echo phpinfo();
			}else{
				Session()->flash('message', 'You are not allowed to access this page!');
					return redirect('/');
				}
		}



}
