<?php

namespace MetodikaTI\Http\Controllers\Front;

use Auth;
use MetodikaTI\User;
use Illuminate\Http\Request;
use MetodikaTI\Mail\RecoverPassword;
use Illuminate\Support\Facades\Mail;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\Front\Account\LoginRequest;
use MetodikaTI\Http\Requests\Front\Account\PasswordResetRequest;

class AccountController extends Controller
{
	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		return view('front.account.index');
	}

	/**
	 * [login description]
	 * @param  LoginRequest $request [description]
	 * @return [type]                [description]
	 */
	public function login(LoginRequest $request) 
	{
		$credentials = [
			'email' => $request->correoElectronico,
			'password' => $request->password,
			'user_group_id' => 3
		];

		if (Auth::attempt($credentials)) {
			return redirect()->intended('client/promotions');
		} else {
			Session::flash('loginError', true);
			return redirect()->intended('/');
		}
	}

	public function passwordRecovery()
	{
		return view('front.account.password-recovery');
	}

	/**
	 * [passwordReset description]
	 * @param  PasswordResetRequest $request [description]
	 * @return [type]                        [description]
	 */
	public function passwordReset(PasswordResetRequest $request)
	{
		$response;

		$client = User::where('email', $request->correoElectronico)->first();

		if ($client != null) {
			$newPassword = $this->passwordGenerate();

			$client->password = bcrypt($newPassword);

			if ($client->save()) {
				//Mail::to($request->correoElectronico)->send(new RecoverPassword($client, $newPassword));

				$response = [
					'status' => true,
					'message' => 'Se ha actualizado tu contarseña, te la haremos llegar por correo.'
				];
			} else {
				$response = [
					'status' => false,
					'message' => 'No se ha podido reestablecer tu contraseña'
				];
			}
		} else {
			$response = [
				'status' => false,
				'message' => 'El correo ingresado no existe en el sistema.'
			];
		}

		return response()->json($response);
	}

	private function passwordGenerate()
	{
		$password = "";

		for ($i = 1; $i <= 8; $i++) {
			$password = $password.chr(rand(96, 122));
		}

		return $password;
	}
}
