<?php

namespace MetodikaTI\Http\Controllers\WS;

use MetodikaTI\NetworkPassword;
use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;

class NetworkPasswordController extends Controller
{
    public function index()
    {
    	$password = NetworkPassword::orderBy('id', 'asc')->first();

    	$response = [
    		'status' => true,
    		'password' => $password
    	];

    	return response()->json($response);
    }
}
