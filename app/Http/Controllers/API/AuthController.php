<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request){

        $user = User::where('email',$request->email)->firstOrFail();
        
        if(!Hash::check($request->password, $user->password))
        return new AuthLoginResource($user)
    }

}
