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
}
