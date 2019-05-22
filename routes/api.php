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
header('Access-Control-Allow-Origin: *');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/tts/contexts','tts\\api\\ContextController@list');
Route::get('/tts/contexts/{id}','tts\\api\\ContextController@one');
Route::get('/placeman/places','placeman\\api\\PlaceController@listPlaces');
Route::get('/placeman/inactiveplaces','placeman\\api\\PlaceController@listInactivePlaces');
Route::get('/placeman/allplaces','placeman\\api\\PlaceController@listAllPlaces');
Route::get('/placeman/placeactivation/{branch_id}/{isActive}','placeman\\api\\PlaceController@changePlaceActivation');
Route::get('/placeman/provinces','placeman\\api\\PlaceController@listProvinces');
Route::get('/placeman/provinces/{Province_id}','placeman\\api\\PlaceController@listCities');
Route::post('/placeman/places/add','placeman\\api\\PlaceController@add');

Route::get('contactus/unit', 'contactus\\API\\unitController@list');
Route::get('contactus/subject', 'contactus\\API\\subjectController@list');
Route::get('contactus/degree', 'contactus\\API\\degreeController@list');
Route::get('contactus/degree/{id}', 'contactus\\API\\degreeController@get');
Route::get('contactus/subject/{id}', 'contactus\\API\\subjectController@get');
Route::get('contactus/unit/{id}', 'contactus\\API\\unitController@get');

Route::get('posts/post', 'posts\\API\\postController@list');
Route::get('posts/post/{id}', 'posts\\API\\postController@get');
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('details', 'API\UserController@details');
    Route::get('/placeman/branches/userinfo','placeman\\api\\PlaceController@getUserBranch');
    Route::post('/placeman/places/edit','placeman\\api\\PlaceController@edit');
    Route::get('/common/messages/{versionNumber}','common\\api\\MessageController@getMessages');
    Route::get('/financial/recharge/new','financial\\api\\RechargeController@newTransaction');
    Route::get('contactus/message/{id}', 'contactus\\API\\messageController@get');
    Route::put('contactus/message/{id}', 'contactus\\API\\messageController@update');
    Route::delete('contactus/message/{id}', 'contactus\\API\\messageController@delete');
    Route::get('contactus/message', 'contactus\\API\\messageController@list');
    Route::get('contactus/message/{id}', 'contactus\\API\\messageController@get');
    Route::put('contactus/message/{id}', 'contactus\\API\\messageController@update');
    Route::delete('contactus/message/{id}', 'contactus\\API\\messageController@delete');
    Route::get('contactus/message', 'contactus\\API\\messageController@list');
    Route::post('contactus/message/', 'contactus\\API\\messageController@add');

    Route::post('contactus/unit', 'contactus\\API\\unitController@add');
    Route::put('contactus/unit/{id}', 'contactus\\API\\unitController@update');
    Route::delete('contactus/unit/{id}', 'contactus\\API\\unitController@delete');

    Route::post('contactus/subject', 'contactus\\API\\subjectController@add');
    Route::put('contactus/subject/{id}', 'contactus\\API\\subjectController@update');
    Route::delete('contactus/subject/{id}', 'contactus\\API\\subjectController@delete');

    Route::post('contactus/degree', 'contactus\\API\\degreeController@add');
    Route::put('contactus/degree/{id}', 'contactus\\API\\degreeController@update');
    Route::delete('contactus/degree/{id}', 'contactus\\API\\degreeController@delete');

    Route::post('posts/post', 'posts\\API\\postController@add');
    Route::put('posts/post/{id}', 'posts\\API\\postController@update');
    Route::delete('posts/post/{id}', 'posts\\API\\postController@delete');


//------------------------------------------------------------------------------------------------------
    Route::post('sas/unit', 'sas\\API\\unitController@add');
    Route::put('sas/unit/{id}', 'sas\\API\\unitController@update');
    Route::delete('sas/unit/{id}', 'sas\\API\\unitController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/unit', 'sas\\API\\unitController@add');
    Route::put('sas/unit/{id}', 'sas\\API\\unitController@update');
    Route::delete('sas/unit/{id}', 'sas\\API\\unitController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/request', 'sas\\API\\requestController@add');
    Route::put('sas/request/approve/{id}', 'sas\\API\\requestController@setUserApproval');
    Route::put('sas/request/status/{id}', 'sas\\API\\requestController@setStatus');
    Route::put('sas/request/priority/{id}', 'sas\\API\\requestController@changePriority');
    Route::put('sas/request/message/{id}', 'sas\\API\\requestController@addMessage');
    Route::put('sas/request/unit/{id}', 'sas\\API\\requestController@sendToNext');
    Route::put('sas/request/{id}', 'sas\\API\\requestController@update');
    Route::delete('sas/request/{id}', 'sas\\API\\requestController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/request', 'sas\\API\\requestController@add');
    Route::put('sas/request/{id}', 'sas\\API\\requestController@update');
    Route::delete('sas/request/{id}', 'sas\\API\\requestController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/device', 'sas\\API\\deviceController@add');
    Route::put('sas/device/{id}', 'sas\\API\\deviceController@update');
    Route::delete('sas/device/{id}', 'sas\\API\\deviceController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/device', 'sas\\API\\deviceController@add');
    Route::put('sas/device/{id}', 'sas\\API\\deviceController@update');
    Route::delete('sas/device/{id}', 'sas\\API\\deviceController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/devicetype', 'sas\\API\\devicetypeController@add');
    Route::put('sas/devicetype/{id}', 'sas\\API\\devicetypeController@update');
    Route::delete('sas/devicetype/{id}', 'sas\\API\\devicetypeController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/devicetype', 'sas\\API\\devicetypeController@add');
    Route::put('sas/devicetype/{id}', 'sas\\API\\devicetypeController@update');
    Route::delete('sas/devicetype/{id}', 'sas\\API\\devicetypeController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/unitsequence', 'sas\\API\\unitsequenceController@add');
    Route::put('sas/unitsequence/{id}', 'sas\\API\\unitsequenceController@update');
    Route::delete('sas/unitsequence/{id}', 'sas\\API\\unitsequenceController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/unitsequence', 'sas\\API\\unitsequenceController@add');
    Route::put('sas/unitsequence/{id}', 'sas\\API\\unitsequenceController@update');
    Route::delete('sas/unitsequence/{id}', 'sas\\API\\unitsequenceController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/status', 'sas\\API\\statusController@add');
    Route::put('sas/status/{id}', 'sas\\API\\statusController@update');
    Route::delete('sas/status/{id}', 'sas\\API\\statusController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/status', 'sas\\API\\statusController@add');
    Route::put('sas/status/{id}', 'sas\\API\\statusController@update');
    Route::delete('sas/status/{id}', 'sas\\API\\statusController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requeststatustrack', 'sas\\API\\requeststatustrackController@add');
    Route::put('sas/requeststatustrack/{id}', 'sas\\API\\requeststatustrackController@update');
    Route::delete('sas/requeststatustrack/{id}', 'sas\\API\\requeststatustrackController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requeststatustrack', 'sas\\API\\requeststatustrackController@add');
    Route::put('sas/requeststatustrack/{id}', 'sas\\API\\requeststatustrackController@update');
    Route::delete('sas/requeststatustrack/{id}', 'sas\\API\\requeststatustrackController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requestunittrack', 'sas\\API\\requestunittrackController@add');
    Route::put('sas/requestunittrack/{id}', 'sas\\API\\requestunittrackController@update');
    Route::delete('sas/requestunittrack/{id}', 'sas\\API\\requestunittrackController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requestunittrack', 'sas\\API\\requestunittrackController@add');
    Route::put('sas/requestunittrack/{id}', 'sas\\API\\requestunittrackController@update');
    Route::delete('sas/requestunittrack/{id}', 'sas\\API\\requestunittrackController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requesttype', 'sas\\API\\requesttypeController@add');
    Route::put('sas/requesttype/{id}', 'sas\\API\\requesttypeController@update');
    Route::delete('sas/requesttype/{id}', 'sas\\API\\requesttypeController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requesttype', 'sas\\API\\requesttypeController@add');
    Route::put('sas/requesttype/{id}', 'sas\\API\\requesttypeController@update');
    Route::delete('sas/requesttype/{id}', 'sas\\API\\requesttypeController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requestmessage', 'sas\\API\\requestmessageController@add');
    Route::put('sas/requestmessage/{id}', 'sas\\API\\requestmessageController@update');
    Route::delete('sas/requestmessage/{id}', 'sas\\API\\requestmessageController@delete');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::post('sas/requestmessage', 'sas\\API\\requestmessageController@add');
    Route::put('sas/requestmessage/{id}', 'sas\\API\\requestmessageController@update');
    Route::delete('sas/requestmessage/{id}', 'sas\\API\\requestmessageController@delete');
//------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------
    Route::post('sas/unittype', 'sas\\API\\unittypeController@add');
    Route::put('sas/unittype/{id}', 'sas\\API\\unittypeController@update');
    Route::delete('sas/unittype/{id}', 'sas\\API\\unittypeController@delete');

//------------------------------------------------------------------------------------------------------
    Route::get('sas/unit', 'sas\\API\\unitController@list');
    Route::get('sas/unit/userunitinfo', 'sas\\API\\unitController@getUserUnitInfo');
    Route::get('sas/unit/{id}', 'sas\\API\\unitController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/unit', 'sas\\API\\unitController@list');
    Route::get('sas/unit/{id}', 'sas\\API\\unitController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/request', 'sas\\API\\requestController@list');
    Route::get('sas/request/currentstats', 'sas\\API\\requestController@getCurrentRequestsStats');
    Route::get('sas/request/inbox', 'sas\\API\\requestController@listInbox');
    Route::get('sas/request/outbox', 'sas\\API\\requestController@listOutBox');
    Route::get('sas/request/current', 'sas\\API\\requestController@listCurrentBox');
    Route::get('sas/request/approve', 'sas\\API\\requestController@listNeedToApproveBox');
    Route::get('sas/request/{id}', 'sas\\API\\requestController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/request', 'sas\\API\\requestController@list');
    Route::get('sas/request/{id}', 'sas\\API\\requestController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/device', 'sas\\API\\deviceController@list');
    Route::get('sas/device/{id}', 'sas\\API\\deviceController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/device', 'sas\\API\\deviceController@listUserDevices');
    Route::get('sas/device/all', 'sas\\API\\deviceController@list');
    Route::get('sas/device/{id}', 'sas\\API\\deviceController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/devicetype', 'sas\\API\\devicetypeController@list');
    Route::get('sas/devicetype/{id}', 'sas\\API\\devicetypeController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/devicetype', 'sas\\API\\devicetypeController@list');
    Route::get('sas/devicetype/{id}', 'sas\\API\\devicetypeController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/unitsequence', 'sas\\API\\unitsequenceController@list');
    Route::get('sas/unitsequence/userunits', 'sas\\API\\unitsequenceController@userunits');
    Route::get('sas/unitsequence/{id}', 'sas\\API\\unitsequenceController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/unitsequence', 'sas\\API\\unitsequenceController@list');
    Route::get('sas/unitsequence/{id}', 'sas\\API\\unitsequenceController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/status', 'sas\\API\\statusController@list');
    Route::get('sas/status/{id}', 'sas\\API\\statusController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/status', 'sas\\API\\statusController@list');
    Route::get('sas/status/{id}', 'sas\\API\\statusController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requeststatustrack', 'sas\\API\\requeststatustrackController@list');
    Route::get('sas/requeststatustrack/{id}', 'sas\\API\\requeststatustrackController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requeststatustrack', 'sas\\API\\requeststatustrackController@list');
    Route::get('sas/requeststatustrack/{id}', 'sas\\API\\requeststatustrackController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requestunittrack', 'sas\\API\\requestunittrackController@list');
    Route::get('sas/requestunittrack/{id}', 'sas\\API\\requestunittrackController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requestunittrack', 'sas\\API\\requestunittrackController@list');
    Route::get('sas/requestunittrack/{id}', 'sas\\API\\requestunittrackController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requesttype', 'sas\\API\\requesttypeController@list');
    Route::get('sas/requesttype/{id}', 'sas\\API\\requesttypeController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requesttype', 'sas\\API\\requesttypeController@list');
    Route::get('sas/requesttype/{id}', 'sas\\API\\requesttypeController@get');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requestmessage', 'sas\\API\\requestmessageController@list');
    Route::get('sas/requestmessage/{id}', 'sas\\API\\requestmessageController@get');
    Route::get('sas/request/message/{id}', 'sas\\API\\requestmessageController@getbyrequest');
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
    Route::get('sas/requestmessage', 'sas\\API\\requestmessageController@list');
    Route::get('sas/requestmessage/{id}', 'sas\\API\\requestmessageController@get');
//------------------------------------------------------------------------------------------------------
    Route::get('sas/unittype', 'sas\\API\\unittypeController@list');
    Route::get('sas/unittype/{id}', 'sas\\API\\unittypeController@get');
});

Route::get('/placeman/provinces/{Province_id}/{cityID}','placeman\\api\\PlaceController@listAreas');
Route::get('/placeman/branches/full/{branch_id}','placeman\\api\\PlaceController@getBranchFullInfo');
Route::get('/placeman/branches/{branch_id}','placeman\\api\\PlaceController@getBranch');
Route::get('/placeman/companies','placeman\\api\\PlaceController@listCompanies');

Route::post('users/login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::get('contactus/messagereceiver', 'contactus\\API\\messagereceiverController@list');
Route::post('contactus/messagereceiver', 'contactus\\API\\messagereceiverController@add');
Route::get('contactus/messagereceiver/{id}', 'contactus\\API\\messagereceiverController@get');
Route::put('contactus/messagereceiver/{id}', 'contactus\\API\\messagereceiverController@update');
Route::delete('contactus/messagereceiver/{id}', 'contactus\\API\\messagereceiverController@delete');
Route::get('contactus/messagereceiver', 'contactus\\API\\messagereceiverController@list');
Route::post('contactus/messagereceiver', 'contactus\\API\\messagereceiverController@add');
Route::get('contactus/messagereceiver/{id}', 'contactus\\API\\messagereceiverController@get');
Route::put('contactus/messagereceiver/{id}', 'contactus\\API\\messagereceiverController@update');
Route::delete('contactus/messagereceiver/{id}', 'contactus\\API\\messagereceiverController@delete');
//Route::post('contactus/message/{id}', 'contactus\\API\\messageController@add');
Route::get('contactus/message/find/{id}', 'contactus\\API\\messageController@Find');
Route::post('contactus/message', 'contactus\\API\\messageController@add');