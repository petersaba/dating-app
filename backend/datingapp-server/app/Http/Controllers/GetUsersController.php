<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetUsersController extends Controller
{

    function getFavorites(){
        $users = User::find(Auth::id())->favorites()->get();

        return response()->json([
            'status' => 'success',
            'message' => $users
        ]);
    }

    function getHomepageUsers(){
        $user = User::find(Auth::id());

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