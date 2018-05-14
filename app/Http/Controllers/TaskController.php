<?php

namespace MetodikaTI\Http\Controllers;

use Carbon\Carbon;
use MetodikaTI\User;
use Illuminate\Http\Request;
use MetodikaTI\ClientPromotion;
use MetodikaTI\FinalUserPromotion;

class TaskController extends Controller
{
    public function lastDay()
    {
    	$response;

    	$currentDate = Carbon::now()->format('Y-m-d H:i:s');
    	$endDate = Carbon::now()->addDay()->format('Y-m-d H:i:s');

    	//Get the promotions that expires in one day
    	$clientPromotions = ClientPromotion::where('end_date', '>=', $currentDate)->where('end_date', '<=', $endDate)->get();

    	if ($clientPromotions->count() > 0) {
    		foreach ($clientPromotions as $promotion) {
    			$finalUserPromotions = FinalUserPromotion::where('client_promotion_id', $promotion->id)->get();

    			if ($finalUserPromotions->count() > 0) {
    				


    				$response = [
    					'status' => true,
    					'data' => $finalUserPromotions
    				];
    			} else {
    				$response =[
		    			'status' => false,
		    			'error_code' =>  'x0002'
		    		];
    			}
    		}
    	} else {
    		$response =[
    			'status' => false,
    			'error_code' =>  'x0003'
    		];
    	}

    	return response()->json($response);
    }
}
