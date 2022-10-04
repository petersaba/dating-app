<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
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

        $users = Favorite::where([['favoriter_id', $request->favoriter_id], ['favorited_id', $request->favorited_id]])->get();

        return response()->json([
            'status' => 'success',
            'message' => $users
        ]);
    }
}
