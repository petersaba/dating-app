<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class ActionsController extends Controller
{
    function addOrRemoveFavorite(Request $request){

        $validator = validator()->make($request->all(), [
            'favorited_id' => 'integer|required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid values sent'
            ]);
        }

        $favorite = Favorite::where([['favoriter_id', Auth::id()], ['favorited_id', $request->favorited_id]])->get();

        if(count($favorite) == 0){
            $favorite = new Favorite;
            $favorite->favorited_id = $request->favorited_id;
            $favorite->favoriter_id = Auth::id();
            $favorite->save();
        }else{
            Favorite::where([['favoriter_id', Auth::id()], ['favorited_id', $request->favorited_id]])->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => $favorite
        ]);
    }

    function addOrRemoveBlock(Request $request){
        $validator = validator()->make($request->all(), [
            'blocker_id' => 'integer|required',
            'blocked_id' => 'integer|required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid values sent'
            ]);
        }

        $favorite = Favorite::where([['favoriter_id', $request->blocker_id], ['favorited_id', $request->blocked_id]])->get();

        if(count($favorite) > 0){
            Favorite::where([['favoriter_id', $request->blocker_id], ['favorited_id', $request->blocked_id]])->delete();
        }

        $block = Block::where([['blocker_id', $request->blocker_id], ['blocked_id', $request->blocked_id]])->get();


        if(count($block) == 0){
            $block = new Block;
            $block->blocked_id = $request->blocked_id;
            $block->blocker_id = $request->blocker_id;
            $block->save();
        }else{
            Block::where([['blocker_id', $request->blocker_id], ['blocked_id', $request->blocked_id]])->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => $block
        ]);
    }

    function newMessage(Request $request){
        $message = new Message;

        $message->messager_id = Auth::id();
        $message->messaged_id = $request->messaged_id;
        $message->content = $request->content;

        if($message->save()){
            return response()->json([
                'status' => 'success',
                'message' => $message
            ]);
        }        
    }

    function getMessages($messaged_id){
        $messager_id = Auth::id();
        $messages = Message::where([['messager_id', $messager_id], ['messaged_id', $messaged_id]])
                                ->orWhere([['messaged_id', $messager_id], ['messager_id', $messaged_id]])
                                ->orderBy('created_at', 'DESC')    
                                ->get();

        return response()->json([
            'status' => 'success',
            'message' => $messages
        ]);
    }

    function getMessagedUsers(){
        $messager_id = Auth::id();

        $messaged_users = User::find($messager_id)->messages()->groupBy('messages.messaged_id')->get();

        return response()->json([
            'status' => 'success',
            'message'=> $messaged_users
        ]);
    }
}
