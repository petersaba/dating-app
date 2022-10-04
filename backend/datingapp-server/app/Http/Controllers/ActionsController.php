<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActionsController extends Controller
{
    function addOrRemoveFavorite(Request $request){

        $validator = validator()->make($request->all(), [
            'favoriter_id' => 'integer|required',
            'favorited_id' => 'integer|required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid values sent'
            ]);
        }

        
    }
}
