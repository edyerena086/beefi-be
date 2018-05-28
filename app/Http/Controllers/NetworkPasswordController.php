<?php

namespace MetodikaTI\Http\Controllers;

use Illuminate\Http\Request;
use MetodikaTI\NetworkPassword;
use MetodikaTI\Http\Requests\Dashboard\NetworkPasswordRequest;

class NetworkPasswordController extends Controller
{
	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$password = NetworkPassword::all();

		return view('network.index', ['passwords' => $password, 'centinel' => 0]);
	}

    public function edit($id)
    {
        $network = NetworkPassword::find(base64_decode($id));

        if ($network == null){
            return back();
        } else {
            return view('network.edit', ['password' => $network]);
        }
    }

	/**
	 * [update description]
	 * @param  NetworkPasswordRequest $request [description]
	 * @param  [type]                 $id      [description]
	 * @return [type]                          [description]
	 */
    public function update(NetworkPasswordRequest $request, $id)
    {
    	$response;

    	$password = NetworkPassword::find(base64_decode($id));

    	if ($password == null) {
    		$response = [
    			'status' => false,
    			'message' => "El password a actualizar no existe."
    		];
    	} else {
    		$password->password = $request->password;

    		if ($password->save()) {
    			$response = [
    				'status' => true,
    				'message' => 'Se ha actualizado con éxito el password.'
    			];
    		} else {
    			$response = [
    				'status' => false,
    				'message' => 'No se ha podido actualizar la contarseña.'
    			];
    		}
    	}

    	return response()->json($response);
    }
}
