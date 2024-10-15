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

Route::post('/websites', [WebsiteController::class, 'store']);
Route::post('/websites/{website_id}/posts', [PostController::class, 'store']);
Route::post('/subscribers',[SubscriberController::class, 'create']);
Route::post('/subscriber/{subscriber_id}/website/{website_id}',[SubscriberController::class, 'subscribe']);

Route::post('/mail/',[MailController::class,'sendMail']);