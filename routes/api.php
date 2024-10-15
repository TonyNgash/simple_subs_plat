<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\MailController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/testa", function(Request $request){
    return json_encode("you");
});

//add new websites
Route::post('/websites', [WebsiteController::class, 'store']);

//add posts to a website
Route::post('/websites/{website_id}/posts', [PostController::class, 'store']);

//create new users
Route::post('/subscribers',[SubscriberController::class, 'create']);

//make a user subscribe to a website
Route::post('/subscriber/{subscriber_id}/website/{website_id}',[SubscriberController::class, 'subscribe']);

//mail testa
// Route::post('/mail/',[MailController::class,'sendMail']);