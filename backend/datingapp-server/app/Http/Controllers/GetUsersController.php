<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GetUsersController extends Controller
{
    var $currentUserLocation;

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

    // to be used to sort array based on location
    function locationSort($a, $b){
        $a = explode(', ', $a);
        $b = explode(', ', $b);

        $lat1 = $a[0];
        $long1 = $a[1];
        $lat2 = $a[0];
        $long2 = $a[1];

        $long1 = deg2rad($long1);
        $long2 = deg2rad($long2);
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);

        $long = $this->getCurrentUserLocation[1];
        $lat = $this->getCurrentUserLocation[0];
        $long = deg2rad($long);
        $lat = deg2rad($lat);

        $dlong1 = $long - $long1;
        $dlati1 = $lat - $lat1;

        $val1 = pow(sin($dlati1/2),2)+cos($lat1)*cos($lat)*pow(sin($dlong1/2),2);
             
        $res1 = 2 * asin(sqrt($val1));
          
        $radius = 3958.756;

        $res1 = $res1*$radius;

        $dlong2 = $long - $long2;
        $dlati2 = $lat - $lat2;


        $val2 = pow(sin($dlati2/2),2)+cos($lat2)*cos($lat)*pow(sin($dlong2/2),2);
             
        $res2 = 2 * asin(sqrt($val2));

        $res2 = $res2*$radius;

        if($res1 == $res2){
            return 0;
        }elseif($res1 > $res2){
            return 1;
        }else{
            return -1;
        }
    }
}
