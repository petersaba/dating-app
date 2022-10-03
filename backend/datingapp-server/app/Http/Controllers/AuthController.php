<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\User;
use Illuminate\Http\Request;

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
        }

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'invalid data'
            ]);
        }

        $user = new User;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->username = $request->username;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = strtolower($request->gender);
        $user->interested_in = strtolower($request->interested_in);

        
        if($user->save()){
            return response()->json([
                'message' => 'User Created',
                'user' => $user
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