<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    //
    public function create(Request $request){
        //validate the incoming user data
        $validator = Validator::make($request->all(), [
            'email'=>'required|email|unique:subscribers,email',
            'fname'=>'required|string|max:255',
            'lname'=>'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //create a new user
        $subscriber = Subscriber::create([
            'email' => $request->email,
            'fname' => $request->fname,
            'lname' => $request->lname,
        ]);

        //return the created user in the response
        return response()->json([
            'status' => 'success',
            'data' => $subscriber
        ], 201);
    }

    public function subscribe(Request $request, $subscriber_id, $website_id){
        //check if the subscriber exists
        $subscriber = Subscriber::find($subscriber_id);

        if(!$subscriber){
            return response()->json([
                'status' => 'error',
                'message' => 'Subscriber not found'
            ], 404);
        }
        
        //check if the website exists
        $website = Website::find($website_id);

        if(!$website){
            return response()->json([
                'status' => 'error',
                'message' => 'Website Not Found'
            ], 404);
        }

        //check if the subscriber is already subscribed to this website
        if($subscriber->websites()->where('website_id',$website_id)->exists()){
            return response()->json([
                'status'=>'error',
                'message'=>'Subscriber is already subscribed to this website'
            ], 409);
        }

        //subscribe the user to the website
        $subscriber->websites()->attach($website_id);
        // $subscriber->save();

        //return the updated subscriber in the response
        return response()->json([
            'status' => 'success',
            'data' => $subscriber->websites()->get()
        ], 200);
    }
}
