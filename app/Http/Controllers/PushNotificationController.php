<?php

namespace MetodikaTI\Http\Controllers;

use MetodikaTI\Poll;
use MetodikaTI\User;
use MetodikaTI\Client;
use MetodikaTI\Company;
use MetodikaTI\Category;
use MetodikaTI\PushNotification;
use MetodikaTI\ProgrammerCategory;
use MetodikaTI\Programmer;
use MetodikaTI\FinalUserPromotion;
use Illuminate\Http\Request;
use MetodikaTI\Http\Requests\PushNotification\StoreRequest;
use MetodikaTI\Http\Requests\PushNotification\StoreSpecificRequest;
use MetodikaTI\Http\Requests\PushNotification\ProgrammerRequest;

class PushNotificationController extends Controller
{
	public function index()
	{
		$pushes = PushNotification::orderBy('created_at', 'DESC')->get();

		return view('push.index', ['pushes' => $pushes, 'centinel' => 1, 'counter' => 0]);
	}

    /**
     * [create description]
     * @return [type] [description]
     */
	public function create()
	{
        $categories = Category::all();

		return view('push.create', ['categories' => $categories]);
	}

    public function store(StoreRequest $request)
    {
    	$response;

    	//Get all users by gender
    	//$clients = Client::where('gender_id', $request->genero)->where('token', '!=', '')->get();
        $clients = Client::where('token', '!=', '')->get();

    	if ($clients->count() > 0) {
    		define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

    		$registrationIds = [];

    		foreach($clients as $item) {
    			$registrationIds[] = $item->token;
    		}

    		//Message
    		$msg = [
    			'message' => $request->mensaje,
    			'title' => $request->titulo,
    			'subtitle' => $request->mensaje,
    			'tickerText' => $request->mensaje,
    			'vibrate'	=> 1,
				'sound'		=> 1,
				'largeIcon'	=> 'large_icon',
				'smallIcon'	=> 'small_icon',
                'payload' => [
                    'pushType' => 7,
                    'title' => $request->titulo,
                    'description' => $request->mesanje,
                    'source' => $request->recursoWeb
                ]
    		];

    		//Headers
    		$headers = [
    			'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
    		];

    		//Fields
    		$fields = [
    			'registration_ids' 	=> ['cN81PLcnXog:APA91bEDnTNrBQDQs1_n2Q4fK86hbWR-QevQWfwaXRFst87hqBm8zfAoG6bLKglLrfR3VE7ifYkshzo8UqkWXAZAJfasr5crcu1-dGiQRk9cnJLtyohM5OOaOPpKE115cVRB9uNJ7eBw'],
				'data'			=> $msg
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

			$record = new PushNotification();
			$record->title = $request->titulo;
			$record->message = $request->mensaje;
			$record->gender = 0;
            $record->url = $request->recursoWeb;

			if ($inner['success'] > 0) {
				$record->status = 1;

				$response = [
					'status' => true,
					'message' => 'Se ha enviado con éxito la notificación push',
					'data' => $registrationIds,
                    'gender' => $request->genero
				];
			} else {
				$record->status = 2;

				$response =[
					'status' => false,
					'message' => 'No se ha podido enviar la notificación',
					'data' => $registrationIds
				];
			}

			$record->save();
     	} else {
     		$response =[
				'status' => false,
				'message' => 'No hay a quien enviarle la notificación'
			];
     	}

     	return response()->json($response);
    }

    public function threeDays(Request $request)
    {
        $response;

        $user = User::find(decrypt($request->user_id));

        if ($user != null) {
            $client = Client::where('user_id', $user->id)->first();

            if ($client != null) {


                //Send push notification
                    define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                    $registrationIds = [$client->token];

                    //Message
                    /*$msg = [
                        'message' => $pushGet->message,
                        'title' => $pushGet->title,
                        'subtitle' => $pushGet->message,
                        'tickerText' => $pushGet->message,
                        'vibrate'   => 1,
                        'sound'     => 1,
                        'largeIcon' => 'large_icon',
                        'smallIcon' => 'small_icon'
                    ];*/


                    $msg = [
                        'message' => "Aun tienes un beneficio disponible por 3 días en MetodikaTI",
                        'title' => 'Beneficio vigente',
                        'subtitle' => "Aun tienes un beneficio disponible por 3 días en MetodikaTI",
                        'tickerText' => "Aun tienes un beneficio disponible por 3 días en MetodikaTI",
                        'vibrate'   => 1,
                        'sound'     => 1,
                        'largeIcon' => 'large_icon',
                        'smallIcon' => 'small_icon',
                        'payload' => [
                            'pushType' => 6
                        ]
                    ];

                    //Headers
                    $headers = [
                        'Authorization: key=' . API_ACCESS_KEY,
                        'Content-Type: application/json'
                    ];

                    //Fields
                    $fields = [
                        'registration_ids'  => $registrationIds,
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
                    'error' => '002'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'error' => '003'
            ];
        }

        return response()->json($response);
    }


    public function oneDays(Request $request)
    {
        $response;

        $user = User::find(decrypt($request->user_id));

        if ($user != null) {
            $client = Client::where('user_id', $user->id)->first();

            if ($client != null) {


                //Send push notification
                    define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                    $registrationIds = [$client->token];

                    //Message
                    /*$msg = [
                        'message' => $pushGet->message,
                        'title' => $pushGet->title,
                        'subtitle' => $pushGet->message,
                        'tickerText' => $pushGet->message,
                        'vibrate'   => 1,
                        'sound'     => 1,
                        'largeIcon' => 'large_icon',
                        'smallIcon' => 'small_icon'
                    ];*/


                    $msg = [
                        'message' => "Aun tienes un beneficio vence el día de mañana en MetodikaTI",
                        'title' => 'Beneficio vigente',
                        'subtitle' => "Aun tienes un beneficio vence el día de mañana en MetodikaTI",
                        'tickerText' => "Aun tienes un beneficio vence el día de mañana en MetodikaTI",
                        'vibrate'   => 1,
                        'sound'     => 1,
                        'largeIcon' => 'large_icon',
                        'smallIcon' => 'small_icon',
                        'payload' => [
                            'pushType' => 6
                        ]
                    ];

                    //Headers
                    $headers = [
                        'Authorization: key=' . API_ACCESS_KEY,
                        'Content-Type: application/json'
                    ];

                    //Fields
                    $fields = [
                        'registration_ids'  => $registrationIds,
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
                    'error' => '002'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'error' => '003'
            ];
        }

        return response()->json($response);
    }

    public function specific(Request $request)
    {
    	$response;

    	$user = User::find(decrypt($request->user_id));

    	if ($user == null) {
    		$response = [
    			'status' => false,
    			'message' => 'El usuario ingresado no existe en el sistema',
                'user' => decrypt('eyJpdiI6ImN0UEFpNUFLdTlhUUFudGkwMGpNVVE9PSIsInZhbHVlIjoiczAyOWlIUlwvU0F2bzVWR3M5c3o5YkE9PSIsIm1hYyI6ImM1NTA3N2NkNjE3YTJhNDkyNTIzNTY3Y2QzMzNiYzU2MjQ0OGQ2NDY2ZWVkNTRlNTMyYjRiZDNhMzhkOTdkNDEifQ==')
    		];
    	} else {
    		$client = Client::where('user_id', $user->id)->first();

    		if ($client == null) {
    			$response = [
	    			'status' => false,
	    			'message' => 'El usuario ingresado no existe en el sistema'
	    		];
    		} else if ($client->token == '') {
    			$response = [
	    			'status' => false,
	    			'message' => 'El usuario no posee un token'
	    		];
    		} else {
    			

	    		$pushGet = PushNotification::where('status', 4)->first();

	    		if ($pushGet != null) {
	    			//Send push notification
	    			define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

		    		$registrationIds = [$client->token];

		    		//Message
		    		$msg = [
		    			'message' => $pushGet->message,
		    			'title' => $pushGet->title,
		    			'subtitle' => $pushGet->message,
		    			'tickerText' => $pushGet->message,
		    			'vibrate'	=> 1,
						'sound'		=> 1,
						'largeIcon'	=> 'large_icon',
						'smallIcon'	=> 'small_icon'
		    		];

		    		//Headers
		    		$headers = [
		    			'Authorization: key=' . API_ACCESS_KEY,
						'Content-Type: application/json'
		    		];

		    		//Fields
		    		$fields = [
		    			'registration_ids' 	=> $registrationIds,
						'data'			=> $msg
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
	    				'message' => 'No se ha podido enviar la notificación push',
                        'push' => $pushGet
	    			];
	    		}
    		}
    	}

    	return response()->json($response);
    }

    /**
     * [storeSpecific description]
     * @param  StoreSpecificRequest $request [description]
     * @return [type]                        [description]
     */
    public function storeSpecific(StoreSpecificRequest $request)
    {
    	$response;

    	$push = new PushNotification();
    	$push->title = $request->titulo;
    	$push->message = $request->mensaje;
    	$push->gender = 1;
    	$push->status = 4;

    	if ($push->save()) {
    		$response = [
    			'status' => true,
    			'message' => 'Se ha guardado con éxito la push notificación'
    		];
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'No se ha podido guardar la push'
    		];
    	}

    	return response()->json($response);
    }

    public function  indexSpecific()
    {
    	$push = PushNotification::where('status', 4)->get();//PushNotification::where('status', 4)->first();

    	return view('push.index-specific', ['pushes' => $push, 'centinel' => 1, 'counter' => ($push->count() > 0) ? 1 : 0]);
    }

    public function createSpecific()
    {
    	return view('push.create-specific');
    }

    public function delete($id)
    {
    	$response;

    	$push = PushNotification::find(base64_decode($id));

    	if ($push == null) {
    		$response = [
    			'status' => false,
    			'message' => 'No eixste la notificación.'
    		];
    	} else {
    		if ($push->delete()) {
    			$response = [
    				'status' => true,
    				'message' => 'Se ha eliminado con éxito la notificación'
    			];
    		} else {
    			$response = [
    				'status' => false,
    				'message' => 'No se ha podido eliminar la notificación'
    			];
    		}
    	}

    	return response()->json($response);
    }

    public function beefispot(Request $request)
    {
        $response;

        $user = User::find(decrypt($request->user_id));

        if ($user != null) {
            $client = Client::where('user_id', $user->id)->first();

            if ($client != null && $client->token != "") {


                //Send push notification
                    define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                    $registrationIds = [$client->token];

                    //Message
                    $msg = [
                        'message' => "Hay una red Bee-Fi cerca de ti, conectate y navega gratis.",
                        'title' => "Bee-Fi",
                        'subtitle' => "Hay una red Bee-Fi cerca de ti, conectate y navega gratis.",
                        'tickerText' => "Hay una red Bee-Fi cerca de ti, conectate y navega gratis.",
                        'vibrate'   => 1,
                        'sound'     => 1,
                        //'largeIcon' => 'large_icon',
                        //'smallIcon' => 'small_icon',
                        'icon' => 'drawable-hdpi-icon',
                        'payload' => [
                            'pushType' => 5
                        ]
                    ];

                    //Headers
                    $headers = [
                        'Authorization: key=' . API_ACCESS_KEY,
                        'Content-Type: application/json'
                    ];

                    //Fields
                    $fields = [
                        'registration_ids'  => $registrationIds,
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


            }
        } else {
            $response = [
                'status' => false,
                'message' => 'El usuario ingresado no éxiste.'
            ];
        }

        return response()->json($response);
    }

    public function toLeavePush(Request $request)
    {
        $response;

        //$user = User::find(decrypt($request->user_id));
        $client = Client::where('proximi_id', $request->text)->first();

        if ($client != null) {
            //$client = Client::where('user_id', $user->id)->first();

            if ($client != null && $client->token != "") {
                $company = Company::where('name', strtolower($request->geofence))->first();

                if ($company != null) {
                    $poll = Poll::where('client_id', $company->id)->first();

                    if ($poll != null) {
                        define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                        $registrationIds = [$client->token];

                        //Message
                        $msg = [
                            'message' => $poll->description,
                            'title' => $poll->title,
                            'subtitle' => $poll->description,
                            'tickerText' => $poll->description,
                            'vibrate'   => 1,
                            'sound'     => 1,
                            //'largeIcon' => 'large_icon',
                            //'smallIcon' => 'small_icon',
                            'icon' => 'drawable-hdpi-icon',
                            'payload' => [
                                'pushType' => 7,
                                'title' => $poll->title,
                                'description' => $poll->description,
                                'source' => $poll->url
                            ]
                        ];

                        //Headers
                        $headers = [
                            'Authorization: key=' . API_ACCESS_KEY,
                            'Content-Type: application/json'
                        ];

                        //Fields
                        $fields = [
                            'registration_ids'  => $registrationIds,
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
                            'message' => 'No hay nada que enviar.'
                        ];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'No existe la geocerca.'
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'El usuario ingresado no éxiste.'
            ];
        }

        return response()->json($response);
    }

    public function toEnterPush(Request $request)
    {
        $response;

        $user = User::find(decrypt($request->user_id));

        if ($user != null) {
            $client = Client::where('user_id', $user->id)->first();

            if ($client != null && $client->token != "") {


                //Send push notification
                    define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                    $registrationIds = [$client->token];

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
                            'pushType' => 4
                        ]
                    ];

                    //Headers
                    $headers = [
                        'Authorization: key=' . API_ACCESS_KEY,
                        'Content-Type: application/json'
                    ];

                    //Fields
                    $fields = [
                        'registration_ids'  => $registrationIds,
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


            }
        } else {
            $response = [
                'status' => false,
                'message' => 'El usuario ingresado no éxiste.'
            ];
        }

        return response()->json($response);
    }


    public function typeSeven()
    {
        //Send push notification
                    define('API_ACCESS_KEY', 'AAAA96jAMpI:APA91bG29LL-rozFQDqaeW3BDJieg5YlKNCz8EKXL2JxMUvMwpkufrhlcZpPVtnpmfpUSx7RAp9hsd73Ldx1bJ_8SMRRrbS_0tAfCqhvZNebxLJKgXMHe6fhJRaXJ6YMuGoGAO72tQlM');

                    //Message
                    $msg = [
                        'message' => "¡Tenemos un beneficio especial para ti 7!",
                        'title' => "Bee-Fi",
                        'subtitle' => "¡Tenemos un beneficio especial para ti 7!",
                        'tickerText' => "¡Tenemos un beneficio especial para ti 7!",
                        'vibrate'   => 1,
                        'sound'     => 1,
                        //'largeIcon' => 'large_icon',
                        //'smallIcon' => 'small_icon',
                        'icon' => 'drawable-hdpi-icon',
                        'payload' => [
                            'pushType' => 7,
                            'title' => 'Esta es una prueba',
                            'description' => 'Esta es la prueba de descripción',
                            'source' => 'http://www.metodika.mx'
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

                    return response()->json($response);
    }

    public function programmer()
    {
        $data = Programmer::orderBy('send', 'DESC')->get();

        return view('programmer.index', ['data' => $data, 'centinel' => 1]);
    }

    public function createProgrammer()
    {
        $categories = Category::all();

        return view('programmer.create', ['categories' => $categories]);
    }

    public function saveProgrammer(Request $request)
    {
        $response;

        $programmer = new Programmer();


        $programmer->title = $request->titulo;
        $programmer->description = $request->mensaje;
        $programmer->url = $request->recursoWeb;
        $programmer->send = $request->envio;

        if ($programmer->save()) {
            if ($request->has('categoria')) {
                foreach ($request->get('categoria') as $key => $value) {
                        $category = new ProgrammerCategory();

                        $category->programmer_id = $programmer->id;
                        $category->category_id = $value;

                        $category->save();
                    }
            }

            $response = [
                'status' => true,
                'message' => 'Se ha agendado con éxito el envio de la notificación push.'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No se ha podido agendar la notificación push.'
            ];
        }

        return response()->json($response);
    }

    public function deleteProgrammer($id)
    {
        $response;

        $programmer = Programmer::find(base64_decode($id));

        if ($programmer == null) {
            $response = [
                'status' => false,
                'message' => 'La notificación push a eliminar no existe.'
            ];
        } else {
            if ($programmer->delete()) {
                $response = [
                    'status' => true,
                    'message' => 'Se ha eliminado la notificación push.'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No se ha eliminado la notificación push.'
                ];
            }
        }

        return response()->json($response);
    }


}
