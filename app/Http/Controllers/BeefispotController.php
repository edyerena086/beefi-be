<?php

namespace MetodikaTI\Http\Controllers;

use MetodikaTI\Beefispot;
use Illuminate\Http\Request;
use MetodikaTI\Http\Requests\Dashboard\Beefispot\StoreRequest;
use MetodikaTI\Http\Requests\Dashboard\Beefispot\UpdateRequest;

class BeefispotController extends Controller
{
    public function index()
    {
        $beefispots = Beefispot::orderBy('created_at', 'DESC')->get();

        return view('beefispot.index', ['beefispots' => $beefispots, 'centinel' => 1]);
    }

    public function create()
    {
        return view('beefispot.create');
    }

    public function store(StoreRequest $request)
    {
    	$response;

    	$beefispot = new Beefispot();

    	$beefispot->title = $request->titulo;
    	$beefispot->description = $request->descripcion;
    	$beefispot->lat = $request->latitud;
    	$beefispot->lng = $request->longitud;

    	if ($beefispot->save()) {
    		$response = [
    			'status' => true,
    			'message' => 'Se ha guardado con éxito el nuevo punto.'
    		];
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'No se ha guarado el punto.'
    		];
    	}

    	return response()->json($response);
    }

    public function edit($id)
    {
        $beefispot = Beefispot::find(base64_decode($id));

        if ($beefispot == null) {

        } else {
            return view('beefispot.edit', ['beefispot' => $beefispot]);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
    	$response;

    	$beefispot = Beefispot::find(base64_decode($id));

    	if ($beefispot != null) {
    		$beefispot->title = $request->titulo;
	    	$beefispot->description = $request->descripcion;
	    	$beefispot->lat = $request->latitud;
	    	$beefispot->lng = $request->longitud;

	    	if ($beefispot->save()) {
	    		$response = [
	    			'status' => true,
	    			'message' => 'Se ha actualizado con éxito el punto.'
	    		];
	    	} else {
	    		$response = [
	    			'status' => false,
	    			'message' => 'No se ha actualizado el punto.'
	    		];
	    	}
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'El punto ingresado no se encuentra en el sistema.'
    		];
    	}

    	return response()->json($response);
    }

    public function delete($id)
    {
    	$response;

    	$beefispot = Beefispot::find(base64_decode($id));

    	if ($beefispot != null) {
    		if ($beefispot->delete()) {
    			$response = [
    				'status' => true,
    				'message' => 'Se ha eliminado con éxito el punto'
    			];
    		} else {
    			$response = [
    				'status' => false,
    				'message' => 'No se ha podido eliminar el punto'
    			];
    		}
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'El punto ingresado no se encuentra en el sistema.'
    		];
    	}

    	return response()->json($response);
    }
}
