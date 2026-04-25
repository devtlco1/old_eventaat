<?php

use App\Http\Controllers\Api\V1\Admin\APIController;
use App\Http\Controllers\Api\V1\Admin\WebhookController;
use App\Http\Controllers\FcmController;
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    Route::post('loginNew', [APIController::class, 'loginNew']);
    Route::post('login', [APIController::class, 'login']);
    Route::post('registration', [APIController::class, 'Registration']);
    Route::get('getCityList', [APIController::class, 'getCityList']);
    Route::post('prepareLogin', [APIController::class, 'prepareLogin']);
    Route::post('webhook', [WebhookController::class, 'action']);
});
Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:sanctum']], function () {
    //Route::post('checkCode', [APIController::class, 'checkCode']);
    Route::get('getMyProfile', [APIController::class, 'getMyProfile']);
    Route::post('updateProfile', [APIController::class, 'updateProfile']);
    Route::post('logout', [APIController::class, 'logout']);
    //Stories
    Route::get('getStories', [APIController::class, 'getStories']);
    Route::post('createStory', [APIController::class, 'createStory']);
    Route::post('updateStory/{id}', [APIController::class, 'updateStory']);
    Route::post('deleteStory', [APIController::class, 'deleteStory']);
    //RestaurantList
    Route::post('getCityRestaurantList', [APIController::class, 'getCityRestaurantList']);
    Route::get('getRestaurantList', [APIController::class, 'getRestaurantList']);
    Route::post('getRestaurantDetails', [APIController::class, 'getRestaurantDetails']);
    // restaurant users start
    Route::get('getMyRestaurants', [APIController::class, 'getMyRestaurants']);
    //pages
    Route::get('getPages', [APIController::class, 'getPages']);
    //Offers
    Route::get('getOffers', [APIController::class, 'getOffers']);
    //Events
    Route::get('getEvents', [APIController::class, 'getEvents']);
    Route::post('getEventById', [APIController::class, 'getEventById']);
    Route::post('createAnEvent', [APIController::class, 'createAnEvent']);
    Route::post('updateAnEvent', [APIController::class, 'updateAnEvent']);
    Route::post('deleteAnEvent', [APIController::class, 'deleteAnEvent']);
    Route::get('getAttendEvents', [APIController::class, 'getAttendEvents']);
    Route::post('getAnEventBookings', [APIController::class, 'getAnEventBookings']);
    Route::post('getEventPendingBookings', [APIController::class, 'getAnEventWaitingBookings']);
    //Favorites
    Route::get('getFavorites', [APIController::class, 'getFavorites']);
    Route::post('AddOrRemoveFavorites', [APIController::class, 'toggleFavorite']);
    //Booking
    Route::get('getMyBookings', [APIController::class, 'getMyBookings']);
    Route::post('createBooking', [APIController::class, 'createBooking']);
    Route::post('updateBooking', [APIController::class, 'updateBooking']);
    Route::post('deleteBooking', [APIController::class, 'deleteBooking']);
    Route::post('acceptBooking', [APIController::class, 'acceptBooking']);
    Route::post('rejectBooking', [APIController::class, 'rejectBooking']);
    Route::post('reBooking', [APIController::class, 'reBooking']);
    Route::post('conformBooking', [APIController::class, 'ConformBooking']);
    //Filter
    Route::post('filter', [APIController::class, 'filter']);
    Route::get('getPrivacyAndfeature', [APIController::class, 'getPrivacyAndfeature']);




    //Restaurents
    Route::post('getAllBooking', [APIController::class, 'getAllBooking']);

    Route::post('send-fcm-notification', [FcmController::class, 'sendFcmNotification']);




//Route::post('changeMyName', [APIController::class, 'saveMyName']);
//Route::post('updateMyProfile', [APIController::class, 'updateMyProfile']);
//Route::get('getFeatures', [APIController::class, 'getFeatures']);
//Route::get('getPrivacyOptions', [APIController::class, 'getPrivacyOptions']);
// Route::post('getChainOffers', [APIController::class, 'getChainOffers']);
////Route::get('getMyChainRestaurants', [APIController::class, 'getMyChainRestaurants']);
//Route::get('getMyChainEvents', [APIController::class, 'getMyChainEvents']);
//Route::get('getMyOwnEvents', [APIController::class, 'getMyOwnEvents']);
});



Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Restaurents
    Route::apiResource('restaurents', 'RestaurentsApiController');
    Route::post('restaurents/media', 'RestaurentsApiController@storeMedia')->name('restaurents.storeMedia');

    // Events
    Route::post('events/media', 'EventsApiController@storeMedia')->name('events.storeMedia');
    Route::apiResource('events', 'EventsApiController');
    // Stories
    Route::post('stories/media', 'StoriesApiController@storeMedia')->name('stories.storeMedia');
    Route::apiResource('stories', 'StoriesApiController');
});





