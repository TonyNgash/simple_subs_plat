<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    //adds a new website record in the websites table
    public function store(Request $request){
        //validate incoming request data
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'url' => 'required|url|unique:websites,url'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //add a new website record to the websites table
        $website = Website::create([
            'name' => $request->name,
            'url' => $request->url,
        ]);

        //return the created website in the response
        return response()->json([
            'status' => 'success',
            'data' => $website,
        ], 201);
    }

    public function all(){
        $websites = Website::select('id','name')->get();
        return response()->json([
            'status' => 'success',
            'data' => $websites
        ],201);
    }
}
