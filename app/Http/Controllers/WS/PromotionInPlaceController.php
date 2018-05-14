<?php

namespace MetodikaTI\Http\Controllers\WS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use MetodikaTI\User;
use MetodikaTI\Company;
use MetodikaTI\ClientPromotion;
use MetodikaTI\PromotionInPlace;
use MetodikaTI\FinalUserPromotion;
use MetodikaTI\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PromotionInPlaceController extends Controller
{
    public function sendGetPush(Request $request)
    {
        $response;

        $clientPromotion = ClientPromotion::find($request->promo_id);

        if ($clientPromotion == null) {
            $response = [
                'status' => false,
                'message' => 'No se ha encontrado el benificio'
            ];
        } else {
            $company = Company::where('user_id', $clientPromotion->user_id)->first();

            $response = [
                'status' => true,
                'data' => $clientPromotion,
                'profile_picture' => $company->profile_picture
            ];
        }

        return response()->json($response);
    }

    public function sendOpeningPush(Request $request)
    {
        $response;

        //return response()->json($request);

        $client = Company::where('name', strtolower($request->geofence))->first();

        if ($client == null) {
            $response = [
                'status' => false,
                'error' => strtolower($request->geofence)
            ];
        } else {
            $user = User::find($client->user_id);
            $clientPromotion = ClientPromotion::where('user_id', $user->id)->where('status', 0)->orderBy('created_at', 'DESC')->first();

            if ($clientPromotion == null) {
                $response = [
                    'status' => false,
                    'error' => 1
                ];
            } else {
                //No le he mandado la prommoción al cliente
                $userFinalPromotion = FinalUserPromotion::where('user_id', decrypt($request->user_id))->where('client_promotion_id', $clientPromotion->id)->first();

                if ($userFinalPromotion == null) {
                    $response = [
                        'status' => true,
                        'data' => $clientPromotion,
                        //'qr' => QrCode::format('png')->generate($clientPromotion->url),
                        'profile_picture' => $client->profile_picture
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'error' => 2
                    ];
                }
             }
        }

        return response()->json($response);
    }

    public function getBenefit(Request $request)
    {
        $response;

        $finalUserPromotion = FinalUserPromotion::where('client_promotion_id', $request->cupon_id)->where('user_id', decrypt($request->user_id))->first();

        if ($finalUserPromotion == null) {
            $response = [
                'status' => false,
                'error' => 1
            ];
        } else {
            $finalUserPromotion->status = 2;

            if ($finalUserPromotion->save()) {
                $response = [
                    'status' => true
                ];
            } else {
                $response = [
                    'status' => false,
                    'error' => 2
                ];
            }
        }

        return response()->json($response);
    }

    public function saveOnbwallet(Request $request)
    {
        $response;

        $userFinalPromotion = FinalUserPromotion::where('client_promotion_id', $request->cupon_id)->where('user_id', decrypt($request->user_id))->first();

        if ($userFinalPromotion != null) {
            $response = [
                'status' => false,
                'entro' => 1
            ];
        } else {
            $createRecord = new FinalUserPromotion();
            $createRecord->user_id = decrypt($request->user_id);
            $createRecord->client_promotion_id = $request->cupon_id;
            $createRecord->status = 1;

            if ($createRecord->save()) {
                $response = [
                    'status' => true,
                ];
            } else {
                $response = [
                    'status' => false,
                    'entro' => 2
                ];
            }
        }

        return response()->json($response);
    }

    public function cuponDetailBwallet(Request $request)
    {
        $finalUserPromotion = FinalUserPromotion::where('client_promotion_id', $request->cupon_id)->where('user_id', decrypt($request->user_id))->first();

        $response;

        if ($finalUserPromotion != null) {
            $cupon = ClientPromotion::find($finalUserPromotion->client_promotion_id);

            $dataCupon = [
                        'id' => $cupon->id,
                        'user_id' => $cupon->user_id,
                        'end_date' => $cupon->end_date,
                        //'hoy' => Carbon::now()->month,
                        //'otro' => Carbon::parse($clientPromotion->end_date),
                        'day_diff' => ceil(Carbon::now()->diffInHours(Carbon::parse($cupon->end_date)) / 24),
                        'icon' => $cupon->icon,
                        'text' => $cupon->text,
                        'bwallet' => $cupon->bwallet,
                        'total_cupons' => $cupon->total_cupons,
                        'gender' => $cupon->gender,
                        'total_tables' => $cupon->total_tables,
                        'url' => $cupon->url 
                    ];





            $user = User::find($cupon->user_id);
            $company = Company::where('user_id', $user->id)->first();

            $response = [
                'status' => true,
                'data' => $dataCupon,
                'profile_picture' => $company->profile_picture,
                'profile_white' => $company->white_picture
            ];
        } else {
            $response = [
                'status' => false
            ];
        }

        return response()->json($response);
    }

    public function cuponsCompany(Request $request)
    {
        $response;

        $company = Company::find($request->company_id);

        if ($company == null) {
            $response = [
                'status' => false
            ];
        } else {
            $companyUser = User::find($company->user_id);

            $companyCupons = ClientPromotion::where('user_id', $companyUser->id)->get();

            $innerData = [];

            foreach ($companyCupons as $item) {
                $finalUserPromotion = FinalUserPromotion::where('client_promotion_id', $item->id)->where('user_id', decrypt($request->user_id))->first();

                if ($finalUserPromotion != null) {

                    $clientPromotion = ClientPromotion::where('id', $finalUserPromotion->client_promotion_id)->first();

                    //$innerData[] = $finalUserPromotion;
                    $dataClient = [
                        'id' => $clientPromotion->id,
                        'user_id' => $clientPromotion->user_id,
                        'end_date' => $clientPromotion->end_date,
                        //'hoy' => Carbon::now()->month,
                        //'otro' => Carbon::parse($clientPromotion->end_date),
                        'day_diff' => ceil(Carbon::now()->diffInHours(Carbon::parse($clientPromotion->end_date)) / 24),
                        'icon' => $clientPromotion->icon,
                        'text' => $clientPromotion->text,
                        'bwallet' => $clientPromotion->bwallet,
                        'total_cupons' => $clientPromotion->total_cupons,
                        'gender' => $clientPromotion->gender,
                        'total_tables' => $clientPromotion->total_tables,
                        'url' => $clientPromotion->url 
                    ];
                    //$innerData[] = $clientPromotion;
                    $innerData[] = $dataClient;
                }
            }

            $response = [
                'status' => true,
                'length' => count($innerData),
                'data' => $innerData,
                'profile_picture' => $company->profile_picture,
                'picture_white' => $company->white_picture
            ];
        }

        return response()->json($response);
    }

    /**
     * [companies description]
     *
     * @user_id
     */
    public function companies(Request $request)
    {
        $response;

        $user = User::find(decrypt($request->user_id));

        if ($user == null) {
            $response = [
                'status' => false
            ];
        } else {
            $promotions = FinalUserPromotion::where('user_id', $user->id)->get();

            if ($promotions->count() > 0) {
                $companiesList = [];
                $innerData = [];

                foreach ($promotions as $promotion) {
                    $mtkPromotion = ClientPromotion::find($promotion->client_promotion_id);

                    if (!in_array($mtkPromotion->user_id, $companiesList)) {
                        $companiesList[] = $mtkPromotion->user_id;
                         
                        $company = Company::where('user_id', $mtkPromotion->user_id)->first();

                        //$totalCupons = FinalUserPromotion::where('user_id', $user->id)->where('client_promotion_id', $company->id)->get()->count();

                        $innerData[] = [
                            //'data' => $mtkPromotion->user_id
                            'id' => $company->id,
                            'name' => $company->name,
                            'profile_picture' => $company->profile_picture,
                            'user_id' => $company->user_id,
                            'status' => $company->status,
                            'white_picture' => $company->white_picture,
                            'total_cupons' => 1
                        ];

                        //$innerData[] = $company;

                        $companiesList[] = $promotion->client_promotion_id;
                    }
                }

                $response = [
                    'status' => true,
                    'promotion' => true,
                    'data' => $innerData
                ];
            } else {
                $response = [
                    'status' => true,
                    'promotion' => false
                ];
            }
        }

        return response()->json($response);
    }

    public function cuponDetail(Request $request)
    {

    }

    public function index()
    {
    	$promotion = PromotionInPlace::where('type', 0)->first();

    	$response =[
    		'hasData' => ($promotion == null) ? false : true,
    		'data' => [
    			'url' => $promotion->url,
    			'company' => $promotion->company_name,
    			'imagen' => url('/').'/storage/uploads/'.$promotion->promotion
    		]
    	];

    	return response()->json($response);
    }

    public function indexLate()
    {
    	$promotion = PromotionInPlace::where('type', 1)->first();

    	$response =[
    		'hasData' => ($promotion == null) ? false : true,
    		'data' => [
    			'url' => $promotion->url,
    			'company' => $promotion->company_name,
    			'imagen' => url('/').'/storage/uploads/'.$promotion->promotion
    		]
    	];

    	return response()->json($response);
    }
}
