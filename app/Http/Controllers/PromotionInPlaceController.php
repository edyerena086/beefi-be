<?php

namespace MetodikaTI\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use MetodikaTI\PromotionInPlace;
use Illuminate\Http\Request;
use MetodikaTI\Http\Requests\Dashboard\PromotionInPlace\StoreRequest;

class PromotionInPlaceController extends Controller
{
	public function index()
	{
		$promotions = PromotionInPlace::where('type', 0)->orderBy('created_at', 'DESC')->get();

		return view('promotion-place.index', ['promotions' => $promotions, 'counter' => $promotions->count(), 'centinel' => 1]);
	}

	public function indexLate()
	{
		$promotions = PromotionInPlace::where('type', 1)->orderBy('created_at', 'DESC')->get();

		return view('promotion-place.index-late', ['promotions' => $promotions, 'counter' => $promotions->count(), 'centinel' => 1]);
	}

    public function store(StoreRequest $request)
    {
    	$response;

    	$promotionInPlace = new PromotionInPlace();
    	$promotionInPlace->company_name = $request->empresa;
    	$promotionInPlace->url = $request->url;
    	$promotionInPlace->type = 0;

    	$imageName = Carbon::now()->timestamp.".".$request->file('imagen')->getClientOriginalExtension();

    	if (Storage::disk('public')->putFileAs('uploads', $request->file('imagen'), $imageName)) {
    		$promotionInPlace->promotion = $imageName;

            if ($promotionInPlace->save()) {
            	$response = [
            		'status' => true,
            		'message' => 'Se ha guardado con éxito la promoción.'
            	];
            } else {
            	$response = [
	        		'status' => false,
	        		'message' => 'No se ha podido guardar la promoción.'
	        	];
            }
        } else {
        	$response = [
        		'status' => false,
        		'message' => 'No se ha podido guardar la promoción.'
        	];
        }

        return response()->json($response);
    }

    public function storeLate(StoreRequest $request)
    {
    	$response;

    	$promotionInPlace = new PromotionInPlace();
    	$promotionInPlace->company_name = $request->empresa;
    	$promotionInPlace->url = $request->url;
    	$promotionInPlace->type = 1;

    	$imageName = Carbon::now()->timestamp.".".$request->file('imagen')->getClientOriginalExtension();

    	if (Storage::disk('public')->putFileAs('uploads', $request->file('imagen'), $imageName)) {
    		$promotionInPlace->promotion = $imageName;

            if ($promotionInPlace->save()) {
            	$response = [
            		'status' => true,
            		'message' => 'Se ha guardado con éxito la promoción.'
            	];
            } else {
            	$response = [
	        		'status' => false,
	        		'message' => 'No se ha podido guardar la promoción.'
	        	];
            }
        } else {
        	$response = [
        		'status' => false,
        		'message' => 'No se ha podido guardar la promoción.'
        	];
        }

        return response()->json($response);
    }

    public function create()
    {
    	return view('promotion-place.create');
    }

    public function createLate()
    {
    	return view('promotion-place.create-late');
    }

    public function delete($id)
    {
    	$response;

    	$promotionInPlace = PromotionInPlace::find(base64_decode($id));

    	if ($promotionInPlace != null) {
    		if ($promotionInPlace->delete()) {
    			$response = [
    				'status' => true,
    				'message' => 'Se ha eliminado con éxito la promoción'
    			];
    		} else {
    			$response = [
    				'status' => false,
    				'message' => 'No se ha podido eliminar la promoción'
    			];
    		}
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'La promoción ingresada no se encuentra en el sistema.'
    		];
    	}

    	return response()->json($response);
    }
}
