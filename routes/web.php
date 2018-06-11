<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AccountController@home');

Route::get('edgar', function () {
	//return bcrypt('Mku8njdro0@');
    //return encrypt(48);
});

Route::get('testy', 'PushNotificationController@typeSeven');

Route::get('artisan', function () {
    Artisan::call('storage:link');
});

Route::post('send-general', 'PushNotificationController@store');


Route::group(['prefix' => 'account'], function () {
    Route::post('login', 'AccountController@login');

    Route::get('logout', 'AccountController@logout');
});

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@getHome');

    Route::get('create', 'DashboardController@getCreate');

    Route::post('store', 'DashboardController@postStore');

    Route::get('delete/{id}', 'DashboardController@getDelete');

    Route::get('edit/{id}', 'DashboardController@getEdit');

    Route::post('update/{id}', 'DashboardController@postUpdate');


    Route::group(['prefix' => 'polls'], function () {
        Route::get('/', 'PollController@index');

        Route::get('create',  'PollController@create');
        Route::post('store', 'PollController@store');

        Route::get('delete/{id}', 'PollController@delete');
    });


    Route::group(['prefix' => 'enter'], function () {
        Route::get('/', 'EnterController@index');

        Route::get('create',  'EnterController@create');
        Route::post('store', 'EnterController@store');

        Route::get('delete/{id}', 'EnterController@delete');
    });



    Route::group(['prefix' => 'network'], function () {
        Route::get('/', 'NetworkPasswordController@index');

        Route::get('edit/{id}', 'NetworkPasswordController@edit');
        Route::post('update/{id}', 'NetworkPasswordController@update');
    });



    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index');

        Route::get('create', 'CategoryController@create');
        Route::post('store', 'CategoryController@store');

        Route::get('edit/{id}', 'CategoryController@edit');
        Route::post('update/{id}', 'CategoryController@update');

        Route::get('delete/{id}', 'CategoryController@destroy');
    });



    /**
     * --------------------------------------------------------------------------------------
     * Beefispot Routes
     * --------------------------------------------------------------------------------------
     * 
     */
    Route::group(['prefix' => 'beefispot'], function () {
        Route::get('/', 'BeefispotController@index');

    	Route::post('store', 'BeefispotController@store');
        Route::get('create', 'BeefispotController@create');

        Route::get('edit/{id}', 'BeefispotController@edit');
    	Route::post('update/{id}', 'BeefispotController@update');

    	Route::get('delete/{id}', 'BeefispotController@delete');
    });

    /**
     * --------------------------------------------------------------------------------------
     * Sponsor Routes
     * --------------------------------------------------------------------------------------
     * 
     */
    Route::group(['prefix' => 'sponsor'], function () {
        Route::get('/', 'SponsorController@index');

        Route::post('store', 'SponsorController@store');
        Route::get('create', 'SponsorController@create');

        /*Route::get('edit/{id}', 'BeefispotController@edit');*/
        Route::post('update/{id}', 'SponsorController@update');

        Route::get('delete/{id}', 'SponsorController@delete');
    });


    Route::group(['prefix' => 'push-notifications'], function () {
        Route::get('/', 'PushNotificationController@index');
        Route::get('specific', 'PushNotificationController@indexSpecific');

        Route::post('send-general', 'PushNotificationController@store');
        Route::get('create', 'PushNotificationController@create');

        Route::get('create-specific', 'PushNotificationController@createSpecific');
        Route::post('store-specific', 'PushNotificationController@storeSpecific');

        Route::get('delete/{id}', 'PushNotificationController@delete');

        Route::post('send-specific', 'PushNotificationController@specific');

        Route::group(['prefix' => 'programmer'], function () {
            Route::get('/', 'PushNotificationController@programmer');

            Route::get('create', 'PushNotificationController@createProgrammer');
            Route::post('store', 'PushNotificationController@saveProgrammer');

            Route::get('delete/{id}', 'PushNotificationController@deleteProgrammer');
        });
    });

    /**
     * --------------------------------------------------------------------------------------
     * Company Routes
     * --------------------------------------------------------------------------------------
     * 
     */
    Route::group(['prefix' => 'company'], function () {
        Route::get('/', 'CompanyController@index');

        Route::get('create', 'CompanyController@create');
        Route::post('store', 'CompanyController@store');

        Route::get('edit/{id}', 'CompanyController@edit');
        Route::post('update/{id}', 'CompanyController@update');

        Route::get('delete/{id}', 'CompanyController@delete');
    });

    /**
     * --------------------------------------------------------------------------------------
     * Promotion In Place Routes
     * --------------------------------------------------------------------------------------
     * 
     */
    Route::group(['prefix' => 'promotion-place'], function () {
        Route::get('/', 'PromotionInPlaceController@index');

        Route::post('store', 'PromotionInPlaceController@store');
        Route::get('create', 'PromotionInPlaceController@create');

        /*Route::get('edit/{id}', 'BeefispotController@edit');*/
        Route::post('update/{id}', 'SponsorController@update');

        Route::get('delete/{id}', 'PromotionInPlaceController@delete');

        Route::group(['prefix' => 'late'], function () {
            Route::get('/', 'PromotionInPlaceController@indexLate');

            Route::post('store', 'PromotionInPlaceController@storeLate');
            Route::get('create', 'PromotionInPlaceController@createLate');

            Route::get('delete/{id}', 'PromotionInPlaceController@delete');
        });
    });
});


/**
* --------------------------------------------------------------------------------------
* Clients Routes
* --------------------------------------------------------------------------------------
* 
*/
Route::group(['prefix' => 'client'], function () {

    /**
     * --------------------------------------------------------------------------------------
     * Beefispot Routes
     * --------------------------------------------------------------------------------------
     * 
     */
    Route::get('/', 'Front\AccountController@index');

    Route::post('/', 'Front\AccountController@login');

    Route::get('password', 'Front\AccountController@passwordRecovery');

    Route::post('password', 'Front\AccountController@passwordReset');
    

    /**
     * --------------------------------------------------------------------------------------
     * Client Promotion Routes
     * --------------------------------------------------------------------------------------
     * 
     */
    Route::group(['prefix' => 'promotions', 'middleware' => 'auth'], function () {
        Route::get('/', 'Front\ClientPromotionController@index');

        Route::get('create', 'Front\ClientPromotionController@create');
        Route::post('store', 'Front\ClientPromotionController@store');

        Route::post('send-push', 'Front\ClientPromotionController@sendPush');

        Route::get('detail/{id}', 'Front\ClientPromotionController@detail');

        Route::get('delete/{id}', 'Front\ClientPromotionController@destroy');

        Route::get('history', 'Front\ClientPromotionController@history');

    });

    /**
     * --------------------------------------------------------------------------------------
     * Track Routes
     * --------------------------------------------------------------------------------------
     * 
     */
    Route::group(['prefix' => 'track'], function () {
        Route::get('{id}', 'Front\TrackController@track');

        Route::post('/', 'WS\TrackController@track');
    });

});

Route::group(['prefix' => 'task'], function () {
    Route::get('last-day', 'TaskController@lastDay');
});