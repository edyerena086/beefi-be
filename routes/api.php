<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'account'], function () {
    Route::post('login', 'WS\AccountController@postLogin');

    Route::post('new-client', 'WS\AccountController@postStoreNewClient');
    Route::post('store-profile', 'WS\AccountController@storeProfilePicture');

    Route::post('restore-password', 'WS\AccountController@postRestorePassword');

    Route::post('update/{id}', 'WS\AccountController@postUpdateClient');

    Route::post('update', 'WS\AccountController@update');

    Route::post('get-info', 'WS\AccountController@postGetInfo');

    Route::post('store-proximi-id', 'WS\AccountController@postStoreProximiToken');


});

Route::group(['prefix' => 'beefispot'], function () {
    Route::post('/', 'WS\BeefispotController@index');
});

Route::group(['prefix' => 'sponsor'], function () {
    Route::post('/', 'WS\SponsorController@index');
});

Route::group(['prefix' => 'promotion'], function () {
    Route::post('/', 'WS\PromotionInPlaceController@index');

    Route::post('opening-push', 'WS\PromotionInPlaceController@sendOpeningPush');

    Route::post('send-get-push', 'WS\PromotionInPlaceController@sendGetPush');

    Route::post('get-companies', 'WS\PromotionInPlaceController@companies');

    Route::post('save-on-bwallet', 'WS\PromotionInPlaceController@saveOnbwallet');

    Route::post('late', 'WS\PromotionInPlaceController@indexLate');

    Route::post('cupon-detail-bwallet', 'WS\PromotionInPlaceController@cuponDetailBwallet');

    Route::post('cupons-by-company', 'WS\PromotionInPlaceController@cuponsCompany');

    Route::post('get-benefit', 'WS\PromotionInPlaceController@getBenefit');
});

Route::post('network/password', 'WS\NetworkPasswordController@index');

Route::group(['prefix' => 'track'], function () {
    Route::post('beat', 'WS\TrackController@beat');

    Route::post('/', 'WS\TrackController@track');
});

Route::group(['prefix' => 'push'], function () {
    Route::post('send', 'WS\PushController@postSendPush');

    Route::post('send-push', 'WS\PushController@postSendFirstPush');

    Route::post('store-promotion', 'WS\PushController@postStorePromotion');

    Route::post('get-client-promotion', 'WS\PushController@postGetClientPromotion');

    Route::post('labs', 'WS\PushController@postLabs');

    Route::post('specific', 'PushNotificationController@specific');

    Route::post('beefispot', 'PushNotificationController@beefispot');

    Route::post('to-enter-net', 'PushNotificationController@toEnterPush');

    //Check push for las day
    Route::post('three-days', 'PushNotificationController@threeDays');

    Route::post('one-days', 'PushNotificationController@oneDays');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
