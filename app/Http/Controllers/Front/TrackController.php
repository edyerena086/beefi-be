<?php

namespace MetodikaTI\Http\Controllers\Front;

use Carbon\Carbon;
use MetodikaTI\User;
use MetodikaTI\Track;
use MetodikaTI\Company;
use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;

class TrackController extends Controller
{
    public function track($id)
	{
        $response;

        //Get company
        $company = Company::where('user_id', User::find($id)->id)->first();

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
                'total' => $total,
                'man' => $man,
                'woman' => $woman
            ];

        }

        
        return view('front.track.index', ['stats' => $response, 'company' => $company]);
		//return response()->json($response);
	}
}
