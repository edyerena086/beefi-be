<?php

namespace MetodikaTI\Http\Controllers\WS;

use MetodikaTI\Sponsor;
use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;

class SponsorController extends Controller
{
    public function index()
    {
    	$response;

    	$sponsor = Sponsor::orderBy('created_at', 'DESC')->first();

    	if ($sponsor == null) {
    		$response = [
	    		'hasData' => ($sponsor == null) ? false : true
	    	];
    	} else {
    		$response = [
	    		'hasData' => ($sponsor == null) ? false : true,
	    		'data' => url('/').'/storage/uploads/'.$sponsor->sponsor_ad
	    	];
    	}

    	return response()->json($response);
    }
}
