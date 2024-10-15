<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostNotification;

class PostController extends Controller
{
    function store(Request $request, $website_id){
        //validate the incoming user data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=> 'error',
                'errors'=> $validator->errors()
            ], 422);
        }
        //check if the website exists
        $website = Website::find($website_id);
        if(!$website){
            return response()->json([
                'status'=>'error',
                'message'=>'Website not found'
            ],404);
        }

        //create a new post for the website
        $post = Post::create([
            'website_id' => $website->id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        //Fetch subscribers of the website
        $subscribers = Website::find($website_id)->subscribers;

        //send emails to all subscribers
        foreach($subscribers as $subscriber){
            Mail::to($subscriber->email)->send(new NewPostNotification($post));
        }

        //return the created post in the response
        return response()->json([
            'status'=>'success',
            'data'=>$post
        ], 201);
    }

}
