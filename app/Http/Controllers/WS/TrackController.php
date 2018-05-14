<?php

namespace MetodikaTI\Http\Controllers\WS;

use Carbon\Carbon;
use MetodikaTI\User;
use MetodikaTI\Track;
use MetodikaTI\Company;
use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;

class TrackController extends Controller
{
	public function track(Request $request)
	{
        $response;

        //Get company
        $company = Company::where('name', $request->empresa)->first();

        if ($company == null) {
            $response = [
                'status' => false
            ];
        } else {

            $now = Carbon::now()->format('Y-m-d H:i:s');
            $before = Carbon::now()->subSeconds(60 * 5)->format('Y-m-d H:i:s');

            $track = Track::where('company_id', $company->id)->where('beat', '>=',$before)
                        ->where('beat', '<=', $now)
                        ->distinct('user_id')
                        ->orderBy('created_at', 'DESC')
                        ->get();

            $total = 0;
            $man = 0;
            $woman = 0;

            $inArray = [];

            foreach ($track as $item) {
                $user = User::find($item->user_id);

                if (!in_array($item->user_id, $inArray)) {

                    $inArray[] = $item->user_id;
                    $total++;

                    if ($user->client->gender_id == 2) {
                        $man++;
                    } else {
                        $woman++;
                    }


                }
                
            }

            $response = [
                'status' => true,
                'data' => [
                    'total' => $total,
                    'man' => $man,
                    'woman' => $woman
                ]
            ];

        }

        

		return response()->json($response);
	}

    public function beat(Request $request)
    {
        $response;

        $company = Company::where('name', $request->empresa)->first();

        if ($company == null) {
            $response = [
                'status' => false,
                'company' => $request->empresa
            ];
        } else {
            $user = User::find(decrypt($request->user_id));

            $track = new Track();
            $track->company_id = $company->id;
            $track->user_id = $user->id;
            $track->beat = Carbon::now()->format('Y-m-d H:i:s');

            if ($track->save()) {
                $response = [
                    'status' => true
                ];
            } else {
                $response = [
                    'status' => false
                ];
            }
        }

        return response()->json($response);
    }


    /*public function beats(Request $request)
    {
    	$response;

    	$company = Company::find($request->empresa_id);

    	if ($company == null) {
    		$response = [
    			'status' => false
    		];
    	} else {
    		$user = User::find(decrypt($request->user_id));

    		$track = new Track();
    		$track->company_id = $company->id;
    		$track->user_id = $user->id;
    		$track->beat = Carbon::now()->format('Y-m-d');

    		if ($track->save()) {
    			$response = [
    				'status' => true
    			];
    		} else {
    			$response = [
    				'status' => false
    			];
    		}
    	}

    	return response()->json($response);
    }*/
}
