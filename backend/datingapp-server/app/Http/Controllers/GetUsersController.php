<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GetUsersController extends Controller
{
    function getFavorites($user_id){
        $users = User::find($user_id)->favoriter;

        return response()->json([
            'status' => 'success',
            'message' => $users
        ]);
    }

    function getHomepageUsers($user_id){
        $user = User::find($user_id);

        if($user->interested_in == 'both'){
            $users = User::where('interested_in', $user->gender)->orWhere('interested_in', 'both')->get();
        }else{
            $users = User::where([['interested_in', $user->gender], ['gender', $user->interested_in]])->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => $users
        ]);
    }
}
