<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\User;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    public function addOrEditUser(Request $request, $id='add'){

        if($id == 'add'){
            $validator = validator()->make($request->all(), [
                'full_name' => 'string|required',
                'email' => 'email|required',
                'password' => 'string|required',
                'username' => 'string|required',
                'date_of_birth' => 'date|required',
                'gender' => ['regex:/^(male|female)$/i', 'required'],
                'interested_in' => ['regex:/^(male|female|both)$/i', 'required']
            ]);
        }else{
            $user = User::find($id);
        }

        if(isset($validator) && $validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'invalid data'
            ]);
        }

        if(!isset($user)){
            if(isEmpty(self::isAttributeUsed('username', $request->username)) && isEmpty(self::isAttributeUsed('email', $request->email))){
                $user = new User;
            }else{
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Username or email already in use'
                ]);
            }
        }

        $user->full_name = $request->full_name ? $request->full_name : $user->full_name;
        $user->email = $request->email ? $request->email : $user->email;
        $user->password = $request->password ? bcrypt($request->password) : $user->password;
        $user->username = $request->username ? $request->username : $user->username;
        $user->date_of_birth = $request->date_of_birth ? $request->date_of_birth : $user->date_of_birth;
        $user->gender = $request->gender ? strtolower($request->gender) : $user->gender;
        $user->interested_in = $request->interested_in ? strtolower($request->interested_in) : $user->interested_in;

        $user->biography = $request->biography ? $request->biography : $user->biography;
        $user->picture_url = $request->picture_base64 ? self::saveImage($request->picture_base64, $id) : $user->picture_url;

        
        if($user->save()){
            return response()->json([
                'status' => 'Success',
                'user' => $user
            ]);
        }
    }

    function isAttributeUsed($attribute_name, $attribute_value){
        return User::where($attribute_name, $attribute_value);
    }

    function saveImage($image_base64, $user_id){
        $data = base64_decode($image_base64);
        $image_name = $user_id . date('Y-m-d-H-i-s');
        file_put_contents('../../../storage/app/images/' . $image_name, $image_base64);
        return $image_name;
    }

    function getUserInfo($user_id){
        $user = User::find($user_id);
        if($user){
            return response()->json([
                'status' => 'success',
                'message' => $user
            ]);
        }else{
            return response()->json([
                'status' => 'Error',
                'message' => 'user does not exist'
            ]);
        }
    }

    /**
     * Get a JWT via given credentials.
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl')
        ]);
    }

    function test(Request $request){
        return response() -> json([
            'status' => 'Success'
        ]);
    }
}