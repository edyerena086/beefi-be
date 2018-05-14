<?php

namespace MetodikaTI\Http\Controllers\WS;

use MetodikaTI\Beefispot;
use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;

class BeefispotController extends Controller
{
    public function index()
    {
    	$beefispots = Beefispot::orderBy('created_at', 'desc')->get();

    	$response = [
    		'hasData' => ($beefispots->count() > 0) ? true : false,
    		'item' => $beefispots
    	];

    	return response()->json($response);
    }
}
