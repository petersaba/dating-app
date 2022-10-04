<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

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

        $favorite = Favorite::where([['favoriter_id', $request->favoriter_id], ['favorited_id', $request->favorited_id]])->get();

        if(count($favorite) == 0){
            $favorite = new Favorite;
            $favorite->favorited_id = $request->favorited_id;
            $favorite->favoriter_id = $request->favoriter_id;
            $favorite->save();
        }else{
            Favorite::where([['favoriter_id', $request->favoriter_id], ['favorited_id', $request->favorited_id]])->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => $favorite
        ]);
    }
}
