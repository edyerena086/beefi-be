<?php

namespace MetodikaTI\Http\Controllers\WS;

use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use MetodikaTI\Http\Requests\WS\LoginRequest;
use MetodikaTI\Http\Requests\WS\StoreNewClientRequest;
use MetodikaTI\Http\Requests\WS\RestorePasswordRequest;
use MetodikaTI\Http\Requests\WS\UpdateClientRequest;
use MetodikaTI\Http\Requests\WS\StoreProfilePictureRequest;
use MetodikaTI\User;
use MetodikaTI\Client;
use MetodikaTI\UserGroup;
use MetodikaTI\Library\Pastora;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use MetodikaTI\Mail\RecoverPassword;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(LoginRequest $request)
    {
        $response = [];

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {

            if ($request->has('token')) {
                $client = Client::where('user_id', '=', Auth::user()->id)->first();

                $client->token = $request->token;

                $client->save();
            }

            $response = [
                'status' => true,
                'user' => [
                    'id' => encrypt(Auth::user()->id),
                    'name' => Auth::user()->name
                ]
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Combinación de usuario y contraseña incorrecta.'
            ];
        }

        return response()->json($response);
    }

    public function storeProfilePicture(StoreProfilePictureRequest $request)
    {
        $response = [
            'status' => false,
            'message' => 'No se ha podido guardar la imagen'
        ];

        //Save image
        $imageName = Carbon::now()->timestamp.".".$request->file('imagenDePerfil')->getClientOriginalExtension();

        if ($request->hasFile('imagenDePerfil')) {
            if (Storage::disk('public')->putFileAs('uploads', $request->file('imagenDePerfil'), $imageName)) {
                $client = Client::where('user_id', decrypt($request->user_id))->first();

                if ($client != null) {
                    $client->picture = $imageName;

                    if ($client->save()) {
                        $response = [
                            'status' => true,
                            'message' => 'Se ha guardado con éxito la imagen de perfil.',
                            'picture' => $imageName
                        ];
                    }
                }
            }
        }

        return response()->json($response);

    }

    /**
     * @param StoreNewClientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postStoreNewClient(StoreNewClientRequest $request)
    {
        $response = [];

        $userGroup = UserGroup::where('name', '=', 'Client')->first();

        $user = new User();

        $user->name = $request->nombre;
        //$user->email = $request->email;
        //$user->password = bcrypt($request->password);
        $user->user_group_id = $userGroup->id;

        if ($user->save()) {
            $client = new Client();

            $client->user_id = $user->id;
            $client->gender_id = $request->sexo;
            $client->birthday = $request->fechaDeNacimiento;
            $client->token = $request->phoneId;


            //Save image
            if ($request->hasFile('imagenDePerfil')) {
                $imageName = Carbon::now()->timestamp.".".$request->file('imagenDePerfil')->getClientOriginalExtension();
                if (Storage::disk('public')->putFileAs('uploads', $request->file('imagenDePerfil'), $imageName)) {
                    $client->picture = $imageName;
                }
            }


            if ($client->save()) {
                $response = [
                    'status' => true,
                    'user' => encrypt($user->id)
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No se ha podido registrar con éxito.'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'No se ha podido registrar con éxito.'
            ];
        }

        return response()->json($response);
    }

    public function update(UpdateClientRequest $request)
    {
        $response;

        $user = User::find(decrypt($request->user_id));

        if ($user == null) {
            $response = [
                'status' => false,
                'message' => 'El usuario ingresado no existe.'
            ];
        } else {
            $finalUser = Client::where('user_id', $user->id)->first();

            $user->name = $request->nombre;

            $finalUser->gender_id = $request->sexo;
            $finalUser->birthday = $request->fechaDeNacimiento;

            if ($user->save() && $finalUser->save()) {
                $response = [
                    'status' => true,
                    'message' => 'Se ha actualizado con éxito el perfil de usuario.'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No se ha podido actualizar la información'
                ];
            }
        }

        return response()->json($response);
    }

    /**
     *
     * @param RestorePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRestorePassword(RestorePasswordRequest $request)
    {
        $response = [];

        $user = User::where('email', '=', $request->email)->first();
        $password = bcrypt(Pastora::passwordGenerator());
        $user->password = $password;
        //$user->password = bcrypt('Mku8njdro0@');

        if ($user->save()) {

            Mail::to($request->email)->send(new RecoverPassword($user, $password));

            $response = [
                'status' => true,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No se ha podido reestablecer la contraseña'
            ];
        }

        return response()->json($response);
    }

    /**
     * @param UpdateClientRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateClient(UpdateClientRequest $request, $id)
    {
        $response = [];

        $client = User::find(decrypt($id));

        if (is_null($client)) {
            $response = [
                'status' => false,
                'message' => 'El usuario no existe.'
            ];
        } else {
            $client->name = $request->nombre;
            //$client->email = $request->email;

            if ($request->has('password')) {
                $client->password = bcrypt($request->password);
            }

            //user specific info
            $user = Client::where('user_id', '=', $client->id)->first();
            $user->gender_id = $request->sexo;
            $user->birthday = $request->fechaDeNacimiento;

            if ($client->save() && $user->save()) {
                $response = [
                    'status' => true,
                    'message' => 'Se ha actualizado la información con éxito'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No se ha podido actualizar la información'
                ];
            }

        }

        return response()->json($response);
    }

    public function postStoreProximiToken(Request $request)
    {
        $response = [];

        if (strlen(trim($request->proximi)) > 0) {
            $userId = decrypt($request->user);

            $client = Client::where('user_id', '=', $userId)->first();
            $client->proximi_id = $request->proximi;

            if ($client->save()) {
                $response = ['status' => true];
            } else {
                $response = ['status' => false];
            }
        } else {
            $response = ['status' => false];
        }



        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postGetInfo(Request $request)
    {
        $userId = decrypt($request->user);

        $response = [];

        $user = User::find($userId);

        if (is_null($user)) {
            $response = [
                'status' => false,
                'message' => 'El usuario no existe.'
            ];
        } else {
            $client = Client::where('user_id', '=', $user->id)->first();

            $dt = Carbon::parse($client->birthday);

            $response = [
                'status' => true,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'gender' => $client->gender_id,
                    'day' => $dt->day,
                    'mont' => $dt->month,
                    'year' => $dt->year,
                    'picture' => ($client->picture == "") ? "" : url('/').'/storage/uploads/'.$client->picture
                ]
            ];
        }

        return response()->json($response);
    }
}
