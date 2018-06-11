<?php

namespace MetodikaTI\Http\Controllers\WS;

use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Client;
use MetodikaTI\User;
use MetodikaTI\Promotion;
use MetodikaTI\PromotionClient;
use MetodikaTI\Labs;
use MetodikaTI\Programmer;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class PushController extends Controller
{
    public function postSendFirstPush(Request $request)
    {
        $user = User::where('email', '=', 'carlos.romanos@gmail.com')->first();
        $client = Client::where('user_id', '=', $user->id)->first();

        $promotion = Promotion::where('extarnal_id', '=', $request->promotion_id)->first();

        $curl = curl_init();
        //$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJlYTE1Y2U5Mi1lOWY3LTQwZmYtODk5ZS04ODZmN2M5NmM4NTYifQ.Q5A_aO4TPf5s1EWbvsgaWHP84e-NGlu3alevmA3Q1Cw";
        //$myToken = "fhijfLN4lUA:APA91bEbue4yvRd8QQoY01Ylv0q7iLXs7dQ4U0t6r1UaV-hp7EWNJIhOEoR5xxxj83LsBv-MWO-Xs2tXmUDJ_0Iiey5xz1L81bx6cFJiXOJZ0IYOCKy7fI3wT9nt1EHtff1Epxd-eJso";
        $myToken = "cktHWimS-KM:APA91bHNloVT5Rur0EfTAvSQ7Nd4vxntnZ-eeTwAymXz19LR7nBDdLzmWiUodwAo1EDDD39Y7egSFAjgeaGtCbNa7JjEMAoOvyGvreGExUWIo_5nQmRTpb63ZPtK9wWNOuSM4R8kGlnV";
        $token = "da3BrHEY7P4:APA91bGTpPmKvY93usfosbO03S1E0CNg3Ok_I08hyErr384teKAPIbMi-e_3QYmmu1Hr4jJYlxkqePjPEkO5T4yaGE3PTpILbNBbvh5XbkIkhjnC_F5RG-yqLRXwXHzB8DhwVIm8ateJ";

        $data = [
            'tokens' => [$myToken],
            'profile' => 'mypush',
            'notification' => [
                'title' => $promotion->name,
                'message' => $promotion->description,
                'payload' => [
                    'url' => $promotion->url,
                    'extarnal_id' => $promotion->extarnal_id
                ]
            ]
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.ionic.io/push/notifications",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $newRelation = new PromotionClient();
            $newRelation->promotion_id = $promotion->extarnal_id;
            $newRelation->client_id = $user->id;

            if ($newRelation->save()) {

            }

            echo $response;
        }
    }

    public function postSendPush(Request $request)
    {
        //Get the user's phone id
        $phones = Client::where('proximi_id', '=', $request->proximi_visitor_id)->first();

        $promotion = Promotion::where('extarnal_id', '=', $request->promotion_id)->first();

        $curl = curl_init();
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJlYTE1Y2U5Mi1lOWY3LTQwZmYtODk5ZS04ODZmN2M5NmM4NTYifQ.Q5A_aO4TPf5s1EWbvsgaWHP84e-NGlu3alevmA3Q1Cw";

        $data = [
            'tokens' => [$phones->token],
            'profile' => 'mypush',
            'notification' => [
                'title' => $promotion->name,
                'message' => $promotion->description,
                'additionalData' => [
                    'other' => 'infomacion'
                ]
            ]
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.ionic.io/push/notifications",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $newRelation = new PromotionClient();
            $newRelation->promotion_id = $promotion->extarnal_id;
            $newRelation->client_id = $phones->id;

            if ($newRelation->save()) {

            }

            echo $response;
        }
    }

    /**
     *
     */
    public function postStorePromotion(Request $request)
    {
        $response = [];

        $relation = new PromotionClient();

        $relation->client_id = decrypt($request->user);
        $relation->promotion_id = $request->promotion_id;

        if (PromotionClient::where('client_id', '=', decrypt($request->user))->where('promotion_id', '=', $request->promotion_id)->get()->count() == 0) {
            if ($relation->save()) {
                $response = [
                    'status' => true
                ];
            } else {
                $response = [
                    'status' => false
                ];
            }
        } else {
            $response = [
                'status' => false
            ];
        }

        return response()->json($response);
    }

    /**
     *
     */
    public function postGetClientPromotion(Request $request)
    {
        $relation = PromotionClient::where('client_id', '=', decrypt($request->user))->where('status', '=', 1)->get();

        $promotions = [];

        $promoID = [];

        foreach ($relation as $item) {

            if (!in_array($item->promotion_id, $promoID)) {

                $pointer = Promotion::where('extarnal_id', '=', $item->promotion_id)->first();

                $promoID[] = $item->promotion_id;

                $data = [
                    'title' => $pointer->name,
                    'description' => $pointer->description,
                    'end_date' => $pointer->end_date,
                    'url' => $pointer->url,
                    'url_length' => (strlen(trim($pointer->url)) > 0) ? true : false,
                    'external_id' => $pointer->extarnal_id,
                    'promotion_type' => $pointer->promotion_type,
                    'business_name' => $pointer->business_name
                ];

                if ($pointer->attachment != null || $pointer->attachment != "") {
                    $data['attachment'] = URL::to('/').'/storage/uploads/'.$pointer->attachment;
                }

                $promotions[] = $data;

            }
        }

        $response = [
            'status' => true,
            'promotion' => $promotions,
            'count' => $relation->count(),
            'id' => decrypt($request->user)
        ];

        return response()->json($response);
    }


    public function postLabs(Request $request)
    {
        if (strlen(trim($request->variable)) > 0) {
            $labs = new Labs();

            $labs->variable = $request->variable;

            $labs->save();
        }
    }


    public function programmer()
    {
        $var = Carbon::now();

        $parse = Carbon::parse($var->year.'-'.$var->month.'-'.$var->day.' '.$var->hour.':'.$var->minute.':00');


        $pushes = Programmer::where('send', $parse)->where('status', 0)->get();

        if ($pushes->count() > 0) {

            foreach ($pushes as $push) {

                $clients = Client::where('token', '!=', '')->get();

                if ($clients->count() > 0) {
                    define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                    $registrationIds = [];

                    foreach($clients as $item) {
                        $registrationIds[] = $item->token;
                    }

                    //Message
                    $msg = [
                        'message' => $push->description,
                        'title' => $push->title,
                        'subtitle' => $push->description,
                        'tickerText' => $push->description,
                        'vibrate'   => 1,
                        'sound'     => 1,
                        'largeIcon' => 'large_icon',
                        'smallIcon' => 'small_icon',
                        'payload' => [
                            'pushType' => 7,
                            'title' => $push->title,
                            'description' => $push->description,
                            'source' => $push->url
                        ]
                    ];

                    //Headers
                    $headers = [
                        'Authorization: key=' . API_ACCESS_KEY,
                        'Content-Type: application/json'
                    ];

                    //Fields
                    $fields = [
                        'registration_ids'  => ['cN81PLcnXog:APA91bEDnTNrBQDQs1_n2Q4fK86hbWR-QevQWfwaXRFst87hqBm8zfAoG6bLKglLrfR3VE7ifYkshzo8UqkWXAZAJfasr5crcu1-dGiQRk9cnJLtyohM5OOaOPpKE115cVRB9uNJ7eBw'],
                        'data'          => $msg
                    ];

                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                    $result = curl_exec($ch );
                    curl_close( $ch );
                    $inner = json_decode($result,true);

                    if ($inner['success'] > 0) {
                        echo 'Se ha enviado la push '.$push->id;
                    } else {
                        echo 'No se ha podido enviar la push '.$push->id;
                    }
                } else {
                    echo 'No hay clientes que mandar.';
                }

            }

        } else {
            return 'No hay nada que mandar.';
        }
    }
}
