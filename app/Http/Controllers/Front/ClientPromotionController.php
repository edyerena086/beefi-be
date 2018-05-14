<?php

namespace MetodikaTI\Http\Controllers\Front;

use Auth;
use Carbon\Carbon;
use MetodikaTI\User;
use MetodikaTI\Track;
use MetodikaTI\Client;
use MetodikaTI\Company;
use Illuminate\Http\Request;
use MetodikaTI\ClientPromotion;
use Illuminate\Support\Facades\Storage;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\Front\ClientPromotion\StoreRequest;

class ClientPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$clientPromotions = ClientPromotion::where('user_id', Auth::user()->id)->orderBy('created_at')->get();
        
        $company = Company::where('user_id', Auth::user()->id)->first();

        return view('front.promotion.index', ['company' => $company]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::where('user_id', Auth::user()->id)->first();

        return view('front.promotion.create', ['company' => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $response;

        $clientPromotion = new ClientPromotion;

        //$clientPromotion->user_id = 10;
        $clientPromotion->user_id = Auth::user()->id;
        $clientPromotion->end_date = $request->fechaDeExpiracion;
        $clientPromotion->text = $request->textoDePromocion;
        $clientPromotion->gender = $request->genero;
        $clientPromotion->total_cupons = $request->numeroDeCupones;
        $clientPromotion->total_tables = $request->numeroDeMesas;
        $clientPromotion->url = $request->url;
        $clientPromotion->bwallet = ($request->bwallet == 1) ? 0 : 1;
        $clientPromotion->status = 0;

        //Save image
        $imageName = Carbon::now()->timestamp.".".$request->file('icono')->getClientOriginalExtension();

        if (Storage::disk('public')->putFileAs('uploads', $request->file('icono'), $imageName)) {
            $clientPromotion->icon = $imageName;
        } 
        //End store file
        

        if ($clientPromotion->save()) {
            $response = [
                'status' => true,
                'message' => 'Se ha guarado con éxito el cupón'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No se ha podido guardar el cupón'
            ];
        }

        return response()->json($response);
    }


    /**
     * [sendPush description]
     * @param  StoreRequest $request [description]
     * @return [type]                [description]
     */
    public function sendPush(StoreRequest $request)
    {
        $response;

        $company = Company::where('user_id', Auth::user()->id)->first();

        if ($company == null) {
            $response = [
                'status' => false,
                'message' => 'No se pudo guardar el beneficio x0002'
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
            $pushTokens = [];

            foreach ($track as $item) {
                $user = User::find($item->user_id);

                if (!in_array($item->user_id, $inArray)) {

                    $mtkClient = Client::where('user_id', $item->user_id)->first();

                    if ($mtkClient->token != null) {
                        $pushTokens[] = $mtkClient->token;
                    }

                    $inArray[] = $item->user_id;
                    $total++;

                    if ($user->client->gender_id == 1) {
                        $man++;
                    } else {
                        $woman++;
                    }


                }
                
            }

            $isFinalUser;

            switch ($request->genero) {
                case 1:
                    $isFinalUser = ($woman > 0) ? true : false;
                    break;

                case 2:
                    $isFinalUser = ($man > 0) ? true : false;
                    break;

                case 3:
                    $isFinalUser = ($total > 0) ? true : false;
                    break;
            }


            if (!$isFinalUser) {
                $response = [
                    'status' => false,
                    'message' => 'No hay clientes conectados en este momento'
                ];
            } else {




                $clientPromotion = new ClientPromotion;

                //$clientPromotion->user_id = 10;
                $clientPromotion->user_id = Auth::user()->id;
                $clientPromotion->end_date = $request->fechaDeExpiracion;
                $clientPromotion->text = $request->textoDePromocion;
                $clientPromotion->gender = $request->genero;
                $clientPromotion->total_cupons = $request->numeroDeCupones;
                $clientPromotion->total_tables = $request->numeroDeMesas;
                $clientPromotion->url = $request->url;
                $clientPromotion->bwallet = ($request->bwallet == 1) ? 0 : 1;
                $clientPromotion->status = 1;

                //Save image
                $imageName = Carbon::now()->timestamp.".".$request->file('icono')->getClientOriginalExtension();

                if (Storage::disk('public')->putFileAs('uploads', $request->file('icono'), $imageName)) {
                    $clientPromotion->icon = $imageName;
                } 
                //End store file
                

                if ($clientPromotion->save()) {
                    /*$response = [
                        'status' => true,
                        'message' => 'Se ha guarado con éxito el cupón',
                        'tokens' => $pushTokens
                    ];*/




                    //Send push notification
                    define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                    //Message
                    $msg = [
                        'message' => "¡Tenemos un beneficio especial para ti!",
                        'title' => "Bee-Fi",
                        'subtitle' => "¡Tenemos un beneficio especial para ti!",
                        'tickerText' => "¡Tenemos un beneficio especial para ti!",
                        'vibrate'   => 1,
                        'sound'     => 1,
                        //'largeIcon' => 'large_icon',
                        //'smallIcon' => 'small_icon',
                        'icon' => 'drawable-hdpi-icon',
                        'payload' => [
                            'pushType' => 3,
                            'promoId' => $clientPromotion->id
                        ]
                    ];

                    //Headers
                    $headers = [
                        'Authorization: key=' . API_ACCESS_KEY,
                        'Content-Type: application/json'
                    ];

                    //Fields
                    $fields = [
                        'registration_ids'  => $pushTokens,
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
                        $response = [
                            'status' => true,
                            'message' => 'Se ha enviado con éxito la notificación push'
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'message' => 'No se ha podido enviar la notificación push',
                            'data' => $result
                        ];
                    }




                } else {
                    $response = [
                        'status' => false,
                        'message' => 'No se ha podido guardar el cupón'
                    ];
                }

                return response()->json($response);





            }


        }


        return response()->json($response);

        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $cupon = ClientPromotion::find($id);

        $company = Company::where('user_id', Auth::user()->id)->first();

        return view('front.promotion.detail', ['cupon' => $cupon, 'company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response;

        $clientPromotion = ClientPromotion::find($id);

        if ($clientPromotion == null) {
            $response = [
                'status' => false,
                'message' => 'La promoción a eliminar no existe'
            ];
        } else {
            if ($clientPromotion->delete()) {
                $response = [
                    'status' => true,
                    'message' => "Se ha eliminado con éxito la promoción"
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => "No se ha podido eliminar la promoción"
                ];
            }
        }

        return response()->json($response);
    }

    /**
     * [history description]
     * @return [type] [description]
     */
    public function history()
    {
        $cupons = ClientPromotion::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->orderBy('end_date', 'ASC')->get();

        $company = Company::where('user_id', Auth::user()->id)->first();

        return view('front.promotion.history', ['cupons' => $cupons, 'company' => $company]);
    }
}
